<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Response;
use Carbon\Carbon;

class ViewController
{
    public function index(): Response
    {
        $coinMarketApi = new CoinMarketCapApiController();

        $currencyPairs = [
            $coinMarketApi->fetch('ETH', 'SOL'),
            $coinMarketApi->fetch('DOGE', 'EUR'),
            $coinMarketApi->fetch('BTC', 'ETH')
        ];

        return new Response('index', [
            'currencyPairs' => $currencyPairs,
            'currentTime' => Carbon::now()
        ]);

    }

    public function search(string $baseCurrency, string $comparedCurrency): Response
    {
        $coinMarketApi = new CoinMarketCapApiController();

        return new Response('search', [
            'currencyPair' => $coinMarketApi->fetch($baseCurrency, $comparedCurrency),
            'currentTime' => Carbon::now()
        ]);
    }

}