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
      // database/migrations/xxxx_xx_xx_create_change_logs_table.php
        Schema::create('change_logs', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('field_name');
            $table->string('change_type'); // 'update', 'insert', 'delete'
            $table->json('old_value')->nullable();
            $table->json('new_value')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_logs');
    }
};
