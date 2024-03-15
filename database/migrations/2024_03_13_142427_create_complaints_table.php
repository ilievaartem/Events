<?php

use App\Constants\DB\CommentDBConstants;
use App\Constants\DB\ComplaintDBConstants;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\MessageDBConstants;
use App\Constants\DB\QuestionDBConstants;
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
        Schema::create(ComplaintDBConstants::TABLE, function (Blueprint $table) {
            $table->uuid(ComplaintDBConstants::ID)->primary();
            $table->foreignUuid(ComplaintDBConstants::AUTHOR_ID)->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(ComplaintDBConstants::USER_ID)->nullable()->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(ComplaintDBConstants::EVENT_ID)->nullable()->references(EventDBConstants::ID)->on(EventDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(ComplaintDBConstants::COMMENT_ID)->nullable()->references(CommentDBConstants::ID)->on(CommentDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(ComplaintDBConstants::QUESTION_ID)->nullable()->references(QuestionDBConstants::ID)->on(QuestionDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(ComplaintDBConstants::MESSAGE_ID)->nullable()->references(MessageDBConstants::ID)->on(MessageDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(ComplaintDBConstants::RESOLVER_ID)->nullable()->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(ComplaintDBConstants::ASSIGNEE)->nullable()->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->boolean(ComplaintDBConstants::OTHER)->default(false);
            $table->string(ComplaintDBConstants::CAUSE_MESSAGE);
            $table->string(ComplaintDBConstants::CAUSE_DESCRIPTION);
            $table->string(ComplaintDBConstants::RESOLVE_MESSAGE)->nullable();
            $table->string(ComplaintDBConstants::RESOLVE_DESCRIPTION)->nullable();
            $table->dateTime(ComplaintDBConstants::READ_AT)->nullable();
            $table->dateTime(ComplaintDBConstants::RESOLVED_AT)->nullable();
            $table->dateTime(ComplaintDBConstants::DELETED_AT)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ComplaintDBConstants::TABLE);
    }
};
