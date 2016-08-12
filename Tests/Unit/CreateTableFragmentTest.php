<?php
declare(strict_types = 1);

namespace MojoCode\SqlParser\Tests\Unit;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use MojoCode\SqlParser\Parser;
use PHPUnit\Framework\TestCase;

class CreateTableFragmentTest extends TestCase
{
    public function canParseCreateTableFragmentDataProvider(): array
    {
        return [
            'CREATE TABLE' => [
                'CREATE TABLE aTable (aField INT)'
            ],
            'CREATE TEMPORARY TABLE' => [
                'CREATE TEMPORARY TABLE aTable (aField INT)'
            ],
            'CREATE TABLE IF NOT EXISTS' => [
                'CREATE TABLE IF NOT EXISTS aTable (aField INT)'
            ],
            'CREATE TEMPORARY TABLE IF NOT EXISTS' => [
                'CREATE TEMPORARY TABLE IF NOT EXISTS aTable (aField INT)'
            ],
            'CREATE TABLE (quoted table name)' => [
                'CREATE TABLE `aTable` (aField INT)'
            ],
            'CREATE TEMPORARY TABLE (quoted table name)' => [
                'CREATE TEMPORARY TABLE `aTable` (aField INT)'
            ],
            'CREATE TABLE IF NOT EXISTS (quoted table name)' => [
                'CREATE TABLE IF NOT EXISTS `aTable` (aField INT)'
            ],
            'CREATE TEMPORARY TABLE IF NOT EXISTS (quoted table name)' => [
                'CREATE TEMPORARY TABLE IF NOT EXISTS `aTable` (aField INT)'
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseCreateTableFragmentDataProvider
     * @param string $statement
     */
    public function canParseCreateTableFragment(string $statement)
    {
        $subject = new Parser($statement);
        $subject->parse();
    }
}
