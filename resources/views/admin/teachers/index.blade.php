<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Professeurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
        }
        .sidebar a {
            color: #bdc3c7;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: all 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #34495e;
            color: white;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-3">
            <h4><i class="fas fa-graduation-cap"></i> Plateforme Admin</h4>
        </div>
        <a href="/admin/dashboard"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
        <a href="/admin/teachers" class="active"><i class="fas fa-chalkboard-teacher"></i> Professeurs</a>
        <a href="/admin/filieres"><i class="fas fa-university"></i> Filières</a>
        <a href="/admin/groupes"><i class="fas fa-users"></i> Groupes</a>
        <a href="/admin/modules"><i class="fas fa-book"></i> Modules</a>
        <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </div>

    <div class  ="main-content">
        <h2 class="mb-4"><i class="fas fa-chalkboard-teacher"></i> Gestion des Professeurs</h2>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-plus"></i> {{ isset($editTeacher) ? 'Modifier' : 'Ajouter' }} un professeur</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ isset($editTeacher) ? '/admin/teachers/'.$editTeacher->id : '/admin/teachers' }}">
                    @csrf
                    @if(isset($editTeacher))
                        @method('PUT')
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="first_name" class="form-control" 
                                       value="{{ $editTeacher->first_name ?? '' }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="last_name" class="form-control" 
                                       value="{{ $editTeacher->last_name ?? '' }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ $editTeacher->email ?? '' }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Téléphone</label>
                                <input type="text" name="phone" class="form-control" 
                                       value="{{ $editTeacher->phone ?? '' }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Filière</label>
                        <select name="filiere_id" class="form-control" required>
                            <option value="">Sélectionner une filière</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}" 
                                    {{ isset($editTeacher) && $editTeacher->filiere_id == $filiere->id ? 'selected' : '' }}>
                                    {{ $filiere->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($editTeacher) ? 'Modifier' : 'Ajouter' }}
                    </button>
                    
                    @if(isset($editTeacher))
                        <a href="/admin/teachers" class="btn btn-secondary">Annuler</a>
                    @endif
                </form>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list"></i> Liste des professeurs ({{ $teachers->count() }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Filière</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->id }}</td>
                                <td>{{ $teacher->full_name }}</td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->phone ?? 'Non spécifié' }}</td>
                                <td>{{ $teacher->filiere->name ?? 'Non assigné' }}</td>
                                <td>
                                    <a href="/admin/teachers/edit/{{ $teacher->id }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/admin/teachers/{{ $teacher->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Supprimer ce professeur ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>