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
 * MySQL supports the SQL standard integer types INTEGER (or INT) and SMALLINT.
 * As an extension to the standard, MySQL also supports the integer types TINYINT, MEDIUMINT, and BIGINT.
 */
class BlobTypesTestAbstract extends AbstractDataTypeBaseTestCase
{
    /**
     * Data provider for canParseBlobDataType()
     *
     * @return array
     */
    public function canParseBlobDataTypeProvider(): array
    {
        return [
            'TINYBLOB' => [
                'TINYBLOB',
                null,
            ],
            'BLOB' => [
                'BLOB',
                null,
            ],
            'MEDIUMBLOB' => [
                'MEDIUMBLOB',
                null,
            ],
            'LONGBLOB' => [
                'LONGBLOB',
                null,
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseBlobDataTypeProvider
     * @param string $columnDefinition
     * @param mixed $expectedResult
     */
    public function canParseBlobDataType(string $columnDefinition, $expectedResult)
    {
        $subject = new Parser($this->createTableStatement($columnDefinition));
        $subject->parse();
    }
}
