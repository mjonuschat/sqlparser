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

use MojoCode\SqlParser\AST\CreateTableStatement;
use MojoCode\SqlParser\Parser;
use PHPUnit\Framework\TestCase;

class CreateTableFragmentTest extends TestCase
{
    /**
     * Each parameter array consists of the following values:
     *  - create table SQL fragment
     *  - table name
     *  - is temporary
     *
     * @return array
     */
    public function canParseCreateTableFragmentDataProvider(): array
    {
        return [
            'CREATE TABLE' => [
                'CREATE TABLE aTable (aField INT)',
                'aTable',
                false
            ],
            'CREATE TEMPORARY TABLE' => [
                'CREATE TEMPORARY TABLE aTable (aField INT)',
                'aTable',
                true
            ],
            'CREATE TABLE IF NOT EXISTS' => [
                'CREATE TABLE IF NOT EXISTS aTable (aField INT)',
                'aTable',
                false
            ],
            'CREATE TEMPORARY TABLE IF NOT EXISTS' => [
                'CREATE TEMPORARY TABLE IF NOT EXISTS aTable (aField INT)',
                'aTable',
                true
            ],
            'CREATE TABLE (quoted table name)' => [
                'CREATE TABLE `aTable` (aField INT)',
                'aTable',
                false
            ],
            'CREATE TEMPORARY TABLE (quoted table name)' => [
                'CREATE TEMPORARY TABLE `aTable` (aField INT)',
                'aTable',
                true
            ],
            'CREATE TABLE IF NOT EXISTS (quoted table name)' => [
                'CREATE TABLE IF NOT EXISTS `aTable` (aField INT)',
                'aTable',
                false
            ],
            'CREATE TEMPORARY TABLE IF NOT EXISTS (quoted table name)' => [
                'CREATE TEMPORARY TABLE IF NOT EXISTS `aTable` (aField INT)',
                'aTable',
                true
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseCreateTableFragmentDataProvider
     * @param string $statement
     * @param string $tableName
     * @param bool $isTemporary
     */
    public function canParseCreateTableFragment(string $statement, string $tableName, bool $isTemporary)
    {
        $subject = $this->createSubject($statement);
        $this->assertInstanceOf(CreateTableStatement::class, $subject);
        $this->assertSame($tableName, $subject->tableName->schemaObjectName);
        $this->assertSame($isTemporary, $subject->isTemporary);
    }

    /**
     * Parse the CREATE TABLE statement and return the reference definition
     *
     * @param string $statement
     * @return \MojoCode\SqlParser\AST\CreateTableStatement
     */
    protected function createSubject(string $statement): CreateTableStatement
    {
        $parser = new Parser($statement);
        return $parser->parse()[0];
    }
}
