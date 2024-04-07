<?php

namespace Test\DevCoder\Resolver;

use DevCoder\Resolver\Option;
use DevCoder\Resolver\OptionsResolver;
use PHPUnit\Framework\TestCase;

class OptionsResolverTest extends TestCase
{
    public function testResolveOptionsSuccessfully()
    {
        $resolver = new OptionsResolver([
            Option::new('option1'),
            Option::new('option2')->setDefaultValue('default'),
        ]);

        $options = $resolver->resolve([
            'option1' => 'value1',
        ]);

        $this->assertSame($options, ['option1' => 'value1', 'option2' => 'default']);
    }

    public function testMissingRequiredOptions()
    {
        $resolver = new OptionsResolver([
            Option::new('requiredOption'),
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $resolver->resolve([]);
    }

    public function testInvalidOptions()
    {
        $resolver = new OptionsResolver([
            Option::new('validOption')->validator(static function ($value) {
                return $value > 0;
            }),
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $resolver->resolve(['validOption' => -5]);
    }

}