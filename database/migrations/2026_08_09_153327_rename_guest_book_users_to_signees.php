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
        Schema::rename('guest_book_users', 'signees');

        Schema::table('signees', function (Blueprint $table) {
            $table->renameColumn('lat', 'latitude');
            $table->renameColumn('long', 'longitude');
            $table->string('ip_address')->nullable()->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signees', function (Blueprint $table) {
            $table->dropColumn('ip_address');
            $table->renameColumn('latitude', 'lat');
            $table->renameColumn('longitude', 'long');
        });

        Schema::rename('signees', 'guest_book_users');
    }
};
