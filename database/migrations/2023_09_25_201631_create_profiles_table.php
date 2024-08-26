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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unsigned();
            $table->foreignId('id_doc_type_id')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_no')->nullable();
            $table->string('id_issue_country')->nullable();
            $table->date('id_expired_at')->nullable();
            $table->date('id_issue_at')->nullable();
            $table->string('id_no_duplicate')->default('no');
            $table->date('date_of_birth')->nullable();
            $table->string('permanent_address')->nullable();
            $table->foreignId('permanent_city_id')->nullable();
            $table->foreignId('permanent_state_id')->nullable();
            $table->foreignId('permanent_country_id')->nullable();
            $table->string('permanent_post_code')->nullable();
            $table->string('present_address')->nullable();
            $table->foreignId('present_city_id')->nullable();
            $table->foreignId('present_state_id')->nullable();
            $table->foreignId('present_country_id')->nullable();
            $table->string('present_post_code')->nullable();
            $table->foreignId('approver_id')->nullable();
            $table->string('blacklisted')->default('no');
            $table->json('user_profile_data')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('profiles');
    }
};
