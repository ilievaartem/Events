<?php

use App\Constants\DB\CityDBConstants;
use App\Constants\DB\CountryDBConstants;
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
        Schema::create(EventDBConstants::TABLE, function (Blueprint $table) {
            $table->uuid(EventDBConstants::ID)->primary();
            $table->string(EventDBConstants::TITLE);
            $table->string(EventDBConstants::SLUG)->unique();
            $table->double(EventDBConstants::LONGITUDE);
            $table->double(EventDBConstants::LATITUDE);
            $table->jsonb(EventDBConstants::ADDITIONAL_AUTHOR)->nullable();
            $table->text(EventDBConstants::DESCRIPTION);
            $table->string(EventDBConstants::SHORT_DESCRIPTION);
            $table->string(EventDBConstants::MAIN_PHOTO)->nullable();
            $table->jsonb(EventDBConstants::PHOTOS)->nullable();
            $table->string(EventDBConstants::STREET_NAME);
            $table->string(EventDBConstants::BUILDING)->nullable();
            $table->string(EventDBConstants::PLACE_NAME)->nullable();
            $table->unsignedInteger(EventDBConstants::CORPUS)->nullable();
            $table->unsignedInteger(EventDBConstants::APARTMENT)->nullable();
            $table->string(EventDBConstants::PLACE_DESCRIPTION);
            $table->date(EventDBConstants::START_DATE);
            $table->time(EventDBConstants::START_TIME);
            $table->date(EventDBConstants::FINISH_DATE);
            $table->time(EventDBConstants::FINISH_TIME);
            $table->unsignedTinyInteger(EventDBConstants::AGE_FROM);
            $table->unsignedTinyInteger(EventDBConstants::AGE_TO);
            $table->jsonb(EventDBConstants::APPLIERS)->nullable();
            $table->jsonb(EventDBConstants::INTERESTARS)->nullable();
            $table->float(EventDBConstants::RATING)->nullable();
            $table->boolean(EventDBConstants::IS_ONLINE)->nullable();
            $table->boolean(EventDBConstants::IS_OFFLINE)->nullable();
            $table->foreignUuid(EventDBConstants::AUTHOR_ID)->references(UserDBConstants::ID)->on(UserDBConstants::TABLE)->onDelete('cascade');
            $table->foreignUuid(EventDBConstants::PARENT_ID)->nullable()->references(EventDBConstants::ID)->on(EventDBConstants::TABLE)->onDelete('cascade');
            $table->foreignId(EventDBConstants::CITY_ID)->references(CityDBConstants::ID)->on(CityDBConstants::TABLE)->onDelete('cascade');
            $table->foreignId(EventDBConstants::COUNTRY_ID)->references(CountryDBConstants::ID)->on(CountryDBConstants::TABLE)->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(EventDBConstants::TABLE);
    }
};
