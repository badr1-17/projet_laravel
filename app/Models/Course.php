<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = "courses";   // nom de la table

    protected $fillable = [
        'titre',
        'description',
        'type',
        'fichier',
        'module_id',
        'groupe_id',
        'teacher_id'
    ];

   
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

  
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
