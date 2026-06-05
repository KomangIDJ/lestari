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
        Schema::create('employee', function (Blueprint $table) {
            $table->integer('id_employee')->autoIncrement()->primary();
            $table->timestamp('entry_date')->nullable()->useCurrent();
            $table->string('name', 100);
            $table->string('rank', 20)->nullable();
            $table->char('gender', 1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
