<?php

namespace CodeFlexTech\Uploader;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use CodeFlexTech\Uploader\Models\File;

class FileUploader
{
    public static function upload(
        UploadedFile $file,
        $model = null,
        array $options = []
    ): File {

        $disk = $options['disk'] ?? config('uploader.disk') ?? 'public';
        $folder = $options['folder'] ?? config('uploader.folder') ?? 'uploads';

        $year = now()->year;
        $month = now()->format('m');
        $week = 'week-'.now()->weekOfMonth;

        $path = "{$folder}/{$year}/{$month}/{$week}";
        $name = Str::uuid().'.'.$file->getClientOriginalExtension();

        // Image optimization
        if (str_starts_with($file->getMimeType(), 'image/')
            && config('uploader.optimize_images')) {

            $image = Image::make($file)
                ->resize(config('uploader.image_max_width'), null, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                })
                ->encode();

            Storage::disk($disk)->put(
                "{$path}/{$name}",
                $image,
                config('uploader.visibility')
            );
        } else {
            $file->storeAs($path, $name, [
                'disk' => $disk,
                'visibility' => config('uploader.visibility')
            ]);
        }

        $type = $options['type'] ?? config('uploader.type') ?? 'file';

        return File::create([
            'disk' => $disk,
            'path' => "{$path}/{$name}",
            'original_name' => $file->getClientOriginalName(),
            'type' => $type,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'fileable_id' => $model?->getKey(),
            'fileable_type' => $model ? get_class($model) : null,
        ]);
    }
}
