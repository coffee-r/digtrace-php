<?php

namespace CoffeeR\Digtrace\Report;

/**
 * 旧系(base)と新系(target)の digtrace JSONL を決定論的に比較する。
 */
class TraceComparer
{
    /** @var Aggregator */
    private $aggregator;

    public function __construct($aggregator = null)
    {
        $this->aggregator = $aggregator ?: new Aggregator();
    }

    /**
     * @param array $baseTraces
     * @param array $targetTraces
     * @return array
     */
    public function compare(array $baseTraces, array $targetTraces)
    {
        $baseReport   = $this->aggregator->aggregate($baseTraces);
        $targetReport = $this->aggregator->aggregate($targetTraces);

        $baseIndex    = $this->indexReport($baseReport);
        $targetIndex  = $this->indexReport($targetReport);
        $baseHttp     = $this->indexHttpFacts($baseTraces);
        $targetHttp   = $this->indexHttpFacts($targetTraces);
        $differences  = [];

        $entryKeys = array_unique(array_merge(array_keys($baseIndex), array_keys($targetIndex), array_keys($baseHttp), array_keys($targetHttp)));
        sort($entryKeys);

        foreach ($entryKeys as $entryKey) {
            $baseEntry   = isset($baseIndex[$entryKey]) ? $baseIndex[$entryKey] : null;
            $targetEntry = isset($targetIndex[$entryKey]) ? $targetIndex[$entryKey] : null;

            if ($baseEntry === null) {
                $differences[] = $this->difference($entryKey, 'entrypoint_added', 'Entrypoint exists only in target.', null, $this->entrySummary($targetEntry));
                continue;
            }
            if ($targetEntry === null) {
                $differences[] = $this->difference($entryKey, 'entrypoint_missing', 'Entrypoint exists only in base.', $this->entrySummary($baseEntry), null);
                continue;
            }

            $baseFacts   = isset($baseHttp[$entryKey]) ? $baseHttp[$entryKey] : $this->emptyHttpFacts();
            $targetFacts = isset($targetHttp[$entryKey]) ? $targetHttp[$entryKey] : $this->emptyHttpFacts();

            $this->compareMap($differences, $entryKey, 'status_changed', 'Status distribution changed.', $baseEntry['status_codes'], $targetEntry['status_codes']);
            $this->compareMap($differences, $entryKey, 'response_kind_changed', 'Response kind distribution changed.', $baseFacts['response_kind_counts'], $targetFacts['response_kind_counts']);
            $this->compareMap($differences, $entryKey, 'response_shape_changed', 'Response shape distribution changed.', $baseFacts['response_shapes'], $targetFacts['response_shapes'], $this->shapeDiff($baseFacts, $targetFacts));
            $this->compareMap($differences, $entryKey, 'compressed_pattern_changed', 'Compressed behavior patterns changed.', $baseEntry['compressed_patterns'], $targetEntry['compressed_patterns']);
            $this->compareMap($differences, $entryKey, 'exact_signature_changed', 'Exact behavior signatures changed.', $baseEntry['exact_signatures'], $targetEntry['exact_signatures']);
            $this->compareMap($differences, $entryKey, 'effects_changed', 'Write effects changed.', $baseEntry['effects'], $targetEntry['effects']);
            $this->compareMap($differences, $entryKey, 'errors_changed', 'Capture errors changed.', $baseEntry['errors'], $targetEntry['errors']);
            $this->compareMap($differences, $entryKey, 'truncation_changed', 'Timeline truncation changed.', $baseEntry['truncations'], $targetEntry['truncations']);
        }

        return [
            'generated_at'     => date('c'),
            'base'             => $this->reportSummary($baseReport),
            'target'           => $this->reportSummary($targetReport),
            'difference_count' => count($differences),
            'differences'      => $differences,
        ];
    }

    /**
     * @param array $report
     * @return array
     */
    private function indexReport(array $report)
    {
        $index = [];
        $entrypoints = isset($report['observed_entrypoints']) && is_array($report['observed_entrypoints'])
            ? $report['observed_entrypoints']
            : [];

        foreach ($entrypoints as $entry) {
            $key = isset($entry['entrypoint_key']) ? $entry['entrypoint_key'] : null;
            if ($key === null) {
                continue;
            }
            $summary = [
                'observed_count'      => isset($entry['observed_count']) ? (int) $entry['observed_count'] : 0,
                'status_codes'        => $this->normalizeMap(isset($entry['status_codes']) ? $entry['status_codes'] : []),
                'compressed_patterns' => [],
                'exact_signatures'    => [],
                'effects'             => [],
                'errors'              => [],
                'truncations'         => [],
            ];

            $patterns = isset($entry['patterns']) && is_array($entry['patterns']) ? $entry['patterns'] : [];
            foreach ($patterns as $pattern) {
                $count = isset($pattern['count']) ? (int) $pattern['count'] : 0;
                $exact = isset($pattern['observed_flow_signature']) ? $pattern['observed_flow_signature'] : '';
                $compressed = isset($pattern['compressed_flow_signature']) ? $pattern['compressed_flow_signature'] : $exact;
                $this->increment($summary['exact_signatures'], $exact, $count);
                $this->increment($summary['compressed_patterns'], $compressed, $count);

                $truncKey = !empty($pattern['truncated'])
                    ? 'TRUNCATED:' . (isset($pattern['truncation_limit']) ? $pattern['truncation_limit'] : 'unknown')
                    : 'not_truncated';
                $this->increment($summary['truncations'], $truncKey, $count);

                $effects = isset($pattern['effects']) && is_array($pattern['effects']) ? $pattern['effects'] : [];
                foreach ($effects as $effect) {
                    $effectKey = implode(':', [
                        isset($effect['op']) ? $effect['op'] : '',
                        isset($effect['table']) ? $effect['table'] : '',
                        isset($effect['statement_hash']) ? $effect['statement_hash'] : '',
                    ]);
                    $this->increment($summary['effects'], $effectKey, isset($effect['count']) ? (int) $effect['count'] : 1);
                }
            }

            $errors = isset($entry['errors']) && is_array($entry['errors']) ? $entry['errors'] : [];
            foreach ($errors as $error) {
                $label = isset($error['error']) ? $error['error'] : 'unknown';
                $this->increment($summary['errors'], $label, isset($error['count']) ? (int) $error['count'] : 1);
            }

            $index[$key] = $this->sortSummary($summary);
        }

        return $index;
    }

    /**
     * @param array $traces
     * @return array
     */
    private function indexHttpFacts(array $traces)
    {
        $index = [];
        foreach ($traces as $trace) {
            $http = isset($trace['http']) && is_array($trace['http']) ? $trace['http'] : [];
            $key = $this->aggregator->entryKey($http);
            if (!isset($index[$key])) {
                $index[$key] = $this->emptyHttpFacts();
            }

            $kind = array_key_exists('response_kind', $http) && $http['response_kind'] !== null
                ? (string) $http['response_kind']
                : 'null';
            $this->increment($index[$key]['response_kind_counts'], $kind, 1);

            if (array_key_exists('response_shape', $http)) {
                $shape = $http['response_shape'];
                $shapeKey = $this->canonical($shape);
                $this->increment($index[$key]['response_shapes'], $shapeKey, 1);
                if (!isset($index[$key]['response_shape_examples'][$shapeKey])) {
                    $index[$key]['response_shape_examples'][$shapeKey] = $shape;
                }
            }
        }

        foreach (array_keys($index) as $key) {
            ksort($index[$key]['response_kind_counts']);
            ksort($index[$key]['response_shapes']);
        }

        return $index;
    }

    /**
     * @return array
     */
    private function emptyHttpFacts()
    {
        return [
            'response_kind_counts'   => [],
            'response_shapes'        => [],
            'response_shape_examples' => [],
        ];
    }

    /**
     * @param array $differences
     * @param string $entryKey
     * @param string $type
     * @param string $message
     * @param mixed $base
     * @param mixed $target
     * @param array $details
     */
    private function compareMap(array &$differences, $entryKey, $type, $message, $base, $target, array $details = [])
    {
        $base = $this->normalizeMap($base);
        $target = $this->normalizeMap($target);
        if ($base === $target) {
            return;
        }
        $diff = $this->difference($entryKey, $type, $message, $base, $target);
        if (!empty($details)) {
            $diff['details'] = $details;
        }
        $differences[] = $diff;
    }

    /**
     * @param string $entryKey
     * @param string $type
     * @param string $message
     * @param mixed $base
     * @param mixed $target
     * @return array
     */
    private function difference($entryKey, $type, $message, $base, $target)
    {
        return [
            'entrypoint_key' => $entryKey,
            'type'           => $type,
            'message'        => $message,
            'base'           => $base,
            'target'         => $target,
        ];
    }

    /**
     * @param array $report
     * @return array
     */
    private function reportSummary(array $report)
    {
        return [
            'trace_count'               => isset($report['trace_count']) ? (int) $report['trace_count'] : 0,
            'observed_entrypoint_count' => isset($report['observed_entrypoint_count']) ? (int) $report['observed_entrypoint_count'] : 0,
            'observed_started_at_min'   => isset($report['observed_started_at_min']) ? $report['observed_started_at_min'] : null,
            'observed_started_at_max'   => isset($report['observed_started_at_max']) ? $report['observed_started_at_max'] : null,
        ];
    }

    /**
     * @param array|null $entry
     * @return array|null
     */
    private function entrySummary($entry)
    {
        if ($entry === null) {
            return null;
        }
        return [
            'observed_count' => isset($entry['observed_count']) ? $entry['observed_count'] : 0,
            'status_codes'   => isset($entry['status_codes']) ? $entry['status_codes'] : [],
        ];
    }

    /**
     * @param array $summary
     * @return array
     */
    private function sortSummary(array $summary)
    {
        foreach (['status_codes', 'compressed_patterns', 'exact_signatures', 'effects', 'errors', 'truncations'] as $key) {
            if (isset($summary[$key]) && is_array($summary[$key])) {
                ksort($summary[$key]);
            }
        }
        return $summary;
    }

    /**
     * @param array $map
     * @param string $key
     * @param int $amount
     */
    private function increment(array &$map, $key, $amount)
    {
        if (!isset($map[$key])) {
            $map[$key] = 0;
        }
        $map[$key] += $amount;
    }

    /**
     * @param mixed $map
     * @return array
     */
    private function normalizeMap($map)
    {
        if (!is_array($map)) {
            return [];
        }
        ksort($map);
        return $map;
    }

    /**
     * @param array $baseFacts
     * @param array $targetFacts
     * @return array
     */
    private function shapeDiff(array $baseFacts, array $targetFacts)
    {
        if (count($baseFacts['response_shape_examples']) !== 1 || count($targetFacts['response_shape_examples']) !== 1) {
            return [];
        }
        $baseShape = reset($baseFacts['response_shape_examples']);
        $targetShape = reset($targetFacts['response_shape_examples']);
        return $this->diffShape($baseShape, $targetShape, '$');
    }

    /**
     * @param mixed $base
     * @param mixed $target
     * @param string $path
     * @return array
     */
    private function diffShape($base, $target, $path)
    {
        if (is_array($base) && is_array($target) && !$this->isList($base) && !$this->isList($target)) {
            $diffs = [];
            $keys = array_unique(array_merge(array_keys($base), array_keys($target)));
            sort($keys);
            foreach ($keys as $key) {
                $childPath = $path . '.' . $key;
                if (!array_key_exists($key, $target)) {
                    $diffs[] = ['path' => $childPath, 'change' => 'removed', 'base' => $base[$key], 'target' => null];
                } elseif (!array_key_exists($key, $base)) {
                    $diffs[] = ['path' => $childPath, 'change' => 'added', 'base' => null, 'target' => $target[$key]];
                } else {
                    $diffs = array_merge($diffs, $this->diffShape($base[$key], $target[$key], $childPath));
                }
            }
            return $diffs;
        }

        if ($this->canonical($base) !== $this->canonical($target)) {
            return [['path' => $path, 'change' => 'changed', 'base' => $base, 'target' => $target]];
        }
        return [];
    }

    /**
     * @param array $array
     * @return bool
     */
    private function isList(array $array)
    {
        if ($array === []) {
            return true;
        }
        return array_keys($array) === range(0, count($array) - 1);
    }

    /**
     * @param mixed $value
     * @return string
     */
    private function canonical($value)
    {
        return json_encode($this->sortRecursive($value), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    private function sortRecursive($value)
    {
        if (!is_array($value)) {
            return $value;
        }
        foreach ($value as $key => $child) {
            $value[$key] = $this->sortRecursive($child);
        }
        if (!$this->isList($value)) {
            ksort($value);
        }
        return $value;
    }
}
