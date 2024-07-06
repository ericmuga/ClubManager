<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Schema,DB};


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // });
        DB::statement("
            CREATE VIEW guests AS
            SELECT *
            FROM users
            WHERE user_type = 'guest'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS guests");
    }
};
