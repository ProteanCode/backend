<?php

namespace App\Models;

use App\Enums\MediaConversions;
use App\Enums\NftCardStatus;
use Illuminate\Database\Eloquent\Builder;
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
 * @property string $status
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 *
 * @method static Builder|NftCard active()
 * @method static Builder|NftCard whereStatus($value)
 *
 * @mixin \Eloquent
 */
class NftCard extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia;

    protected $guarded = ['id'];

    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('status', NftCardStatus::ACTIVE->value);
    }

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
