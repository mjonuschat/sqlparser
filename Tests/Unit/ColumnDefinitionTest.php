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

class ColumnDefinitionTest extends TestCase
{
    public function canParseColumnDefinitionAttributesDataProvider(): array
    {
        return [
            'NULL' => [
                'NULL',
                null
            ],
            'NOT NULL' => [
                'NOT NULL',
                null
            ],
            'DEFAULT' => [
                "DEFAULT '0'",
                null
            ],
            'AUTO_INCREMENT' => [
                'AUTO_INCREMENT',
                null
            ],
            'UNIQUE' => [
                'UNIQUE',
                null
            ],
            'UNIQUE KEY' => [
                'UNIQUE KEY',
                null
            ],
            'PRIMARY' => [
                'PRIMARY',
                null
            ],
            'PRIMARY KEY' => [
                'PRIMARY KEY',
                null
            ],
            'KEY' => [
                'KEY',
                null
            ],
            'COMMENT' => [
                "COMMENT 'aComment'",
                null
            ],
            'COLUMN_FORMAT FIXED' => [
                'COLUMN_FORMAT FIXED',
                null
            ],
            'COLUMN_FORMAT DYNAMIC' => [
                'COLUMN_FORMAT DYNAMIC',
                null
            ],
            'COLUMN_FORMAT DEFAULT' => [
                'COLUMN_FORMAT DEFAULT',
                null
            ],
            'STORAGE DISK' => [
                'STORAGE DISK',
                null
            ],
            'STORAGE MEMORY' => [
                'STORAGE MEMORY',
                null
            ],
            'STORAGE DEFAULT' => [
                'STORAGE DEFAULT',
                null
            ],
            "NOT NULL DEFAULT '0'" => [
                "NOT NULL DEFAULT '0'",
                null
            ],
            'NOT NULL AUTO_INCREMENT' => [
                'NOT NULL AUTO_INCREMENT',
                null
            ],
            'NULL DEFAULT NULL' => [
                'NULL DEFAULT NULL',
                null
            ],
            'NOT NULL PRIMARY KEY' => [
                'NOT NULL PRIMARY KEY',
                null
            ],
            "NULL DEFAULT 'dummy' UNIQUE" => [
                "NULL DEFAULT 'dummy' UNIQUE",
                null
            ],
            "NOT NULL DEFAULT '0' COMMENT 'aComment with blanks' AUTO_INCREMENT PRIMARY KEY COLUMN_FORMAT DYNAMIC" => [
                "NOT NULL DEFAULT '0' COMMENT 'aComment with blanks' AUTO_INCREMENT PRIMARY KEY COLUMN_FORMAT DYNAMIC",
                null
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseColumnDefinitionAttributesDataProvider
     * @param string $columnAttribute
     */
    public function canParseColumnDefinitionAttributes(string $columnAttribute, $expectedResult)
    {
        $statement = sprintf('CREATE TABLE `aTable`(`aField` INT(11) %s)', $columnAttribute);
        $subject = new Parser($statement);
        $subject->parse();
    }
}
