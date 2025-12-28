<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Module;
use App\Models\Groupe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    // Afficher la liste des cours du professeur
    public function index()
    {
        $courses = Course::where('teacher_id', Auth::id())
                        ->with(['module', 'groupe'])
                        ->latest()
                        ->get();
        
        return view('courses.index', compact('courses'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        $modules = Module::all();
        $groupes = Groupe::all();
        
        return view('courses.create', compact('modules', 'groupes'));
    }

    // Enregistrer un nouveau cours
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:cours,td,tp,projet',
            'module_id' => 'required|exists:modules,id',
            'groupe_id' => 'required|exists:groupes,id',
            'fichier' => 'required|file|mimes:pdf,ppt,pptx,doc,docx,zip,txt|max:20480',
        ]);

        // Gestion du fichier
        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('courses', $fileName, 'public');
        }

        // Création du cours
        Course::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'type' => $request->type,
            'module_id' => $request->module_id,
            'groupe_id' => $request->groupe_id,
            'teacher_id' => Auth::id(),
            'fichier' => $filePath,
        ]);

        return redirect()->route('courses.index')
                        ->with('success', 'Cours déposé avec succès!');
    }

    // Afficher le formulaire d'édition
    public function edit(Course $course)
    {
        // Vérifier que le professeur est propriétaire du cours
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }
        
        $modules = Module::all();
        $groupes = Groupe::all();
        
        return view('courses.edit', compact('course', 'modules', 'groupes'));
    }

    // Mettre à jour un cours
    public function update(Request $request, Course $course)
    {
        // Vérifier que le professeur est propriétaire du cours
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }
        
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:cours,td,tp,projet',
            'module_id' => 'required|exists:modules,id',
            'groupe_id' => 'required|exists:groupes,id',
            'fichier' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,zip,txt|max:20480',
        ]);

        $data = $request->only(['titre', 'description', 'type', 'module_id', 'groupe_id']);

        // Gestion du nouveau fichier
        if ($request->hasFile('fichier')) {
            // Supprimer l'ancien fichier
            if ($course->fichier && Storage::disk('public')->exists($course->fichier)) {
                Storage::disk('public')->delete($course->fichier);
            }
            
            // Enregistrer le nouveau fichier
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['fichier'] = $file->storeAs('courses', $fileName, 'public');
        }

        $course->update($data);

        return redirect()->route('courses.index')
                        ->with('success', 'Cours mis à jour avec succès!');
    }

    // Supprimer un cours
    public function destroy(Course $course)
    {
        // Vérifier que le professeur est propriétaire du cours
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }
        
        // Supprimer le fichier physique
        if ($course->fichier && Storage::disk('public')->exists($course->fichier)) {
            Storage::disk('public')->delete($course->fichier);
        }
        
        $course->delete();

        return redirect()->route('courses.index')
                        ->with('success', 'Cours supprimé avec succès!');
    }
}