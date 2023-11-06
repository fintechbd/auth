<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('id_doc_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable();
            $table->string('name');
            $table->string('code');
            $table->unsignedSmallInteger('sides')->default(1);
            $table->boolean('enabled')->default(true);
            $table->json('id_doc_type_data')->nullable();
            $table->foreignId('creator_id')->nullable();
            $table->foreignId('editor_id')->nullable();
            $table->foreignId('destroyer_id')->nullable();
            $table->foreignId('restorer_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('restored_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('id_doc_types');
    }
};
