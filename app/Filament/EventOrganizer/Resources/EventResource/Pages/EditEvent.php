<?php

namespace App\Filament\EventOrganizer\Resources\EventResource\Pages;

use App\Filament\EventOrganizer\Resources\EventResource;
use App\Models\Event;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('status')
                ->disabled()
                ->badge()
                ->color(fn (Event $event) => $event->status->getColor())
                ->label(fn (Event $event) => $event->status->getLabel()),
            Actions\Action::make('publish')
                ->action(fn (Event $event) => $event->publish())
                ->authorize('publish', Event::class)
                ->color(Event\Status::PUBLISHED->getColor()),
            Actions\Action::make('republish')
                ->action(fn (Event $event) => $event->publish())
                ->authorize('republish', Event::class)
                ->color(Event\Status::PUBLISHED->getColor()),
            Actions\Action::make('archive')
                ->action(fn (Event $event) => $event->archive())
                ->authorize('archive', Event::class),
            Actions\DeleteAction::make(),
        ];
    }
}
