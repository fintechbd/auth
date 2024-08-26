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
        Schema::table(
            config('auth.passwords.users.table', 'password_reset_tokens'),
            function (Blueprint $table) {
                $table->string('channel')
                    ->default('email')
                    ->after('email')
                    ->comment('notification channel');
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(
            config('auth.passwords.users.table', 'password_reset_tokens'),
            function (Blueprint $table) {
                $table->dropColumn('channel');
            }
        );
    }
};
