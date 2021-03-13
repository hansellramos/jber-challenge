<?php

namespace jber\cache;

use jber\enum\CacheEnum;
use Monolog\Logger;
use Predis\Client;

/**
 * Class CacheService used to handle all related with cache
 * @package jber\cache
 */
class CacheService {

    /**
     * Get data about cache flags from header
     * @return bool
     */
    public static function ignoreCache(Logger $logger = null): bool
    {
        $headers = getallheaders();
        $cache = $headers['Cache-Control'] ?: CacheEnum::NO_CACHE;

        if (LEVEL === 'debug' && $logger != null) {
            $logger->info("Cache-Control header value: {$headers['Cache-Control']}");
        }

        if ($cache === CacheEnum::NO_STORE) {
            return true;
        }

        return false;
    }

    /**
     * Save value to cache
     * @param string $key
     * @param string $value
     * @param Logger|null $logger
     */
    public static function save(string $key, string $value, Logger $logger = null): void
    {
        $client = self::getClient();
        $client->connect();
        $client->set($key, $value);
        $client->expire($key, CACHE_TIME_IN_SECONDS);
        if (LEVEL === 'debug' && $logger != null) {
            $logger->info("Data saved in cache using key:'$key' with expire time: " . CACHE_TIME_IN_SECONDS);
        }
        $client->disconnect();
    }

    /**
     * Get value saved on cache
     * @param string $key
     * @param Logger|null $logger
     * @return string|null
     */
    public static function get(string $key, Logger $logger = null): ?string
    {
        $client = self::getClient();
        $client->connect();
        $value = $client->get($key);
        $client->disconnect();
        if (!empty($value)) {
            if (LEVEL === 'debug' && $logger != null) {
                $logger->info("Data read from cache using key:'$key'");
            }
            return $value;
        }
        if (LEVEL === 'debug' && $logger != null) {
            $logger->info("No cache data using key:'$key'");
        }
        return $value;
    }

    /**
     * Create new redis client
     * @return Client
     */
    private static function getClient(): Client
    {
        return new Client(REDIS_HOST_URI);
    }

}
