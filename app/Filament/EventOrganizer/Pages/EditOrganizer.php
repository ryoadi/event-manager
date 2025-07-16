<?php

namespace App\Filament\EventOrganizer\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;

class EditOrganizer extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Edit Organizer Profile';
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
}
