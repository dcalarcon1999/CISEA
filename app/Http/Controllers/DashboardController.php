<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return match(auth()->user()->rol) {
            'operador' => redirect()->route('constancias.index'),
            'sip'      => redirect()->route('constancias.index'),
            'jefatura' => redirect()->route('reportes.index'),
            'auditor'  => redirect()->route('auditoria.index'),
            default    => redirect()->route('login'),
        };
    }

    public function operador()
    {
        return view('operador.panel');
    }

    public function reportes()
    {
        return view('reportes.index');
    }

    public function auditoria()
    {
        return view('auditoria.index');
    }
}
