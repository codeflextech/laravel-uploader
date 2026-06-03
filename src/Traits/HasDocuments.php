<?php
declare(strict_types = 1);
namespace CodeFlexTech\Uploader\Traits;

use CodeFlexTech\Uploader\DocumentUploader;
use CodeFlexTech\Uploader\Models\Document;
use Illuminate\Support\Facades\Storage;

/**
 * Trait HasDocuments
 *
 * @package   CodeFlexTech\Uploader\Traits
 *
 * @author    Faisal Shah <faisalshah4004@gmail.com>
 *
 * @copyright 2026 CodeFlexTech.com
 * @version   1.0
 */
trait HasDocuments
{
    public static function bootHasDocuments()
    {
        static::deleting(function ($model) {
            $model->documents()->each(function ($document) {
                Storage::disk($document->disk)->delete($document->path);
                $document->delete();
            });
        });
    }

    /**
     * Function documents
     *
     * @return mixed
     */
    public function documents(): mixed
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    /**
     * Function documentsByType
     *
     * @param $type
     *
     * @return mixed
     */
    public function documentsByType($type): mixed
    {
        return $this->documents()->where('type', $type);
    }

    /**
     * Function latestDocument
     *
     * @param string|int $type
     *
     * @return mixed
     */
    public function latestDocument(string|int $type = 'document'): mixed
    {
        return $this->documents()
            ->when($type, fn ($q) => $q->where('type', $type))
            ->latest()
            ->first();
    }

    /**
     * Function upload
     *
     * @param       $document
     * @param array $options
     *
     * @return \CodeFlexTech\Uploader\Models\Document
     */
    public function upload($document, array $options = []): Document
    {
        $type = $options['type'] ?? config('uploader.type', 'document');

        // Delete existing document(s) of this type
        $this->documentsByType($type)->get()->each(function ($existingdocument) {
            Storage::disk($existingdocument->disk)->delete($existingdocument->path);
            $existingdocument->delete();
        });

        $options['type'] = $type;

        return DocumentUploader::upload($document, $this, $options);
    }
}
