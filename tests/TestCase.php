<?php

declare(strict_types=1);

namespace Tests;

use Domain\AdminUser\AdminUser;
use Domain\Drug\Drug;
use Domain\MedicationHistory\MedicationHistory;
use Domain\User\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Infra\EloquentModels\AdminUser as AdminUserModel;
use Infra\EloquentModels\Drug as DrugModel;
use Infra\EloquentModels\MedicationHistory as MedicationHistoryModel;
use Infra\EloquentModels\User as UserModel;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function createAdminUser(): AdminUser
    {
        $model = new AdminUserModel();

        $model->user_id = 'takada_yuki';
        $model->password = Hash::make('takada_yuki0316');
        $model->name = '高田憂希';
        $model->role = 1;
        $model->status = 1;

        $model->save();

        return $model->toDomain();
    }

    public function createDrug(): Drug
    {
        $model = new DrugModel();

        $model->drug_name = 'フルニトラゼパム';
        $model->url = 'https://ja.wikipedia.org/wiki/%E3%83%95%E3%83%AB%E3%83%8B%E3%83%88%E3%83%A9%E3%82%BC%E3%83%91%E3%83%A0';

        $model->save();

        return $model->toDomain();
    }

    public function createMedicationHistory(): MedicationHistory
    {
        $model = new MedicationHistoryModel();
        $user = $this->createUser();
        $drug = $this->createDrug();

        $model->user_id = $user->getId()->getRawValue();
        $model->drug_id = $drug->getId()->getRawValue();
        $model->amount = 2;

        $model->save();

        return $model->toDomain();
    }

    public function createUser(): User
    {
        $model = new UserModel();

        $model->user_id = 19890308;
        $model->name = '松井恵理子';
        $model->icon_url = '';
        $model->password = Hash::make('hogehoge');
        $model->status = 1;

        $model->save();

        return $model->toDomain();
    }
}
