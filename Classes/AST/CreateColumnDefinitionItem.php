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

use MojoCode\SqlParser\AST\DataType\AbstractDataType;

class CreateColumnDefinitionItem extends AbstractCreateDefinitionItem
{
    /**
     * Allow NULL values
     *
     * @var bool
     */
    public $null = true;

    /**
     * Explicit default value
     *
     * @var bool
     */
    public $hasDefaultValue = false;

    /**
     * The explicit default value
     *
     * @var mixed
     */
    public $defaultValue;

    /**
     * Set auto increment flag
     *
     * @var bool
     */
    public $autoIncrement = false;

    /**
     * Create non-unique index for column
     *
     * @var bool
     */
    public $index = false;

    /**
     * Create unique constraint for column
     *
     * @var bool
     */
    public $unique = false;

    /**
     * Use column as primary key for table
     *
     * @var bool
     */
    public $primary = false;

    /**
     * Column comment
     *
     * @var string
     */
    public $comment;

    /**
     * The column format (DYNAMIC or FIXED)
     *
     * @var string
     */
    public $columnFormat;

    /**
     * The storage type for the column (ignored unless MySQL Cluster with NDB Engine)
     *
     * @var string
     */
    public $storage;

    /**
     * @var ReferenceDefinition
     */
    public $reference;

    /**
     * CreateColumnDefinitionItem constructor.
     *
     * @param \MojoCode\SqlParser\AST\Identifier $columnName
     * @param \MojoCode\SqlParser\AST\DataType\AbstractDataType $dataType
     */
    public function __construct(Identifier $columnName, AbstractDataType $dataType)
    {
    }
}
