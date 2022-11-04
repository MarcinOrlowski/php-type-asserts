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

namespace MarcinOrlowski\TypeAsserts;

use MarcinOrlowski\TypeAsserts\Exception as Ex;

/**
 * Data validator helper
 */
class Validator
{
    /**
     * Checks if $item (of name $key) is of type that is include in $allowed_types (there's `OR` connection
     * between specified types).
     *
     * @param mixed           $value          Variable to be asserted.
     * @param string|string[] $allowedTypes   Array of allowed types for $value, i.e. [Type::INTEGER]
     * @param string          $exceptionClass Name of exception class (which implements
     *                                        Ex\InvalidTypeExceptionContract) to be used when assertion
     *                                        fails. In that case object of that class will be instantiated
     *                                        and thrown.
     * @param string|null     $variableName   Label or name of the variable to use exception message.
     *
     */
    public static function assertIsType(mixed        $value,
                                        string|array $allowedTypes,
                                        string       $exceptionClass = Ex\InvalidTypeException::class,
                                        ?string      $variableName = null): void
    {
        $allowedTypes = (array)$allowedTypes;

        // Type::EXISTING_CLASS is artificial type, so we need separate logic to handle it.
        $filteredAllowedTypes = $allowedTypes;
        $idx = \array_search(Type::EXISTING_CLASS, $filteredAllowedTypes, true);
        if ($idx !== false) {
            // Remove the type, so gettype() test loop won't see it.
            unset($filteredAllowedTypes[ $idx ]);
            if (\is_string($value) && \class_exists($value)) {
                // It's existing class, no need to test further.
                return;
            }
        }

        $type = \get_debug_type($value);
        if (empty($filteredAllowedTypes)) {
            throw new \InvalidArgumentException('List of allowed types cannot be empty.');
        }
        if (!\in_array($type, $filteredAllowedTypes, true)) {
            // FIXME we need to ensure $exClass implements Ex\InvalidTypeExceptionContract at some point.
            throw new $exceptionClass($type, $filteredAllowedTypes, $variableName);
        }
    }

    /* **************************************************************************************************** */

} // end of class
