<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('provider');               // google, github, ...
            $table->string('provider_id');
            $table->string('provider_email')->nullable();
            $table->string('provider_avatar')->nullable();
            $table->json('provider_data')->nullable(); // raw provider payload
            $table->text('access_token')->nullable();  // encrypted (model cast)
            $table->text('refresh_token')->nullable(); // encrypted (model cast)
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();

            $table->unique(['provider', 'provider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_accounts');
    }
};
