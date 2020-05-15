<?php

namespace App\Models;

use App\Helpers\Util;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $table = 'medias';
    protected $guarded = [];
    protected $appends = ['readable_bytes', 'original_url', 'thumbnail_url'];

    public function mediable()
    {
        return $this->morphTo('mediable');
    }

    public function getOriginalUrlAttribute()
    {
        return $this->original_path ? Storage::disk('public')->url($this->original_path) : '';
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? Storage::disk('public')->url($this->thumbnail_path) : '';
    }

    public function getReadableBytesAttribute()
    {
        return $this->size ? Util::getHumanNumber($this->size) : '0 byte';
    }
}
