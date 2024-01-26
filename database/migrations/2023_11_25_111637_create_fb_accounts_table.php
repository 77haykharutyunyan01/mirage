<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fb_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('login');
            $table->string('password');
            $table->string('cookie');
            $table->string('token');
            $table->string('session_id')->nullable();
            $table->unsignedBigInteger('proxy_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fb_accounts');
    }
};
