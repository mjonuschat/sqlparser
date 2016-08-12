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
 * The DECIMAL and NUMERIC types store exact numeric data values.
 */
class FixedPointTypesTestAbstract extends AbstractDataTypeBaseTestCase
{
    /**
     * Data provider for canParseFixedPointTypes()
     *
     * @return array
     */
    public function canParseFixedPointTypesProvider(): array
    {
        return [
            'DECIMAL without precision and scale' => [
                'DECIMAL',
                null,
            ],
            'DECIMAL with precision' => [
                'DECIMAL(5)',
                null,
            ],
            'DECIMAL with precision and scale' => [
                'DECIMAL(5,2)',
                null,
            ],
            'NUMERIC without length' => [
                'NUMERIC',
                null,
            ],
            'NUMERIC with length' => [
                'NUMERIC(5)',
                null,
            ],
            'NUMERIC with length and precision' => [
                'NUMERIC(5,2)',
                null,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseFixedPointTypesProvider
     * @param string $columnDefinition
     * @param mixed $expectedResult
     */
    public function canParseFixedPointTypes(string $columnDefinition, $expectedResult)
    {
        $subject = new Parser($this->createTableStatement($columnDefinition));
        $subject->parse();
    }
}
