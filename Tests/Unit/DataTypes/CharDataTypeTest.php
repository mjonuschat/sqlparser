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

use MojoCode\SqlParser\AST\DataType\BinaryDataType;
use MojoCode\SqlParser\AST\DataType\CharDataType;
use MojoCode\SqlParser\AST\DataType\VarBinaryDataType;
use MojoCode\SqlParser\AST\DataType\VarCharDataType;
use MojoCode\SqlParser\Tests\Unit\AbstractDataTypeBaseTestCase;

class CharDataTypeTest extends AbstractDataTypeBaseTestCase
{
    /**
     * Data provider for canParseBinaryDataType()
     *
     * @return array
     */
    public function canParseBinaryDataTypeProvider(): array
    {
        return [
            'CHAR without length' => [
                'CHAR',
                CharDataType::class,
                0,
            ],
            'CHAR with length' => [
                'CHAR(200)',
                CharDataType::class,
                200,
            ],
            'VARCHAR without length' => [
                'VARCHAR',
                VarCharDataType::class,
                0,
            ],
            'VARCHAR with length' => [
                'VARCHAR(200)',
                VarCharDataType::class,
                200,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseBinaryDataTypeProvider
     * @param string $columnDefinition
     * @param string $className
     * @param int $length
     */
    public function canParseDataType(string $columnDefinition, string $className, int $length)
    {
        $subject = $this->createSubject($columnDefinition);

        $this->assertInstanceOf($className, $subject->dataType);
        $this->assertSame($length, $subject->dataType->length);
    }
}
