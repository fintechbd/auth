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
        if (Schema::hasTable('users')) {
            throw new ErrorException('`users` table already exists. please remove migration file and backup user data.');
        }

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('users');
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('login_id')->unique();
            $table->string('password');
            $table->unsignedSmallInteger('wrong_password')->default(0);
            $table->string('pin')->nullable();
            $table->unsignedSmallInteger('wrong_pin')->default(0);
            $table->string('status')->nullable();
            $table->string('language')->nullable();
            $table->string('currency')->nullable();
            $table->string('app_version')->default('1.0.0')->nullable();
            $table->rememberToken();
            $table->string('fcm_token')->nullable();
            $table->foreignId('creator_id')->nullable();
            $table->foreignId('editor_id')->nullable();
            $table->foreignId('destroyer_id')->nullable();
            $table->foreignId('restorer_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
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
        Schema::dropIfExists('users');
    }
};
