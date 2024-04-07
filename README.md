# Option Array Processing and Validation Library

This library provides a simple solution for processing and validating option arrays in PHP.

[![Latest Stable Version](http://poser.pugx.org/devcoder-xyz/php-options-resolver/v)](https://packagist.org/packages/devcoder-xyz/php-options-resolver)
[![Total Downloads](http://poser.pugx.org/devcoder-xyz/php-options-resolver/downloads)](https://packagist.org/packages/devcoder-xyz/php-options-resolver)
[![Latest Unstable Version](http://poser.pugx.org/devcoder-xyz/php-options-resolver/v/unstable)](https://packagist.org/packages/devcoder-xyz/php-options-resolver)
[![License](http://poser.pugx.org/devcoder-xyz/php-options-resolver/license)](https://packagist.org/packages/devcoder-xyz/php-options-resolver)

## Installation

To install this library, use [Composer](https://getcomposer.org/)

### Run the following Composer command:

```bash
composer require devcoder-xyz/php-options-resolver
```

## Requirements

* PHP version 7.4 or higher

### Defining Required Options

Define the required options for your class using `OptionsResolver` with the expected options:

```php
<?php

use DevCoder\Resolver\Option;
use DevCoder\Resolver\OptionsResolver;

class Database
{
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver([
            new Option('host'),
            new Option('username'),
            new Option('password'),
            new Option('dbname'),
        ]);

        try {
            $this->options = $resolver->resolve($options);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException("Error: " . $e->getMessage());
        }
    }
}

// Example usage:
try {
    $database = new Database([
        'host' => 'localhost',
        'dbname' => 'app',
    ]);
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage(); // Displays: "Error: The required option 'username' is missing."
}
```

### Defining Default Options

You can also set default values for your options using `setDefaultValue` for each option:

```php
<?php

class Database
{
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver([
            (new Option('host'))->setDefaultValue('localhost'),
            (new Option('username'))->setDefaultValue('root'),
            (new Option('password'))->setDefaultValue('root'),
            (new Option('dbname'))->setDefaultValue('app'),
        ]);

        $this->options = $resolver->resolve($options);
    }
}

// Example usage:
$database = new Database([]);
var_dump($database->getOptions());
// Expected output:
// array(4) {
//     ["host"]=> string(9) "localhost"
//     ["username"]=> string(4) "root"
//     ["password"]=> string(4) "root"
//     ["dbname"]=> string(3) "app"
// }
```

### Handling Non-existent Options

If a provided option does not exist in the defined list of options, an `InvalidArgumentException` will be thrown:

```php
<?php

class Database
{
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver([
            (new Option('host'))->setDefaultValue('localhost'),
            (new Option('username'))->setDefaultValue('root'),
            (new Option('password'))->setDefaultValue('root'),
            (new Option('dbname'))->setDefaultValue('app'),
        ]);

        try {
            $this->options = $resolver->resolve($options);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException("Error: " . $e->getMessage());
        }
    }
}

// Example usage:
try {
    $database = new Database([
        'url' => 'mysql://root:root@localhost/app',
    ]);
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage(); // Displays: "Error: The option(s) 'url' do(es) not exist. Defined options are: 'host', 'username', 'password', 'dbname'."
}
```

### Validating Option Values

You can add custom validators for each option to validate the provided values:

```php
<?php

class Database
{
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver([
            (new Option('host'))->validator(static function($value) {
                return is_string($value);
            })->setDefaultValue('localhost'),

            (new Option('username'))->validator(static function($value) {
                return is_string($value);
            })->setDefaultValue('root'),

            (new Option('password'))->validator(static function($value) {
                return is_string($value);
            })->setDefaultValue('root'),

            (new Option('dbname'))->validator(static function($value) {
                return is_string($value);
            })->setDefaultValue('app'),

            (new Option('driver'))->validator(static function($value) {
                return in_array($value, ['pdo_mysql', 'pdo_pgsql']);
            })->setDefaultValue('pdo_mysql'),
        ]);

        try {
            $this->options = $resolver->resolve($options);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException("Error: " . $e->getMessage());
        }
    }
}

// Example usage with an invalid driver value:
try {
    $database = new Database([
        'host' => '192.168.1.200',
        'username' => 'root',
        'password' => 'root',
        'dbname' => 'my-app',
        'driver' => 'pdo_sqlite',
    ]);
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage(); // Displays: "Error: The option 'driver' with value 'pdo_sqlite' is invalid."
}
```

Certainly! Let's focus specifically on the use of `Option::new()` to instantiate options in a fluent manner:

---

## Instantiating Options with `Option::new()`

You can use `Option::new()` to create and configure option instances in a fluent style before adding them to the `OptionsResolver`. Here's an example that demonstrates this approach:

```php
<?php

use DevCoder\Resolver\Option;
use DevCoder\Resolver\OptionsResolver;

// Create an option instance using Option::new()
$option1 = Option::new('option1');

// Create another option instance with a default value using Option::new()
$option2 = Option::new('option2')->setDefaultValue('default');

// Create a resolver and add the configured options
$resolver = new OptionsResolver([$option1, $option2]);

// Resolve the options with provided values
$options = $resolver->resolve([
    'option1' => 'value1',
]);

```

In this example:

- We use `Option::new('option1')` to create an `Option` instance named `'option1'`.
- Similarly, we use `Option::new('option2')->setDefaultValue('default')` to create an `Option` instance named `'option2'` with a default value of `'default'`.
- Both options are then added to the `OptionsResolver` when it's instantiated.
- Finally, we resolve the options by passing an array of values, and only `'option1'` is provided with a value (`'value1'`).

Using `Option::new()` provides a concise and clear way to create and configure option instances before resolving them with specific values.

---

This library is ideal for small projects where you need to manage and validate options in a simple and effective way.
