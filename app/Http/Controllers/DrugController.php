<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as AppController;
use App\Models\Drug;
use App\Services\Interfaces\DrugServiceInterface;
use Illuminate\View\View;

class DrugController extends AppController
{

    protected $drugService;

    public function __construct(DrugServiceInterface $drugService) {

        parent::__construct();
        $this->drugService = $drugService;

    }

    public function index(): View {

        $drugs = $this->drugService->getDrugs();
        return view('drugs.index', compact('drugs'));

    }

    public function create(): View {

        return view('drugs.create');

    }

    public function store() {

    }

    public function edit(Drug $drug): View {

        return view('drugs.edit', compact('drug'));

    }


}
