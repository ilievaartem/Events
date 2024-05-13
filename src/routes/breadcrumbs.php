<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use App\Models\Region;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Home > Events
Breadcrumbs::for('events', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Events', route('events.index'));
});

// Home > Events > Create
Breadcrumbs::for('events-create', function (BreadcrumbTrail $trail) {
    $trail->parent('events');
    $trail->push('Create', route('events.show.create'));
});

// Home > Events > [Event-Id]
Breadcrumbs::for('event-id', function (BreadcrumbTrail $trail) {
    $eventId = request()->route('id');
    $event = Event::query()->select(['title'])->find($eventId);
    $trail->parent('events');
    $trail->push($event->title, route('events.show', $eventId));
});

// Home > Events > [Event-Id] > Comments-Event-Id
Breadcrumbs::for('comments-event-id', function (BreadcrumbTrail $trail) {
    $commentEventId = request()->route('id');
    $trail->parent('event-id');
    $trail->push('Comments', route('events.show.comments', $commentEventId));
});

// Home > Events > [Event-Id] > Questions-Event-Id
Breadcrumbs::for('questions-event-id', function (BreadcrumbTrail $trail) {
    $questionEventId = request()->route('id');
    $trail->parent('event-id');
    $trail->push('Questions', route('events.show.questions', $questionEventId));
});

// Home > Users
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Users', route('users.index'));
});

// Home > Users > Create
Breadcrumbs::for('users-create', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Create', route('users.show.create'));
});

// Home > Users > [User-Id]
Breadcrumbs::for('user-id', function (BreadcrumbTrail $trail) {
    $userId = request()->route('id');
    $user = User::query()->select(['name'])->find($userId);
    $trail->parent('users');
    $trail->push($user->name, route('users.show', $userId));
});

// Home > Categories
Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Categories', route('categories.index'));
});

// Home > Categories > Create
Breadcrumbs::for('categories-create', function (BreadcrumbTrail $trail) {
    $trail->parent('categories');
    $trail->push('Create', route('categories.show.create'));
});

// Home > Categories > [Category-Id]
Breadcrumbs::for('category-id', function (BreadcrumbTrail $trail) {
    $categoryId = request()->route('id');
    $category = Category::query()->select(['name'])->find($categoryId);
    $trail->parent('categories');
    $trail->push($category->name, route('categories.show', $categoryId));
});

// Home > Regions
Breadcrumbs::for('regions', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Regions', route('regions.index'));
});

// Home > Regions > Create
Breadcrumbs::for('regions-create', function (BreadcrumbTrail $trail) {
    $trail->parent('regions');
    $trail->push('Create', route('regions.show.create'));
});

// Home > Regions > [Region-Id]
Breadcrumbs::for('region-id', function (BreadcrumbTrail $trail) {
    $regionId = request()->route('id');
    $region = Region::query()->select(['name'])->find($regionId);
    $trail->parent('regions');
    $trail->push($region->name, route('regions.show', $regionId));
});

// Home > Complaints
Breadcrumbs::for('complaints', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Complaints', route('complaints.index'));
});

// Home > Comments
Breadcrumbs::for('comments', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Comments', route('comments.index'));
});

// Home > Questions
Breadcrumbs::for('questions', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Questions', route('questions.index'));
});

// Home > Messages
Breadcrumbs::for('messages', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Messages', route('messages.index'));
});
