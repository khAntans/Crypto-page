<?php

declare(strict_types=1);

namespace App\Models;

use App\IsoCodes;

class Currency
{
    private ?int $id;
    private ?string $name;
    private string $symbol;
    private ?string $slug;
    private string $logoUrl;

    public function __construct(?int $id, ?string $name, string $symbol, ?string $slug, ?string $logoUrl)
    {
        $this->id = $id;
        $this->name = $name ?? $this->findFiatName($symbol);
        $this->symbol = $symbol;
        $this->slug = $slug;
        $this->logoUrl = $logoUrl ?? 'http://placekitten.com/64/64';
    }

    private function findFiatName(string $code): ?string
    {
        $isoCodes = (new IsoCodes())->get();
        if (isset($isoCodes[$code])) {
            return $isoCodes[$code];
        }
        return null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getLogoUrl(): string
    {
        return $this->logoUrl;
    }

}