# PHP Type Asserts #

[![Latest Stable Version](https://poser.pugx.org/marcin-orlowski/php-type-asserts/v/stable)](https://packagist.org/packages/marcin-orlowski/php-type-asserts)
[![License](https://poser.pugx.org/marcin-orlowski/php-type-asserts/license)](https://packagist.org/packages/marcin-orlowski/php-type-asserts)

PHP Data type assertions.

---

This package provides helper methods to validate variable data type. While there are handy native
methods like `is_string()` or `is_array()`, you can have then check for single type at a time.
This package allows to validate against type union (i.e. `STRING|INT`) or ensure that priovided
`string` refers to existing class. Also, contrary to native methods, if there's no match and
variable contains data of non-welcomed type, exception is thrown which lets you simplify your
code flow.

## Installation ##

```bash
composer require --dev marcin-orlowski/type-asserts
```

----

## Usage example ##

The following code ensures `$var` is of either `int` or `float` type before math is done:

```php
use MarcinOrlowski\TypeAsserts\Type;
use MarcinOrlowski\TypeAsserts\Validator;

$var = 'foo';

Validator::assertIsType($var, [Type::INT, Type::FLOAT]);
$result = $var * 5;
```

The following code ensures `$var` refers to existing class, before we try to instantiate it:

```php
use MarcinOrlowski\TypeAsserts\Type;
use MarcinOrlowski\TypeAsserts\Validator;

$cls = 'non-existing';

Validator::assertIsType($cls, Type::EXISTING_CLASS);
$obj = new $cls;
```

----

## License ##

* Written and copyrighted &copy;2014-2022 by Marcin Orlowski
* Open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
