<?php
declare(strict_types = 1);

namespace MojoCode\SqlParser\AST;

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

/**
 * Scans a MySQL CREATE TABLE statement for tokens.
 *
 * @author Morton Jonuschat <m.jonuschat@mojocode.de>
 */
class CreateTableStatement extends AbstractCreateStatement
{
    /**
     * CreateTableStatement constructor.
     *
     * @param \MojoCode\SqlParser\AST\CreateTableClause $createTableClause
     * @param \MojoCode\SqlParser\AST\CreateDefinition $createDefinition
     */
    public function __construct(CreateTableClause $createTableClause, CreateDefinition $createDefinition)
    {
    }
}
