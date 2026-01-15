<?php

namespace CodeFlexTech\Uploader\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'disk',
        'path',
        'original_name',
        'mime_type',
        'size',
        'fileable_id',
        'fileable_type',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
}