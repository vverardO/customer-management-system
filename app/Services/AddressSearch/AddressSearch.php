<?php

namespace App\Services\AddressSearch;

use App\Services\AddressSearch\Contracts\AddressSearchInterface;

class AddressSearch
{
    public function __construct(
        readonly AddressSearchInterface $addressSearchHandler,
    ) {}

    public function handle(
        string $postcode,
    ): array {
        return $this->addressSearchHandler->get($postcode);
    }
}
