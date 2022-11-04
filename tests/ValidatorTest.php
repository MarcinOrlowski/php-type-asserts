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

namespace MarcinOrlowski\TypeAsserts\Tests;

use MarcinOrlowski\TypeAsserts\Type;
use MarcinOrlowski\TypeAsserts\Validator;

/**
 * Class ValidatorTest
 *
 * @package MarcinOrlowski\ResponseBuilder\Tests
 */
class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests assertIsType() helper.
     */
    public function testAssertTypeWithVariousData(): void
    {
        /**
         * Test data. Each entry is an array with a following keys:
         *   item    : value to be tested or array of values from which one value will be randomly picked for testing.
         *   types   : array of allowed `Type::xxx` types
         *   expected: @false if test is expected to fail (type of `item` is not in `types`), @true if it should pass.
         */
        $testData = [
            [
                'item'     => new Dummy(),
                'types'    => [Type::EXISTING_CLASS,
                               Type::OBJECT,
                ],
                'expected' => true,
            ],
            [
                'item'     => false,
                'types'    => [type::STRING],
                'expected' => false,
            ],
            [
                'item'     => false,
                'types'    => [type::BOOL],
                'expected' => true,
            ],
            [
                'item'     => 'foo',
                'types'    => [type::STRING],
                'expected' => true,
            ],
            [
                'item'     => 23,
                'types'    => [type::STRING],
                'expected' => false,
            ],
            [
                'item'     => 667,
                'types'    => [type::INT],
                'expected' => true,
            ],
            [
                'item'     => 'fail',
                'types'    => [Type::INT,
                               Type::BOOL,
                ],
                'expected' => false,
            ],
            [
                'item'     => 'string',
                'types'    => [Type::FLOAT,
                               Type::INT,
                ],
                'expected' => false,
            ],
        ];

        foreach ($testData as $key => $data) {
            $test_passed = true;
            try {
                Validator::assertIsType($data['item'], $data['types']);
                $msg = 'OK';
            } /** @noinspection BadExceptionsProcessingInspection */ catch (\Exception $ex) {
                $msg = $ex->getMessage();
                $test_passed = false;
            }
            $this->assertEquals($test_passed, $data['expected'], $msg);
        }
    }

} // end of class
