<?php

namespace CodeFlexTech\Uploader\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'disk',
        'path',
        'original_name',
        'type',
        'mime_type',
        'size',
        'fileable_id',
        'fileable_type',
    ];

    public function getTable()
    {
        return config('uploader.table_name', 'files');
    }

    public function getUrlAttribute()
    {
        return \Illuminate\Support\Facades\Storage::disk($this->disk)->url($this->path);
    }

    public function fileable()
    {
        return $this->morphTo();
    }
}