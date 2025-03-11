<?php

namespace App\Models\Event;

use Str;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Status implements HasLabel, HasColor
{
    case DRAFT;
    case PUBLISHED;
    case ARCHIVED;

    public function getLabel(): string
    {
        return Str::title($this->name);
    }

    public function getColor(): string
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::PUBLISHED => 'success',
            self::ARCHIVED => 'warning',
        };
    }
}
