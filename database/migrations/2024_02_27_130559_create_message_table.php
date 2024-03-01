<?php

use App\Constants\DB\ChatDBConstants;
use App\Constants\DB\MessageDBConstants;
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
        Schema::create(MessageDBConstants::TABLE, function (Blueprint $table) {
            $table->uuid(MessageDBConstants::ID)->primary();
            $table->text(MessageDBConstants::TEXT);
            $table->foreignUuid(MessageDBConstants::AUTHOR_ID)->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(MessageDBConstants::CHAT_ID)->references(ChatDBConstants::ID)->on(ChatDBConstants::TABLE)->onDelete('cascade');

            $table->timestamp(MessageDBConstants::CREATED_AT)->useCurrent()->timezone('UTC');
            $table->timestamp(MessageDBConstants::UPDATED_AT)->useCurrent()->timezone('UTC');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(MessageDBConstants::TABLE);
    }
};
