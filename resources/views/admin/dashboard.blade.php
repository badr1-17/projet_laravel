<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
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
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            text-align: center;
        }
        .stat-card i {
            font-size: 40px;
            color: #667eea;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-3">
            <h4><i class="fas fa-graduation-cap"></i> Plateforme Admin</h4>
            <p class="text-muted small">Connecté en tant qu'admin</p>
        </div>
        <a href="/admin/dashboard" class="active"><i class="fas fa-tachometer-alt"></i> Tableau de bord</a>
        <a href="/admin/teachers"><i class="fas fa-chalkboard-teacher"></i> Professeurs</a>
        <a href="/admin/filieres"><i class="fas fa-university"></i> Filières</a>
        <a href="/admin/groupes"><i class="fas fa-users"></i> Groupes</a>
        <a href="/admin/modules"><i class="fas fa-book"></i> Modules</a>
        <a href="{{ route('logout') }}" style="margin-top: auto;"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </div>

    
    <div class="main-content">
        <h2 class="mb-4"><i class="fas fa-tachometer-alt"></i> Tableau de bord Administrateur</h2>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="row">
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <h3>{{ $stats['teachers'] }}</h3>
                    <p>Professeurs</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-university"></i>
                    <h3>{{ $stats['filieres'] }}</h3>
                    <p>Filières</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h3>{{ $stats['groupes'] }}</h3>
                    <p>Groupes</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <i class="fas fa-book"></i>
                    <h3>{{ $stats['modules'] }}</h3>
                    <p>Modules</p>
                </div>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-info-circle"></i> Actions rapides</h5>
                <div class="d-flex gap-2">
                    <a href="/admin/teachers" class="btn btn-primary"><i class="fas fa-plus"></i> Ajouter un professeur</a>
                    <a href="/admin/filieres" class="btn btn-success"><i class="fas fa-plus"></i> Ajouter une filière</a>
                    <a href="/admin/modules" class="btn btn-info"><i class="fas fa-plus"></i> Ajouter un module</a>
                     <a href="/admin/groupes" class="btn btn-info"><i class="fas fa-plus"></i> Ajouter un groupe</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>