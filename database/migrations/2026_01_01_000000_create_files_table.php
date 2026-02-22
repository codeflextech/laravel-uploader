<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    public function up()
    {
        $table_name = config('uploader.table_name', 'files');

        Schema::create($table_name, function (Blueprint $table) {
            $table->id();
            $table->string('disk');
            $table->string('path');
            $table->string('original_name');
            $table->string('type')->index();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('size')->nullable();
            $table->nullableMorphs('fileable');
            $table->timestamps();
        });

    }

    public function down()
    {
        $table_name = config('uploader.table_name', 'files');

        Schema::dropIfExists($table_name);
    }
}