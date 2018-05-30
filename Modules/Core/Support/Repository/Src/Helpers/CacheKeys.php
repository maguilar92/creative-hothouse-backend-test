<?php

namespace Modules\Core\Support\Repository\Src\Helpers;

class CacheKeys
{
    /**
     * File name for store cache keys.
     *
     * @var string
     */
    protected static $storeFile = 'repository-cache-keys.json';

    /**
     * Property with repositories keys.
     *
     * @var array
     */
    protected static $keys = null;

    /**
     * Put new key.
     *
     * @param string $group
     * @param string $key
     *
     * @return void
     */
    public static function putKey(string $group, string $key)
    {
        self::loadKeys();

        self::$keys[$group] = self::getKeys($group);

        if (!in_array($key, self::$keys[$group])) {
            self::$keys[$group][] = $key;
        }

        self::storeKeys();
    }

    /**
     * Remove group keys.
     *
     * @param string $group
     *
     * @return void
     */
    public static function removeGroupKeys(string $group)
    {
        self::loadKeys();

        self::$keys[$group] = [];

        self::storeKeys();
    }

    /**
     * Load existing keys.
     *
     * @return array
     */
    public static function loadKeys()
    {
        if (!is_null(self::$keys) && is_array(self::$keys)) {
            return self::$keys;
        }

        $file = self::getFileKeys();

        if (!file_exists($file)) {
            self::storeKeys();
        }

        $content = file_get_contents($file);
        self::$keys = json_decode($content, true);

        return self::$keys;
    }

    /**
     * Get file keys.
     *
     * @return string
     */
    public static function getFileKeys()
    {
        $file = storage_path('framework/cache/'.self::$storeFile);

        return $file;
    }

    /**
     * Store keys.
     *
     * @return int
     */
    public static function storeKeys()
    {
        $file = self::getFileKeys();
        self::$keys = is_null(self::$keys) ? [] : self::$keys;
        $content = json_encode(self::$keys);

        return file_put_contents($file, $content);
    }

    /**
     * Get key from group.
     *
     * @param string $group
     *
     * @return array|mixed
     */
    public static function getKeys(string $group)
    {
        self::loadKeys();
        self::$keys[$group] = isset(self::$keys[$group]) ? self::$keys[$group] : [];

        return self::$keys[$group];
    }

    /**
     * Overloading __callStatic.
     *
     * @param mixed $method
     * @param mixed $parameters
     *
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = new static();

        return call_user_func_array([
            $instance,
            $method,
        ], $parameters);
    }

    /**
     * Overloading __call.
     *
     * @param mixed $method
     * @param mixed $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $instance = new static();

        return call_user_func_array([
            $instance,
            $method,
        ], $parameters);
    }
}
