<?php

namespace CoffeeR\Digtrace\Report;

/**
 * TraceComparer の出力を Markdown 文字列にレンダリングする。
 */
class CompareMarkdownRenderer
{
    /**
     * @param array $report
     * @return string
     */
    public function render(array $report)
    {
        $lines = [];
        $lines[] = '# digtrace compare report';
        $lines[] = '';
        $lines[] = '- 生成日時: `' . $this->value(isset($report['generated_at']) ? $report['generated_at'] : '-') . '`';
        $lines[] = '- base traces: `' . $this->value($this->nested($report, ['base', 'trace_count'], 0)) . '`';
        $lines[] = '- target traces: `' . $this->value($this->nested($report, ['target', 'trace_count'], 0)) . '`';
        $lines[] = '- base entrypoints: `' . $this->value($this->nested($report, ['base', 'observed_entrypoint_count'], 0)) . '`';
        $lines[] = '- target entrypoints: `' . $this->value($this->nested($report, ['target', 'observed_entrypoint_count'], 0)) . '`';
        $lines[] = '- differences: `' . $this->value(isset($report['difference_count']) ? $report['difference_count'] : 0) . '`';
        $lines[] = '';

        $differences = isset($report['differences']) && is_array($report['differences'])
            ? $report['differences']
            : [];

        if (count($differences) === 0) {
            $lines[] = 'No differences found.';
            return implode("\n", $lines) . "\n";
        }

        $byEntry = [];
        foreach ($differences as $difference) {
            $entryKey = isset($difference['entrypoint_key']) ? $difference['entrypoint_key'] : 'UNKNOWN';
            if (!isset($byEntry[$entryKey])) {
                $byEntry[$entryKey] = [];
            }
            $byEntry[$entryKey][] = $difference;
        }

        foreach ($byEntry as $entryKey => $entryDiffs) {
            $lines[] = '## ' . $entryKey;
            $lines[] = '';
            $lines[] = '| Type | Summary |';
            $lines[] = '|---|---|';
            foreach ($entryDiffs as $difference) {
                $lines[] = '| ' . $this->cell(isset($difference['type']) ? $difference['type'] : '-') . ' | ' . $this->cell(isset($difference['message']) ? $difference['message'] : '-') . ' |';
            }
            $lines[] = '';

            foreach ($entryDiffs as $difference) {
                $lines[] = '### ' . (isset($difference['type']) ? $difference['type'] : 'difference');
                $lines[] = '';
                $lines[] = '```json';
                $lines[] = json_encode([
                    'base'    => isset($difference['base']) ? $difference['base'] : null,
                    'target'  => isset($difference['target']) ? $difference['target'] : null,
                    'details' => isset($difference['details']) ? $difference['details'] : null,
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                $lines[] = '```';
                $lines[] = '';
            }
        }

        return implode("\n", $lines) . "\n";
    }

    /**
     * @param array $data
     * @param string[] $path
     * @param mixed $default
     * @return mixed
     */
    private function nested(array $data, array $path, $default)
    {
        $cursor = $data;
        foreach ($path as $key) {
            if (!is_array($cursor) || !array_key_exists($key, $cursor)) {
                return $default;
            }
            $cursor = $cursor[$key];
        }
        return $cursor;
    }

    /**
     * @param mixed $value
     * @return string
     */
    private function value($value)
    {
        return str_replace('`', "'", (string) $value);
    }

    /**
     * @param mixed $value
     * @return string
     */
    private function cell($value)
    {
        return str_replace('|', '\\|', (string) $value);
    }
}
