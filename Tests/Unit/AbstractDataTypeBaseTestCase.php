<?php
declare(strict_types = 1);

namespace MojoCode\SqlParser\Tests\Unit;

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

use PHPUnit\Framework\TestCase;

abstract class AbstractDataTypeBaseTestCase extends TestCase
{
    /**
     * Insert datatype to test into this create table statement
     */
    const CREATE_TABLE_STATEMENT = 'CREATE TABLE `aTable`(`aField` %s)';

    /**
     * Wrap a column definition into a create table statement for testing
     *
     * @param string $columnDefinition
     * @return string
     */
    protected function createTableStatement(string $columnDefinition): string
    {
        return sprintf(static::CREATE_TABLE_STATEMENT, $columnDefinition);
    }
}
