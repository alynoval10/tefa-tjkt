<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {

            $table->id();

            $table->string('school_name')->nullable();
$table->string('tefa_name')->nullable();
$table->string('department_name')->nullable();

$table->text('address')->nullable();

$table->string('phone')->nullable();
$table->string('email')->nullable();
$table->string('website')->nullable();

$table->string('school_logo')->nullable();
$table->string('tefa_logo')->nullable();

$table->foreignId('head_program_id')->nullable()->constrained('users')->nullOnDelete();
$table->foreignId('treasurer_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};