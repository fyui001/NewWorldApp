<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as AppController;
use Illuminate\View\View;

class HomeController extends AppController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        parent::__construct();

    }

    /**
     * Top page.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View {

        return view('top_page');

    }
}
