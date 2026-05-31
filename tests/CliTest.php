<?php

namespace CoffeeR\Digtrace\Tests;

use PHPUnit\Framework\TestCase;

class CliTest extends TestCase
{
    private function runCli($args)
    {
        $bin = __DIR__ . '/../bin/digtrace';
        $cmd = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($bin) . ' ' . $args . ' 2>&1';
        $output = [];
        $code = 0;
        exec($cmd, $output, $code);
        return [$code, implode("\n", $output)];
    }

    public function testCompareMarkdownCommand()
    {
        $fixture = escapeshellarg(__DIR__ . '/fixtures/sample.jsonl');
        list($code, $output) = $this->runCli('compare ' . $fixture . ' --against ' . $fixture);

        $this->assertSame(0, $code);
        $this->assertStringStartsWith('# digtrace compare report', $output);
        $this->assertStringContainsString('No differences found.', $output);
    }

    public function testCompareJsonCommand()
    {
        $fixture = escapeshellarg(__DIR__ . '/fixtures/sample.jsonl');
        list($code, $output) = $this->runCli('compare ' . $fixture . ' --against ' . $fixture . ' --format json');

        $this->assertSame(0, $code);
        $decoded = json_decode($output, true);
        $this->assertIsArray($decoded);
        $this->assertSame(0, $decoded['difference_count']);
    }

    public function testCompareRequiresAgainst()
    {
        $fixture = escapeshellarg(__DIR__ . '/fixtures/sample.jsonl');
        list($code, $output) = $this->runCli('compare ' . $fixture);

        $this->assertSame(1, $code);
        $this->assertStringContainsString('--against', $output);
    }

    public function testCompareRequiresBaseFiles()
    {
        $fixture = escapeshellarg(__DIR__ . '/fixtures/sample.jsonl');
        list($code, $output) = $this->runCli('compare --against ' . $fixture);

        $this->assertSame(1, $code);
        $this->assertStringContainsString('No base JSONL files', $output);
    }

    public function testCompareRequiresTargetFiles()
    {
        $fixture = escapeshellarg(__DIR__ . '/fixtures/sample.jsonl');
        list($code, $output) = $this->runCli('compare ' . $fixture . ' --against');

        $this->assertSame(1, $code);
        $this->assertStringContainsString('No target JSONL files', $output);
    }

    public function testCompareRejectsUnknownFormat()
    {
        $fixture = escapeshellarg(__DIR__ . '/fixtures/sample.jsonl');
        list($code, $output) = $this->runCli('compare ' . $fixture . ' --against ' . $fixture . ' --format xml');

        $this->assertSame(1, $code);
        $this->assertStringContainsString('Unknown format', $output);
    }

    public function testCompareKeepsJsonlReaderWarnings()
    {
        $file = tempnam(sys_get_temp_dir(), 'digtrace-invalid-');
        file_put_contents($file, "{invalid}\n");
        $fixture = escapeshellarg(__DIR__ . '/fixtures/sample.jsonl');

        try {
            list($code, $output) = $this->runCli('compare ' . escapeshellarg($file) . ' --against ' . $fixture);
        } finally {
            @unlink($file);
        }

        $this->assertSame(0, $code);
        $this->assertStringContainsString('Warning: base:', $output);
    }
}
