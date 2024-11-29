<?php
namespace Tests\Feature;

use App\Models\ApprovalStage;
use App\Models\Approver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ApprovalStageTest extends TestCase
{
    use RefreshDatabase; // Untuk reset database sebelum dan setelah setiap test

    /**
     * Test untuk menambahkan Approval Stage baru.
     */
    public function test_store_approval_stage()
    {
        // Membuat approver terlebih dahulu
        $approver = Approver::create(['name' => 'Ana']);

        // Data yang dikirimkan dalam request
        $data = [
            'approver_id' => $approver->id,
            'stage_order' => 1
        ];

        // Mengirim POST request ke endpoint /approval-stages
        $response = $this->postJson('/api/approval-stages', $data);

        // Assert status response
        $response->assertStatus(Response::HTTP_OK);

        // Assert bahwa pesan berhasil ditambahkan
        $response->assertJson([
            'message' => 'Approval stage added successfully'
        ]);

        // Assert bahwa data approval stage ada di database
        $this->assertDatabaseHas('approval_stages', [
            'approver_id' => $approver->id,
            'stage_order' => 1
        ]);
    }

    /**
     * Test untuk mengubah Approval Stage yang ada.
     */
    public function test_update_approval_stage()
    {
        // Membuat approver dan approval stage terlebih dahulu
        $approver1 = Approver::create(['name' => 'Ana']);
        $approvalStage = ApprovalStage::create([
            'approver_id' => $approver1->id,
            'stage_order' => 1
        ]);

        // Membuat approver baru untuk update
        $approver2 = Approver::create(['name' => 'Ani']);

        // Data yang dikirimkan dalam request untuk update
        $data = [
            'approver_id' => $approver2->id,
            'stage_order' => 2
        ];

        // Mengirim PUT request untuk update approval stage
        $response = $this->putJson("/api/approval-stages/{$approvalStage->id}", $data);

        // Assert status response
        $response->assertStatus(Response::HTTP_OK);

        // Assert bahwa pesan berhasil diperbarui
        $response->assertJson([
            'message' => 'Approval stage updated successfully'
        ]);

        // Assert bahwa data approval stage yang diupdate ada di database
        $this->assertDatabaseHas('approval_stages', [
            'approver_id' => $approver2->id,
            'stage_order' => 2
        ]);
    }

    /**
     * Test untuk validasi ketika approver_id tidak ada.
     */
    public function test_store_approval_stage_validation_error()
    {
        // Mengirim POST request dengan data yang invalid (approver_id tidak ada)
        $response = $this->postJson('/api/approval-stages', [
            'approver_id' => 999, // approver_id yang tidak ada
            'stage_order' => 1
        ]);

        // Assert bahwa status response adalah 422 (Validation error)
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // Assert bahwa ada pesan error validasi
        $response->assertJsonValidationErrors(['approver_id']);
    }

    /**
     * Test untuk validasi ketika stage_order sudah ada.
     */
    public function test_store_approval_stage_duplicate_stage_order_error()
    {
        // Membuat approver dan approval stage pertama
        $approver = Approver::create(['name' => 'Ana']);
        ApprovalStage::create([
            'approver_id' => $approver->id,
            'stage_order' => 1
        ]);

        // Mengirim POST request dengan stage_order yang duplikat
        $response = $this->postJson('/api/approval-stages', [
            'approver_id' => $approver->id,
            'stage_order' => 1 // Duplikat stage_order
        ]);

        // Assert bahwa status response adalah 422 (Validation error)
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // Assert bahwa ada pesan error validasi
        $response->assertJsonValidationErrors(['stage_order']);
    }

    /**
     * Test untuk validasi ketika stage_order tidak ada.
     */
    public function test_update_approval_stage_missing_stage_order()
    {
        // Membuat approver dan approval stage
        $approver = Approver::create(['name' => 'Ana']);
        $approvalStage = ApprovalStage::create([
            'approver_id' => $approver->id,
            'stage_order' => 1
        ]);

        // Mengirim PUT request dengan data yang invalid (stage_order tidak ada)
        $response = $this->putJson("/api/approval-stages/{$approvalStage->id}", [
            'approver_id' => $approver->id, // approver_id yang valid
        ]);

        // Assert bahwa status response adalah 422 (Validation error)
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        // Assert bahwa ada pesan error validasi
        $response->assertJsonValidationErrors(['stage_order']);
    }
}
