<?php
declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateDocumentsTable
 *
 * @package   ${NAMESPACE}
 *
 * @author    Faisal Shah <faisalshah4004@gmail.com>
 *
 * @copyright 2026 CodeFlexTech.com
 * @version   2.0
 */
class CreateDocumentsTable extends Migration
{
    /**
     * Function up
     */
    public function up(): void
    {
        $tableName = config('uploader.table_name', 'documents');

        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->string('disk');
            $table->string('path');
            $table->string('original_name');
            $table->string('type')->index();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->nullableMorphs('documentable');
            $table->timestamps();
        });

    }

    /**
     * Function down
     */
    public function down(): void
    {
        $tableName = config('uploader.table_name', 'documents');

        Schema::dropIfExists($tableName);
    }
}
