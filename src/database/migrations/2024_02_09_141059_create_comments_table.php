<?php

use App\Constants\DB\CommentDBConstants;
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
        Schema::create(CommentDBConstants::TABLE, function (Blueprint $table) {
            $table->uuid(CommentDBConstants::ID);
            $table->primary(CommentDBConstants::ID);

            $table->text(CommentDBConstants::CONTENT);
            $table->unsignedTinyInteger(CommentDBConstants::RATING)->nullable();
            $table->foreignUuid(CommentDBConstants::EVENT_ID)->references(EventDBConstants::ID)->on(EventDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(CommentDBConstants::AUTHOR_ID)->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(CommentDBConstants::PARENT_ID)->nullable()->references(CommentDBConstants::ID)
                ->on(CommentDBConstants::TABLE)->onDelete('set null');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(CommentDBConstants::TABLE);
    }
};
