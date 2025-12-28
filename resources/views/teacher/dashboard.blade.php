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
            background: linear-gradient(180deg, #2c3e50 0%, #3498db 100%);
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .teacher-sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .teacher-sidebar a:hover, .teacher-sidebar a.active {
            background: rgba(255,255,255,0.1);
            border-left: 3px solid #fff;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .hidden {
            display: none;
        }
        .card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar Professeur -->
    <div class="teacher-sidebar">
        <div class="p-3 text-center">
            <h4><i class="fas fa-chalkboard-teacher"></i> Espace Professeur</h4>
            <p class="small mb-0">Bienvenue, {{ session('user_name') }}</p>
            <div class="mt-2">
                <span class="badge bg-light text-dark">{{ session('user_role') }}</span>
            </div>
        </div>
        <hr class="bg-light mx-3 my-2">
        <a href="/teacher/dashboard" class="{{ request()->is('teacher/dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Tableau de bord
        </a>
        <a href="#" id="showUploadForm">
            <i class="fas fa-upload"></i> Déposer un cours
        </a>
        <a href="{{ route('teacher.courses.index') }}" class="{{ request()->is('teacher/courses*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Mes Cours
        </a>
        <div class="mt-auto">
            <hr class="bg-light mx-3 my-2">
            <a href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-tachometer-alt"></i> Tableau de bord Professeur</h2>
            <div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Bienvenue dans votre espace professeur</h4>
                <p class="card-text">Vous êtes connecté en tant que professeur.</p>
                <div class="row">
                    <div class="col-md-4">
                        <p><strong><i class="fas fa-user"></i> Nom:</strong> {{ session('user_name') }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong><i class="fas fa-envelope"></i> Email:</strong> {{ session('user_email') }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong><i class="fas fa-user-tag"></i> Rôle:</strong> Professeur</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Formulaire de dépôt de cours -->
        <div id="uploadForm" class="card mt-4 hidden">
            <div class="card-body">
                <h4 class="card-title"><i class="fas fa-upload"></i> Déposer un cours</h4>
                <form action="{{ route('teacher.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="title" class="form-label">Titre du cours <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="module" class="form-label">Module <span class="text-danger">*</span></label>
                            <select class="form-select" id="module" name="module" >
                                <option value="" disabled selected>Choisir un module</option>
                                 <option value="php">PHP</option>
                                 <option value="javascript">JavaScript</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="description" name="description" rows="3" ></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="groupe" class="form-label">Groupe <span class="text-danger">*</span></label>
                            <select class="form-select" id="groupe" name="groupe" required>
                                <option value="" disabled selected>Choisir un groupe</option>
                                <option value="groupe_1">Groupe 1</option>
                                <option value="groupe_2">Groupe 2</option>
                                <option value="groupe_3">Groupe 3</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="file_type" class="form-label">Type de fichier <span class="text-danger">*</span></label>
                            <select class="form-select" id="file_type" name="file_type" required>
                                <option value="" disabled selected>Choisir le type</option>
                                <option value="PDF">PDF</option>
                                <option value="Word">Word</option>
                                <option value="PowerPoint">PowerPoint</option>
                                <option value="Image">Image</option>
                                <option value="Video">Vidéo</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="file" class="form-label">Fichier <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="file" name="file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png,.mp4">
                            <small class="text-muted">Taille max: 10MB</small>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('uploadForm').classList.add('hidden')">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Déposer le cours
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Statistiques -->
        <div class="row mt-4">
            <div class="col-md-3">
                <a href="{{ route('teacher.courses.index') }}" class="text-decoration-none">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-book fa-3x text-primary mb-3"></i>
                            <h5>Mes Cours</h5>
                            <p class="text-muted">Gérer mes cours déposés</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-success mb-3"></i>
                        <h5>Étudiants</h5>
                        <p class="text-muted">Voir mes étudiants</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="fas fa-calendar fa-3x text-info mb-3"></i>
                        <h5>Planning</h5>
                        <p class="text-muted">Voir mon emploi du temps</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <a href="#" class="text-decoration-none">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-user-edit fa-3x text-warning mb-3"></i>
                            <h5>Mon Profil</h5>
                            <p class="text-muted">Modifier mes informations</p>
                        </div>
                    </div>
                </a>
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

        // Ajouter la validation des fichiers
        document.getElementById('file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const maxSize = 10 * 1024 * 1024; // 10MB
            
            if (file && file.size > maxSize) {
                alert('Le fichier est trop volumineux (max 10MB)');
                this.value = '';
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>