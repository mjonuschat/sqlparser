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

class SetAbstractDataTypeTest extends AbstractDataTypeBaseTestCase
{
    /**
     * Data provider for canParseSetDataType()
     *
     * @return array
     */
    public function canParseSetDataTypeProvider(): array
    {
        return [
            'SET(value)' => [
                "SET('value1')",
                null,
            ],
            'SET(value,value)' => [
                "SET('value1','value2')",
                null,
            ],
            'SET(value, value)' => [
                "SET('value1', 'value2')",
                null,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseSetDataTypeProvider
     * @param string $columnDefinition
     * @param mixed $expectedResult
     */
    public function canParseSetDataType(string $columnDefinition, $expectedResult)
    {
        $subject = new Parser($this->createTableStatement($columnDefinition));
        $subject->parse();
    }
}
