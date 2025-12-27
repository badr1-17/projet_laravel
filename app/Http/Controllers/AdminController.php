<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Filiere;
use App\Models\Groupe;
use App\Models\Module;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Verifier si cest admin
        if (session('user_role') !== 'admin') {
            return redirect('/login');
        }
        
        $stats = [
            'teachers' => Teacher::count(),
            'filieres' => Filiere::count(),
            'groupes' => Groupe::count(),
            'modules' => Module::count()
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
    
    
    public function teachersIndex()
    {
        $teachers = Teacher::with('filiere')->get();
        $filieres = Filiere::all();
        return view('admin.teachers.index', compact('teachers', 'filieres'));
    }
    
    public function storeTeacher(Request $request)
    {
        Teacher::create($request->all());
        return back()->with('success', 'Professeur ajouté avec succès!');
    }
    
    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->update($request->all());
        return back()->with('success', 'Professeur modifié avec succès!');
    }
    
    public function deleteTeacher($id)
    {
        Teacher::destroy($id);
        return back()->with('success', 'Professeur supprimé avec succès!');
    }
    
    public function filieresIndex()
    {
        $filieres = Filiere::withCount('teachers', 'groupes')->get();
        return view('admin.filieres.index', compact('filieres'));
    }
    
    public function storeFiliere(Request $request)
    {
        Filiere::create($request->all());
        return back()->with('success', 'Filière ajoutée avec succès!');
    }
    
    public function updateFiliere(Request $request, $id)
    {
        $filiere = Filiere::findOrFail($id);
        $filiere->update($request->all());
        return back()->with('success', 'Filière modifiée avec succès!');
    }
    
    public function deleteFiliere($id)
    {
        Filiere::destroy($id);
        return back()->with('success', 'Filière supprimée avec succès!');
    }
    
   
    public function groupesIndex()
    {
        $groupes = Groupe::with('filiere')->get();
        $filieres = Filiere::all();
        return view('admin.groupes.index', compact('groupes', 'filieres'));
    }
    
    public function storeGroupe(Request $request)
    {
        Groupe::create($request->all());
        return back()->with('success', 'Groupe ajouté avec succès!');
    }
    
    public function updateGroupe(Request $request, $id)
    {
        $groupe = Groupe::findOrFail($id);
        $groupe->update($request->all());
        return back()->with('success', 'Groupe modifié avec succès!');
    }
    
    public function deleteGroupe($id)
    {
        Groupe::destroy($id);
        return back()->with('success', 'Groupe supprimé avec succès!');
    }
    
    
    public function modulesIndex()
    {
        $modules = Module::all();
        $teachers = Teacher::all();
        return view('admin.modules.index', compact('modules', 'teachers'));
    }
    
    public function storeModule(Request $request)
    {
        $module = Module::create($request->all());
        
        
        if ($request->has('teacher_ids')) {
            $module->teachers()->attach($request->teacher_ids);
        }
        
        return back()->with('success', 'Module ajouté avec succès!');
    }
    
    public function updateModule(Request $request, $id)
    {
        $module = Module::findOrFail($id);
        $module->update($request->all());
        
      
        if ($request->has('teacher_ids')) {
            $module->teachers()->sync($request->teacher_ids);
        }
        
        return back()->with('success', 'Module modifié avec succès!');
    }
    
    public function deleteModule($id)
    {
        Module::destroy($id);
        return back()->with('success', 'Module supprimé avec succès!');
    }
}