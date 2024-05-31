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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->tinyInteger('role')->default(1);
            $table->timestamp('FirstLogin')->nullable(); // First Login of the user in the system. example, "March 14, 2021 - 11:10 P.M"
            $table->timestamp('LastLogin')->nullable(); // Latest Login of the user in the system example, "6 Hours ago"
            $table->string('AvgProcessTime')->nullable(); // Average use of the user account. example, "5 Hours per Day"
            $table->timestamp('current_login_at')->nullable();
            $table->timestamp('last_logout_at')->nullable();
            $table->integer('sessions_count')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
