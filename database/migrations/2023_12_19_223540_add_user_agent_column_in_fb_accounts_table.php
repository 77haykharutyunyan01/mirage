<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fb_accounts', function (Blueprint $table) {
            $table->text('user_agent')->after('cookie');
        });
    }

    public function down(): void
    {
        Schema::table('fb_accounts', function (Blueprint $table) {
            $table->dropColumn('user_agent');
        });
    }
};
