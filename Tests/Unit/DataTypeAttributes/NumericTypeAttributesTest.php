<?php
declare(strict_types = 1);

namespace MojoCode\SqlParser\Tests\Unit\DataTypeAttributes;

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
class NumericTypeAttributesTestAbstract extends AbstractDataTypeBaseTestCase
{

    /**
     * Data provider for canParseNumericDataTypeAttributes()
     *
     * @return array
     */
    public function canParseNumericDataTypeAttributesProvider(): array
    {
        return [
            'UNSIGNED' => [
                'INT(11) UNSIGNED',
                null,
            ],
            'ZEROFILL' => [
                'INT(11) ZEROFILL',
                null,
            ],
            'UNSIGNED ZEROFILL' => [
                'INT(11) UNSIGNED ZEROFILL',
                null,
            ]
        ];
    }

    /**
     * @test
     * @dataProvider canParseNumericDataTypeAttributesProvider
     * @param string $columnDefinition
     * @param mixed $expectedResult
     */
    public function canParseNumericDataTypeAttributes(string $columnDefinition, $expectedResult)
    {
        $subject = new Parser($this->createTableStatement($columnDefinition));
        $subject->parse();
    }
}
