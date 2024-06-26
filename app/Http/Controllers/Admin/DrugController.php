<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as AppController;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\Drugs\CreateDrugRequest;
use App\Http\Requests\Admin\Drugs\UpdateDrugRequest;
use App\Services\DrugService;
use Domain\Common\Paginator\Paginate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Infra\EloquentModels\Drug as DrugModel;

class DrugController extends AppController
{
    public function __construct(private readonly DrugService $drugService)
    {
        parent::__construct();
    }

    /**
     * Index of drugs.
     *
     * @return View
     */
    public function index(AdminRequest $request): View
    {
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 20);

        $paginate = Paginate::make((int)$page, (int)$perPage);

        $drugs = $this->drugService->getDrugsPaginator($paginate);

        return view('drugs.index', compact('drugs'));
    }

    /**
     * Form to create drugs
     *
     * @return View
     */
    public function create(): View
    {
        return view('drugs.create');
    }

    /**
     * Create drug.
     *
     * @param CreateDrugRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreateDrugRequest $request): Redirector|RedirectResponse|Application
    {
        $response = $this->drugService->createDrug($request->getDrugName(), $request->getUrl());

        if (!$response['status']) {
            if ($response['errors']['key'] === 'failed_register_drug') {
                return redirect()->route('drugs.index')->with(['error' => '薬物の登録に失敗しました']);
            }
            return redirect(route('admin.drugs.create'))->with('error', '不正な入力です');
        }
        return redirect(route('admin.drugs.index'))->with('success', '薬物を登録しました');
    }

    /**
     * Form to edit drugs
     *
     * @param DrugModel $drug
     * @return View
     */
    public function edit(DrugModel $drug): View
    {
        return view('drugs.edit', compact('drug'));
    }

    /**
     * From to update drug
     *
     * @param DrugModel $drug
     * @param UpdateDrugRequest $request
     * @return RedirectResponse
     */
    public function update(DrugModel $drug, UpdateDrugRequest $request): RedirectResponse
    {
        $response = $this->drugService->updateDrug(
            $drug->toDomain()->getId(),
            $request->getName(),
            $request->getUrl(),
        );

        if (!$response['status']) {
            return redirect(route('admin.drugs.index'))->with(['error' => '薬物の更新に失敗しました']);
        }

        return redirect(route('admin.drugs.index'))->with(['success' => '薬物の更新に成功しました']);
    }

    /**
     * Delete the drug
     *
     * @param DrugModel $drug
     * @return RedirectResponse
     */
    public function delete(DrugModel $drug): RedirectResponse
    {

        $response = $this->drugService->deleteDrug($drug->toDomain()->getId());
        if (!$response['status']) {
            if ($response['errors']['key'] === 'have_a_medication_history') {
                return redirect(route('admin.drugs.index'))->with(['error' => '服薬履歴が存在するため削除できません']);
            }
            return redirect(route('admin.drugs.index'))->with(['error' => '薬物の削除に失敗しました']);
        }

        return redirect(route('admin.drugs.index'))->with(['success' => '薬物を削除しました']);

    }

}
