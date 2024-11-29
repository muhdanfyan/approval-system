<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Approver;

class ApproverTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_approver()
    {
        $response = $this->postJson('/api/approvers', ['name' => 'Ana']);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Approver added successfully']);

        $this->assertDatabaseHas('approvers', ['name' => 'Ana']);
    }

    public function test_cannot_create_duplicate_approver()
    {
        Approver::create(['name' => 'Ana']);

        $response = $this->postJson('/api/approvers', ['name' => 'Ana']);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }
    public function test_validation_error_when_name_is_missing()
    {
        $response = $this->postJson('/api/approvers', []);

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'message',
                     'errors' => [
                         'name',
                     ],
                 ]);
    }

    public function test_validation_error_when_name_is_not_unique()
    {
        \App\Models\Approver::create(['name' => 'Ana']);

        $response = $this->postJson('/api/approvers', ['name' => 'Ana']);

        $response->assertStatus(422)
                 ->assertJsonFragment([
                     'name' => ['The name has already been taken.']
                 ]);
    }
}
