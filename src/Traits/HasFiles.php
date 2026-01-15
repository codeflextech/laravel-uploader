<?php
namespace CodeFlexTech\Uploader\Traits;

use CodeFlexTech\Uploader\Models\File;
use Illuminate\Support\Facades\Storage;

trait HasFiles
{
    public static function bootHasFiles()
    {
        static::deleting(function ($model) {
            $model->files()->each(function ($file) {
                Storage::disk($file->disk)->delete($file->path);
                $file->delete();
            });
        });
    }

    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
