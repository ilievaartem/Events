<?php

use App\Http\Controllers\ApplierController;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EventArchiveController;
use App\Http\Controllers\InteresterController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminIsAuthorized;
use App\Http\Middleware\CheckChatMember;
use App\Http\Middleware\CheckCommentAuthor;
use App\Http\Middleware\CheckEventAuthor;
use App\Http\Middleware\CheckEventDoNotAuthor;
use App\Http\Middleware\CheckMessageAuthor;
use App\Http\Middleware\CheckQuestionAuthor;
use App\Http\Middleware\UserIsAuthorized;
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
Route::post('events/{id}/photos/upload', [EventController::class, 'addPhotos'])->middleware([UserIsAuthorized::class]);
Route::patch('events/{id}/photos/delete', [EventController::class, 'deletePhotos'])->middleware([UserIsAuthorized::class, CheckEventAuthor::class]);
Route::patch('events/{id}/photos/deleteMain', [EventController::class, 'deleteMainPhoto'])->middleware([UserIsAuthorized::class, CheckEventAuthor::class]);
Route::post('events', [EventController::class, 'create'])->middleware([UserIsAuthorized::class]);
Route::get('events/filter', [EventController::class, 'filter']);
Route::put('events/{id}', [EventController::class, 'update'])->middleware([UserIsAuthorized::class, CheckEventAuthor::class]);
Route::get('events/{id}/similar', [EventController::class, 'similar']);
Route::delete('events/{id}', [EventController::class, 'delete'])->middleware([UserIsAuthorized::class, CheckEventAuthor::class]);
Route::get('events/maili/search', [EventController::class, 'mailisearch']);
Route::get('users/{id}/events', [EventController::class, 'getEventsByAuthorId']);

Route::get('events/{id}', [EventController::class, 'show']);
//eventArchives
Route::get('eventArchives', [EventArchiveController::class, 'index']);
Route::get('users/{id}/eventArchives', [EventArchiveController::class, 'showUserEventArchives']);
Route::post('events/{id}/eventArchives', [EventArchiveController::class, 'archive'])->middleware([UserIsAuthorized::class, CheckEventAuthor::class]);
Route::delete('eventArchives/{id}/unarchive', [EventArchiveController::class, 'unarchive'])->middleware([UserIsAuthorized::class, CheckEventAuthor::class]);
Route::delete('eventArchives/{id}', [EventArchiveController::class, 'delete'])->middleware([UserIsAuthorized::class]);
Route::get('eventArchives/{id}', [EventArchiveController::class, 'show']);

//places
Route::get('communities/{communityId}/places', [PlaceController::class, 'CommunityPlaces']);
Route::get('places/{id}', [PlaceController::class, 'show']);
Route::delete('places/{id}', [PlaceController::class, 'delete'])->middleware([AdminIsAuthorized::class]);
Route::post('communities/{communityId}/places', [PlaceController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('communities/{communityId}/places/{id}', [PlaceController::class, 'update'])->middleware([AdminIsAuthorized::class]);
//communities
Route::get('regions/{regionsId}/communities', [CommunityController::class, 'RegionCommunities']);
Route::get('communities/{id}', [CommunityController::class, 'show']);
Route::delete('communities/{id}', [CommunityController::class, 'delete'])->middleware([AdminIsAuthorized::class]);
Route::post('regions/{regionsId}/communities', [CommunityController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('regions/{regionsId}/communities/{id}', [CommunityController::class, 'update'])->middleware([AdminIsAuthorized::class]);
//regions
Route::get('countries/{countryId}/regions', [RegionController::class, 'CountryRegions']);
Route::get('regions/{id}', [RegionController::class, 'show']);
Route::delete('regions/{id}', [RegionController::class, 'delete'])->middleware([AdminIsAuthorized::class]);
Route::post('countries/{countryId}/regions', [RegionController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('countries/{countryId}/regions/{id}', [RegionController::class, 'update'])->middleware([AdminIsAuthorized::class]);
//countries
Route::get('countries', [CountryController::class, 'index']);
Route::get('countries/{id}', [CountryController::class, 'show']);
Route::post('countries', [CountryController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::put('countries/{id}', [CountryController::class, 'update'])->middleware([AdminIsAuthorized::class]);
Route::delete('countries/{id}', [CountryController::class, 'delete'])->middleware([AdminIsAuthorized::class]);

//comments
Route::get('comments', [CommentController::class, 'index']);
Route::get('users/{id}/comments', [CommentController::class, 'getCommentsByAuthorId']);
Route::get('comments/{id}', [CommentController::class, 'show']);
Route::post('events/{id}/comments', [CommentController::class, 'create'])->middleware([UserIsAuthorized::class]);
Route::get('events/{id}/comments', [CommentController::class, 'getEventComments']);
Route::put('comments/{id}', [CommentController::class, 'update'])->middleware([UserIsAuthorized::class, CheckCommentAuthor::class]);
Route::delete('comments/{id}', [CommentController::class, 'delete'])->middleware([UserIsAuthorized::class, CheckCommentAuthor::class]);

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
//messages
Route::get('messages', [MessageController::class, 'index']);
// ->middleware([AdminIsAuthorized::class]);
Route::get('messages/{id}', [MessageController::class, 'show']);
// ->middleware([AdminIsAuthorized::class]);
Route::patch('messages/{id}', [MessageController::class, 'update'])->middleware([UserIsAuthorized::class, CheckMessageAuthor::class]);
Route::post('events/{eventId}/messages', [MessageController::class, 'create'])->middleware([UserIsAuthorized::class]);
//chats
Route::get('chats/author', [ChatController::class, 'getAllAuthorChat'])->middleware([UserIsAuthorized::class]);
Route::get('chats/member', [ChatController::class, 'getAllMemberChat'])->middleware([UserIsAuthorized::class]);
Route::get('chats/{id}', [ChatController::class, 'show'])->middleware([UserIsAuthorized::class], [CheckChatMember::class]);
Route::get('chats/{id}/messages', [ChatController::class, 'getChatWithAllMessages'])->middleware([UserIsAuthorized::class, CheckChatMember::class]);
//auth
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

//test
Route::post('test', [TestController::class, 'maxDifferentWithDumbCondition']);

//media

Route::get('comments/{id}/media', [MediaController::class, 'getCommentMedia']);
Route::get('events/{id}/media', [MediaController::class, 'getEventMedia']);
Route::get('media/{id}', [MediaController::class, 'show']);
Route::post('media/comments/{comment_id}', [MediaController::class, 'addPhotos']);
// ->middleware([UserIsAuthorized::class,CheckCommentAuthor::class]);
Route::delete('media/{id}', [MediaController::class, 'delete']);
// ->middleware([AdminIsAuthorized::class,CheckMediaAuthor::class]);
//questions
Route::get('users/{id}/questions', [QuestionController::class, 'getQuestionsByAuthorId']);
Route::get('events/{id}/questions', [QuestionController::class, 'getEventQuestions']);
Route::get('questions/{id}', [QuestionController::class, 'show']);
Route::post('events/{id}/questions/ask', [QuestionController::class, 'createQuestion'])
    ->middleware([UserIsAuthorized::class, CheckEventDoNotAuthor::class]);
Route::post('events/{id}/questions/response', [QuestionController::class, 'responseToQuestion'])
    ->middleware([UserIsAuthorized::class, CheckEventAuthor::class]);
Route::put('questions/{id}', [QuestionController::class, 'update'])->middleware([
    UserIsAuthorized::class
    // , CheckQuestionAuthor::class
]);
Route::delete('questions/{id}', [QuestionController::class, 'delete'])->middleware([
    UserIsAuthorized::class
    // , CheckQuestionAuthor::class
]);
//appliers
Route::get('events/{id}/appliers', [ApplierController::class, 'EventAppliers']);
// ->middleware([AdminIsAuthorized::class]);
Route::get('events/{id}/appliers/count', [ApplierController::class, 'applierCount']);
Route::get('appliers/{id}', [ApplierController::class, 'show'])->middleware([AdminIsAuthorized::class]);
Route::put('events/{id}/appliers', [ApplierController::class, 'changeApplierStatus'])->middleware([UserIsAuthorized::class]);
//interesters
Route::get('events/{id}/interesters', [InteresterController::class, 'EventInteresters']);
// ->middleware([AdminIsAuthorized::class]);
Route::get('events/{id}/interesters/count', [InteresterController::class, 'InteresterCount']);
Route::get('interesters/{id}', [InteresterController::class, 'show'])->middleware([AdminIsAuthorized::class]);
Route::put('events/{id}/interesters', [InteresterController::class, 'changeInteresterStatus'])->middleware([UserIsAuthorized::class]);
//complaints complaints/018dc206-75b3-7162-8a0e-1bb416cda147/unassign
Route::get('complaints', [ComplaintController::class, 'index']);
Route::get('events/{id}/authorComplaints', [ComplaintController::class, 'getAuthorComplaints']);
Route::get('events/{id}/receiverComplaints', [ComplaintController::class, 'getReceiverComplaints']);
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
// ->middleware([AdminIsAuthorized::class]);
Route::post('users/{id}/avatars', [UserController::class, 'addPhoto'])->middleware([AdminIsAuthorized::class]);
Route::delete('users/{id}/avatars', [UserController::class, 'deletePhoto'])->middleware([AdminIsAuthorized::class]);
Route::post('users', [UserController::class, 'create'])->middleware([AdminIsAuthorized::class]);
Route::patch('users/{id}/banned', [UserController::class, 'banned'])->middleware([AdminIsAuthorized::class]);
Route::put('users/{id}', [UserController::class, 'update'])->middleware([AdminIsAuthorized::class]);
Route::delete('users/{id}', [UserController::class, 'delete'])->middleware([AdminIsAuthorized::class]);


