<?php

namespace Test\DevCoder\Resolver;

use DevCoder\Resolver\Option;
use DevCoder\Resolver\OptionsResolver;
use PHPUnit\Framework\TestCase;

class ValidateOptionsTest extends TestCase
{
    public function testNotValid(): void
    {
        $resolver = new OptionsResolver([
            (new Option('action'))
                ->validator(static function ($value) {
                    return filter_var($value, FILTER_VALIDATE_URL) !== false;
                })
            ,
            (new Option('method'))
                ->setDefaultValue('POST'),
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $resolver->resolve([
            'action' => null,
        ]);
    }

    public function testValid(): void
    {
        $resolver = new OptionsResolver([
            (new Option('action'))
                ->validator(static function ($value) {
                    return filter_var($value, FILTER_VALIDATE_URL) !== false;
                })
            ,
            (new Option('method'))
                ->setDefaultValue('POST'),
        ]);

        $options = $resolver->resolve([
            'action' => 'https://www.devcoder.xyz',
        ]);
        $this->assertSame($options, ['action' => 'https://www.devcoder.xyz', 'method' => 'POST']);
    }
}
