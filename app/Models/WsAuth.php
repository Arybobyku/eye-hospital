<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class WsAuth extends Authenticatable implements JWTSubject {
    
    protected $table = 'pengguna';
    public $timestamp = false;

    protected $fillable = [
        'uuid', 'nama', 'username', 'password', 'posisi', 
        'sebagai', 'email', 'status', 'delete_soft'
    ];

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return ['username' => $this->username,];
    }
};