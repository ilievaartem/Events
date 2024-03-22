<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;


test(
    'get_user',
    function (Collection $user, array $userResponse) {
        $hui = Mockery::mock(Builder::class);
        $userModel = Mockery::mock(User::class);

        $hui->shouldReceive('find')->andReturn($hui);
        $userModel->shouldReceive('find')->andReturn($user);
        $userModel->shouldReceive('query')->andReturn($hui);

        $hui->shouldReceive('exists')->andReturn(true);
        $this->app->instance(UserRepositoryInterface::class, new UserRepository($userModel));

        $response = $this->get('api/users/018e5717-6678-7330-b055-0b961ba00f17')->json();
        expect($response)->toBe($userResponse);
        // $response->assertStatus(200);
    }
)->with('get_user');

