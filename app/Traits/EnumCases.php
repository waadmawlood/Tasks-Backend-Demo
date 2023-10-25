<?php

namespace App\Traits;

trait EnumCases
{
    /** Return the enum's value when it's $invoked(). */
    public function __invoke()
    {
        return $this instanceof \BackedEnum ? $this->value : $this->name;
    }

    /** Return the enum's value or name when it's called ::STATICALLY(). */
    public static function __callStatic($name, $args)
    {
        $cases = static::cases();

        foreach ($cases as $case) {
            if ($case->name === $name) {
                return $case instanceof \BackedEnum ? $case->value : $case->name;
            }
        }

        $class = get_called_class();
        throw new \Exception("Undefined constant $class::$case");
    }

    /** Get an array of case names. */
    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }


    /** Get an array of case values. */
    public static function values(): array
    {
        $cases = static::cases();

        return isset($cases[0]) && $cases[0] instanceof \BackedEnum
            ? array_column($cases, 'value')
            : array_column($cases, 'name');
    }


    /**
     * Gets the Enum by name, if it exists, for "Pure" enums.
     *
     * This will not override the `from()` method on BackedEnums
     *
     * @throws \Exception
     */
    public static function from(string $case): static
    {
        return static::fromName($case);
    }

    /**
     * Gets the Enum by name, if it exists, for "Pure" enums.
     *
     * This will not override the `tryFrom()` method on BackedEnums
     */
    public static function tryFrom(string $case): ?static
    {
        return static::tryFromName($case);
    }

    /**
     * Gets the Enum by name.
     *
     * @throws \Exception
     */
    public static function fromName(string $case): static
    {
        return static::tryFromName($case) ?? throw new \Exception('"' . $case . '" is not a valid name for enum "' . static::class . '"');
    }

    /**
     * Gets the Enum by name, if it exists.
     */
    public static function tryFromName(string $case): ?static
    {
        $cases = array_filter(
            static::cases(),
            fn ($c) => $c->name === $case
        );

        return array_values($cases)[0] ?? null;
    }
}
