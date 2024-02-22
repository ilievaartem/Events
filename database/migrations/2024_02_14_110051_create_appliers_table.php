<?php

use App\Constants\DB\ApplierDBConstants;
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
        Schema::create(ApplierDBConstants::TABLE, function (Blueprint $table) {
            $table->uuid(ApplierDBConstants::ID)->primary();

            $table->foreignUuid(ApplierDBConstants::EVENT_ID)->references(EventDBConstants::ID)->on(EventDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(ApplierDBConstants::AUTHOR_ID)->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(ApplierDBConstants::TABLE);
    }
};
