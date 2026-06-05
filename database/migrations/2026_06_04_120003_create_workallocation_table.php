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
        Schema::create('workallocation', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->primary();
            $table->text('remarks')->nullable();
            $table->integer('employee')->nullable();
            $table->date('trans_date')->nullable();
            $table->string('process', 10)->nullable();
            $table->string('sw', 25)->nullable();
            
            $table->foreign('employee')
                ->references('id_employee')
                ->on('employee');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workallocation');
    }
};
