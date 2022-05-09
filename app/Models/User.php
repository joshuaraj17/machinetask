<?php

namespace App\Models;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable //implements MustVerifyEmail
{
    use HasRoles;
    use SoftDeletes, Notifiable;
    use HasApiTokens;
    public $table = 'users';
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
    ];

    protected $fillable = [
        'first_name',
        'last_name',        
        'email',
        'phone_no',
        'linkedin_url',
        'country_code',
        'resume',
        'is_active',
        'remember_token',
        'is_email_verify',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];
}