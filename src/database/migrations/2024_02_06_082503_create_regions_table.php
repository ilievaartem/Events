<?php

use App\Constants\DB\CountryDBConstants;
use App\Constants\DB\RegionDBConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(RegionDBConstants::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(RegionDBConstants::NAME);
            $table->unsignedBigInteger(RegionDBConstants::COUNTRY_ID);

            $table->foreign(RegionDBConstants::COUNTRY_ID)->references(CountryDBConstants::ID)->on(CountryDBConstants::TABLE)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(RegionDBConstants::TABLE);
    }
};
