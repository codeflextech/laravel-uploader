# CodeFlexTech Laravel Uploader

A production-ready Laravel file uploader with:
- Polymorphic relations
- Public & private files
- Local / S3 support
- Image optimization
- Auto cleanup on model delete
- **Multiple File Types Support** 

## Installation

composer require codeflextech/laravel-uploader
```

## Configuration

Publish the config file to customize defaults:

```bash
php artisan vendor:publish --tag=uploader-config
```

### Key Config Options (`config/uploader.php`)

*   **`disk`**: Default storage disk (e.g., `public`, `s3`).
*   **`folder`**: Default folder name inside the disk (default: `uploads`).
*   **`structure`**: Date structure for organized files (default: `year/month/week`).
*   **`visibility`**: File visibility (`public` or `private`).
*   **`optimize_images`**: Auto-resize images (boolean).

## Direct Public Uploads

By default, files are stored in `storage/app/public` and symlinked. If you want to upload **directly** to the `public/` folder (bypassing `storage/`), you can define a custom disk.

1.  Add to `config/filesystems.php`:

    ```php
    'public_uploads' => [
        'driver' => 'local',
        'root'   => public_path('uploads'), // Uploads to public/uploads
        'url'    => env('APP_URL').'/uploads',
        'visibility' => 'public',
    ],
    ```

2.  Use it in your upload:

    ```php
    $user->upload($file, ['disk' => 'public_uploads']);
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
```php
// Old way (still works)
// FileUploader::upload($request->file('avatar'), $user, [...]);

// New, cleaner way
$user->upload(
    $request->file('avatar'),
    [
        'folder' => 'avatars',
        'disk'   => 'public',
        'type'   => 'profile_pic'
    ]
);
```

## Advanced Usage: File Types & Validation

You can categorize uploads by `type` (e.g., 'resume', 'profile_pic').

### 1. Upload with Type

Pass the `type` in the options array. If omitted, it defaults to `'file'`.

```php
FileUploader::upload($file, $user, ['type' => 'resume']);
```

### 2. Define Allowed Types (Validation)

To restrict allowed types, define a `const FILE_TYPES` array in your model.

```php
class User extends Authenticatable
{
    use HasFiles;

    const FILE_TYPES = [
        'resume',
        'profile_pic',
        'contract'
    ];
}
```

*If you try to upload a type not in this list, an `InvalidArgumentException` will be thrown.*

### 3. Retrieve Files by Type

The `HasFiles` trait provides helper methods:

```php
// Get all resumes
$resumes = $user->filesByType('resume')->get();

// Get the latest profile picture
$pic = $user->latestFile('profile_pic');
```

## License

MIT
