<?php

use App\Constants\DB\ArchiveTables\EventArchiveDBConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(EventArchiveDBConstants::TABLE, function (Blueprint $table) {
            $table->uuid(EventArchiveDBConstants::ID)->primary();
            $table->string(EventArchiveDBConstants::TITLE);
            $table->string(EventArchiveDBConstants::SLUG)->unique();
            $table->double(EventArchiveDBConstants::LONGITUDE);
            $table->double(EventArchiveDBConstants::LATITUDE);
            $table->jsonb(EventArchiveDBConstants::ADDITIONAL_AUTHOR)->nullable();
            $table->text(EventArchiveDBConstants::DESCRIPTION);
            $table->string(EventArchiveDBConstants::SHORT_DESCRIPTION);
            $table->string(EventArchiveDBConstants::MAIN_PHOTO)->nullable();
            $table->jsonb(EventArchiveDBConstants::PHOTOS)->nullable();
            $table->string(EventArchiveDBConstants::STREET_NAME);
            $table->string(EventArchiveDBConstants::BUILDING)->nullable();
            $table->string(EventArchiveDBConstants::PLACE_NAME)->nullable();
            $table->unsignedInteger(EventArchiveDBConstants::CORPUS)->nullable();
            $table->unsignedInteger(EventArchiveDBConstants::APARTMENT)->nullable();
            $table->string(EventArchiveDBConstants::PLACE_DESCRIPTION);
            $table->date(EventArchiveDBConstants::START_DATE);
            $table->time(EventArchiveDBConstants::START_TIME);
            $table->date(EventArchiveDBConstants::FINISH_DATE);
            $table->time(EventArchiveDBConstants::FINISH_TIME);
            $table->unsignedTinyInteger(EventArchiveDBConstants::AGE_FROM);
            $table->unsignedTinyInteger(EventArchiveDBConstants::AGE_TO);
            $table->jsonb(EventArchiveDBConstants::CATEGORIES_IDS)->nullable();
            $table->jsonb(EventArchiveDBConstants::TAGS_IDS)->nullable();
            $table->jsonb(EventArchiveDBConstants::APPLIERS)->nullable();
            $table->jsonb(EventArchiveDBConstants::INTERESTARS)->nullable();
            $table->float(EventArchiveDBConstants::RATING)->nullable();
            $table->boolean(EventArchiveDBConstants::IS_ONLINE)->nullable();
            $table->boolean(EventArchiveDBConstants::IS_OFFLINE)->nullable();
            $table->string(EventArchiveDBConstants::AUTHOR_ID)->nullable();
            $table->string(EventArchiveDBConstants::PARENT_ID)->nullable();
            $table->integer(EventArchiveDBConstants::CITY_ID);
            $table->integer(EventArchiveDBConstants::COUNTRY_ID);

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(EventArchiveDBConstants::TABLE);
    }
};
