<?php

use App\Constants\DB\ChatDBConstants;
use App\Constants\DB\EventDBConstants;
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
        Schema::create(ChatDBConstants::TABLE, function (Blueprint $table) {
            $table->uuid(ChatDBConstants::ID)->primary();
            $table->string(ChatDBConstants::TOPIC);
            $table->foreignUuid(ChatDBConstants::AUTHOR_ID)->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(ChatDBConstants::EVENT_ID)->references(EventDBConstants::ID)->on(EventDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(ChatDBConstants::MEMBER_ID)->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->string(ChatDBConstants::LAST_MESSAGE_TEXT);
            $table->foreignUuid(ChatDBConstants::LAST_MESSAGE_AUTHOR_ID)->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ChatDBConstants::TABLE);
    }
};
