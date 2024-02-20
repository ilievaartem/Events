<?php

use App\Constants\DB\CommentDBConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\MediaDBConstants;
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
        Schema::create(MediaDBConstants::TABLE, function (Blueprint $table) {
            $table->uuid(MediaDBConstants::ID)->primary();
            $table->string(MediaDBConstants::PATH);
            $table->string(MediaDBConstants::TYPE);
            $table->timestamps();
            $table->foreignUuid(MediaDBConstants::EVENT_ID)->references(EventDBConstants::ID)->on(EventDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(MediaDBConstants::AUTHOR_ID)->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(MediaDBConstants::COMMENT_ID)->references(CommentDBConstants::ID)->on(CommentDBConstants::TABLE)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(MediaDBConstants::TABLE);
    }
};
