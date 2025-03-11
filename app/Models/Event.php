<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property Event\Status $status
*/
class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => Event\Status::class
    ];

    public function publish(): void
    {
        $this->update([
            'status' => Event\Status::PUBLISHED,
        ]);
    }

    public function archive(): void
    {
        $this->update([
            'status' => Event\Status::ARCHIVED,
        ]);
    }
}
