<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'cod_funcionario' => ['required', 'string'],
            'password'        => ['required', 'string'],
        ], [
            'cod_funcionario.required' => 'El Código de Funcionario es obligatorio.',
            'password.required'        => 'La contraseña es obligatoria.',
        ]);

        $cod = strtoupper(trim($credentials['cod_funcionario']));

        if (Auth::attempt(['cod_funcionario' => $cod, 'password' => $credentials['password']], false)) {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return back()
            ->withInput($request->only('cod_funcionario'))
            ->withErrors(['cod_funcionario' => 'Código de Funcionario o contraseña incorrectos.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
