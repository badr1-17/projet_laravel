<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashboard()
    {
        // Vérifier si teacher
        if (session('user_role') !== 'teacher') {
            return redirect('/login');
        }
        
        return view('teacher.dashboard');
        
    }
}