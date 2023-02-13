<?php

namespace App\Services\AddressSearch\ViaCEP;

use App\Services\AddressSearch\Contracts\AddressSearchInterface;
use Exception;
use GuzzleHttp\Client;

class ViaCEP implements AddressSearchInterface
{
    private string $url = 'http://viacep.com.br/ws/';

    public function client(): Client
    {
        return new Client([
            'base_uri' => $this->url,
        ]);
    }

    public function get(string $postcode): array
    {
        if ('' == $postcode) {
            throw new Exception();
        }

        $response = json_decode(
            $this->client()
                ->get("{$postcode}/json/")
                ->getBody()
                ->getContents()
        );

        return [
            'postcode' => $postcode,
            'street' => $response->logradouro,
            'city' => $response->localidade,
            'state' => $response->uf,
            'neighborhood' => $response->bairro,
        ];
    }
}
