<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApproverTest extends TestCase
{
    use RefreshDatabase;

    public function test_approver_can_be_created()
    {
        $response = $this->postJson('/api/approvers', ['name' => 'Ana']);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Approver added successfully']);

        $this->assertDatabaseHas('approvers', ['name' => 'Ana']);
    }

    public function test_validation_fails_with_duplicate_name()
    {
        $this->postJson('/api/approvers', ['name' => 'Ana']);
        $response = $this->postJson('/api/approvers', ['name' => 'Ana']);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    public function test_validation_fails_with_empty_name()
    {
        $response = $this->postJson('/api/approvers', ['name' => '']);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
}

