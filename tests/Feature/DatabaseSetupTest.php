<?php

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates the projects table with correct columns', function () {
    expect(Schema::hasColumn('projects', 'name'))->toBeTrue();
    expect(Schema::hasColumn('projects', 'user_id'))->toBeTrue();
});

it('cascades delete from project to tasks', function () {
    $project = Project::factory()->has(Task::factory()->count(3))->create();

    $project->delete();

    expect(Task::where('project_id', $project->id)->count())->toBe(0);
});

it('creates tasks with the factory', function () {
    $task = Task::factory()->create();
    expect($task->status)->toBeIn(['draft', 'in_progress', 'done']);
});
