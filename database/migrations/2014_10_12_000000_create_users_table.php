<?php

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
        Schema::create(UserDBConstants::TABLE, function (Blueprint $table) {
            $table->uuid(UserDBConstants::ID)->primary();
            $table->string(UserDBConstants::NAME);
            $table->string(UserDBConstants::EMAIL)->unique();
            $table->string(UserDBConstants::ROLE)->default(UserDBConstants::ROLE_USER);
            $table->string(UserDBConstants::TELEPHONE);
            $table->string(UserDBConstants::AVATAR)->nullable();
            $table->timestamp(UserDBConstants::EMAIL_VERIFIED_AT)->nullable();
            $table->string(UserDBConstants::PASSWORD);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(UserDBConstants::TABLE);
    }
};
