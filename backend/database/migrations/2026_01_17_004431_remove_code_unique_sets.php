<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $constraintExists = DB::select(
            "SELECT constraint_name 
             FROM information_schema.table_constraints 
             WHERE table_name = 'tcg_set_types' 
             AND constraint_name = 'tcg_set_types_code_unique'"
        );

        if (!empty($constraintExists)) {
            Schema::table('tcg_set_types', function (Blueprint $table) {
                $table->dropUnique(['code']);
            });
        }
    }

    public function down(): void
    {
        Schema::table('tcg_set_types', function (Blueprint $table) {
            $table->unique('code');
        });
    }
};
