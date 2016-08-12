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
 * The FLOAT and DOUBLE types represent approximate numeric data values.
 */
class FloatingPointTypesTestAbstract extends AbstractDataTypeBaseTestCase
{
    /**
     * Data provider for canParseFloatingPointTypes()
     *
     * @return array
     */
    public function canParseFloatingPointTypesProvider(): array
    {
        return [
            'FLOAT without precision' => [
                'FLOAT',
                null,
            ],
            'FLOAT with precision' => [
                'FLOAT(44)',
                null,
            ],
            'FLOAT with precision and decimals' => [
                'FLOAT(44,5)',
                null,
            ],
            'REAL without precision' => [
                'REAL',
                null,
            ],
            'REAL with precision' => [
                'REAL(44)',
                null,
            ],
            'REAL with precision and decimals' => [
                'REAL(44,5)',
                null,
            ],
            'DOUBLE without precision' => [
                'DOUBLE',
                null,
            ],
            'DOUBLE with precision' => [
                'DOUBLE(44)',
                null,
            ],
            'DOUBLE with precision and decimals' => [
                'DOUBLE(44,5)',
                null,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseFloatingPointTypesProvider
     * @param string $columnDefinition
     * @param mixed $expectedResult
     */
    public function canParseFloatingPointTypes(string $columnDefinition, $expectedResult)
    {
        $subject = new Parser($this->createTableStatement($columnDefinition));
        $subject->parse();
    }
}
