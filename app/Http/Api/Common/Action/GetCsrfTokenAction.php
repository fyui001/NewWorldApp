<?php

declare(strict_types=1);

namespace App\Http\Api\Common\Action;

use App\Http\Api\Common\Request\CommonRequest;
use App\Http\Api\Common\Responder\CsrfTokenResponder;
use App\Http\Controllers\Controller;

class GetCsrfTokenAction extends Controller
{
    public function __invoke(CommonRequest $request): CsrfTokenResponder
    {
        return new CsrfTokenResponder($request->session()->token());
    }
}
