<?php

namespace App\Models\Event;

use App\Models\Event;
use App\Models\User;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organizer extends Model implements HasName
{
    protected $fillable = ['label'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function getFilamentName(): string
    {
        return $this->label;
    }
}
