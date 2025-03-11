<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Models\Event;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\EventResource;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('status')
                ->disabled()
                ->badge()
                ->color(fn(Event $event) => $event->status->getColor())
                ->label(fn(Event $event) => $event->status->getLabel()),
            Actions\Action::make('publish')
                ->action(fn(Event $event) => $event->publish())
                ->authorize('publish', Event::class)
                ->color(Event\Status::PUBLISHED->getColor()),
            Actions\Action::make('republish')
                ->action(fn(Event $event) => $event->publish())
                ->authorize('republish', Event::class)
                ->color(Event\Status::PUBLISHED->getColor()),
            Actions\Action::make('archive')
                ->action(fn(Event $event) => $event->archive())
                ->authorize('archive', Event::class),
            Actions\DeleteAction::make(),
        ];
    }
}
