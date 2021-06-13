# This library processes and validates option array.
## Requirements

* PHP version 7.3
  
**How to use ?**

Define required options
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

        $this->options = $resolver->resolve($options);
    }
}

$database = new Database([
    'host' => 'localhost',
    'dbname' => 'app',
]);
// Uncaught InvalidArgumentException: The required option "username" is missing.

$database = new Database([
    'host' => 'localhost',
    'dbname' => 'app',
    'username' => 'root',
    'password' => 'root',
]);
// OK
```

Define default options
```php
<?php

use DevCoder\Resolver\Option;
use DevCoder\Resolver\OptionsResolver;

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

        /**
         * array(4) {
         * ["host"]=>
         * string(9) "localhost"
         * ["username"]=>
         * string(4) "root"
         * ["password"]=>
         * string(4) "root"
         * ["dbname"]=>
         * string(3) "app"
         * }
         */
        $this->options = $resolver->resolve($options);
    }
}

$database = new Database([]);
// OK
```
```php
<?php

use DevCoder\Resolver\Option;
use DevCoder\Resolver\OptionsResolver;

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

        /**
         * array(4) {
         * ["host"]=>
         * string(9) "localhost"
         * ["username"]=>
         * string(4) "root"
         * ["password"]=>
         * string(4) "root"
         * ["dbname"]=>
         * string(3) "app-2"
         * }
         */
        $this->options = $resolver->resolve($options);
    }
}

$database = new Database([
    'dbname' => 'app-2'
]);
// OK
```

Non-existent options
```php
<?php

use DevCoder\Resolver\Option;
use DevCoder\Resolver\OptionsResolver;

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

$database = new Database([
    'url' => 'mysql://root:root@localhost/app',
]);
// Uncaught InvalidArgumentException: The option(s) "url" do(es) not exist. Defined options are: "host", "username", "password", "dbname"
```
Validate options values
```php
<?php

use DevCoder\Resolver\Option;
use DevCoder\Resolver\OptionsResolver;

class Database
{
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver([
            (new Option('host'))
                ->validator(static function($value) {
                    return is_string($value);
                })
                ->setDefaultValue('localhost'),
            (new Option('username'))
                ->validator(static function($value) {
                    return is_string($value);
                })
                ->setDefaultValue('root')
            ,
            (new Option('password'))
                ->validator(static function($value) {
                    return is_string($value);
                })
                ->setDefaultValue('root'),
            (new Option('dbname'))
                ->validator(static function($value) {
                    return is_string($value);
                })
                ->setDefaultValue('app'),
            (new Option('driver'))
                ->validator(static function($value) {
                    return in_array($value, ['pdo_mysql', 'pdo_pgsql']);
                })
                ->setDefaultValue('pdo_mysql'),
        ]);

        $this->options = $resolver->resolve($options);
    }
}

$database = new Database([
    'host' => '192.168.1.200',
    'username' => 'root',
    'password' => 'root',
    'dbname' => 'my-app',
    'driver' => 'pdo_sqlite'
]);
// Uncaught InvalidArgumentException: The option "driver" with value "pdo_sqlite" is invalid.
```

Ideal for small project.

Simple and easy!