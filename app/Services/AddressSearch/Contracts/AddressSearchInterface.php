<?php

namespace App\Services\AddressSearch\Contracts;

use GuzzleHttp\Client;

interface AddressSearchInterface
{
    public function get(string $postcode): array;
    public function client(): Client;
}
