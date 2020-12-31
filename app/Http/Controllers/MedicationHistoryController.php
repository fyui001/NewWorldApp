<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as AppController;
use App\Services\Interfaces\MedicationHistoryServiceInterface;
use Illuminate\View\View;

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

}
