<?php

use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('deletes logs older than the specified days', function () {
    ActivityLog::factory()->create(['created_at' => now()->subDays(40)]);
    ActivityLog::factory()->create(['created_at' => now()->subDays(10)]);

    $this->artisan('logs:clean --days=30 --force')
        ->expectsOutput('Deleted 1 log record(s).')
        ->assertSuccessful();

    expect(ActivityLog::count())->toBe(1);
});

it('does nothing when no old logs exist', function () {
    ActivityLog::factory()->create(['created_at' => now()->subDays(5)]);

    $this->artisan('logs:clean --days=30 --force')
        ->expectsOutput('No logs to clean.')
        ->assertSuccessful();
});

it('confirms before deleting when --force is not passed', function () {
    ActivityLog::factory()->create(['created_at' => now()->subDays(40)]);

    $this->artisan('logs:clean --days=30')
        ->expectsConfirmation('Delete 1 log record(s)?', 'no')
        ->assertSuccessful();

    expect(ActivityLog::count())->toBe(1);
});
