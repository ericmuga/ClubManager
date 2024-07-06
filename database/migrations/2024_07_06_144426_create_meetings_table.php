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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('description');
            $table->date('meeting_date');
            $table->string('venue')->nullable();
            $table->string('topic')->nullable();
            $table->text('detail')->nullable();
            $table->string('host')->nullable();
            $table->string('uuid')->nullable();
            $table->string('meeting_no');
            $table->time('official_start_time');
            $table->time('official_end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
