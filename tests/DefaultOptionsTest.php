<?php

namespace Test\DevCoder\Resolver;

use DevCoder\Resolver\Option;
use DevCoder\Resolver\OptionsResolver;
use PHPUnit\Framework\TestCase;

class DefaultOptionsTest extends TestCase
{
    public function test(): void
    {
        $resolver = new OptionsResolver([
            Option::new('action'),
            Option::new('method')->setDefaultValue('POST'),
            Option::new('id')->setDefaultValue('form-01'),
        ]);

        $options = $resolver->resolve([
            'action' => 'https://www.devcoder.xyz',
            'id' => 'form-payment'
        ]);
        $this->assertSame($options, ['action' => 'https://www.devcoder.xyz', 'method' => 'POST', 'id' => 'form-payment']);
    }
}
