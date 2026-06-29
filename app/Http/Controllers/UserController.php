<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('apellidos')->paginate(15);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cod_funcionario' => 'required|string|max:20|unique:users',
            'apellidos'       => 'required|string|max:80',
            'nombres'         => 'required|string|max:80',
            'grado'           => 'required|string|max:60',
            'unidad'          => 'required|string|max:120',
            'rol'             => ['required', Rule::in(['operador', 'sip', 'jefatura', 'auditor'])],
            'email'           => 'required|email|unique:users',
            'password'        => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'cod_funcionario' => $data['cod_funcionario'],
            'apellidos'       => strtoupper($data['apellidos']),
            'nombres'         => mb_convert_case(strtolower($data['nombres']), MB_CASE_TITLE, 'UTF-8'),
            'name'            => strtoupper($data['apellidos']) . ' ' . strtoupper($data['nombres']),
            'grado'           => strtoupper($data['grado']),
            'unidad'          => strtoupper($data['unidad']),
            'rol'             => $data['rol'],
            'email'           => $data['email'],
            'password'        => Hash::make($data['password']),
            'rut'             => '00000000-0',
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Funcionario registrado correctamente.');
    }

    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $data = $request->validate([
            'apellidos' => 'required|string|max:80',
            'nombres'   => 'required|string|max:80',
            'grado'     => 'required|string|max:60',
            'unidad'    => 'required|string|max:120',
            'rol'       => ['required', Rule::in(['operador', 'sip', 'jefatura', 'auditor'])],
            'email'     => ['required', 'email', Rule::unique('users')->ignore($usuario->id)],
            'password'  => 'nullable|string|min:8|confirmed',
        ]);

        $usuario->apellidos = strtoupper($data['apellidos']);
        $usuario->nombres   = mb_convert_case(strtolower($data['nombres']), MB_CASE_TITLE, 'UTF-8');
        $usuario->name      = strtoupper($data['apellidos']) . ' ' . strtoupper($data['nombres']);
        $usuario->grado     = strtoupper($data['grado']);
        $usuario->unidad    = strtoupper($data['unidad']);
        $usuario->rol       = $data['rol'];
        $usuario->email     = $data['email'];

        if (!empty($data['password'])) {
            $usuario->password = Hash::make($data['password']);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')
            ->with('success', 'Datos del funcionario actualizados.');
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puede eliminar su propia cuenta.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Funcionario eliminado del sistema.');
    }
}
