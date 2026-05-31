<?php

namespace CoffeeR\Digtrace\Tests\Report;

use CoffeeR\Digtrace\Report\CompareMarkdownRenderer;
use CoffeeR\Digtrace\Report\TraceComparer;
use PHPUnit\Framework\TestCase;

class TraceComparerTest extends TestCase
{
    private function makeTrace(array $overrides = [])
    {
        return array_replace_recursive([
            'trace_id'   => 'trace-' . uniqid(),
            'started_at' => '2025-05-30T10:00:00+00:00',
            'http'       => [
                'method'        => 'GET',
                'path'          => '/users',
                'path_pattern'  => '/users',
                'status'        => 200,
                'response_kind' => 'json',
                'response_shape' => ['id' => 'number', 'name' => 'string'],
            ],
            'timeline' => [$this->makeSqlEvent()],
            'effects'  => [],
            'errors'   => [],
        ], $overrides);
    }

    private function makeSqlEvent(array $overrides = [])
    {
        return array_merge([
            'seq'                  => 1,
            'type'                 => 'sql',
            'operation'            => 'SELECT',
            'tables'               => ['USERS'],
            'statement_normalized' => 'SELECT * FROM users WHERE id = {parameter}',
            'statement_hash'       => 'sha256:users',
        ], $overrides);
    }

    public function testCompareIdenticalTracesHasNoDifferences()
    {
        $trace = $this->makeTrace();
        $report = (new TraceComparer())->compare([$trace], [$trace]);

        $this->assertSame(0, $report['difference_count']);
        $this->assertSame([], $report['differences']);
    }

    public function testCompareDetectsMissingEntrypoint()
    {
        $report = (new TraceComparer())->compare([$this->makeTrace()], []);

        $this->assertSame(1, $report['difference_count']);
        $this->assertSame('entrypoint_missing', $report['differences'][0]['type']);
    }

    public function testCompareDetectsAddedEntrypoint()
    {
        $report = (new TraceComparer())->compare([], [$this->makeTrace()]);

        $this->assertSame(1, $report['difference_count']);
        $this->assertSame('entrypoint_added', $report['differences'][0]['type']);
    }

    public function testCompareDetectsStatusChange()
    {
        $base = $this->makeTrace(['http' => ['status' => 200]]);
        $target = $this->makeTrace(['http' => ['status' => 500]]);

        $report = (new TraceComparer())->compare([$base], [$target]);

        $this->assertContains('status_changed', array_column($report['differences'], 'type'));
    }

    public function testCompareDetectsResponseShapeChange()
    {
        $base = $this->makeTrace();
        $target = $this->makeTrace(['http' => ['response_shape' => ['id' => 'number', 'name' => 'number']]]);

        $report = (new TraceComparer())->compare([$base], [$target]);

        $types = array_column($report['differences'], 'type');
        $this->assertContains('response_shape_changed', $types);
    }

    public function testCompareDetectsCompressedPatternChange()
    {
        $base = $this->makeTrace(['timeline' => [$this->makeSqlEvent(), $this->makeSqlEvent()]]);
        $target = $this->makeTrace(['timeline' => [$this->makeSqlEvent()]]);

        $report = (new TraceComparer())->compare([$base], [$target]);

        $this->assertContains('compressed_pattern_changed', array_column($report['differences'], 'type'));
    }

    public function testCompareDetectsEffectsChange()
    {
        $effect = ['op' => 'UPDATE', 'table' => 'USERS', 'statement_hash' => 'sha256:update', 'count' => 1];
        $base = $this->makeTrace(['effects' => [$effect]]);
        $target = $this->makeTrace();

        $report = (new TraceComparer())->compare([$base], [$target]);

        $this->assertContains('effects_changed', array_column($report['differences'], 'type'));
    }

    public function testCompareDetectsTruncationChange()
    {
        $base = $this->makeTrace();
        $target = $this->makeTrace(['errors' => [['type' => 'capture_failure', 'message' => 'timeline truncated: limit=500']]]);

        $report = (new TraceComparer())->compare([$base], [$target]);

        $this->assertContains('truncation_changed', array_column($report['differences'], 'type'));
    }

    public function testMarkdownRendererShowsNoDifferences()
    {
        $trace = $this->makeTrace();
        $report = (new TraceComparer())->compare([$trace], [$trace]);
        $markdown = (new CompareMarkdownRenderer())->render($report);

        $this->assertStringStartsWith('# digtrace compare report', $markdown);
        $this->assertStringContainsString('No differences found.', $markdown);
    }

    public function testMarkdownRendererShowsDifferences()
    {
        $report = (new TraceComparer())->compare([$this->makeTrace()], []);
        $markdown = (new CompareMarkdownRenderer())->render($report);

        $this->assertStringContainsString('## GET /users', $markdown);
        $this->assertStringContainsString('entrypoint_missing', $markdown);
    }
}
