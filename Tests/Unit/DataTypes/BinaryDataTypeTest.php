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

class BinaryAbstractDataTypeTest extends AbstractDataTypeBaseTestCase
{
    /**
     * Data provider for canParseBinaryDataType()
     *
     * @return array
     */
    public function canParseBinaryDataTypeProvider(): array
    {
        return [
            'BINARY without length' => [
                'BINARY',
                null,
            ],
            'BINARY with length' => [
                'BINARY(200)',
                null,
            ],
            'VARBINARY without length' => [
                'VARBINARY',
                null,
            ],
            'VARBINARY with length' => [
                'VARBINARY(200)',
                null,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseBinaryDataTypeProvider
     * @param string $columnDefinition
     * @param mixed $expectedResult
     */
    public function canParseBinaryDataType(string $columnDefinition, $expectedResult)
    {
        $subject = new Parser($this->createTableStatement($columnDefinition));
        $subject->parse();
    }
}
