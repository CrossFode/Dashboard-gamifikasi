<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $fillable = [
        'username', 'name', 'email', 'role', 'password_hash', 'avatar_url'
    ];

    protected $hidden = ['password_hash'];
    
    // override password column
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
