<?php

namespace CoffeeR\Tekagami\Tests;

use PHPUnit\Framework\TestCase;

class CliTest extends TestCase
{
    private function runCli($args)
    {
        $bin = __DIR__ . '/../bin/tekagami';
        $cmd = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($bin) . ' ' . $args . ' 2>&1';
        $output = [];
        $code = 0;
        exec($cmd, $output, $code);
        return [$code, implode("\n", $output)];
    }

    public function testExportJsonCommand()
    {
        $fixture = escapeshellarg(__DIR__ . '/fixtures/sample.jsonl');
        list($code, $output) = $this->runCli('export ' . $fixture . ' --format json');

        $this->assertSame(0, $code);
        $decoded = json_decode($output, true);
        $this->assertIsArray($decoded);
        $this->assertArrayHasKey('sql_dictionary', $decoded);
        $this->assertArrayHasKey('legend', $decoded);
    }

    public function testExportRequiresFiles()
    {
        list($code, $output) = $this->runCli('export');

        $this->assertSame(1, $code);
        $this->assertStringContainsString('No JSONL files', $output);
    }

    public function testExportRejectsUnknownFormat()
    {
        $fixture = escapeshellarg(__DIR__ . '/fixtures/sample.jsonl');
        list($code, $output) = $this->runCli('export ' . $fixture . ' --format xml');

        $this->assertSame(1, $code);
        $this->assertStringContainsString('Unknown format', $output);
    }

    public function testDecryptCommandIsRemoved()
    {
        list($code, $output) = $this->runCli('decrypt');

        $this->assertSame(1, $code);
        $this->assertStringContainsString('Unknown command: decrypt', $output);
    }

    public function testCompareCommandIsRemoved()
    {
        list($code, $output) = $this->runCli('compare');

        $this->assertSame(1, $code);
        $this->assertStringContainsString('Unknown command: compare', $output);
    }

    public function testHelpDoesNotListCompare()
    {
        list($code, $output) = $this->runCli('--help');

        $this->assertSame(0, $code);
        $this->assertStringNotContainsString('compare', $output);
    }

    public function testHelpListsDiff()
    {
        list($code, $output) = $this->runCli('--help');

        $this->assertSame(0, $code);
        $this->assertStringContainsString('diff', $output);
    }

    public function testDiffCommandJsonOutput()
    {
        $legacy = escapeshellarg(__DIR__ . '/fixtures/diff-legacy.json');
        $target = escapeshellarg(__DIR__ . '/fixtures/diff-target.json');
        list($code, $output) = $this->runCli('diff ' . $legacy . ' ' . $target . ' --format json');

        $this->assertSame(0, $code, 'Exit code: ' . $output);
        $decoded = json_decode($output, true);
        $this->assertIsArray($decoded);
        $this->assertArrayHasKey('entrypoints', $decoded);
        $this->assertArrayHasKey('meaning_near_matches', $decoded);
    }

    public function testDiffCommandMarkdownOutput()
    {
        $legacy = escapeshellarg(__DIR__ . '/fixtures/diff-legacy.json');
        $target = escapeshellarg(__DIR__ . '/fixtures/diff-target.json');
        list($code, $output) = $this->runCli('diff ' . $legacy . ' ' . $target . ' --format md');

        $this->assertSame(0, $code, 'Exit code: ' . $output);
        $this->assertStringContainsString('# tekagami diff report', $output);
    }

    public function testDiffRequiresTwoFiles()
    {
        $legacy = escapeshellarg(__DIR__ . '/fixtures/diff-legacy.json');
        list($code, $output) = $this->runCli('diff ' . $legacy);

        $this->assertSame(1, $code);
        $this->assertStringContainsString('exactly 2', $output);
    }

    public function testDiffRejectsUnknownFormat()
    {
        $legacy = escapeshellarg(__DIR__ . '/fixtures/diff-legacy.json');
        $target = escapeshellarg(__DIR__ . '/fixtures/diff-target.json');
        list($code, $output) = $this->runCli('diff ' . $legacy . ' ' . $target . ' --format xml');

        $this->assertSame(1, $code);
        $this->assertStringContainsString('Unknown format', $output);
    }
}
