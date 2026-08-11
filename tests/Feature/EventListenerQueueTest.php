<?php

use App\Events\UserRegistered;
use App\Listeners\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Events\CallQueuedListener;

uses(RefreshDatabase::class);

it('fires UserRegistered event on registration', function () {
    Event::fake([UserRegistered::class]);

    $this->postJson('/api/register', [
        'name'                  => 'Alice',
        'email'                 => 'alice@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ])->assertCreated();

    Event::assertDispatched(UserRegistered::class);
});

it('queues SendWelcomeEmail when UserRegistered fires', function () {
    Queue::fake();

    $user = User::factory()->create();
    event(new UserRegistered($user));

    Queue::assertPushed(CallQueuedListener::class, function ($job) {
        return $job->class === SendWelcomeEmail::class;
    });
});

//it('dispatches the event when a user registers', function () {
//    Event::fake();
//
//    User::factory()->create();
//
//    Event::assertDispatched(UserRegistered::class);
//});
