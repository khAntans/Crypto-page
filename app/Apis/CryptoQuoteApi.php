<?php

declare(strict_types=1);

namespace App\Apis;

class CryptoQuoteApi
{
    const BASE_URL = 'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest';

    public function getUrl(string $coin, string $coinToCompare)
    {
        $parameters = [
            'symbol' => $coin,
            'convert' => $coinToCompare
        ];

        $qs = http_build_query($parameters);
        return self::BASE_URL . "?{$qs}";

    }


}