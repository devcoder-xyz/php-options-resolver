<?php

namespace Test\DevCoder\Resolver;

use DevCoder\Resolver\Option;
use DevCoder\Resolver\OptionsResolver;
use PHPUnit\Framework\TestCase;

class RequiredOptionsTest extends TestCase
{
    public function test(): void
    {
        $resolver = new OptionsResolver([
            Option::new( 'action' ),
            Option::new( 'method' )
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $resolver->resolve([
            'method' => 'GET'
        ]);
    }
}
