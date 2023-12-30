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
     * Checks if $item (of name $key) is of type that is include in $allowed_types (there's `OR`
     * connection between specified types).
     *
     * @param mixed           $value          Variable to be asserted.
     * @param string|string[] $allowedTypes   Array of allowed types for $value, i.e.
     *                                        [Type::INTEGER]
     * @param string          $exceptionClass Name of exception class (which implements
     *                                        Ex\InvalidTypeExceptionContract) to be used when
     *                                        assertion fails. In that case object of that class
     *                                        will be instantiated and thrown.
     * @param string|null     $variableName   Label or name of the variable to use exception
     *                                        message.
     *
     */
    public static function assertIsType(mixed        $value,
                                        string|array $allowedTypes,
                                        string       $exceptionClass = Ex\InvalidTypeException::class,
                                        ?string      $variableName = null): void
    {
        $allowedTypes = (array)$allowedTypes;
        if (empty($allowedTypes)) {
            throw new \InvalidArgumentException('List of allowed types cannot be empty.');
        }
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

        $providedType = \gettype($value) === 'object' ? 'object' : \get_debug_type($value);
        if (!\in_array($providedType, $allowedTypes, true)) {
            // FIXME we need to ensure $exClass implements Ex\InvalidTypeExceptionContract
            /* @phpstan-ignore-next-line */
            throw new $exceptionClass($providedType, $allowedTypes, $variableName);
        }
    }

    /* ****************************************************************************************** */

    public static function assertIsArray(mixed $value, ?string $variableName = null): void
    {
        self::assertIsType($value, Type::ARRAY, Ex\NotArrayException::class, $variableName);
    }

    public static function assertIsBool(mixed $value, ?string $variableName = null): void
    {
        self::assertIsType($value, Type::BOOL, Ex\NotBooleanException::class, $variableName);
    }

    public static function assertIsFloat(mixed $value, ?string $variableName = null): void
    {
        self::assertIsType($value, Type::FLOAT, Ex\NotFloatException::class, $variableName);
    }

    public static function assertIsInt(mixed $value, ?string $variableName = null): void
    {
        self::assertIsType($value, Type::INT, Ex\NotIntegerException::class, $variableName);
    }

    public static function assertIsObject(mixed $value, ?string $variableName = null): void
    {
        self::assertIsType($value, Type::OBJECT, Ex\NotObjectException::class, $variableName);
    }

    public static function assertIsString(mixed $value, ?string $variableName = null): void
    {
        self::assertIsType($value, Type::STRING, Ex\NotStringException::class, $variableName);
    }

} // end of class
