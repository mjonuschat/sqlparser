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

use MojoCode\SqlParser\AST\CreateForeignKeyDefinitionItem;
use MojoCode\SqlParser\Parser;
use PHPUnit\Framework\TestCase;

class ForeignKeyDefinitionTest extends TestCase
{
    /**
     * Each parameter array consists of the following values:
     *  - index definition SQL fragment
     *  - index name
     *  - array of index column definitions [name, length, direction]
     *  - foreign table name
     *  - array of foreign column definitions [name, length, direction]
     *
     * @return array
     */
    public function canParseForeignKeyDefinitionDataProvider(): array
    {
        return [
            // See ReferenceDefinitionTest for actual reference definition parsing tests
            'FOREIGN KEY (single column)' => [
                'FOREIGN KEY (`aField`) REFERENCES `bTable` (`bField`)',
                '',
                [['aField', 0, null]],
                'bTable',
                [['bField', 0, null]],
            ],
            'FOREIGN KEY (multiple columns)' => [
                'FOREIGN KEY (`aField`(20) ASC, `bField`) REFERENCES `bTable` (`cField`, `dField`)',
                '',
                [['aField', 20, 'ASC'], ['bField', 0, null]],
                'bTable',
                [['cField', 0, null], ['dField', 0, null]],
            ],
            'FOREIGN KEY (index name)' => [
                'FOREIGN KEY `aIndex`(`aField`, `bField`) REFERENCES `bTable` (`cField`(240) DESC, `dField`)',
                'aIndex',
                [['aField', 0, null], ['bField', 0, null]],
                'bTable',
                [['cField', 240, 'DESC'], ['dField', 0, null]],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseForeignKeyDefinitionDataProvider
     * @param string $indexDefinition
     * @param string $indexName
     * @param array $indexColumns
     * @param string $foreignTableName
     * @param array $foreignTableColumns
     */
    public function canParseForeignKeyDefinition(
        string $indexDefinition,
        string $indexName,
        array $indexColumns,
        string $foreignTableName,
        array $foreignTableColumns
    ) {
        $statement = sprintf('CREATE TABLE `aTable`(`aField` INT(11), %s)', $indexDefinition);
        $subject = $this->createSubject($statement);

        $this->assertInstanceOf(CreateForeignKeyDefinitionItem::class, $subject);
        $this->assertSame($indexName, $subject->indexName->schemaObjectName);
        $this->assertSame($foreignTableName, $subject->reference->tableName->schemaObjectName);

        foreach ($indexColumns as $index => $column) {
            $this->assertSame($column[0], $subject->columnNames[$index]->columnName->schemaObjectName);
            $this->assertSame($column[1], $subject->columnNames[$index]->length);
            $this->assertSame($column[2], $subject->columnNames[$index]->direction);
        }

        foreach ($foreignTableColumns as $index => $column) {
            $this->assertSame($column[0], $subject->reference->columnNames[$index]->columnName->schemaObjectName);
            $this->assertSame($column[1], $subject->reference->columnNames[$index]->length);
            $this->assertSame($column[2], $subject->reference->columnNames[$index]->direction);
        }
    }

    /**
     * Parse the CREATE TABLE statement and return the reference definition
     *
     * @param string $statement
     * @return \MojoCode\SqlParser\AST\CreateForeignKeyDefinitionItem
     */
    protected function createSubject(string $statement): CreateForeignKeyDefinitionItem
    {
        $parser = new Parser($statement);
        $createTableStatement = $parser->parse()[0];

        return $createTableStatement->createDefinition->items[1];
    }
}
