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
        Schema::table('questoes', function (Blueprint $table) {
            if (Schema::hasColumn('questoes', 'gabarito_id')) {
                $table->dropForeign(['gabarito_id']);
                $table->dropColumn('gabarito_id');
            }
        });
    }
};
