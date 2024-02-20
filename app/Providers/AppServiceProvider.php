<?php

namespace App\Providers;

use App\Models\Applier;
use App\Models\Category;
use App\Models\City;
use App\Models\Color;
use App\Models\Comment;
use App\Models\Complaint;
use App\Models\Country;
use App\Models\Manufacturer;
use App\Models\Event;
use App\Models\Interester;
use App\Models\Media;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use App\Repositories\ApplierRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CityRepository;
use App\Repositories\ColorRepository;
use App\Repositories\CommentRepository;
use App\Repositories\ComplaintRepository;
use App\Repositories\CountryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\ColorRepositoryInterface;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\ManufacturerRepositoryInterface;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\ManufacturerRepository;
use App\Repositories\EventRepository;
use App\Repositories\InteresterRepository;
use App\Repositories\Interfaces\ApplierRepositoryInterface;
use App\Repositories\Interfaces\CityRepositoryInterface;
use App\Repositories\Interfaces\ComplaintRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Repositories\Interfaces\InteresterRepositoryInterface;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\PhotoRepositoryInterface;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Repositories\MediaRepository;
use App\Repositories\PhotoRepository;
use App\Repositories\QuestionRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(CommentRepositoryInterface::class, function () {
            return new CommentRepository(new Comment());
        });
        $this->app->bind(TagRepositoryInterface::class, function () {
            return new TagRepository(new Tag());
        });
        $this->app->bind(EventRepositoryInterface::class, function () {
            return new EventRepository(new Event());
        });
        $this->app->bind(UserRepositoryInterface::class, function () {
            return new UserRepository(new User());
        });
        $this->app->bind(CategoryRepositoryInterface::class, function () {
            return new CategoryRepository(new Category());
        });
        $this->app->bind(PhotoRepositoryInterface::class, function () {
            return new PhotoRepository();
        });
        $this->app->bind(CityRepositoryInterface::class, function () {
            return new CityRepository(new City());
        });
        $this->app->bind(CountryRepositoryInterface::class, function () {
            return new CountryRepository(new Country());
        });
        $this->app->bind(QuestionRepositoryInterface::class, function () {
            return new QuestionRepository(new Question());
        });
        $this->app->bind(ApplierRepositoryInterface::class, function () {
            return new ApplierRepository(new Applier());
        });
        $this->app->bind(MediaRepositoryInterface::class, function () {
            return new MediaRepository(new Media());
        });
        $this->app->bind(InteresterRepositoryInterface::class, function () {
            return new InteresterRepository(new Interester());
        });
        $this->app->bind(ComplaintRepositoryInterface::class, function () {
            return new ComplaintRepository(new Complaint());
        });
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
