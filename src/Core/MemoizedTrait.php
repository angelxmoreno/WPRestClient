<?php

declare(strict_types=1);

namespace WPRestClient\Core;

use Cake\Collection\Collection;
use Cake\Utility\Hash;

trait MemoizedTrait
{
    protected static array $_memoized = [];

    protected static function addMemoize(array $data = []): void
    {
        $key = Hash::get($data, 'id');
        if ($key) {
            static::$_memoized[$key] = $data;
        }
    }

    protected static function addBatchMemoize(array $data = []): void
    {
        foreach ($data as $datum) {
            static::addMemoize($datum);
        }
    }

    /**
     * @param int $key
     * @return array|null
     * @SuppressWarnings(PHPMD.UndefinedVariable) see https://github.com/phpmd/phpmd/issues/714
     */
    protected static function getMemoize(int $key): ?array
    {
        return static::$_memoized[$key] ?? null;
    }

    /**
     * @param int $key
     * @return void
     * @SuppressWarnings(PHPMD.UndefinedVariable) see https://github.com/phpmd/phpmd/issues/714
     */
    protected static function removeMemoize(int $key): void
    {
        unset(static::$_memoized[$key]);
    }

    protected static function getMemoizedCollection(): Collection
    {
        return new Collection(self::$_memoized);
    }
}
