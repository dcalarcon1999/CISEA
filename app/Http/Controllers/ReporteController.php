<?php

namespace App\Http\Controllers;

use App\Models\Constancia;
use App\Models\Evidencia;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        // --- Evidencias ---
        $qEv = Evidencia::query();

        if ($request->filled('fecha_desde')) {
            $qEv->whereDate('fecha_novedad', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $qEv->whereDate('fecha_novedad', '<=', $request->fecha_hasta);
        }
        if ($request->filled('estado')) {
            $qEv->where('estado', $request->estado);
        }
        if ($request->filled('motivo')) {
            $qEv->where('motivo', $request->motivo);
        }
        if ($request->filled('buscar')) {
            $q = $request->buscar;
            $qEv->where(function ($sub) use ($q) {
                $sub->where('apellidos_nombre', 'like', "%$q%")
                    ->orWhere('cod_funcionario',  'like', "%$q%")
                    ->orWhere('motivo_nro',        'like', "%$q%")
                    ->orWhere('estamento_solicitante', 'like', "%$q%");
            });
        }

        $evidencias = $qEv->orderBy('fecha_novedad', 'desc')
                          ->paginate(10, ['*'], 'pe')
                          ->withQueryString();

        // --- Constancias ---
        $qCo = Constancia::query();

        if ($request->filled('fecha_desde')) {
            $qCo->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $qCo->whereDate('created_at', '<=', $request->fecha_hasta);
        }
        if ($request->filled('buscar')) {
            $q = $request->buscar;
            $qCo->where(function ($sub) use ($q) {
                $sub->where('apellidos_nombre', 'like', "%$q%")
                    ->orWhere('cod_funcionario',  'like', "%$q%")
                    ->orWhere('descripcion',       'like', "%$q%");
            });
        }

        $constancias = $qCo->orderBy('nro_orden', 'desc')
                           ->paginate(10, ['*'], 'pc')
                           ->withQueryString();

        // --- KPIs (sin filtros para reflejar totales globales) ---
        $kpis = [
            'total_evidencias'    => Evidencia::count(),
            'pendientes'          => Evidencia::where('estado', 'pendiente')->count(),
            'entregadas'          => Evidencia::where('estado', 'entregado')->count(),
            'constancias_mes'     => Constancia::whereMonth('created_at', now()->month)
                                               ->whereYear('created_at',  now()->year)
                                               ->count(),
        ];

        return view('reportes.index', compact('evidencias', 'constancias', 'kpis'));
    }
}
