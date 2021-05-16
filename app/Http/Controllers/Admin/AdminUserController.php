<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Models\AdminUser;
use App\Http\Controllers\Controller as AppController;
use App\Services\Interfaces\AdminUserServiceInterface;
use App\Http\Requests\AdminUsers\CreateAdminUserRequest;
use App\Http\Requests\AdminUsers\UpdateAdminUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends AppController
{

    protected AdminUserServiceInterface $adminUserService;

    public function __construct(AdminUserServiceInterface $adminUserService) {

        parent::__construct();
        $this->adminUserService = $adminUserService;

    }

    /**
     * Index of users.
     *
     * @return View
     */
    public function index(): View {

        $adminUsers = $this->adminUserService->getUsers();
        return view('admin_users.index', compact('adminUsers'));

    }

    /**
     * Form to create user.
     *
     * @return View
     */
    public function create(): View {

        return view('admin_users.create');

    }

    /**
     * Store a user.
     *
     * @param CreateAdminUserRequest $request
     * @return RedirectResponse
     */
    public function store(CreateAdminUserRequest $request): RedirectResponse {

        $this->adminUserService->createUser($request);
        return redirect(route('admin_users.index'))->with('success', 'ユーザーを保存しました');

    }

    /**
     * Form to update the user.
     *
     * @param AdminUser $adminUser
     * @return View
     */
    public function edit(AdminUser $adminUser): View {

        return view('admin_users.edit', compact('adminUser'));

    }

    /**
     * Update the user.
     *
     * @param AdminUser $adminUser
     * @param UpdateAdminUserRequest $request
     * @return RedirectResponse
     */
    public function update(AdminUser $adminUser, UpdateAdminUserRequest $request): RedirectResponse {

        $this->adminUserService->updateUser($adminUser, $request);
        return redirect(route('admin_users.index'))->with(['success' => 'ユーザーを編集しました']);

    }

    /**
     * Delete the user.
     *
     * @param AdminUser $adminUser
     * @return RedirectResponse
     */
    public function destroy(AdminUser $adminUser): RedirectResponse {

        $this->adminUserService->deleteUser($adminUser);
        return redirect()->route('admin_users.index')->with(['success' => 'ユーザーを削除しました']);

    }

    /**
     * View a api token
     *
     * @return View
     */
    public function apiToken(): View {

        $adminUser = Auth::user();
        $apiToken = $this->adminUserService->apiTokenView($adminUser);

        return view('admin_users.api_token', compact('apiToken'));

    }

    public function updateApiToken() {

        $response = $this->adminUserService->updateApiToken();
        if (!$response['status']) {
            return redirect(route('admin_users.api_token'))->with(['error', $response['errors']['type']]);
        }

        return redirect(route('admin_users.api_token'))->with(['success', 'Updated api token!']);
    }

}
