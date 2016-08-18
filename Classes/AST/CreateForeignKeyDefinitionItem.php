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

class CreateForeignKeyDefinitionItem extends AbstractCreateDefinitionItem
{
    /**
     * @var
     */
    public $indexName = '';

    /**
     * The index name
     *
     * @var string
     */
    public $name = '';

    /**
     * @var IndexColumnName[]
     */
    public $columnNames = [];

    /**
     * Reference definition
     *
     * @var ReferenceDefinition
     */
    public $reference;

    /**
     * CreateForeignKeyDefinitionItem constructor.
     *
     * @param \MojoCode\SqlParser\AST\Identifier $indexName
     * @param array $columnNames
     * @param \MojoCode\SqlParser\AST\ReferenceDefinition $reference
     */
    public function __construct(Identifier $indexName, array $columnNames, ReferenceDefinition $reference)
    {
        $this->indexName = $indexName;
        $this->columnNames = $columnNames;
        $this->reference = $reference;
    }
}
