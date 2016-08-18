<?php
declare(strict_types = 1);

namespace MojoCode\SqlParser\AST\DataType;

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

class EnumDataType extends AbstractDataType
{
    /**
     * @var array
     */
    public $values;

    /**
     * @var array
     */
    public $options;

    /**
     * EnumDataType constructor.
     *
     * @param array $values
     * @param array $options
     */
    public function __construct(array $values, array $options)
    {
        $this->values = $values;
        $this->options = $options;
    }
}
