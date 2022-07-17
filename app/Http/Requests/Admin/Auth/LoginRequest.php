<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Auth;

use App\Http\Requests\Request as AppRequest;
use Domain\AdminUser\AdminUserId;
use Domain\Common\RawPassword;

class LoginRequest extends AppRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|max:255',
            'password' => 'required|max:255',
        ];
    }

    public function getUserId(): AdminUserId
    {
        return new AdminUserId($this->input('user_id'));
    }

    public function getPasswordAsBaseValue(): RawPassword
    {
        return new RawPassword($this->input('password'));
    }
}
