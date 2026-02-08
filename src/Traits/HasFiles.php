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

    public function filesByType($type)
    {
        return $this->files()->where('type', $type);
    }

    public function latestFile($type = null)
    {
        return $this->files()
            ->when($type, fn ($q) => $q->where('type', $type))
            ->latest()
            ->first();
    }

    /**
     * Upload a file and attach it to this model.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param array $options
     * @return \CodeFlexTech\Uploader\Models\File
     */
    public function upload($file, array $options = [])
    {
        return \CodeFlexTech\Uploader\FileUploader::upload($file, $this, $options);
    }
}
