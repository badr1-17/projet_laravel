<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = ['name', 'filiere_id', 'capacity'];
    
    public function filiere()
    {
        return $this->belongsTo(Filiere::class);  //relation avec filiere 
    }
}