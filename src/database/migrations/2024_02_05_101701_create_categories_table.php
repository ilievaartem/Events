<?php

use App\Constants\DB\CategoryDBConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(CategoryDBConstants::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(CategoryDBConstants::PARENT_ID)->nullable();
            $table->foreign(CategoryDBConstants::PARENT_ID)->references(CategoryDBConstants::ID)
                ->on(CategoryDBConstants::TABLE)->onDelete('cascade');
            $table->string(CategoryDBConstants::NAME);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(CategoryDBConstants::TABLE);
    }
};
