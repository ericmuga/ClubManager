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
        Schema::create('club_settings', function (Blueprint $table) {
            $table->id();
            $table->string('club_name', 50);
            $table->boolean('change_log_active')->nullable();
            $table->string('default_currency', 5)->nullable();
            $table->string('logo', 100)->nullable();
            $table->boolean('dispatch_emails')->nullable();
            $table->boolean('active')->nullable();
            $table->string('address', 100)->nullable();
            $table->string('telephone', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('slogan', 100)->nullable();
            $table->string('pin', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_settings');
    }
};
