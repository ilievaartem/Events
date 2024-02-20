<?php

use App\Constants\DB\TagDBConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(TagDBConstants::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(TagDBConstants::NAME);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TagDBConstants::TABLE);
    }
};
