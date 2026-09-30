<?php

declare(strict_types=1);

namespace Tests\Page;

class RestorePasswordPage extends BasePage
{
    private const URL = '/site/restore-password';
    private string $passwordRecoveryForm = 'form#reset-form';
    private string $title = 'div.h1';
    private array $validationMessages = [
        'ru' => [
            'title' => 'Восстановление пароля',
        ],
        'en' => [
            'title' => 'Password recovery',
        ],
    ];

    public function open(): void
    {
        $this->tester->amOnPage(self::URL);
    }

    public function waitUntilOpened(): void
    {
        $this->tester->waitForElement($this->passwordRecoveryForm);
    }

    public function seeChosenLanguage(): void
    {
        $this->tester->see(
            $this->validationMessages[$this->languageContext->getLocale()]['title'],
            $this->title,
            'Язык страницы не соответствует заданному'
        );
    }

    public function seePageOpened(): void
    {
        $this->tester->seeInCurrentUrl(self::URL);
        $this->tester->seeElement($this->passwordRecoveryForm);
        $this->seeChosenLanguage();
    }
}
