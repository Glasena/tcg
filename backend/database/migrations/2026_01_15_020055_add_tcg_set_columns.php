<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tcg_set_types', function (Blueprint $table) {
            $table->integer('num_of_cards')->nullable();
            $table->date('tcg_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('tcg_set_types', function (Blueprint $table) {
            $table->dropColumn('num_of_cards');
            $table->dropColumn('tcg_date');
        });
    }
};
