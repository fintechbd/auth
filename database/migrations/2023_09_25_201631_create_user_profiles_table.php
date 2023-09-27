<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unsigned();
            $table->string('id_type')->nullable();
            $table->string('id_no')->nullable();
            $table->string('id_issue_country')->nullable();
            $table->date('id_expired_at')->nullable();
            $table->date('id_issue_at')->nullable();
            $table->string('id_no_duplicate')->default('no');
            $table->date('date_of_birth')->nullable();
            $table->string('permanent_address')->nullable();
            $table->foreignId('city_id')->nullable()->unsigned();
            $table->foreignId('state_id')->nullable()->unsigned();
            $table->foreignId('country_id')->nullable()->unsigned();
            $table->string('post_code')->nullable();
            $table->string('present_address')->nullable();
            $table->foreignId('present_city_id')->nullable()->unsigned();
            $table->foreignId('present_state_id')->nullable()->unsigned();
            $table->foreignId('present_country_id')->nullable()->unsigned();
            $table->string('present_post_code')->nullable();
            $table->foreignId('approver_id')->nullable()->unsigned();
            $table->string('blacklisted')->default('no');
            $table->json('user_profile_data')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('present_country_id')->references('id')->on('countries')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('present_state_id')->references('id')->on('states')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('present_city_id')->references('id')->on('cities')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->unsignedBigInteger('creator_id')->index()->nullable();
            $table->unsignedBigInteger('editor_id')->index()->nullable();
            $table->unsignedBigInteger('destroyer_id')->index()->nullable();
            $table->timestamps();
            $table->softDeletes();
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
