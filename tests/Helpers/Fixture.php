<?php

declare(strict_types=1);

namespace WPRestClient\Test\Helpers;

use UnexpectedValueException;

class Fixture
{
    public static function load(string $name): array
    {
        $path = self::nameToPath($name);
        assert(is_file($path), new UnexpectedValueException(sprintf(
            '"%s" is not a valid fixture. "%s" not found.',
            $name,
            $path
        )));
        return json_decode(file_get_contents($path), true);
    }

    public static function generate(string $name, array $data): void
    {
        $path = self::nameToPath($name);
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
    }

    protected static function nameToPath(string $name): string
    {
        return FIXTURES_DIR . $name . '.fixture.json';
    }
}
