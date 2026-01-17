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
        Schema::create('card_tcg_set_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tcg_set_type_id')->constrained('tcg_set_types');
            $table->foreignId('card_id')->constrained('cards');
            $table->string('img_url')->nullable();
            $table->string('code');
            $table->string('rarity_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_tcg_set_type');
    }
};
