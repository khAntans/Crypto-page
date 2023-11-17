<?php

namespace App\Models;

use Carbon\Carbon;

class CurrencyPair
{
    private Currency $baseCurrency;
    private Currency $comparedCurrency;
    private float $price;
    private float $dayVolume;
    private float $dayVolumeChange;
    private float $hourlyPercentChange;
    private float $dailyPercentChange;
    private float $weeklyPercentChange;
    private float $monthlyPercentChange;
    private float $marketCap;
    private float $marketCapDominance;
    private float $fullyDilutedMarketCap;
    private Carbon $lastUpdated;


    public function __construct(
        Currency $baseCurrency,
        Currency $comparedCurrency,
        float    $price,
        float    $dayVolume,
        float    $dayVolumeChange,
        float    $hourlyPercentChange,
        float    $dailyPercentChange,
        float    $weeklyPercentChange,
        float    $monthlyPercentChange,
        float    $marketCap,
        float    $marketCapDominance,
        float    $fullyDilutedMarketCap,
        string   $lastUpdated
    )
    {
        $this->baseCurrency = $baseCurrency;
        $this->comparedCurrency = $comparedCurrency;
        $this->price = $price;
        $this->dayVolume = $dayVolume;
        $this->dayVolumeChange = $dayVolumeChange;
        $this->hourlyPercentChange = $hourlyPercentChange;
        $this->dailyPercentChange = $dailyPercentChange;
        $this->weeklyPercentChange = $weeklyPercentChange;
        $this->monthlyPercentChange = $monthlyPercentChange;
        $this->marketCap = $marketCap;
        $this->marketCapDominance = $marketCapDominance;
        $this->fullyDilutedMarketCap = $fullyDilutedMarketCap;
        $this->lastUpdated = Carbon::parse($lastUpdated);
    }

    public function getBaseCurrency(): Currency
    {
        return $this->baseCurrency;
    }

    public function getComparedCurrency(): Currency
    {
        return $this->comparedCurrency;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDayVolume(): float
    {
        return $this->dayVolume;
    }

    public function getDayVolumeChange(): float
    {
        return $this->dayVolumeChange;
    }

    public function getHourlyPercentChange(): float
    {
        return $this->hourlyPercentChange;
    }

    public function getDailyPercentChange(): float
    {
        return $this->dailyPercentChange;
    }

    public function getWeeklyPercentChange(): float
    {
        return $this->weeklyPercentChange;
    }

    public function getMonthlyPercentChange(): float
    {
        return $this->monthlyPercentChange;
    }

    public function getMarketCap(): float
    {
        return $this->marketCap;
    }

    public function getMarketCapDominance(): float
    {
        return $this->marketCapDominance;
    }

    public function getFullyDilutedMarketCap(): float
    {
        return $this->fullyDilutedMarketCap;
    }

    public function getLastUpdated(): string
    {
        return $this->lastUpdated->parse();
    }

}