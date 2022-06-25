<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Requests\Admin\AdminUsers\CreateAdminUserRequest;
use App\Http\Requests\Admin\AdminUsers\UpdateAdminUserRequest;
use App\Services\Service as AppService;
use App\Services\Interfaces\AdminUserServiceInterface;
use Domain\AdminUser\AdminId;
use Domain\AdminUser\AdminUser;
use Domain\AdminUser\AdminUserDomainService;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;

class AdminUserService extends AppService implements AdminUserServiceInterface
{
    private AdminUserDomainService $adminUserDomainService;

    public function __construct(AdminUserDomainService $adminUserDomainService)
    {
        $this->adminUserDomainService = $adminUserDomainService;
    }

    /**
     * Get all users from paginator.
     *
     * @return LengthAwarePaginator
     */
    public function getUsers(): LengthAwarePaginator
    {
        return $this->adminUserDomainService->getPaginator();
    }

    /**
     * Create a user.
     *
     * @param CreateAdminUserRequest $request
     * @return void
     */
    public function createUser(CreateAdminUserRequest $request): void
    {
        $this->adminUserDomainService->createAdminUser(
            $request->getUserId(),
            $request->getHashedPassword(),
            $request->getName(),
            $request->getRole(),
            $request->getStatus()
        );
    }

    /**
     * Update the user.
     *
     * @param AdminId $adminId
     * @param UpdateAdminUserRequest $request
     */
    public function updateUser(AdminId $adminId, UpdateAdminUserRequest $request): void
    {
        $this->adminUserDomainService->updateAdminUser(
            new AdminUser(
                $adminId,
                $request->getUserId(),
                $request->getHashedPassword(),
                $request->getName(),
                $request->getRole(),
                $request->getStatus()
            )
        );
    }

    /**
     * Delete the user.
     *
     * @param AdminId $adminId
     * @throws Exception
     */
    public function deleteUser(AdminId $adminId): void
    {
        $this->adminUserDomainService->deleteAdminUser($adminId);
    }
}
