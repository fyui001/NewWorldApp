<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as AppController;
use Illuminate\Http\RedirectResponse;
use Infra\EloquentModels\MedicationHistory;
use App\Services\Interfaces\MedicationHistoryServiceInterface;
use Illuminate\View\View;
use App\Http\Requests\Admin\MedicationHistories\UpdateMedicationHistoryRequest;

class MedicationHistoryController extends AppController
{

    protected MedicationHistoryServiceInterface $medicationHistoryService;

    public function __construct(MedicationHistoryServiceInterface $medicationHistoryService)
    {
        parent::__construct();
        $this->medicationHistoryService = $medicationHistoryService;
    }

    /**
     * 服薬履歴一覧
     *
     * @return View
     */
    public function index(): View
    {
        $medicationHistories = $this->medicationHistoryService->getMedicationHistories();

        return view('medication_histories.index', compact('medicationHistories'));
    }

    /**
     * 服薬履歴編集
     *
     * @param MedicationHistory $medicationHistory
     * @return View
     */
    public function edit(MedicationHistory $medicationHistory): View
    {
        return view('medication_histories.edit', compact('medicationHistory'));
    }

    /**
     * 服薬履歴更新
     *
     * @param MedicationHistory $medicationHistory
     * @param UpdateMedicationHistoryRequest $request
     * @return RedirectResponse
     */
    public function update(MedicationHistory $medicationHistory, UpdateMedicationHistoryRequest $request): RedirectResponse
    {
        if (!$this->medicationHistoryService->updateMedicationHistory(
                $medicationHistory,
                $request
            )) {
            return redirect(route('admin.medication_histories.index'))->with(['error' => '服薬履歴の更新に失敗しました']);
        }

        return redirect(route('admin.medication_histories.index'))->with(['success' => '服薬履歴の更新に成功しました']);
    }
}
