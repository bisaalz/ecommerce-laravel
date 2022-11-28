<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role','status','phone','address', 'activation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRules(){
        return [
            'name' => 'required|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'role' => 'required|in:admin,vendor,customer',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|confirmed|min:8|max:16'
        ];
    }

    public function getRegisterRules(){
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'role' => 'required|in:vendor,customer',
            'password' => 'required|string|confirmed|min:8|max:16'
        ];
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



}
