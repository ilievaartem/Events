<?php

use App\Constants\DB\EventDBConstants;
use App\Constants\Request\EventRequestConstants;
use App\Http\Controllers\ApplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\InteresterController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminIsAuthorized;
use App\Http\Middleware\CheckAuthor;
use App\Http\Middleware\UserIsAuthorized;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Scout;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('events', [EventController::class, 'index']);
Route::get('events/search', [EventController::class, 'searchEvent']);
Route::post('events/{id}/photos/upload', [EventController::class, 'addPhotos']);
Route::post('events', [EventController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::get('events/filter', [EventController::class, 'filter']);
Route::put('events/{id}', [EventController::class, 'update'])->middleware([AdminIsAuthorized::class]);
Route::delete('events/{id}', [EventController::class, 'delete'])->middleware([AdminIsAuthorized::class]);
Route::get('events/maili/search', [EventController::class, 'mailisearch']);
Route::get('events/{id}', [EventController::class, 'show']);

//cities
Route::get('cities', [CityController::class, 'index']);
Route::get('cities/{id}', [CityController::class, 'show']);
Route::post('cities', [CityController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('cities/{id}', [CityController::class, 'update'])->middleware([AdminIsAuthorized::class]);
Route::delete('cities/{id}', [CityController::class, 'delete'])->middleware([AdminIsAuthorized::class]);
//countries
Route::get('countries', [CountryController::class, 'index']);
Route::get('countries/{id}', [CountryController::class, 'show']);
Route::post('countries', [CountryController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('countries/{id}', [CountryController::class, 'update'])->middleware([AdminIsAuthorized::class]);
Route::delete('countries/{id}', [CountryController::class, 'delete'])->middleware([AdminIsAuthorized::class]);

//comments
Route::get('comments', [CommentController::class, 'index']);
Route::get('comments/{id}', [CommentController::class, 'show']);
Route::post('comments', [CommentController::class, 'create'])->middleware([UserIsAuthorized::class]);
Route::put('comments/{id}', [CommentController::class, 'update'])->middleware([UserIsAuthorized::class, CheckAuthor::class]);
Route::delete('comments/{id}', [CommentController::class, 'delete'])->middleware([UserIsAuthorized::class, CheckAuthor::class]);

//category
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);
Route::post('categories', [CategoryController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('categories/{id}', [CategoryController::class, 'update'])->middleware([AdminIsAuthorized::class]);
Route::delete('categories/{id}', [CategoryController::class, 'delete'])->middleware([AdminIsAuthorized::class]);
//tag
Route::get('tags', [TagController::class, 'index']);
Route::get('tags/{id}', [TagController::class, 'show']);
Route::post('tags', [TagController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('tags/{id}', [TagController::class, 'update'])->middleware([AdminIsAuthorized::class]);
Route::delete('tags/{id}', [TagController::class, 'delete'])->middleware([AdminIsAuthorized::class]);

//auth
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

//test
Route::post('test', [TestController::class, 'maxDifferentWithDumbCondition']);

//media

Route::get('media', [MediaController::class, 'index']);
Route::get('media/{id}', [MediaController::class, 'show']);
Route::post('media/comments/{comment_id}', [MediaController::class, 'create']);
// ->middleware([AdminIsAuthorized::class]);
Route::post('media/{id}', [MediaController::class, 'update']);
// ->middleware([AdminIsAuthorized::class]);
Route::delete('media/{id}', [MediaController::class, 'delete']);
// ->middleware([AdminIsAuthorized::class]);
//questions
Route::get('questions', [QuestionController::class, 'index']);
Route::get('questions/{id}', [QuestionController::class, 'show']);
Route::post('questions', [QuestionController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('questions/{id}', [QuestionController::class, 'update'])->middleware([AdminIsAuthorized::class]);
Route::delete('questions/{id}', [QuestionController::class, 'delete'])->middleware([AdminIsAuthorized::class]);
//appliers
Route::get('appliers', [ApplierController::class, 'index']);
Route::get('appliers/{id}', [ApplierController::class, 'show']);
Route::post('appliers', [ApplierController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('appliers/{id}', [ApplierController::class, 'update'])->middleware([AdminIsAuthorized::class]);
Route::delete('appliers/{id}', [ApplierController::class, 'delete'])->middleware([AdminIsAuthorized::class]);
//interesters
Route::get('interesters', [InteresterController::class, 'index']);
Route::get('interesters/{id}', [InteresterController::class, 'show']);
Route::post('interesters', [InteresterController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('interesters/{id}', [InteresterController::class, 'update'])->middleware([AdminIsAuthorized::class]);
Route::delete('interesters/{id}', [InteresterController::class, 'delete'])->middleware([AdminIsAuthorized::class]);
//complaints complaints/018dc206-75b3-7162-8a0e-1bb416cda147/unassign
Route::get('complaints', [ComplaintController::class, 'index']);
Route::get('complaints/filter', [ComplaintController::class, 'filter']);
Route::get('complaints/{id}', [ComplaintController::class, 'show']);
Route::post('events/{id}/complaints', [ComplaintController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('complaints/{id}', [ComplaintController::class, 'update'])->middleware([AdminIsAuthorized::class]);
Route::patch('complaints/{id}/read', [ComplaintController::class, 'read'])->middleware([AdminIsAuthorized::class]);
Route::patch('complaints/{id}/toAssign', [ComplaintController::class, 'toAssign'])->middleware([AdminIsAuthorized::class]);
Route::patch('complaints/{id}/unassign', [ComplaintController::class, 'unassign'])->middleware([AdminIsAuthorized::class]);
Route::delete('complaints/{id}', [ComplaintController::class, 'delete'])->middleware([AdminIsAuthorized::class]);

//user
Route::get('users', [UserController::class, 'index']);
// ->middleware([AdminIsAuthorized::class]);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('users/{id}/avatars/upload', [UserController::class, 'addPhoto']);
Route::get('users/{id}/events', [UserController::class, 'userEvents']);
// ->middleware([AdminIsAuthorized::class]);
Route::post('users', [UserController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('users/{id}', [UserController::class, 'update']);
// ->middleware([AdminIsAuthorized::class]);
Route::delete('users/{id}', [UserController::class, 'delete'])->middleware([AdminIsAuthorized::class]);


