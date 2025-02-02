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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->text('answer');
            $table->enum('type', ['basique', 'carte inversée', 'texte à trous'])->default('basique');
            $table->foreignId('deck_id')->constrained()->onDelete('cascade');
            $table->boolean('deleted')->default(false);
            $table->timestamp('next_review_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
