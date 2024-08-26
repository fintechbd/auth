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
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('ip')->nullable();
            $table->string('mac')->nullable();
            $table->mediumText('agent')->nullable();
            $table->string('platform')->nullable();
            $table->mediumText('address')->nullable();
            $table->string('city')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->string('state')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->string('country')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('status')->nullable();
            $table->mediumText('note')->nullable();
            $table->json('login_attempt_data')->nullable();
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
        Schema::dropIfExists('login_attempts');
    }
};
