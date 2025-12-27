<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Modules</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #dee2e6;
        }
        .nav-links {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .nav-btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            background: #e9ecef;
            border: 1px solid #ddd;
            transition: all 0.3s;
        }
        .nav-btn:hover {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        .nav-btn.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 15px;
            font-weight: bold;
        }
        .btn-action {
            padding: 5px 10px;
            margin: 0 2px;
            font-size: 12px;
        }
    </style>
</head>
<body>
   
    <div class="container">
     
        <div class="header">
            <h2><i class="fas fa-book"></i> Gestion des Modules</h2>
            <div class="nav-links">
                <a href="/admin/dashboard" class="nav-btn">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="/admin/teachers" class="nav-btn">
                    <i class="fas fa-chalkboard-teacher"></i> Profs
                </a>
                <a href="/admin/filieres" class="nav-btn">
                    <i class="fas fa-university"></i> Filières
                </a>
                <a href="/admin/groupes" class="nav-btn">
                    <i class="fas fa-users"></i> Groupes
                </a>
                <a href="/admin/modules" class="nav-btn active">
                    <i class="fas fa-book"></i> Modules
                </a>
                <a href="{{ route('logout') }}" class="nav-btn" style="background: #dc3545; color: white;">
                    <i class="fas fa-sign-out-alt"></i> Déco
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus"></i> {{ isset($editModule) ? 'Modifier' : 'Ajouter' }} un module
            </div>
            <div class="card-body">
                <form method="POST" action="{{ isset($editModule) ? '/admin/modules/'.$editModule->id : '/admin/modules' }}">
                    @csrf
                    @if(isset($editModule))
                        @method('PUT')
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Code du module *</label>
                                <input type="text" name="code" class="form-control" 
                                       value="{{ $editModule->code ?? old('code') }}" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nom du module *</label>
                                <input type="text" name="name" class="form-control" 
                                       value="{{ $editModule->name ?? old('name') }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Coefficient</label>
                                <input type="number" name="coefficient" class="form-control" step="0.5" 
                                       value="{{ $editModule->coefficient ?? old('coefficient', 1) }}" min="0.5">
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Professeur(s)</label>
                                <select name="teacher_ids[]" class="form-control" multiple>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ (isset($editModule) && $editModule->teachers->contains($teacher->id)) || (is_array(old('teacher_ids')) && in_array($teacher->id, old('teacher_ids'))) ? 'selected' : '' }}>
                                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Ctrl+clic pour sélectionner plusieurs</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2">{{ $editModule->description ?? old('description') }}</textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> {{ isset($editModule) ? 'Modifier' : 'Ajouter' }}
                        </button>
                        
                        @if(isset($editModule))
                            <a href="/admin/modules" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-list"></i> Liste des modules ({{ $modules->count() }})
            </div>
            <div class="card-body">
                @if($modules->isEmpty())
                    <div class="text-center py-4">
                        <i class="fas fa-book fa-2x text-muted mb-3"></i>
                        <p class="text-muted">Aucun module trouvé</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Nom</th>
                                    <th>Coefficient</th>
                                    <th>Professeurs</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($modules as $module)
                                <tr>
                                    <td><code>{{ $module->code }}</code></td>
                                    <td><strong>{{ $module->name }}</strong></td>
                                    <td>{{ $module->coefficient }}</td>
                                    <td>
                                        @if($module->teachers->count() > 0)
                                            @foreach($module->teachers as $teacher)
                                                <span class="badge bg-info">{{ $teacher->first_name }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Aucun</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="/admin/modules/edit/{{ $module->id }}" class="btn btn-warning btn-sm btn-action">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="/admin/modules/{{ $module->id }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-action" 
                                                    onclick="return confirm('Supprimer ce module ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>