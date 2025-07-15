<?php

namespace Tests\Feature;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

uses( RefreshDatabase::class,
    WithFaker::class
);

test('can get all courses', function () {
    Course::factory()->count(5)->create();

    $response = $this->getJson('/api/courses');

    $response->assertStatus(200)
             ->assertJsonCount(5);
});

test('can create a course', function () {
    $courseData = [
        'name' => $this->faker->word,
        'description' => $this->faker->sentence,
        'duration' => $this->faker->numberBetween(1, 100),
        'price' => $this->faker->randomFloat(2, 10, 1000),
    ];

    $response = $this->postJson('/api/courses', $courseData);

    $response->assertStatus(201)
             ->assertJsonFragment($courseData);
});

test('can show a course', function () {
    $course = Course::factory()->create();

    $response = $this->getJson("/api/courses/{$course->id}");

    $response->assertStatus(200)
             ->assertJsonFragment($course->toArray());
});

test('can update a course', function () {
    $course = Course::factory()->create();
    $updatedData = [
        'name' => 'Updated Course Name',
        'description' => 'Updated Description',
        'duration' => 50,
        'price' => 200.00,
    ];

    $response = $this->putJson("/api/courses/{$course->id}", $updatedData);

    $response->assertStatus(200)
             ->assertJsonFragment($updatedData);
});

test('can delete a course', function () {
    $course = Course::factory()->create();

    $response = $this->deleteJson("/api/courses/{$course->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('courses', ['id' => $course->id]);
});

test('course name is required', function () {
    $response = $this->postJson('/api/courses', [
        'description' => 'Test Description',
        'duration' => 30,
        'price' => 100.00,
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['name']);
});

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
