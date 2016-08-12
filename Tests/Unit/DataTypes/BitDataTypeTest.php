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

class BitAbstractDataTypeTest extends AbstractDataTypeBaseTestCase
{
    /**
     * Data provider for canParseBitDataType()
     *
     * @return array
     */
    public function canParseBitDataTypeProvider(): array
    {
        return [
            'BIT without length' => [
                'BIT',
                null,
            ],
            'BIT with length' => [
                'BIT(8)',
                null,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseBitDataTypeProvider
     * @param string $columnDefinition
     * @param mixed $expectedResult
     */
    public function canParseBitDataType(string $columnDefinition, $expectedResult)
    {
        $subject = new Parser($this->createTableStatement($columnDefinition));
        $subject->parse();
    }
}
