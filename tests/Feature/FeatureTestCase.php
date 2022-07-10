<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Auth\AdminUser;
use App\Auth\User;
use Domain\AdminUser\AdminUser as AdminUserDomain;
use Domain\AdminUser\AdminUserId;
use Domain\Drug\Drug;
use Domain\MedicationHistory\MedicationHistory;
use Domain\User\User as UserDomain;
use Domain\User\UserId;
use Illuminate\Support\Facades\Hash;
use Infra\EloquentModels\AdminUser as AdminUserModel;
use Infra\EloquentModels\Drug as DrugModel;
use Infra\EloquentModels\MedicationHistory as MedicationHistoryModel;
use Infra\EloquentModels\User as UserModel;
use Infra\EloquentRepository\AdminUserRepository;
use Infra\EloquentRepository\UserRepository;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{
    private AdminUserRepository $adminUserRepository;
    private UserRepository $userRepository;

    protected AdminUserDomain $adminUser;
    protected Drug $drug;
    protected MedicationHistory $medicationHistory;
    protected UserDomain $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminUserRepository = $this->app->make(AdminUserRepository::class);
        $this->userRepository = $this->app->make(UserRepository::class);

        $this->createAdminUser();
        $this->createUser();
        $this->createDrug();
        $this->createMedicationHistory();
    }

    public function adminLogin(): void
    {
        $admin = new AdminUser(
            $this->adminUserRepository->getByUserId(
                new AdminUserId('takada_yuki')

            )
        );

        $this->be($admin, 'web');
    }

    public function userLogin(): void
    {
        $user = new User(
            $this->userRepository->getUserByUserId(
                new UserId(19890308)
            ),
        );

        $this->be($user, 'api');
    }

    public function createAdminUser(): void
    {
        $model = new AdminUserModel();

        $model->user_id = 'takada_yuki';
        $model->password = Hash::make('takada_yuki0316');
        $model->name = '高田憂希';
        $model->role = 1;
        $model->status = 1;

        $model->save();

        $this->adminUser = $model->toDomain();
    }

    public function createDrug(): void
    {
        $model = new DrugModel();

        $model->drug_name = 'フルニトラゼパム';
        $model->url = 'https://ja.wikipedia.org/wiki/%E3%83%95%E3%83%AB%E3%83%8B%E3%83%88%E3%83%A9%E3%82%BC%E3%83%91%E3%83%A0';

        $model->save();

        $this->drug = $model->toDomain();
    }

    public function createMedicationHistory(): void
    {
        $model = new MedicationHistoryModel();
        $user = $this->user;
        $drug = $this->drug;

        $model->user_id = $user->getId()->getRawValue();
        $model->drug_id = $drug->getId()->getRawValue();
        $model->amount = 2;

        $model->save();

        $this->medicationHistory = $model->toDomain();
    }

    public function createUser(): void
    {
        $model = new UserModel();

        $model->user_id = 19890308;
        $model->name = '松井恵理子';
        $model->icon_url = 'https://example.com';
        $model->password = Hash::make('hogehoge');
        $model->status = 1;

        $model->save();

        $this->user = $model->toDomain();
    }
}
