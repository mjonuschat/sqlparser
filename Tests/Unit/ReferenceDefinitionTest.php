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

use MojoCode\SqlParser\AST\ReferenceDefinition;
use MojoCode\SqlParser\Parser;
use PHPUnit\Framework\TestCase;

class ReferenceDefinitionTest extends TestCase
{
    /**
     * Each parameter array consists of the following values:
     *  - reference definition SQL fragment
     *  - expected table Name
     *  - array of index column definitions [name, length, direction]
     *  - MATCH value
     *  - ON DELETE value
     *  - ON UPDATE value
     *
     * @return array
     */
    public function canParseReferenceDefinitionDataProvider(): array
    {
        return [
            'REFERENCES `anotherTable`(`aColumn`)' => [
                'REFERENCES `anotherTable`(`aColumn`)',
                'anotherTable',
                [['aColumn', 0, null]],
                null,
                null,
                null,
            ],
            'REFERENCES `anotherTable`(`aColumn`, anotherColumn)' => [
                'REFERENCES `anotherTable`(`aColumn`, anotherColumn)',
                'anotherTable',
                [['aColumn', 0, null], ['anotherColumn', 0, null]],
                null,
                null,
                null,
            ],
            'REFERENCES `anotherTable`(`aColumn`(199),`anotherColumn`)' => [
                'REFERENCES `anotherTable`(`aColumn`(199),`anotherColumn`)',
                'anotherTable',
                [['aColumn', 199, null], ['anotherColumn', 0, null]],
                null,
                null,
                null,
            ],
            'REFERENCES `anotherTable`(`aColumn`(199) ASC, anotherColumn DESC)' => [
                'REFERENCES `anotherTable`(`aColumn`(199) ASC, anotherColumn DESC)',
                'anotherTable',
                [['aColumn', 199, 'ASC'], ['anotherColumn', 0, 'DESC']],
                null,
                null,
                null,
            ],
            'REFERENCES anotherTable(aColumn) MATCH FULL' => [
                'REFERENCES anotherTable(aColumn) MATCH FULL',
                'anotherTable',
                [['aColumn', 0, null]],
                'FULL',
                null,
                null,
            ],
            'REFERENCES anotherTable(aColumn) MATCH PARTIAL' => [
                'REFERENCES anotherTable(aColumn) MATCH PARTIAL',
                'anotherTable',
                [['aColumn', 0, null]],
                'PARTIAL',
                null,
                null,
            ],
            'REFERENCES anotherTable(aColumn) MATCH SIMPLE' => [
                'REFERENCES anotherTable(aColumn) MATCH SIMPLE',
                'anotherTable',
                [['aColumn', 0, null]],
                'SIMPLE',
                null,
                null,
            ],
            'REFERENCES anotherTable(aColumn) ON DELETE RESTRICT' => [
                'REFERENCES anotherTable(aColumn) ON DELETE RESTRICT',
                'anotherTable',
                [['aColumn', 0, null]],
                null,
                'RESTRICT',
                null,
            ],
            'REFERENCES anotherTable(aColumn) ON DELETE CASCADE' => [
                'REFERENCES anotherTable(aColumn) ON DELETE CASCADE',
                'anotherTable',
                [['aColumn', 0, null]],
                null,
                'CASCADE',
                null,
            ],
            'REFERENCES anotherTable(aColumn) ON DELETE SET NULL' => [
                'REFERENCES anotherTable(aColumn) ON DELETE SET NULL',
                'anotherTable',
                [['aColumn', 0, null]],
                null,
                'SET NULL',
                null,
            ],
            'REFERENCES anotherTable(aColumn) ON DELETE NO ACTION' => [
                'REFERENCES anotherTable(aColumn) ON DELETE NO ACTION',
                'anotherTable',
                [['aColumn', 0, null]],
                null,
                'NO ACTION',
                null,
            ],
            'REFERENCES anotherTable(aColumn) ON UPDATE RESTRICT' => [
                'REFERENCES anotherTable(aColumn) ON UPDATE RESTRICT',
                'anotherTable',
                [['aColumn', 0, null]],
                null,
                null,
                'RESTRICT',
            ],
            'REFERENCES anotherTable(aColumn) ON UPDATE CASCADE' => [
                'REFERENCES anotherTable(aColumn) ON UPDATE CASCADE',
                'anotherTable',
                [['aColumn', 0, null]],
                null,
                null,
                'CASCADE',
            ],
            'REFERENCES anotherTable(aColumn) ON UPDATE SET NULL' => [
                'REFERENCES anotherTable(aColumn) ON UPDATE SET NULL',
                'anotherTable',
                [['aColumn', 0, null]],
                null,
                null,
                'SET NULL',
            ],
            'REFERENCES anotherTable(aColumn) ON UPDATE NO ACTION' => [
                'REFERENCES anotherTable(aColumn) ON UPDATE NO ACTION',
                'anotherTable',
                [['aColumn', 0, null]],
                null,
                null,
                'NO ACTION',
            ],
            'REFERENCES anotherTable(uid, `hash`(199) DESC) MATCH PARTIAL ON DELETE RESTRICT ON UPDATE SET NULL' => [
                'REFERENCES anotherTable(uid, `hash`(199) DESC) MATCH PARTIAL ON DELETE RESTRICT ON UPDATE SET NULL',
                'anotherTable',
                [['uid', 0, null], ['hash', 199, 'DESC']],
                'PARTIAL',
                'RESTRICT',
                'SET NULL',
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseReferenceDefinitionDataProvider
     * @param string $columnAttribute
     * @param string $table
     * @param array $columns
     * @param string $match
     * @param string $onDelete
     * @param string $onUpdate
     */
    public function canParseReferenceDefinition(
        string $columnAttribute,
        string $table,
        array $columns,
        string $match = null,
        string $onDelete = null,
        string $onUpdate = null
    ) {
        $statement = sprintf('CREATE TABLE `aTable`(`aField` INT(11) %s)', $columnAttribute);
        $subject = $this->createSubject($statement);

        $this->assertInstanceOf(ReferenceDefinition::class, $subject);
        $this->assertSame($table, $subject->tableName->schemaObjectName);
        $this->assertSame($match, $subject->match);
        $this->assertSame($onDelete, $subject->onDelete);
        $this->assertSame($onUpdate, $subject->onUpdate);

        foreach ($columns as $index => $column) {
            $this->assertSame($column[0], $subject->columnNames[$index]->columnName->schemaObjectName);
            $this->assertSame($column[1], $subject->columnNames[$index]->length);
            $this->assertSame($column[2], $subject->columnNames[$index]->direction);
        }
    }

    /**
     * Parse the CREATE TABLE statement and return the reference definition
     *
     * @param string $statement
     * @return \MojoCode\SqlParser\AST\ReferenceDefinition
     */
    protected function createSubject(string $statement): ReferenceDefinition
    {
        $parser = new Parser($statement);
        $createTableStatement = $parser->parse()[0];

        return $createTableStatement->createDefinition->items[0]->reference;
    }
}
