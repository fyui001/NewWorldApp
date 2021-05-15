<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as AppController;
use App\Models\Drug;
use App\Http\Requests\Drugs\CreateDrugRequest;
use App\Http\Requests\Drugs\UpdateDrugRequest;
use App\Services\Interfaces\DrugServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DrugController extends AppController
{

    protected $drugService;

    public function __construct(DrugServiceInterface $drugService) {

        parent::__construct();
        $this->drugService = $drugService;

    }

    /**
     * Index of drugs.
     *
     * @return View
     */
    public function index(): View {

        $drugs = $this->drugService->getDrugs();
        return view('drugs.index', compact('drugs'));

    }

    /**
     * Form to create drugs
     *
     * @return View
     */
    public function create(): View {

        return view('drugs.create');

    }

    /**
     * Create Drugs
     *
     * @param CreateDrugRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateDrugRequest $request) {

        if (!$this->drugService->createDrug($request)) {
            return redirect(route('drugs.create'))->with('error', '不正な入力です');
        }
        return redirect(route('drugs.index'))->with('success', '薬物を登録しました');

    }

    /**
     * Form to edit drugs
     *
     * @param Drug $drug
     * @return View
     */
    public function edit(Drug $drug): View {

        return view('drugs.edit', compact('drug'));

    }

    /**
     * From to update drug
     *
     * @param Drug $drug
     * @param UpdateDrugRequest $request
     * @return mixed
     */
    public function update(Drug $drug, UpdateDrugRequest $request) {

        if (!$this->drugService->updateDrug($drug, $request)) {
            return redirect()->route('drugs.index')->with(['error' => '薬物の更新に失敗しました']);
        }

        return redirect()->route('drugs.index')->with(['success' => '薬物の更新に成功しました']);

    }

    /**
     * Delete the drug
     *
     * @param Drug $drug
     * @return RedirectResponse
     */
    public function delete(Drug $drug): RedirectResponse {

        $response = $this->drugService->deleteDrug($drug);
        if (!$response['status']) {
            if ($response['errors']['key'] === 'have_a_medication_history') {
                return redirect()->route('drugs.index')->with(['error' => '服薬履歴が存在するため削除できません']);
            }
            return redirect()->route('drugs.index')->with(['error' => '薬物の削除に失敗しました']);
        }

        return redirect()->route('drugs.index')->with(['success' => '薬物を削除しました']);

    }

}
