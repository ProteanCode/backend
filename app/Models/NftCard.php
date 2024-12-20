<?php

namespace App\Models;

use App\Enums\MediaConversions;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property string $id
 * @property string $name
 * @property string $collection
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|NftCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NftCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NftCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|NftCard whereCollection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NftCard whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NftCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NftCard whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NftCard whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NftCard whereUserId($value)
 *
 * @mixin \Eloquent
 */
class NftCard extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion(MediaConversions::RESPONSEIVE->value)
            ->withResponsiveImages()
            ->queued();
    }
}
