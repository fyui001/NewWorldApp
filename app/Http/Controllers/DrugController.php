<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as AppController;
use App\Models\Drug;
use App\Http\Requests\Drugs\CreateDrugRequest;
use App\Services\Interfaces\DrugServiceInterface;
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
     * @param Drug $Drug
     * @return View
     */
    public function edit(Drug $drug): View {

        return view('drugs.edit', compact('drug'));

    }


}
