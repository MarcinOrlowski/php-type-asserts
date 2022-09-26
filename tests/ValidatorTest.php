<?php
declare(strict_types=1);

namespace MarcinOrlowski\TypeAsserts\Tests;

/**
 * Laravel API Response Builder
 *
 * @package   MarcinOrlowski\ResponseBuilder
 *
 * @author    Marcin Orlowski <mail (#) marcinOrlowski (.) com>
 * @copyright 2016-2022 Marcin Orlowskis
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/MarcinOrlowski/laravel-api-response-builder
 */

use MarcinOrlowski\TypeAsserts\Type;
use MarcinOrlowski\TypeAsserts\Validator;

/**
 * Class ValidatorTest
 *
 * @package MarcinOrlowski\ResponseBuilder\Tests
 */
class ValidatorTest extends TestCase
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
        $test_data = [
//            [
//                'item'     => false,
//                'types'    => [type::STRING],
//                'expected' => false,
//            ],
//            [
//                'item'     => false,
//                'types'    => [type::BOOL],
//                'expected' => true,
//            ],
//            [
//                'item'     => 'foo',
//                'types'    => [type::STRING],
//                'expected' => true,
//            ],
//            [
//                'item'     => 23,
//                'types'    => [type::STRING],
//                'expected' => false,
//            ],
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

        ];

        foreach ($test_data as $key => $data) {
            $var_name = \sprintf('test_data[%d]', $key);

            $test_passed = true;
            try {
                Validator::assertIsType($data['item'], $data['types']);
            } /** @noinspection BadExceptionsProcessingInspection */ catch (\Exception $ex) {
                $test_passed = false;
            }

            $msg = \sprintf('Entry #%d: testing if "%s" (%s) is one of these: %s.',
                $key, $data['item'], \gettype($data['item']), \implode(', ', $data['types']));
            $this->assertEquals($test_passed, $data['expected'], $msg);
        }
    }

} // end of class
