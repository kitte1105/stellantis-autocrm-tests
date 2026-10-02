<?php

declare(strict_types=1);

namespace Tests\Context;

final class LanguageContext
{
    private string $locale = 'ru';

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): void
    {
        $this->locale = $locale;
    }
}