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

use MojoCode\SqlParser\AST\DataType\LongTextDataType;
use MojoCode\SqlParser\AST\DataType\MediumTextDataType;
use MojoCode\SqlParser\AST\DataType\TextDataType;
use MojoCode\SqlParser\AST\DataType\TinyTextDataType;
use MojoCode\SqlParser\Parser;
use MojoCode\SqlParser\Tests\Unit\AbstractDataTypeBaseTestCase;

/**
 * MySQL supports the SQL standard integer types INTEGER (or INT) and SMALLINT.
 * As an extension to the standard, MySQL also supports the integer types TINYINT, MEDIUMINT, and BIGINT.
 */
class TextTypesTestAbstract extends AbstractDataTypeBaseTestCase
{
    /**
     * Data provider for canParseTextDataType()
     *
     * @return array
     */
    public function canParseTextDataTypeProvider(): array
    {
        return [
            'TINYTEXT' => [
                'TINYTEXT',
                TinyTextDataType::class,
            ],
            'TEXT' => [
                'TEXT',
                TextDataType::class,
            ],
            'MEDIUMTEXT' => [
                'MEDIUMTEXT',
                MediumTextDataType::class,
            ],
            'LONGTEXT' => [
                'LONGTEXT',
                LongTextDataType::class,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseTextDataTypeProvider
     * @param string $columnDefinition
     * @param string $className
     */
    public function canParseDataType(string $columnDefinition, string $className)
    {
        $subject = $this->createSubject($columnDefinition);

        $this->assertInstanceOf($className, $subject->dataType);
    }
}
