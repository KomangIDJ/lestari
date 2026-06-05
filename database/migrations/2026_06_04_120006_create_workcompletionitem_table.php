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
        Schema::create('workcompletionitem', function (Blueprint $table) {
            $table->integer('idm')->autoIncrement()->primary();
            $table->integer('ordinal')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('weight', 15, 2)->nullable();
            $table->bigInteger('link_id')->nullable();
            $table->integer('link_ord')->nullable();
            $table->integer('fg')->nullable();
            
            $table->foreign('fg')
                ->references('id_product')
                ->on('product');
        });

        // Add work_completion_id column if not exists (for the migration update)
        if (!Schema::hasColumn('workcompletionitem', 'work_completion_id')) {
            Schema::table('workcompletionitem', function (Blueprint $table) {
                $table->integer('work_completion_id')->nullable()->after('idm');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workcompletionitem');
    }
};
