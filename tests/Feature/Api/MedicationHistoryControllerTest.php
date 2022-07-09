<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use Domain\MedicationHistory\MedicationHistory;
use Domain\MedicationHistory\MedicationHistoryId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Infra\EloquentRepository\MedicationHistoryRepository;
use Tests\TestCase;

class MedicationHistoryControllerTest extends TestCase
{
    use RefreshDatabase;

    private MedicationHistoryRepository $medicationHistoryRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->medicationHistoryRepository = $this->app->make(MedicationHistoryRepository::class);
    }

    public function testCreate()
    {
        $this->userLogin();

        $params = [
            'user_id' => $this->medicationHistory->getUser()->getId()->getRawValue(),
            'drug_name' => $this->medicationHistory->getDrug()->getName()->getRawValue(),
            'amount' => $this->medicationHistory->getAmount()->getRawValue(),
        ];

        $response = $this->json('POST', route('api.medication_histories.create'), $params);

        $except = [
            'status' => true,
            'message' => '',
            'data' => (
                new MedicationHistory(
                    new MedicationHistoryId(($this->medicationHistory->getId()->getRawValue()) + 1),
                    $this->user,
                    $this->drug,
                    $this->medicationHistory->getAmount(),
                )
            )->toArray(),
        ];

        $response->assertStatus(200)
            ->assertJson($except);
    }
}
