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
        Schema::table('users', function (Blueprint $table) {
        // $table->timestamp('email_verified_at')->nullable()->after('password');
        $table->boolean('is_active')->default(0)->after('email_verified_at');
        $table->string('address')->nullable();
        $table->string('first_name');
        $table->string('last_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn([
            'is_active',
            'address',
            'first_name',
            'last_name'
        ]);
        });
    }
};
