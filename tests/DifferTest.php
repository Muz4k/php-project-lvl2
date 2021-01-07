<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;

use function genDiff;

class DifferTest extends TestCase
{
    public function testJsonDiff(): void
    {
        $pathToFile1 = __DIR__ . '/fixtures/filepath1.json';
        $pathToFile2 = __DIR__ . '/fixtures/filepath2.json';

        $result = genDiff($pathToFile1, $pathToFile2);

        $this->assertEquals(file_get_contents(__DIR__ . '/fixtures/result.txt'), $result);
    }
}
