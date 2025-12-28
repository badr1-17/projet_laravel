<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'module_id',
        'groupe',
        'file_type',
        'file_path',
        'teacher_id',
        'upload_date'
    ];

    protected $casts = [
        'upload_date' => 'datetime'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}