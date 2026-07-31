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
    Schema::create('kas', function (Blueprint $table) {
        $table->id();

        $table->date('tanggal');

        $table->foreignId('category_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->enum('jenis', [
            'income',
            'expense',
        ]);

        $table->decimal('nominal', 15, 2);

        $table->text('keterangan')->nullable();

        $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kas');
    }
};
