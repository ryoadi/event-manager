<?php

use App\Models\Event;
use App\Models\User;
use App\Filament\Resources\EventResource;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('can display the table', function () {
    Event::factory()->create([
        'name' => 'Test Event',
    ]);
    actingAs(User::factory()->create());
    livewire(EventResource\Pages\ListEvents::class)
        ->assertTableColumnExists('name')
        ->assertTableColumnExists('status')
        ->assertTableFilterExists('status')
        ->assertTableActionExists('edit')
        ->assertTableActionExists('publish')
        ->assertTableActionExists('republish')
        ->assertTableActionExists('archive')
        ->assertTableBulkActionExists('delete')
        ->assertActionExists('create');
});

it('can filter by status', function () {
    $draftEvent = Event::factory()->create([
        'name' => 'Test Event',
        'status' => Event\Status::DRAFT,
    ]);
    $publishedEvent = Event::factory()->create([
        'name' => 'Test Event 2',
        'status' => Event\Status::PUBLISHED,
    ]);
    actingAs(User::factory()->create());
    livewire(EventResource\Pages\ListEvents::class)
        ->filterTable('status', Event\Status::DRAFT->name)
        ->assertCanSeeTableRecords([$draftEvent])
        ->assertCanNotSeeTableRecords([$publishedEvent]);
});

it('can search by name', function () {
    $event = Event::factory()->create([
        'name' => 'Test Event',
    ]);
    $event2 = Event::factory()->create([
        'name' => 'Test Event 2',
    ]);
    actingAs(User::factory()->create());
    livewire(EventResource\Pages\ListEvents::class)
        ->searchTable('Test Event 2')
        ->assertCanSeeTableRecords([$event2])
        ->assertCanNotSeeTableRecords([$event]);
});
