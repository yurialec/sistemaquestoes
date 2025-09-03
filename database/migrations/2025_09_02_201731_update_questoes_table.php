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
        Schema::table('questoes', function (Blueprint $table) {
            if (!Schema::hasColumn('questoes', 'gabarito_id')) {
                $table->foreignId('gabarito_id')
                    ->nullable()
                    ->constrained('alternativas')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('questoes', 'gabarito_id')) {
            $fk = DB::selectOne("
                SELECT CONSTRAINT_NAME
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_SCHEMA = DATABASE()
                  AND TABLE_NAME = 'questoes'
                  AND COLUMN_NAME = 'gabarito_id'
                  AND REFERENCED_TABLE_NAME IS NOT NULL
                LIMIT 1
            ");

            if ($fk) {
                Schema::table('questoes', function (Blueprint $table) {
                    $table->dropForeign(['gabarito_id']);
                });
            }
        }
    }
};
