<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .teacher-sidebar {
            width: 250px;
            background: #3498db;
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }
        .teacher-sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: all 0.3s;
        }
        .teacher-sidebar a:hover {
            background: #2980b9;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar Professeur -->
    <div class="teacher-sidebar">
        <div class="p-3">
            <h4><i class="fas fa-chalkboard-teacher"></i> Espace Professeur</h4>
            <p class="small">Bienvenue, {{ session('user_name') }}</p>
        </div>
        <a href="/teacher/dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
        <a href="#" id="showUploadForm"><i class="fas fa-upload"></i> Déposer un cours</a>
        <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Tableau de bord Professeur</h2>
        
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bienvenue dans votre espace professeur</h4>
                <p class="card-text">Vous êtes connecté en tant que professeur.</p>
                <p><strong>Nom:</strong> {{ session('user_name') }}</p>
                <p><strong>Email:</strong> {{ session('user_email') }}</p>
                <p><strong>Rôle:</strong> Professeur</p>
            </div>
        </div>
        
        <!-- Formulaire de dépôt de cours (initialement caché) -->
        <div id="uploadForm" class="card mt-4 hidden">
            <div class="card-body">
                <h4 class="card-title"><i class="fas fa-upload"></i> Déposer un cours</h4>
                <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre du cours</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="module" class="form-label">Module</label>
                        <select class="form-select" id="module" name="module" required>
                            <option value="" disabled selected>Choisir un module</option>
                            @php
                                // ESSAYEZ CETTE MÉTHODE POUR DEBUGGER
                                try {
                                    // Option 1: Récupérer tous les modules
                                    $modules = DB::table('modules')->get();
                                    
                                    // Debug: Afficher la structure des données
                                    // echo "<pre>";
                                    // print_r($modules->first());
                                    // echo "</pre>";
                                    
                                    // Si vide, utiliser des données par défaut
                                    if($modules->isEmpty()) {
                                        $modules = collect([
                                            (object)['id' => 1, 'name' => 'Module PHP'],
                                            (object)['id' => 3, 'name' => 'Module JavaScript']
                                        ]);
                                    }
                                    
                                } catch (Exception $e) {
                                    // En cas d'erreur, utiliser des données par défaut
                                    $modules = collect([
                                        (object)['id' => 1, 'name' => 'Module PHP'],
                                        (object)['id' => 3, 'name' => 'Module JavaScript']
                                    ]);
                                }
                            @endphp
                            
                            @foreach($modules as $module)
                                {{-- Essayer différentes propriétés --}}
                                @php
                                    // Essayer plusieurs noms de propriétés possibles
                                    $moduleName = $module->name ?? 
                                                 $module->nom ?? 
                                                 $module->module_name ?? 
                                                 $module->module_nom ?? 
                                                 $module->titre ?? 
                                                 'Module ' . $module->id;
                                @endphp
                                <option value="{{ $module->id }}">{{ $moduleName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="groupe" class="form-label">Groupe</label>
                        <select class="form-select" id="groupe" name="groupe" required>
                            <option value="" disabled selected>Choisir un groupe</option>
                            <option value="groupe_1">Groupe 1</option>
                            <option value="groupe_3">Groupe 3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="file_type" class="form-label">Type de fichier</label>
                        <select class="form-select" id="file_type" name="file_type" required>
                            <option value="" disabled selected>Choisir le type</option>
                            <option value="PDF">PDF</option>
                            <option value="Word">Word</option>
                            <option value="PowerPoint">PowerPoint</option>
                            <option value="Image">Image</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Fichier</label>
                        <input type="file" class="form-control" id="file" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Déposer</button>
                </form>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-book fa-3x text-primary mb-3"></i>
                        <h5>Mes Cours</h5>
                        <p class="text-muted">Gérer mes cours</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-calendar fa-3x text-success mb-3"></i>
                        <h5>Emploi du temps</h5>
                        <p class="text-muted">Voir mon planning</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <i class="fas fa-user-edit fa-3x text-warning mb-3"></i>
                        <h5>Mon Profil</h5>
                        <p class="text-muted">Modifier mes informations</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const showFormBtn = document.getElementById('showUploadForm');
        const uploadForm = document.getElementById('uploadForm');

        showFormBtn.addEventListener('click', (e) => {
            e.preventDefault();
            uploadForm.classList.toggle('hidden');
            uploadForm.scrollIntoView({ behavior: 'smooth' });
        });
    </script>
</body>
</html>