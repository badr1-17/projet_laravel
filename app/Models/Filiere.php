<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $fillable = ['name', 'description'];
    
    public function teachers()
    {
        return $this->hasMany(Teacher::class);  //relation avec les profs
    }
    
    public function groupes()
    {
        return $this->hasMany(Groupe::class);   
    }
}