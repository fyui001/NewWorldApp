<?php

declare(strict_types=1);

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{

    protected $table = 'users';

    protected $fillable = [
        'user_id',
        'name',
        'password',
        'is_registered',
        'del_flg',
    ];

    protected $hidden = [
        'password',
    ];

    public function medicationHistories() {

        return $this->hasMany('App\Models\MedicationHistory', 'user_id');

    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {

        return $this->getKey();

    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {

        return [];

    }
}
