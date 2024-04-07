<?php

declare(strict_types=1);

namespace DevCoder\Resolver;

final class Option
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var mixed
     */
    private $defaultValue;

    /**
     * @var bool
     */
    private bool $hasDefaultValue = false;

    /**
     * @var \Closure|null
     */
    private ?\Closure $validator = null;

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
     * Set the default value of the option.
     *
     * @param mixed $value The default value to set.
     * @return Option
     */
    public function setDefaultValue($value): self
    {
        $this->hasDefaultValue = true;
        $this->defaultValue = $value;
        return $this;
    }


    /**
     * Check if the option has a default value.
     *
     * @return bool True if the option has a default value, false otherwise.
     */
    public function hasDefaultValue(): bool
    {
        return $this->hasDefaultValue;
    }

    /**
     * Set a validator function for the option.
     *
     * @param \Closure $closure The closure to use as a validator.
     * @return Option
     */
    public function validator(\Closure $closure): self
    {
        $this->validator = $closure;
        return $this;
    }

    /**
     * Check if a value is valid based on the validator function.
     *
     * @param mixed $value The value to validate.
     * @return bool True if the value is valid, false otherwise.
     */
    public function isValid($value): bool
    {
        if ($this->validator instanceof \Closure) {
            $validator = $this->validator;
            return $validator($value);
        }
        return true;
    }

    public static function new(string $name) : self
    {
        return new self($name);
    }
}
