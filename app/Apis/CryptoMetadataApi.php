<?php

declare(strict_types=1);

namespace App\Apis;

class CryptoMetadataApi
{
    const BASE_URL = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/info';

    public function getUrl(string $coinSymbol)
    {
        $parameters = [
            'symbol' => $coinSymbol
        ];

        $qs = http_build_query($parameters);
        return self::BASE_URL . "?{$qs}";

    }

}