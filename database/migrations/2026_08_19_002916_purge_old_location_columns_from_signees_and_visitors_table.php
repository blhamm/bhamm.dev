<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	protected array $columns = [
		'latitude',
		'longitude',
		'lat',
		'long',
		'city',
		'state',
		'country',
		'place_id'
	];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('signees', function (Blueprint $table) {
			$columns = collect($this->columns)->filter(
				fn($col) => Schema::hasColumn('signees', $col)
			);

            if ($columns->isNotEmpty()) {
                $table->dropColumn($columns->all());
            }
        });

        Schema::table('visitors', function (Blueprint $table) {
            $columns = collect($this->columns)->filter(
				fn($col) => Schema::hasColumn('visitors', $col)
			);

            if ($columns->isNotEmpty()) {
                $table->dropColumn($columns->all());
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signees', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('place_id')->nullable();
        });

        Schema::table('visitors', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
        });
    }
};
