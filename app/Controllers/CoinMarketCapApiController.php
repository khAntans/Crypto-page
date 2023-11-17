<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Apis\CryptoMetadataApi;
use App\Apis\CryptoQuoteApi;
use App\Models\Currency;
use App\Models\CurrencyPair;
use Dotenv\Dotenv;
use GuzzleHttp\Client;

class CoinMarketCapApiController
{
    private Client $client;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable('../');
        $dotenv->load();

        $this->client = new Client([
            'headers' => [
                'Accepts' => 'application/json',
                'X-CMC_PRO_API_KEY' => $_ENV['COINMARKETCAP_API_KEY']
            ]
        ]);
    }

    public function fetch(string $baseCurrencySymbol, string $comparedCurrencySymbol): CurrencyPair
    {
        $baseCurrencySymbol = trim(strtoupper($baseCurrencySymbol));

        $baseCurrency = $this->buildCurrency($baseCurrencySymbol);

        $comparedCurrencySymbol = trim(strtoupper($comparedCurrencySymbol));

        $comparedCurrency = $this->buildCurrency($comparedCurrencySymbol);

        $pairQuoteUrl = (new CryptoQuoteApi())->getUrl($baseCurrencySymbol, $comparedCurrencySymbol);
        $pairQuoteRequest = $this->client->get($pairQuoteUrl);
        $pairQuoteData = json_decode($pairQuoteRequest->getBody()->getContents())->data->{$baseCurrencySymbol}[0]->quote->$comparedCurrencySymbol;

        $pairQuote = new CurrencyPair(
            $baseCurrency,
            $comparedCurrency,
            $pairQuoteData->price,
            $pairQuoteData->volume_24h,
            $pairQuoteData->volume_change_24h,
            $pairQuoteData->percent_change_1h,
            $pairQuoteData->percent_change_24h,
            $pairQuoteData->percent_change_7d,
            $pairQuoteData->percent_change_30d,
            $pairQuoteData->market_cap,
            $pairQuoteData->market_cap_dominance,
            $pairQuoteData->fully_diluted_market_cap,
            $pairQuoteData->last_updated
        );

        return $pairQuote;

    }

    private function buildCurrency(string $currencySymbol): Currency
    {
        $currencyMetadataUrl = (new CryptoMetadataApi())->getUrl($currencySymbol);
        $currencyMetadataRequest = $this->client->get($currencyMetadataUrl);
        $currencyMetadata = json_decode($currencyMetadataRequest->getBody()->getContents())->data->{$currencySymbol}[0];

        if ($currencyMetadata) {
            return new Currency(
                $currencyMetadata->id,
                $currencyMetadata->name,
                $currencyMetadata->symbol,
                $currencyMetadata->slug,
                $currencyMetadata->logo
            );
        }
        return new Currency(null, null, $currencySymbol, null, null);

    }


}