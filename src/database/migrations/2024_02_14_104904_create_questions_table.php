<?php

use App\Constants\DB\EventDBConstants;
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
        Schema::create(QuestionDBConstants::TABLE, function (Blueprint $table) {
            $table->uuid(QuestionDBConstants::ID);
            $table->primary(QuestionDBConstants::ID);

            $table->text(QuestionDBConstants::CONTENT);
            $table->foreignUuid(QuestionDBConstants::EVENT_ID)->references(EventDBConstants::ID)->on(EventDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(QuestionDBConstants::AUTHOR_ID)->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(QuestionDBConstants::PARENT_ID)->nullable()->references(QuestionDBConstants::ID)
                ->on(QuestionDBConstants::TABLE)->onDelete('set null');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(QuestionDBConstants::TABLE);
    }
};
