<?php

use App\Http\Controllers\Web\CategoryViewController;
use App\Http\Controllers\Web\CommentsViewController;
use App\Http\Controllers\Web\ComplaintsViewController;
use App\Http\Controllers\Web\DashboardViewController;
use App\Http\Controllers\Web\MessagesViewContainer;
use App\Http\Controllers\Web\QuestionsViewController;
use App\Http\Controllers\Web\RegionsViewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\EventsViewController;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\UsersViewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|action="{{ route('users.update', $content['id']) }}" method="post" target="_parent"
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be aendpointsssigned to the "web" middleware group. Make something great!
|
*/
Route::group(['middleware' => 'web'], function () {

    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    //dashboard
    Route::get('dashboard', [DashboardViewController::class, 'index'])->name('dashboard.index');
    //events
    Route::get('events', [EventsViewController::class, 'filterEvents'])->name('events.index');
    Route::get('events/create', [EventsViewController::class, 'showCreate'])->name('events.show.create');
    Route::post('events/create', [EventsViewController::class, 'create'])->name('events.create');
    Route::get('events/{id}', [EventsViewController::class, 'viewEvent'])->name('events.show');
    Route::get('events/{id}/edit', [EventsViewController::class, 'show'])->name('events.show.edit');
    Route::get('events/{id}/comments', [EventsViewController::class, 'showComments'])->name('events.show.comments');
    Route::get('events/{id}/questions', [EventsViewController::class, 'showQuestions'])->name('events.show.questions');
    Route::post('events/{id}', [EventsViewController::class, 'update'])->name('events.update');
    Route::delete('events/{id}', [EventsViewController::class, 'delete'])->name('events.delete');
    //main
    Route::get('main', [IndexController::class, 'main'])->name('main');
    //users
    Route::get('users', [UsersViewController::class, 'index'])->name('users.index');
    Route::get('users/create', [UsersViewController::class, 'showCreate'])->name('users.show.create');
    Route::post('users/create', [UsersViewController::class, 'create'])->name('users.create');
    Route::get('users/{id}', [UsersViewController::class, 'viewUser'])->name('users.show');
    Route::get('users/{id}/edit', [UsersViewController::class, 'show'])->name('users.show.edit');
    Route::post('users/{id}', [UsersViewController::class, 'update'])->name('users.update');
    Route::delete('users/{id}', [UsersViewController::class, 'delete'])->name('users.delete');
    Route::get('test', [UsersViewController::class, 'test'])->name('registration');
    //regions
    Route::get('regions', [RegionsViewController::class, 'index'])->name('regions.index');
    Route::get('regions/create', [RegionsViewController::class, 'showCreate'])->name('regions.show.create');
    Route::post('regions/create', [RegionsViewController::class, 'create'])->name('regions.create');
    Route::get('regions/{id}', [RegionsViewController::class, 'viewRegion'])->name('regions.show');
    Route::get('regions/{id}/edit', [RegionsViewController::class, 'show'])->name('regions.show.edit');
    Route::post('regions/{id}', [RegionsViewController::class, 'update'])->name('regions.update');
    Route::delete('regions/{id}', [RegionsViewController::class, 'delete'])->name('regions.delete');
    //categories
    Route::get('categories', [CategoryViewController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryViewController::class, 'showCreate'])->name('categories.show.create');
    Route::post('categories/create', [CategoryViewController::class, 'create'])->name('categories.create');
    Route::get('categories/{id}', [CategoryViewController::class, 'viewCategory'])->name('categories.show');
    Route::get('categories/{id}/edit', [CategoryViewController::class, 'show'])->name('categories.show.edit');
    Route::post('categories/{id}', [CategoryViewController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [CategoryViewController::class, 'delete'])->name('categories.delete');
    //complaints
    Route::get('complaints', [ComplaintsViewController::class, 'index'])->name('complaints.index');
    Route::get('complaints/{id}', [ComplaintsViewController::class, 'resolveView'])->name('complaints.resolve.edit');
    Route::post('complaints/{id}', [ComplaintsViewController::class, 'resolve'])->name('complaints.resolve');
    Route::put('complaints/{id}', [ComplaintsViewController::class, 'read'])->name('complaints.read');
    //comments
    Route::get('comments', [CommentsViewController::class, 'index'])->name('comments.index');
    //questions
    Route::get('questions', [QuestionsViewController::class, 'index'])->name('questions.index');
    //messages
    Route::get('messages', [MessagesViewContainer::class, 'index'])->name('messages.index');

//    Auth::routes();

//    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
