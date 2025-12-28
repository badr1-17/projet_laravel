<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'filiere_id'];
    
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);  //relation avec filiere 
    }
    
    public function modules()
    {
        return $this->belongsToMany(Module::class);  //relation avec module
    }
    
        public function getFullNameAttribute()
        {
            return $this->first_name . ' ' . $this->last_name;
        }
}