<?php

use App\Models\Event;
use App\Models\User;
use App\Filament\Resources\EventResource;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('can publish the event', function () {
    $event = Event::factory()->create([
        'name' => 'Test Event',
        'status' => Event\Status::DRAFT,
    ]);
    actingAs(User::factory()->create());
    livewire(EventResource\Pages\EditEvent::class, [
        'record' => $event->getKey(),
    ])
        ->callAction('publish')
        ->assertHasNoErrors();
});

it('cannot publish published event', function () {
    $event = Event::factory()->create([
        'name' => 'Test Event',
        'status' => Event\Status::PUBLISHED,
    ]);
    actingAs(User::factory()->create());
    livewire(EventResource\Pages\EditEvent::class, [
        'record' => $event->getKey(),
    ])
        ->assertActionHidden('publish');
});
