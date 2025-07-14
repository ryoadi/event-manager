<?php

namespace App\Filament\EventOrganizer\Resources;

use App\Filament\EventOrganizer\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                FileUpload::make('logo')
                    ->image()
                    ->imageEditor()
                    ->directory('events')
                    ->downloadable(),
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->image()
                    ->columnSpanFull()
                    ->directory('events/gallery')
                    ->downloadable()
                    ->multiple()
                    ->reorderable()
                    ->responsiveImages()
                    ->conversion('webp'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(Event\Status::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('publish')
                    ->action(fn (Event $event) => $event->publish())
                    ->authorize('publish', Event::class),
                Tables\Actions\Action::make('republish')
                    ->action(fn (Event $event) => $event->publish())
                    ->authorize('republish', Event::class),
                Tables\Actions\Action::make('archive')
                    ->action(fn (Event $event) => $event->archive())
                    ->authorize('archive', Event::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
