<?php
declare(strict_types = 1);

namespace MojoCode\SqlParser\Tests\Unit\DataTypes;

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
use MojoCode\SqlParser\Tests\Unit\AbstractDataTypeBaseTestCase;

/**
 * MySQL supports the SQL standard integer types INTEGER (or INT) and SMALLINT.
 * As an extension to the standard, MySQL also supports the integer types TINYINT, MEDIUMINT, and BIGINT.
 */
class IntegerTypesTestAbstract extends AbstractDataTypeBaseTestCase
{
    /**
     * Data provider for canParseIntegerDataType()
     *
     * @return array
     */
    public function canParseIntegerDataTypeProvider(): array
    {
        return [
            'TINYINT without length' => [
                'TINYINT',
                null,
            ],
            'SMALLINT without length' => [
                'SMALLINT',
                null,
            ],
            'MEDIUMINT without length' => [
                'MEDIUMINT',
                null,
            ],
            'INT without length' => [
                'INT',
                null,
            ],
            'INTEGER without length' => [
                'INTEGER',
                null,
            ],
            'BIGINT without length' => [
                'BIGINT',
                null,
            ],
            // MySQL supports an extension for optionally specifying the display width of integer data types
            // in parentheses following the base keyword for the type. For example, INT(4) specifies an INT
            // with a display width of four digits.
            // The display width does not constrain the range of values that can be stored in the column.
            'TINYINT with length' => [
                'TINYINT(4)',
                null,
            ],
            'SMALLINT with length' => [
                'SMALLINT(6)',
                null,
            ],
            'MEDIUMINT with length' => [
                'MEDIUMINT(8)',
                null,
            ],
            'INT with length' => [
                'INT(11)',
                null,
            ],
            'INTEGER with length' => [
                'INTEGER(11)',
                null,
            ],
            'BIGINT with length' => [
                'BIGINT(20)',
                null,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseIntegerDataTypeProvider
     * @param string $columnDefinition
     * @param mixed $expectedResult
     */
    public function canParseIntegerDataType(string $columnDefinition, $expectedResult)
    {
        $subject = new Parser($this->createTableStatement($columnDefinition));
        $subject->parse();
    }
}
