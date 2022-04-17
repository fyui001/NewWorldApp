<?php

declare(strict_types=1);

namespace Infra\EloquentRepository;

use Courage\CoInt\CoPositiveInteger;
use Domain\AdminUsers\AdminUserHashedPassword;
use Domain\AdminUsers\AdminUserName;
use Domain\AdminUsers\AdminUserRepository as AdminUserRepositoryInterface;
use Domain\AdminUsers\AdminUser;
use Domain\AdminUsers\AdminId;
use Domain\AdminUsers\AdminUserId;
use Domain\AdminUsers\AdminUserRole;
use Domain\AdminUsers\AdminUserStatus;
use Domain\Exceptions\LogicException;
use Domain\Exceptions\NotFoundException;
use Infra\EloquentModels\AdminUser as AdminUserModel;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminUserRepository implements AdminUserRepositoryInterface
{
    public function getPaginator(): LengthAwarePaginator
    {
        return AdminUserModel::paginate(15);
    }

    public function create(
        AdminUserId $adminUserId,
        AdminUserHashedPassword $adminUserHashedPassWord,
        AdminUserName $adminUserName,
        AdminUserRole $adminUserRole,
        AdminUserStatus $adminUserStatus
    ): AdminUser {
        $model = new AdminUserModel();

        $model->user_id = $adminUserId->getRawValue();
        $model->password = $adminUserHashedPassWord->getRawValue();
        $model->name = $adminUserName->getRawValue();
        $model->role = $adminUserRole->getValue()->getRawValue();
        $model->status = $adminUserStatus->getValue()->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function update(AdminUser $adminUser): AdminUser
    {
        $model = AdminUserModel::where(['id' => $adminUser->getId()->getRawValue()])->first();

        $model->user_id = $adminUser->getUserId()->getRawValue();
        $model->password = $adminUser->getPassword()->getRawValue();
        $model->name = $adminUser->getName()->getRawValue();
        $model->role = $adminUser->getRole()->getValue()->getRawValue();
        $model->status = $adminUser->getStatus()->getValue()->getRawValue();

        $model->save();

        return $model->toDomain();
    }

    public function delete(AdminId $adminId): CoPositiveInteger
    {
        $model = AdminUserModel::where(['id' => $adminId->getRawValue()]);

        if (!$model) {
            throw new NotFoundException();
        }

        $result = $model->delete();

        if (!$result) {
            throw new LogicException();
        }

        return new CoPositiveInteger($result);
    }
}
