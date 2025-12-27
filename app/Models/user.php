<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email', 'password', 'role'];
    
    protected $hidden = ['password'];
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    
    public function isTeacher()
    {
        return $this->role === 'teacher';
    }
}