<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    protected static string $layout = 'filament.layouts.auth';

    protected Width | string | null $maxWidth = Width::Medium;

    public function hasTopbar(): bool
    {
        return false;
    }

    public function hasLogo(): bool
    {
        return false;
    }

    public function getTitle(): string | Htmlable
    {
        return 'Sign in — Acremann CMS';
    }

    public function getHeading(): string | Htmlable | null
    {
        if (filled($this->userUndertakingMultiFactorAuthentication)) {
            return parent::getHeading();
        }

        return 'Welcome back';
    }

    public function getSubheading(): string | Htmlable | null
    {
        if (filled($this->userUndertakingMultiFactorAuthentication)) {
            return parent::getSubheading();
        }

        return 'Sign in to manage properties, leads, assistant conversations, and site content.';
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email address')
            ->email()
            ->required()
            ->autocomplete('username')
            ->autofocus()
            ->prefixIcon(Heroicon::OutlinedEnvelope)
            ->placeholder('you@company.com')
            ->extraInputAttributes(['spellcheck' => 'false']);
    }

    protected function getPasswordFormComponent(): Component
    {
        return parent::getPasswordFormComponent()
            ->label('Password')
            ->prefixIcon(Heroicon::OutlinedLockClosed)
            ->placeholder('Enter your password');
    }

    protected function getRememberFormComponent(): Component
    {
        return parent::getRememberFormComponent()
            ->label('Keep me signed in on this device');
    }

    protected function getAuthenticateFormAction(): \Filament\Actions\Action
    {
        return parent::getAuthenticateFormAction()
            ->label('Sign in to CMS')
            ->icon(Heroicon::OutlinedArrowRightEndOnRectangle);
    }
}
