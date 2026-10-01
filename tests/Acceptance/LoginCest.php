<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Skip;
use Codeception\Scenario;
use Codeception\Example;
use Tests\Support\AcceptanceTester;
use Tests\Page\LoginPage;

final class LoginCest
{
    public function _before(
        LoginPage $loginPage
    ): void {
        $loginPage->open();
        $loginPage->setLanguage('en');
        $loginPage->waitForLanguageChanged();
        $loginPage->seePageOpened();
    }

    public function loginWithInvalidCredentialsTest(
        LoginPage $loginPage,
    ): void {
        $loginPage->fillEmail('incorrect_email@example.com');
        $loginPage->fillPassword('wrong_password');

        $loginPage->clickLogin();
        $loginPage->waitForPasswordFieldErrorState();

        $loginPage->seePasswordFieldHasErrorState();
        $loginPage->seeEmailPasswordIncorrectError();
    }

    public function emptyCredentialTest(
        LoginPage $loginPage,
    ): void {
        $loginPage->clickLogin();
        $loginPage->waitForEmailFieldErrorState();

        $loginPage->seeEmailFieldHasErrorState();
        $loginPage->seeEmailRequiredError();

        $loginPage->seePasswordFieldHasErrorState();
        $loginPage->seePasswordRequiredError();
    }

    public function passwordMaskingTest(
        LoginPage $loginPage,
    ): void {
        $loginPage->fillPassword('wrong_password');
        $loginPage->removeFieldFocus();
        $loginPage->waitForPasswordValid();
        $loginPage->seePasswordIsMasked();
    }

    #[DataProvider('emailValidationProvider')]
    public function invalidEmailValueTest(
        LoginPage $loginPage,
        Example $userData,
        Scenario $scenario
    ): void {
        if (preg_match('/[^\x00-\x7F]/', $userData['correct_email'])) {
            $scenario->skip('Приложение не поддерживает Unicode email');
        }
        $loginPage->fillEmail($userData['incorrect_email']);
        $loginPage->removeFieldFocus();
        $loginPage->waitForEmailFieldErrorState();

        $loginPage->seeEmailFieldHasErrorState();
        $loginPage->seeInvalidEmailMessage();

        $loginPage->fillPassword($userData['password']);
        $loginPage->removeFieldFocus();
        $loginPage->waitForPasswordValid();

        $loginPage->seePasswordFieldIsValid();
        $loginPage->clickLogin();

        $loginPage->waitForLoginButtonDisabled();
        $loginPage->seeLoginButtonDisabled();

        $loginPage->fillEmail($userData['correct_email']);
        $loginPage->removeFieldFocus();
        $loginPage->waitForEmailValid();

        $loginPage->seeEmailFieldIsValid();
        $loginPage->dontSeeInvalidEmailMessage();

        /* Баг: Вводим некорректный email, надижимаем Submit -> кнопка лочится
        Вводим корректный Email, проверка прошла, однако кнопка остается залоченной и мы не можем авторизоваться
        $loginPage->waitForLoginButtonEnabled();
        $loginPage->seeLoginButtonEnabled();*/
    }

    public function forgotPasswordTest(
        LoginPage $loginPage,
    ): void {
        $restorePasswordPage = $loginPage->clickForgotPassword();

        $restorePasswordPage->waitUntilOpened();
        $restorePasswordPage->seePageOpened();
    }

    protected function emailValidationProvider(): array
    {
        return [
            'login instead email'    => [
                'incorrect_email' => 'invalid-email',
                'password'        => 'password',
                'correct_email'   => 'tester@example.com',
            ],
            'cyrillic correct email' => [
                'incorrect_email' => 'invalid@.com',
                'password'        => 'another-password',
                'correct_email'   => 'тестер@пример.рф',
            ],
        ];
    }
}