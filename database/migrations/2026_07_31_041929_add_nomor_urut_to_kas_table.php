<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->unsignedInteger('nomor_urut')
                ->default(0)
                ->after('no_bukti');
        });
    }

    public function down(): void
    {
        Schema::table('kas', function (Blueprint $table) {
            $table->dropColumn('nomor_urut');
        });
    }
};