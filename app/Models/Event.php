<?php

namespace App\Models;

use App\Models\Event\Organizer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property string $name
 * @property Event\Status $status
*/
class Event extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'status',
        'logo',
        'organizer_id',
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

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp');
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }
}
