<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConstanciaRequest;
use App\Models\Constancia;
use App\Models\Evidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConstanciaController extends Controller
{
    public function index(Request $request)
    {
        $qConstancias = Constancia::query();

        if ($request->filled('fecha_desde')) {
            $qConstancias->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $qConstancias->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        $constancias  = $qConstancias->orderBy('nro_orden', 'desc')->paginate(10, ['*'], 'pc')->withQueryString();
        $nroSiguiente = (DB::table('contadores')->where('nombre', 'nro_orden')->value('valor') ?? 0) + 1;

        $evidencias = null;
        if (auth()->user()->rol === 'sip') {
            $qEvidencias = Evidencia::query();
            if ($request->filled('fecha_desde')) {
                $qEvidencias->whereDate('fecha_novedad', '>=', $request->fecha_desde);
            }
            if ($request->filled('fecha_hasta')) {
                $qEvidencias->whereDate('fecha_novedad', '<=', $request->fecha_hasta);
            }
            $evidencias = $qEvidencias->orderBy('nro_novedad', 'desc')->paginate(10, ['*'], 'pe')->withQueryString();
        }

        return view('operador.panel', compact('constancias', 'evidencias', 'nroSiguiente'));
    }

    public function store(StoreConstanciaRequest $request)
    {
        $funcionario = auth()->user();

        $constancia = DB::transaction(function () use ($request, $funcionario) {
            $contador = DB::table('contadores')
                ->where('nombre', 'nro_orden')
                ->lockForUpdate()
                ->first();

            $nroOrden = $contador->valor + 1;

            DB::table('contadores')
                ->where('nombre', 'nro_orden')
                ->update(['valor' => $nroOrden]);

            return Constancia::create([
                'nro_orden'        => $nroOrden,
                'cod_funcionario'  => $funcionario->cod_funcionario,
                'grado'            => $funcionario->grado,
                'apellidos_nombre' => $funcionario->nombre_snapshot,
                'unidad'           => $funcionario->unidad,
                'descripcion'      => $request->validated()['descripcion'],
                'operador_id'      => $funcionario->id,
                'created_at'       => now(),
            ]);
        });

        return redirect()
            ->route('constancias.index')
            ->with('success', "Constancia N° {$constancia->nro_orden} registrada correctamente.");
    }
}
