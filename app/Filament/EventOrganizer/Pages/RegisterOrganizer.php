<?php

namespace App\Filament\EventOrganizer\Pages;

use App\Models\Event\Organizer;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterOrganizer extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register New Organizer';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('label')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function handleRegistration(array $data): Organizer
    {
        return tap(parent::handleRegistration($data), fn(Organizer $organizer) =>
            $organizer->users()->attach(auth()->id()));
    }
}
