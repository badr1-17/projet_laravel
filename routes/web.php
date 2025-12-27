<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;

// login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']); 

//  Admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    // partie de Professeurs
    Route::get('/teachers', [AdminController::class, 'teachersIndex']);
    Route::post('/teachers', [AdminController::class, 'storeTeacher']);
    Route::put('/teachers/{id}', [AdminController::class, 'updateTeacher']);
    Route::delete('/teachers/{id}', [AdminController::class, 'deleteTeacher']);
    Route::get('/teachers/edit/{id}', function($id) {
        $editTeacher = \App\Models\Teacher::findOrFail($id);
        $teachers = \App\Models\Teacher::with('filiere')->get();
        $filieres = \App\Models\Filiere::all();
        return view('admin.teachers.index', compact('teachers', 'filieres', 'editTeacher'));
    });
    
    //partie de Filières
    Route::get('/filieres', [AdminController::class, 'filieresIndex']);
    Route::post('/filieres', [AdminController::class, 'storeFiliere']);
    Route::put('/filieres/{id}', [AdminController::class, 'updateFiliere']);
    Route::delete('/filieres/{id}', [AdminController::class, 'deleteFiliere']);
    Route::get('/filieres/edit/{id}', function($id) {
        $editFiliere = \App\Models\Filiere::findOrFail($id);
        $filieres = \App\Models\Filiere::withCount(['teachers', 'groupes'])->get();
        return view('admin.filieres.index', compact('filieres', 'editFiliere'));
    });
    
    // partie de Groupes
    Route::get('/groupes', [AdminController::class, 'groupesIndex']);
    Route::post('/groupes', [AdminController::class, 'storeGroupe']);
    Route::put('/groupes/{id}', [AdminController::class, 'updateGroupe']);
    Route::delete('/groupes/{id}', [AdminController::class, 'deleteGroupe']);
    Route::get('/groupes/edit/{id}', function($id) {
        $editGroupe = \App\Models\Groupe::findOrFail($id);
        $groupes = \App\Models\Groupe::with('filiere')->get();
        $filieres = \App\Models\Filiere::all();
        return view('admin.groupes.index', compact('groupes', 'filieres', 'editGroupe'));
    });
    
    //partie de Modules
    Route::get('/modules', [AdminController::class, 'modulesIndex']);
    Route::post('/modules', [AdminController::class, 'storeModule']);
    Route::put('/modules/{id}', [AdminController::class, 'updateModule']);
    Route::delete('/modules/{id}', [AdminController::class, 'deleteModule']);
    Route::get('/modules/edit/{id}', function($id) {
        $editModule = \App\Models\Module::findOrFail($id);
        $modules = \App\Models\Module::with('teachers')->get();
        $teachers = \App\Models\Teacher::all();
        return view('admin.modules.index', compact('modules', 'teachers', 'editModule'));
    });
});

// partie de Teacher
Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('dashboard');
    Route::post('/courses/store', [TeacherController::class, 'storeCourse'])->name('courses.store');
     Route::get('/courses', [TeacherController::class, 'indexCourses'])->name('courses.index');
});




Route::get('/', function () {
    return redirect('/login');
});