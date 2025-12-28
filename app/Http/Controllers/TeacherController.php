<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class TeacherController extends Controller
{
    /**
     * Récupérer tous les cours du professeur
     */

    public function dashboard()
    {

        if (session('user_role') !== 'teacher') {
            return redirect('/login');
        }
        return view('teacher.dashboard');
    }

    public function myCourses()
    {
        

        $teacherId = session('user_id');
        $courses = Course::where('teacher_id', $teacherId)->get();

        return view('teacher.courses.index', compact('courses'));
    }

    /**
     * Enregistrer un nouveau cours
     */
    public function storeCourse(Request $request)
    {
       

        $teacherId = session('user_id');

        // Validation minimale
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        // Créer le cours avec l'ID du professeur
        Course::create([
            'titre' => $request->title,
            'description' => $request->description,
            'professeur_id' => $teacherId,
            // Valeurs par défaut pour les autres champs
            'module_id' => 1,
            'groupe_id' => 1,
            'type_document' => 'cours',
        ]);

        return back()->with('success', 'Cours ajouté avec succès!');
    }
}
