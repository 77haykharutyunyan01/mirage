<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fb_accounts', function (Blueprint $table) {
            $table->boolean('is_valid')->default(true);
            $table->timestamp('last_used_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('fb_accounts', function (Blueprint $table) {
            $table->dropColumn('is_valid');
            $table->dropColumn('last_used_at');
        });
    }
};
