<?php

use App\Constants\DB\EventDBConstants;
use App\Constants\DB\InteresterDBConstants;
use App\Constants\DB\UserDBConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(InteresterDBConstants::TABLE, function (Blueprint $table) {
            $table->uuid(InteresterDBConstants::ID)->primary();
            $table->foreignUuid(InteresterDBConstants::EVENT_ID)->references(EventDBConstants::ID)->on(EventDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(InteresterDBConstants::AUTHOR_ID)->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(InteresterDBConstants::TABLE);
    }
};
