# CodeFlexTech Laravel Uploader

A production-ready Laravel document uploader with:
- Polymorphic relations
- Public & private Documents
- Local / S3 support
- Image optimization
- Auto cleanup on model delete
- **Multiple document Types Support** 

## Installation

composer require codeflextech/laravel-uploader
```

## Configuration

Publish the config file to customize defaults:

```bash
php artisan vendor:publish --tag=uploader-config
```

### Key Config Options (`config/uploader.php`)

*   **`table_name`**: The database table name (default: `documents`). Can be set via `UPLOAD_TABLE_NAME` env var.
*   **`disk`**: Default storage disk (e.g., `public`, `s3`).
*   **`folder`**: Default folder name inside the disk (default: `uploads`).
*   **`structure`**: Date structure for organized Documents (default: `year/month/week`).
*   **`visibility`**: documents visibility (`public` or `private`).
*   **`optimize_images`**: Auto-resize images (boolean).

## Direct Public Uploads

By default, Documents are stored in `storage/app/public` and symlinked. If you want to upload **directly** to the `public/` folder (bypassing `storage/`), you can define a custom disk.

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
    $user->upload($document, ['disk' => 'public_uploads']);
    ```

## Basic Usage

### 1. Add Trait to Model

Add the `HasDocuments` trait to any model that should have Documents attached (e.g., User, Post, Product).

```php
use CodeFlexTech\Uploader\Traits\HasDocuments;

class User extends Authenticatable
{
    use HasDocuments;
}
```

### 2. Upload a Document

Use the `DocumentUploader` facade or class to handle uploads.

```php
$user->upload(
    $request->file('avatar'),
    [
        'folder' => 'avatars',
        'disk'   => 'public',
        'type'   => 'profile_pic'
    ]
);
```

## Advanced Usage: Document Types & Validation

You can categorize uploads by `type` (e.g., 'resume', 'profile_pic').

### 1. Upload with Type

Pass the `type` in the options array. If omitted, it defaults to `'document'`.

```php
$user->upload($document, ['type' => 'resume']);
```

### 2. Replacing Documents

By default, the `upload()` method enforces a 1-to-1 relationship per `type`. 
If a user already has a `'profile_pic'` and uploads a new one, the old document will automatically be deleted from storage and the database before the new one is saved.

### 3. Retrieve Documents by Type

The `HasDocuments` trait provides helper methods:

```php
// Get all resumes
$resumes = $user->documentsByType('resume')->get();

// Get the latest profile picture
$pic = $user->latestFile('profile_pic');
```

## License

MIT
