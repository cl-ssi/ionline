<?php

namespace App\Filament\Auth;
use Filament\Pages\Auth\Login;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Support\Htmlable;

class CustomLogin extends Login
{
    /**
     * @return array<int | string, string | Form>
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getRunFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getRunFormComponent(): Component
    {
        return TextInput::make('run')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'run' => $data['run'] = preg_replace('/[^0-9K]/', '', strtoupper($data['run'])),
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.run' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    public function getHeading(): string | Htmlable
    {
        return env('APP_SS') ?? 'Variable APP_SS no está definida';
    }
}
