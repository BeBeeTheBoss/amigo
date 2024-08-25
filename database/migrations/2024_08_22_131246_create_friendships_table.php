<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_user_id')->references('id')->on('users');
            $table->foreignId('accept_user_id')->references('id')->on('users');
            $table->boolean('is_accepted')->default(false);
            $table->enum('type', ['friend', 'partner', 'family_member']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friendships');
    }
};
