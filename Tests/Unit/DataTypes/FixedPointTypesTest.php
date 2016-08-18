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

use MojoCode\SqlParser\AST\DataType\DecimalDataType;
use MojoCode\SqlParser\AST\DataType\NumericDataType;
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
                DecimalDataType::class,
                null,
                null,
            ],
            'DECIMAL with precision' => [
                'DECIMAL(5)',
                DecimalDataType::class,
                5,
                null,
            ],
            'DECIMAL with precision and scale' => [
                'DECIMAL(5,2)',
                DecimalDataType::class,
                5,
                2,
            ],
            'NUMERIC without length' => [
                'NUMERIC',
                NumericDataType::class,
                null,
                null,
            ],
            'NUMERIC with length' => [
                'NUMERIC(5)',
                NumericDataType::class,
                5,
                null,
            ],
            'NUMERIC with length and precision' => [
                'NUMERIC(5,2)',
                NumericDataType::class,
                5,
                2,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseFixedPointTypesProvider
     * @param string $columnDefinition
     * @param string $className
     * @param int $precision
     * @param int $scale
     */
    public function canParseDataType(
        string $columnDefinition,
        string $className,
        int $precision = null,
        int $scale = null
    ) {
        $subject = $this->createSubject($columnDefinition);

        $this->assertInstanceOf($className, $subject->dataType);
        $this->assertSame($precision, $subject->dataType->precision);
        $this->assertSame($scale, $subject->dataType->scale);
    }
}
