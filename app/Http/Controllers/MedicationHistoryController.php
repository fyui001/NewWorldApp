<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as AppController;
use App\Models\MedicationHistory;
use App\Services\Interfaces\MedicationHistoryServiceInterface;
use Illuminate\View\View;
use App\Http\Requests\MedicationHistories\UpdateMedicationHistoryRequest;

class MedicationHistoryController extends AppController
{

    protected $medicationHistoryService;

    public function __construct(MedicationHistoryServiceInterface $medicationHistoryService) {

        parent::__construct();
        $this->medicationHistoryService = $medicationHistoryService;

    }

    /**
     * 服薬履歴一覧
     *
     * @return View
     */
    public function index() {

        $medicationHistories = $this->medicationHistoryService->getMedicationHistories();
        return view('medication_histories.index', compact('medicationHistories'));

    }

    /**
     * 服薬履歴編集
     *
     * @param MedicationHistory $medicationHistory
     * @return View
     */
    public function edit(MedicationHistory $medicationHistory): View {

        return view('medication_histories.edit', compact('medicationHistory'));

    }

    /**
     * 服薬履歴更新
     *
     * @param MedicationHistory $medicationHistory
     * @param UpdateMedicationHistoryRequest $request
     * @return mixed
     */
    public function update(MedicationHistory $medicationHistory, UpdateMedicationHistoryRequest $request) {
        if (!$this->medicationHistoryService->updateMedicationHistory($medicationHistory, $request)) {
            return redirect()->route('medication_histories.index')->with(['error' => '服薬履歴の更新に失敗しました']);
        }
        return redirect()->route('medication_histories.index')->with(['success' => '服薬履歴の更新に成功しました']);
    }

}
