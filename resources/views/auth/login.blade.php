<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Plateforme Éducative</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 100%;
        }
        .role-btn {
            width: 100%;
            padding: 15px;
            border: 2px solid #dee2e6;
            background: white;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s;
            font-weight: 500;
        }
        .role-btn.active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        .password-requirements {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }
        .form-control:invalid {
            border-color: #dc3545;
        }
        .form-control:valid {
            border-color: #28a745;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 class="text-center mb-4">
            <i class="fas fa-graduation-cap"></i>
            Plateforme Éducative
        </h2>
        
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Rôle</label>
                <div class="d-flex gap-2">
                    <button type="button" class="role-btn active" data-role="admin">
                        <i class="fas fa-user-shield"></i> Administrateur
                    </button>
                    <button type="button" class="role-btn" data-role="teacher">
                        <i class="fas fa-chalkboard-teacher"></i> Professeur
                    </button>
                </div>
                <input type="hidden" name="role" id="roleInput" value="admin">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="exemple@email.com" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" 
                       placeholder="Votre mot de passe" 
                       minlength="8"
                       pattern=".{8,}"
                       title="Le mot de passe doit contenir au moins 8 caractères"
                       required>
                <div class="password-requirements">
                    <small><i class="fas fa-info-circle"></i> Le mot de passe doit contenir au moins 8 caractères</small>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </button>
        </form>
    </div>

    <script>
        document.querySelectorAll('.role-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.role-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('roleInput').value = this.dataset.role;
            });
        });

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const passwordInput = document.querySelector('input[name="password"]');
            const password = passwordInput.value;
            
            if (password.length < 8) {
                e.preventDefault();
                alert('Le mot de passe doit contenir au moins 8 caractères.');
                passwordInput.focus();
                passwordInput.classList.add('is-invalid');
            } else {
                passwordInput.classList.remove('is-invalid');
                passwordInput.classList.add('is-valid');
            }
        });

        document.querySelector('input[name="password"]').addEventListener('input', function(e) {
            const password = e.target.value;
            if (password.length < 8 && password.length > 0) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (password.length >= 8) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.remove('is-valid');
            }
        });
    </script>
</body>
</html>