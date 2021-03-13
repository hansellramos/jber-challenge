<?php

namespace jber\model;

use jber\cache\CacheService;
use jber\mapper\PokemonMapper;
use jber\request\SimpleJsonRequest;
use Monolog\Logger;

/**
 * Class PokemonModel used to get all data related with pokemon
 * @package jber\model
 */
class PokemonModel {

    /**
     * @var Logger
     */
    private $logger;

    /**
     * PokemonModel constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Get data about pokemon with given name
     * @param string $name
     * @return array
     * @throws \Exception
     */
    public function get(string $name): array
    {
        $now = microtime(true);
        $ignoreCache = CacheService::ignoreCache();
        if (!$ignoreCache) {
            $result = CacheService::get($name);
            if (!empty($result)) {
                $this->logger->info('Response time: ' . (microtime(true) - $now) . ' seconds, with cache');
                return json_decode($result, JSON_OBJECT_AS_ARRAY);
            }
        }

        try {
            $data = SimpleJsonRequest::get(SERVICE_BASE_PATH . $name);
            $response = PokemonMapper::map($data);
            $this->logger->info('Response time: ' . (microtime(true) - $now) . ' seconds, no cache');
            CacheService::save($name, json_encode($response));
            return $response;
        } catch (\Exception $ex) {
            $this->logger->error($ex->getMessage());
            throw new \Exception('There was an error with external server', 500);
        }
    }

}
