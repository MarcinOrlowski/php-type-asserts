<?php
declare(strict_types=1);

/**
 * PHP Type Asserts
 *
 * @author    Marcin Orlowski
 * @copyright 2014-2022 Marcin Orlowski
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/MarcinOrlowski/php-type-asserts
 */

namespace MarcinOrlowski\TypeAsserts\Exception;

class InvalidTypeException extends \Exception implements InvalidTypeExceptionContract
{
    /**
     * NotAnTypeBaseException constructor.
     *
     * @param string      $providedType Current type of the $value
     * @param array       $allowedTypes Array of allowed types [Type::*]
     * @param string|null $variableName Name of the variable (to be included in error message)
     */
    public function __construct(string $providedType, array $allowedTypes, ?string $variableName = null)
    {
        $variableName ??= 'ITEM';

        switch (\count($allowedTypes)) {
            case 0:
                throw new \InvalidArgumentException('allowedTypes array must not be empty.');

            case 1:
                $msg = '"%1$s" must be %2$s but %3$s found.';
                break;

            default;
                $msg = '"%1$s" must be one of allowed types: %2$s but %3$s found.';
                break;
        }

        parent::__construct(\sprintf($msg, $variableName, implode(', ', $allowedTypes), $providedType));
    }

} // end of class
