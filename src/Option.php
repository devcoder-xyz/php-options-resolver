<?php

declare(strict_types=1);

namespace DevCoder\Resolver;

final class Option
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $defaultValue;

    /**
     * @var bool
     */
    private $hasDefaultValue = false;

    /**
     * @var \Closure|null
     */
    private $validator;

    /**
     * Option constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $defaultValue
     * @return Option
     */
    public function setDefaultValue($defaultValue): self
    {
        $this->hasDefaultValue = true;
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function hasDefaultValue(): bool
    {
        return $this->hasDefaultValue;
    }

    public function validator(\Closure $closure): self
    {
        $this->validator = $closure;
        return $this;
    }

    public function isValid($value): bool
    {
        if ($this->validator instanceof \Closure) {
            $validator = $this->validator;
            return $validator($value);
        }
        return true;
    }
}
