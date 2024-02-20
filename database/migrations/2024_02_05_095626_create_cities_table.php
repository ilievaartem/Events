<?php

use App\Constants\DB\CityDBConstants;
use App\Constants\DB\CountryDBConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(CityDBConstants::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(CityDBConstants::NAME);
            $table->unsignedBigInteger(CityDBConstants::COUNTRY_ID);
            $table->foreign(CityDBConstants::COUNTRY_ID)->references(CountryDBConstants::ID)
                ->on(CountryDBConstants::TABLE)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(CityDBConstants::TABLE);
    }
};
