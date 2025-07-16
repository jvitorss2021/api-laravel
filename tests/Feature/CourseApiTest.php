<?php

namespace Tests\Feature; 

use App\Models\Course;
use App\Models\User; 
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

uses(
    RefreshDatabase::class,
    WithFaker::class
);

test('can get all courses', function () {
    $user = User::factory()->create(); 
    Course::factory()->count(5)->create();


    $this->actingAs($user)
         ->getJson('/api/courses')
         ->assertStatus(200)
         ->assertJsonCount(5);
});

test('an authenticated user can create a course', function () {
    $user = User::factory()->create();
    
    $courseData = [
        'name' => $this->faker->word,
        'description' => $this->faker->sentence,
        'duration' => $this->faker->numberBetween(1, 100),
        'price' => $this->faker->randomFloat(2, 10, 1000),
    ];

    $this->actingAs($user)
         ->postJson('/api/courses', $courseData)
         ->assertStatus(201);

    $this->assertDatabaseHas('courses', ['name' => $courseData['name']]);
});

test('can show a course', function () {
    $user = User::factory()->create();
    $course = Course::factory()->create();

    $this->actingAs($user)
         ->getJson("/api/courses/{$course->id}")
         ->assertStatus(200)
         ->assertJsonFragment(['id' => $course->id]);
});

test('an authenticated user can update a course', function () { 
    $user = User::factory()->create();
    $course = Course::factory()->create(['user_id' => $user->id]);

    $updateData = ['name' => 'Updated Course Name'];

    $this->actingAs($user) 
         ->putJson("/api/courses/{$course->id}", $updateData)
         ->assertStatus(200)
         ->assertJsonFragment($updateData);

    $this->assertDatabaseHas('courses', $updateData);
});

test('an authenticated user can delete a course', function () { 
    $user = User::factory()->create();
    $course = Course::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user) 
         ->deleteJson("/api/courses/{$course->id}")
         ->assertStatus(204);
    
    $this->assertDatabaseMissing('courses', ['id' => $course->id]);
});

test('it returns a validation error if name is not provided', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->postJson('/api/courses', ['name' => ''])
         ->assertStatus(422)
         ->assertJsonValidationErrors(['name']);
});

