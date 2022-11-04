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
     * @param string      $providedType  Current type of the $value
     * @param array       $allowed_types Array of allowed types [Type::*]
     * @param string|null $var_name      Name of the variable (to be included in error message)
     */
    public function __construct(string $providedType, array $allowed_types, ?string $var_name = null)
    {
        $var_name ??= 'ITEM';

        switch (\count($allowed_types)) {
            case 0:
                throw new \InvalidArgumentException('allowed_types array must not be empty.');

            case 1:
                $msg = '"%s" must be %s but %s found.';
                break;

            default;
                $msg = '"%s" must be one of allowed types: %s but %s found.';
                break;
        }

        parent::__construct(\sprintf($msg, $var_name, implode(', ', $allowed_types), $providedType));
    }

} // end of class
