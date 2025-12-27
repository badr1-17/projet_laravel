<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()  //elle affiche la page du formulaire 
    {
        return view('auth.login');
    }
    
    public function login(Request $request)  //la connexion
    {
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:admin,teacher'
        ]);
        
        // Vérifier les identifiants 
        $email = $request->email;
        $password = $request->password;
        

        $user = User::where('email', $email)->first();
        
        if (!$user) {
            // Créer un utilisateur de test
            $name = explode('@', $email)[0];
            $user = User::create([
                'name' => ucfirst($name),
                'email' => $email,
                'password' => bcrypt($password),
                'role' => $request->role
            ]);
        }
        
        // Stocker en session
        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role
        ]);
        
        // Redirection selon le rôle
        if ($request->role === 'admin') {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/teacher/dashboard');
        }   
    }
    
    public function logout()  //deconnexion 
    {
        session()->flush();
        return redirect('/login');
    }
}