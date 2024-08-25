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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->references('id')->on('chats');
            $table->foreignId('sender_id')->references('id')->on('users');
            $table->longText('text')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['send', 'delivered', 'seen'])->default('send');
            $table->boolean('is_edited')->default(false);
            $table->boolean('is_forwarded')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
