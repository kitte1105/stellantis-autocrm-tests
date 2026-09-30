<?php

declare(strict_types=1);

namespace Tests\Page;

use Tests\Support\AcceptanceTester;
use Tests\Context\LanguageContext;

class LoginPage extends BasePage
{
    private const URL = '/login';

    private string $authorizationDiv = 'div.authorization';
    private string $loginForm = 'form#login-form';
    private string $emailContainer = 'div.field-loginform-email';
    private string $emailField = 'input#loginform-email';
    private string $emailLabel = 'label[for="loginform-email"]';
    private string $passwordContainer = 'div.field-loginform-password';
    private string $passwordField = 'input#loginform-password';
    private string $submitButton = 'button[type=\'submit\']';
    private string $helpBlockError = 'p.help-block-error';
    private string $restorePasswordLink = 'a[href*=\'restore-password\']';
    private array $validationMessages = [
        'ru' => [
            'required_email'       => 'Необходимо заполнить «Электронная почта»',
            'required_password'    => 'Необходимо заполнить «Пароль»',
            'incorrect_email'      => 'Некорректный email',
            'email_label'          => 'Электронная почта',
            'incorrect_email_pass' => 'Некорректный email / пароль',
        ],
        'en' => [
            'required_email'       => 'Email cannot be blank',
            'required_password'    => 'Password cannot be blank',
            'incorrect_email'      => 'Invalid email',
            'email_label'          => 'Email',
            'incorrect_email_pass' => 'Incorrect email / password',
        ],
    ];

    public function __construct(
        AcceptanceTester $tester,
        LanguageContext $languageContext,
        private readonly RestorePasswordPage $restorePasswordPage,
    ) {
        parent::__construct($tester, $languageContext);
    }

    public function open(): void
    {
        $this->tester->amOnPage(self::URL);
    }

    public function seeChosenLanguage(): void
    {
        $this->tester->see(
            $this->validationMessages[$this->languageContext->getLocale()]['email_label'],
            $this->emailLabel,
            'Язык страницы не соответствует заданному'
        );
    }

    public function seePageOpened(): void
    {
        $this->tester->seeInCurrentUrl(self::URL);
        $this->tester->seeElement($this->loginForm);
        $this->seeChosenLanguage();
    }

    public function removeFieldFocus(): void
    {
        $this->tester->click($this->authorizationDiv);
    }

    protected function waitForFieldErrorState(string $element): void
    {
        $this->tester->waitForElement(
            $element . '.has-error',
            5
        );
    }

    protected function waitForFieldValid(string $element): void
    {
        $this->tester->waitForElement(
            $element . '.has-success',
            5
        );
    }

    protected function seeFieldIsErrorState(string $element): void
    {
        $this->tester->seeElement($element . '.has-error');
    }

    protected function seeFieldIsValid(string $element): void
    {
        $this->tester->seeElement($element . '.has-success');
    }

    //Email
    public function fillEmail(string $email): void
    {
        $this->tester->fillField($this->emailField, $email, $this->loginForm);
        $this->tester->wait(0.2);
    }

    public function waitForEmailFieldErrorState(): void
    {
        $this->waitForFieldErrorState($this->emailContainer);
    }

    public function waitForEmailValid(): void
    {
        $this->waitForFieldValid($this->emailContainer);
    }

    public function seeEmailFieldHasErrorState(): void
    {
        $this->seeFieldIsErrorState($this->emailContainer);
    }

    public function seeEmailFieldIsValid(): void
    {
        $this->seeFieldIsValid($this->emailContainer);
    }

    public function seeInvalidEmailMessage(): void
    {
        $this->tester->seeElement($this->emailContainer . ' ' . $this->helpBlockError);
        $this->tester->see($this->validationMessages[$this->languageContext->getLocale()]['incorrect_email']);
    }

    public function seeEmailRequiredError(): void
    {
        $this->tester->seeElement($this->emailContainer . ' ' . $this->helpBlockError);
        $this->tester->see($this->validationMessages[$this->languageContext->getLocale()]['required_email']);
    }

    //Password
    public function fillPassword(string $password): void
    {
        $this->tester->fillField($this->passwordField, $password, $this->loginForm);
    }

    public function waitForPasswordFieldErrorState(): void
    {
        $this->waitForFieldErrorState($this->passwordContainer);
    }

    public function waitForPasswordValid(): void
    {
        $this->waitForFieldValid($this->passwordContainer);
    }

    public function seePasswordFieldHasErrorState(): void
    {
        $this->seeFieldIsErrorState($this->passwordContainer);
    }

    public function seePasswordFieldIsValid(): void
    {
        $this->seeFieldIsValid($this->passwordContainer);
    }

    public function seePasswordRequiredError(): void
    {
        $this->tester->seeElement($this->passwordContainer . ' ' . $this->helpBlockError);
        $this->tester->see($this->validationMessages[$this->languageContext->getLocale()]['required_password']);
    }

    public function seeEmailPasswordIncorrectError(): void
    {
        $this->tester->seeElement($this->passwordContainer . ' ' . $this->helpBlockError);
        $this->tester->see($this->validationMessages[$this->languageContext->getLocale()]['incorrect_email_pass']);
    }

    public function waitForLoginButtonDisabled(): void
    {
        $this->tester->waitForElementChange(
            $this->submitButton,
            function ($element): bool {
                return $element->getAttribute('disabled') !== null;
            },
            5
        );
    }

    public function waitForLoginButtonEnabled(): void
    {
        $this->tester->waitForElementChange(
            $this->submitButton,
            function ($element): bool {
                return $element->getAttribute('disabled') === null;
            },
            5
        );
    }

    public function seeLoginButtonDisabled(): void
    {
        $this->tester->seeElement($this->submitButton, [
            'disabled' => true,
        ]);
    }

    public function dontSeeInvalidEmailMessage(): void
    {
        $this->tester->dontSeeElement($this->emailContainer . ' ' . $this->helpBlockError);
        $this->tester->dontSee($this->validationMessages[$this->languageContext->getLocale()]['incorrect_email'], $this->loginForm);;
    }

    public function seeLoginButtonEnabled(): void
    {
        $this->tester->dontSeeElement($this->submitButton, [
            'disabled' => true,
        ]);
    }

    public function clickLogin(): void
    {
        $this->tester->click($this->submitButton, $this->loginForm);
    }

    public function login(string $email, string $password): void
    {
        $this->fillEmail($email);
        $this->fillPassword($password);

        $this->clickLogin();
    }

    public function seePasswordIsMasked(): void
    {
        $this->tester->seeElement($this->passwordField, [
            'type' => 'password',
        ]);
    }

    public function clickForgotPassword(): RestorePasswordPage
    {
        $this->tester->click($this->restorePasswordLink, $this->loginForm);

        return $this->restorePasswordPage;
    }
}
