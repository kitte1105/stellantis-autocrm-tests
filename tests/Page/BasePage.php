<?php

declare(strict_types=1);

namespace Tests\Page;

use Tests\Support\AcceptanceTester;
use Tests\Context\LanguageContext;

class BasePage
{
    private string $languageChanger = 'a.header__guestUsermenuLang[href*=\'language=%s\']';
    private string $activeLanguageSelector = 'a.header__guestUsermenuLang__active[href*=\'language=%s\']';

    public function __construct(
        protected AcceptanceTester $tester,
        protected LanguageContext $languageContext,
    ) {}

    public function setLanguage(string $locale): void
    {
        $this->tester->click(
            sprintf($this->languageChanger, $locale)
        );

        $this->languageContext->setLocale($locale);
    }

    public function waitForLanguageChanged(): void
    {
        $this->tester->waitForElement(
            sprintf(
                $this->activeLanguageSelector,
                $this->languageContext->getLocale()
            ),
            5
        );
    }
}
