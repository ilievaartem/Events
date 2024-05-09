<?php

use App\Constants\DB\CommunityDBConstants;
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
        Schema::create(CommunityDBConstants::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(CommunityDBConstants::NAME);
            $table->unsignedBigInteger(CommunityDBConstants::REGION_ID);
            $table->foreign(CommunityDBConstants::REGION_ID)->references(RegionDBConstants::ID)->on(RegionDBConstants::TABLE)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(CommunityDBConstants::TABLE);
    }
};
