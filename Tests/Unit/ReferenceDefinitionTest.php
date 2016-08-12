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

use MojoCode\SqlParser\Parser;
use PHPUnit\Framework\TestCase;

class ReferenceDefinitionTest extends TestCase
{
    public function canParseReferenceDefinitionDataProvider(): array
    {
        return [
            'REFERENCES `anotherTable`(`aColumn`)' => [
                'REFERENCES `anotherTable`(`aColumn`)',
                null
            ],
            'REFERENCES `anotherTable`(`aColumn`, anotherColumn)' => [
                'REFERENCES `anotherTable`(`aColumn`, anotherColumn)',
                null
            ],
            'REFERENCES `anotherTable`(`aColumn`(199),`anotherColumn`)' => [
                'REFERENCES `anotherTable`(`aColumn`(199),`anotherColumn`)',
                null
            ],
            'REFERENCES `anotherTable`(`aColumn`(199) ASC, anotherColumn DESC)' => [
                'REFERENCES `anotherTable`(`aColumn`(199) ASC, anotherColumn DESC)',
                null
            ],
            'REFERENCES anotherTable(aColumn) MATCH FULL' => [
                'REFERENCES anotherTable(aColumn) MATCH FULL',
                null
            ],
            'REFERENCES anotherTable(aColumn) MATCH PARTIAL' => [
                'REFERENCES anotherTable(aColumn) MATCH PARTIAL',
                null
            ],
            'REFERENCES anotherTable(aColumn) MATCH SIMPLE' => [
                'REFERENCES anotherTable(aColumn) MATCH SIMPLE',
                null
            ],
            'REFERENCES anotherTable(aColumn) ON DELETE RESTRICT' => [
                'REFERENCES anotherTable(aColumn) ON DELETE RESTRICT',
                null
            ],
            'REFERENCES anotherTable(aColumn) ON DELETE CASCADE' => [
                'REFERENCES anotherTable(aColumn) ON DELETE CASCADE',
                null
            ],
            'REFERENCES anotherTable(aColumn) ON DELETE SET NULL' => [
                'REFERENCES anotherTable(aColumn) ON DELETE SET NULL',
                null
            ],
            'REFERENCES anotherTable(aColumn) ON DELETE NO ACTION' => [
                'REFERENCES anotherTable(aColumn) ON DELETE NO ACTION',
                null
            ],
            'REFERENCES anotherTable(aColumn) ON UPDATE RESTRICT' => [
                'REFERENCES anotherTable(aColumn) ON UPDATE RESTRICT',
                null
            ],
            'REFERENCES anotherTable(aColumn) ON UPDATE CASCADE' => [
                'REFERENCES anotherTable(aColumn) ON UPDATE CASCADE',
                null
            ],
            'REFERENCES anotherTable(aColumn) ON UPDATE SET NULL' => [
                'REFERENCES anotherTable(aColumn) ON UPDATE SET NULL',
                null
            ],
            'REFERENCES anotherTable(aColumn) ON UPDATE NO ACTION' => [
                'REFERENCES anotherTable(aColumn) ON UPDATE NO ACTION',
                null
            ],
            'REFERENCES anotherTable(uid, `hash`(199) DESC) MATCH PARTIAL ON DELETE RESTRICT ON UPDATE SET NULL' => [
                'REFERENCES anotherTable(uid, `hash`(199) DESC) MATCH PARTIAL ON DELETE RESTRICT ON UPDATE SET NULL',
                null
            ],
        ];
    }

    /**
     * @test
     * @dataProvider canParseReferenceDefinitionDataProvider
     * @param string $columnAttribute
     */
    public function canParseReferenceDefinition(string $columnAttribute, $expectedResult)
    {
        $statement = sprintf('CREATE TABLE `aTable`(`aField` INT(11) %s)', $columnAttribute);
        $subject = new Parser($statement);
        $subject->parse();
    }
}
