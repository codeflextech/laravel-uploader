# CodeFlexTech Laravel Uploader

A production-ready Laravel file uploader with:
- Polymorphic relations
- Public & private files
- Local / S3 support
- Image optimization
- Auto cleanup on model delete

## Installation

```bash
composer require codeflextech/laravel-uploader
```

## Basic Usage

### 1. Add Trait to Model

Add the `HasFiles` trait to any model that should have files attached (e.g., User, Post, Product).

```php
use CodeFlexTech\Uploader\Traits\HasFiles;

class User extends Authenticatable
{
    use HasFiles;
}
```

### 2. Upload a File

Use the `FileUploader` facade or class to handle uploads.

```php
use CodeFlexTech\Uploader\FileUploader;

FileUploader::upload(
    $request->file('avatar'),
    $user, // The model instance (owner)
    [
        'folder' => 'avatars',
        'disk'   => 'public', // or 's3'
    ]
);
```

## License

MIT
