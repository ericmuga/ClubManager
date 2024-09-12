<?php

use App\Models\EntryType;
use App\Models\User;
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
        Schema::create('entries', function (Blueprint $table) {
                $table->id();
                $table->foreignIdFor(EntryType::class); // Make sure EntryType model is correctly referenced
                $table->foreignIdFor(User::class)->nullable();
                $table->string('description')->nullable();
                $table->date('posting_date');
                $table->string('user_type')->nullable();
                $table->string('member_no')->nullable();
                $table->string('currency_code');
                $table->decimal('amount', 18, 2); // Use decimal for monetary values (18 digits, 2 after the decimal point)
                $table->timestamps();
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
