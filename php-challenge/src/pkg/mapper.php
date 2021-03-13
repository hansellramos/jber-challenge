<?php

namespace jber\mapper;

class PokemonMapper {

    /**
     * Map pokemon to get basic data
     * @param array $data
     * @return array
     */
    public static function map(array $data): array
    {
        return [
            'name' => $data['name'] ?? '',
            'height' => $data['height'] ?? '',
            'weight' => $data['weight'] ?? '',
            'types' => $data['types'] ?? ''
        ];
    }

}
