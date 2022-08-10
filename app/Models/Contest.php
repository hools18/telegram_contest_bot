<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Contest extends Model  implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['id'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb_1200')
            ->quality(80)
            ->fit('max', 1280, 800)
            ->performOnCollections('image')
            ->keepOriginalImageFormat()
            ->nonQueued();
    }

    public function members(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ContestMember::class);
    }

    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = Carbon::createFromFormat('d.m.Y H:i', $value)->format('Y-m-d H:i:s');
    }

    public function getStartDateAttribute($value): string
    {
        return Carbon::parse($value)->format('d.m.Y H:i');
    }

    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = Carbon::createFromFormat('d.m.Y H:i', $value)->format('Y-m-d H:i:s');
    }

    public function getEndDateAttribute($value): string
    {
        return Carbon::parse($value)->format('d.m.Y H:i');
    }

    public function getContestImage(): string
    {
        return url($this->getFirstMediaUrl('image', 'thumb_1200')) ?? 'https://berkut52.ru/images/design/logo.jpg';
    }
}
