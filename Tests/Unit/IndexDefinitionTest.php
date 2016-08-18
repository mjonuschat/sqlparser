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

class IndexDefinitionTest extends TestCase
{
    public function canParseIndexDefinitionDataProvider(): array
    {
        return [
            'PRIMARY KEY (single column)' => [
                'PRIMARY KEY (`aField`)',
                null
            ],
            'PRIMARY KEY (multiple columns)' => [
                'PRIMARY KEY (`aField`, `bField`(199), cField)',
                null
            ],
            'PRIMARY KEY (index type)' => [
                'PRIMARY KEY USING HASH (`aField`)',
                null
            ],
            'PRIMARY KEY (index options)' => [
                "PRIMARY KEY (`aField`, bField(199)) KEY_BLOCK_SIZE 4 WITH PARSER `something` COMMENT 'aTest'",
                null
            ],
            'PRIMARY KEY (all parts)' => [
                "PRIMARY KEY USING BTREE (`aField`, bField(199)) KEY_BLOCK_SIZE 4 COMMENT 'aTest'",
                null
            ],
            'INDEX (single column)' => [
                'INDEX (`aField`(24))',
                null
            ],
            'INDEX (multiple columns)' => [
                'INDEX (`aField`(24), bField)',
                null
            ],
            'INDEX (index name)' => [
                'INDEX aIndex (`aField`)',
                null
            ],
            'INDEX (index type)' => [
                'INDEX USING HASH (`aField`)',
                null
            ],
            'INDEX (index name & type)' => [
                'INDEX `aIndex` USING BTREE (`aField`)',
                null
            ],
            'INDEX (all parts)' => [
                "INDEX `aIndex` USING BTREE (`aField`) COMMENT 'aComment'",
                null
            ],
            'KEY (single column)' => [
                'KEY (`aField`(24))',
                null
            ],
            'KEY (multiple columns)' => [
                'KEY (`aField`(24), bField)',
                null
            ],
            'KEY (index name)' => [
                'KEY aIndex (`aField`)',
                null
            ],
            'KEY (index type)' => [
                'KEY USING BTREE (aField(96))',
                null
            ],
            'KEY (index name & type)' => [
                'KEY `aIndex` USING HASH (`aField`)',
                null
            ],
            'KEY (all parts)' => [
                'KEY `aIndex` USING HASH (`aField`) WITH PARSER aParser',
                null
            ],
            'UNIQUE (single column)' => [
                'UNIQUE (`aField`)',
                null
            ],
            'UNIQUE (multiple columns)' => [
                'UNIQUE (`aField`, bField, cField(40))',
                null
            ],
            'UNIQUE INDEX (single column)' => [
                'UNIQUE INDEX (`aField`)',
                null
            ],
            'UNIQUE KEY (multiple columns)' => [
                'UNIQUE KEY (`aField`, bField, cField(40))',
                null
            ],
            'UNIQUE (index name)' => [
                'UNIQUE aIndex (`aField`)',
                null
            ],
            'UNIQUE (index type)' => [
                'UNIQUE USING BTREE (`aField`)',
                null
            ],
            'UNIQUE (index name & type)' => [
                'UNIQUE `aIndex` USING BTREE (`aField`)',
                null
            ],
            'UNIQUE (all parts)' => [
                'UNIQUE `aIndex` USING BTREE (`aField`) KEY_BLOCK_SIZE = 24',
                null
            ],
            'FULLTEXT (single column)' => [
                'FULLTEXT (`aField`)',
                null
            ],
            'FULLTEXT (multiple columns)' => [
                'FULLTEXT (`aField`, `bField`)',
                null
            ],
            'FULLTEXT (index name)' => [
                'FULLTEXT aIndex (`aField`, `bField`)',
                null
            ],
            'FULLTEXT (all parts)' => [
                "FULLTEXT `aIndex` (`aField`, `bField`) COMMENT 'aComment'",
                null
            ],
            'FULLTEXT INDEX (single column)' => [
                'FULLTEXT INDEX (`aField`)',
                null
            ],
            'FULLTEXT INDEX (multiple columns)' => [
                'FULLTEXT INDEX (`aField`, bField(19))',
                null
            ],
            'FULLTEXT KEY (single column)' => [
                'FULLTEXT KEY (aField(20))',
                null
            ],
            'FULLTEXT KEY (multiple columns)' => [
                'FULLTEXT KEY (aField(20), `bField`)',
                null
            ],
            'SPATIAL (single column)' => [
                'SPATIAL (`aField`)',
                null
            ],
            'SPATIAL (multiple columns)' => [
                'SPATIAL (`aField`, `bField`)',
                null
            ],
            'SPATIAL (index name)' => [
                'SPATIAL `aIndex` (`aField`, `bField`)',
                null
            ],
            'SPATIAL (all parts)' => [
                "SPATIAL `aIndex` (`aField`, `bField`) WITH PARSER aParser COMMENT 'aComment'",
                null
            ],
            'SPATIAL INDEX (single column)' => [
                'SPATIAL INDEX (`aField`)',
                null
            ],
            'SPATIAL INDEX (multiple columns)' => [
                'SPATIAL INDEX (aField, bField)',
                null
            ],
            'SPATIAL KEY (single column)' => [
                'SPATIAL KEY (aField)',
                null
            ],
            'SPATIAL KEY (multiple columns)' => [
                'SPATIAL KEY (aField, bField(240))',
                null
            ],
            // See ReferenceDefinitionTest for actual reference definition parsing tests
            'FOREIGN KEY (single column)' => [
                'FOREIGN KEY (`aField`) REFERENCES `bTable` (`bField`)',
                null
            ],
            'FOREIGN KEY (multiple columns)' => [
                'FOREIGN KEY (`aField`, `bField`) REFERENCES `bTable` (`cField`, `dField`)',
                null
            ],
            'FOREIGN KEY (index name)' => [
                'FOREIGN KEY `aIndex`(`aField`, `bField`) REFERENCES `bTable` (`cField`, `dField`)',
                null
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseIndexDefinitionDataProvider
     * @param string $indexDefinition
     */
    public function canParseIndexDefinition(string $indexDefinition, $expectedResult)
    {
        $statement = sprintf('CREATE TABLE `aTable`(`aField` INT(11), %s)', $indexDefinition);
        $subject = new Parser($statement);
        $subject->parse();
    }
}
