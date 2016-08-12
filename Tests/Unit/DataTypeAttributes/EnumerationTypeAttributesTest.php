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
class EnumerationTypeAttributesTestAbstract extends AbstractDataTypeBaseTestCase
{

    /**
     * Data provider for canParseEnumerationDataTypeAttributes()
     *
     * @return array
     */
    public function canParseEnumerationDataTypeAttributesProvider(): array
    {
        return [
            'CHARACTER SET' => [
                "ENUM('value1', 'value2') CHARACTER SET latin1",
                null,
            ],
            'COLLATE' => [
                "SET('value1', 'value2')  COLLATE latin1_german1_ci",
                null,
            ],
            'CHARACTER SET + COLLATE' => [
                "SET('value1', 'value2') CHARACTER SET latin1 COLLATE latin1_german1_ci",
                null,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseEnumerationDataTypeAttributesProvider
     * @param string $columnDefinition
     * @param mixed $expectedResult
     */
    public function canParseEnumerationDataTypeAttributes(string $columnDefinition, $expectedResult)
    {
        $subject = new Parser($this->createTableStatement($columnDefinition));
        $subject->parse();
    }
}
