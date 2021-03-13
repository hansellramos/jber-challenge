<?php

namespace jber\controller;

use jber\cache\CacheService;
use jber\model\PokemonModel;
use Monolog\Logger;

class PokemonController {

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var PokemonModel
     */
    private $model;

    public function __construct(Logger $logger = null)
    {
        $this->logger = $logger;
        $this->model = new PokemonModel($logger);
    }

    /**
     * Handle all request to get Info about pokemon
     */
    public function handle(): void
    {
        $validation = $this->validateParameters($_REQUEST);
        if (!empty($validation)) {
            $param = $validation['parameter'];
            $this->sendJsonResponse(['message' => "Missing parameter $param", 'success' => false, 'code' => 400]);
            exit;
        }

        if (LEVEL === 'debug') {
            $ignoreCache = CacheService::ignoreCache($this->logger);
            $this->logger->info('Ignore cache? ' . ($ignoreCache ? 'Yes' : 'No'));
        }

        $pokemonName = $_REQUEST['pokemon'];
        try {
            $result = $this->model->get($pokemonName);
            $this->sendJsonResponse([
                'message' => 'Success',
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $ex) {
            $this->sendJsonResponse([
                'message' => $ex->getMessage(),
                'code' => $ex->getCode(),
                'success' => false
            ]);
        }
    }

    /**
     * Validate if required parameters are present
     * @param array $params
     * @return array
     */
    public function validateParameters($params = []): array
    {
        if (empty($params)) {
            $this->logger->error('Parameter required');
            return ['parameter' => ''];
        }

        if (!empty($params['name'])) {
            $this->logger->error('Missing parameter name is required');
            return ['parameter' => 'name'];
        }

        return [];
    }

    /**
     * Sends json output response
     * @param $params
     */
    public function sendJsonResponse($params): void
    {
        if (empty($params['code'])) {
            $params['code'] = 200;
        }

        if (!$params['success']) {
            http_response_code($params['code']);
        }

        if (empty($params['data'])) {
            $params['data'] = [];
        }

        header('Content-type: application/json');
        echo json_encode($params);
    }

}
