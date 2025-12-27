<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Filières</title>
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
        <a href="/admin/teachers"><i class="fas fa-chalkboard-teacher"></i> Professeurs</a>
        <a href="/admin/filieres" class="active"><i class="fas fa-university"></i> Filières</a>
        <a href="/admin/groupes"><i class="fas fa-users"></i> Groupes</a>
        <a href="/admin/modules"><i class="fas fa-book"></i> Modules</a>
        <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </div>

   
    <div class="main-content">
        <h2 class="mb-4"><i class="fas fa-university"></i> Gestion des Filières</h2>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
      
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-plus"></i> {{ isset($editFiliere) ? 'Modifier' : 'Ajouter' }} une filière</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ isset($editFiliere) ? '/admin/filieres/'.$editFiliere->id : '/admin/filieres' }}">
                    @csrf
                    @if(isset($editFiliere))
                        @method('PUT')
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label">Nom de la filière</label>
                        <input type="text" name="name" class="form-control" 
                               value="{{ $editFiliere->name ?? '' }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3">{{ $editFiliere->description ?? '' }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> {{ isset($editFiliere) ? 'Modifier' : 'Ajouter' }}
                    </button>
                    
                    @if(isset($editFiliere))
                        <a href="/admin/filieres" class="btn btn-secondary">Annuler</a>
                    @endif
                </form>
            </div>
        </div>
        
      
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-list"></i> Liste des filières ({{ $filieres->count() }})</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Professeurs</th>
                                <th>Groupes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($filieres as $filiere)
                            <tr>
                                <td>{{ $filiere->id }}</td>
                                <td>{{ $filiere->name }}</td>
                                <td>{{ $filiere->description ?: 'Aucune description' }}</td>
                                <td>{{ $filiere->teachers_count }}</td>
                                <td>{{ $filiere->groupes_count }}</td>
                                <td>
                                    <a href="/admin/filieres/edit/{{ $filiere->id }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="/admin/filieres/{{ $filiere->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Supprimer cette filière ?')">
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