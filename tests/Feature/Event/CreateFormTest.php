<?php

use App\Models\User;
use App\Filament\Resources\EventResource;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

it('can display the page', function () {
    actingAs(User::factory()->create())
        ->get(EventResource::getUrl('create'))
        ->assertSuccessful();
});

it('can display the form', function () {
    actingAs(User::factory()->create());
    livewire(EventResource\Pages\CreateEvent::class)
        ->assertFormExists()
        ->assertFormFieldExists('name');
});

it('can create an event', function () {
    actingAs(User::factory()->create());
    livewire(EventResource\Pages\CreateEvent::class)
        ->fillForm([
            'name' => 'Test Event',
        ])
        ->call('create')
        ->assertHasNoFormErrors()
        ->assertRedirect(EventResource::getUrl('edit', [1]));
});
