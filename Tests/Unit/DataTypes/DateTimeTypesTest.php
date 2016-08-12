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
use MojoCode\SqlParser\StatementException;
use MojoCode\SqlParser\Tests\Unit\AbstractDataTypeBaseTestCase;

class DateTimeTypesTestAbstract extends AbstractDataTypeBaseTestCase
{
    /**
     * Data provider for canParseDateTimeType()
     *
     * @return array
     */
    public function canParseDateTimeTypeProvider(): array
    {
        return [
            'DATE' => [
                'DATE',
                null,
            ],
            'YEAR' => [
                'YEAR',
                null,
            ],
            'TIME' => [
                'TIME',
                null,
            ],
            'TIME with fractional second part' => [
                'TIME(3)',
                null,
            ],
            'TIMESTAMP' => [
                'TIMESTAMP',
                null,
            ],
            'TIMESTAMP with fractional second part' => [
                'TIMESTAMP(3)',
                null,
            ],
            'DATETIME' => [
                'DATETIME',
                null,
            ],
            'DATETIME with fractional second part' => [
                'DATETIME(3)',
                null,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseDateTimeTypeProvider
     * @param string $columnDefinition
     * @param mixed $expectedResult
     */
    public function canParseDateTimeType(string $columnDefinition, $expectedResult)
    {
        $subject = new Parser($this->createTableStatement($columnDefinition));
        $subject->parse();
    }

    /**
     * @test
     */
    public function parseDateTimeTypeWithInvalidLowerBound()
    {
        $this->expectException(StatementException::class);
        $this->expectExceptionMessageRegExp(
            '@Error: the fractional seconds part for TIME, DATETIME or TIMESTAMP columns must >= 0@'
        );
        $subject = new Parser($this->createTableStatement('TIME(-1)'));
        $subject->parse();
    }

    /**
     * @test
     */
    public function parseDateTimeTypeWithInvalidUpperBound()
    {
        $this->expectException(StatementException::class);
        $this->expectExceptionMessageRegExp(
            '@Error: the fractional seconds part for TIME, DATETIME or TIMESTAMP columns must <= 6@'
        );
        $subject = new Parser($this->createTableStatement('DATETIME(7)'));
        $subject->parse();
    }
}
