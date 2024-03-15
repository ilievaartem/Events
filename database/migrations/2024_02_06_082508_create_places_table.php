<?php

use App\Constants\DB\CommunityDBConstants;
use App\Constants\DB\PlaceDBConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(PlaceDBConstants::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(PlaceDBConstants::NAME);
            $table->string(PlaceDBConstants::TYPE);
            $table->unsignedBigInteger(PlaceDBConstants::COMMUNITY_ID);
            $table->foreign(PlaceDBConstants::COMMUNITY_ID)->references(CommunityDBConstants::ID)->on(CommunityDBConstants::TABLE)->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(PlaceDBConstants::TABLE);
    }
};
