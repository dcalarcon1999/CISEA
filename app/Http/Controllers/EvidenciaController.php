<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\User;
use App\Http\Requests\StoreEvidenciaRequest;
use App\Http\Requests\UpdateEvidenciaRequest;
use Illuminate\Http\Request;

class EvidenciaController extends Controller
{
    private function usuarioActual(): User
    {
        return auth()->user() ?? User::where('rol', 'operador')->firstOrFail();
    }

    public function index(Request $request)
    {
        $query = Evidencia::query();

        if ($request->filled('buscar')) {
            $q = $request->buscar;
            $query->where(function ($sub) use ($q) {
                $sub->where('nro_novedad',       'like', "%$q%")
                    ->orWhere('apellidos_nombre', 'like', "%$q%")
                    ->orWhere('motivo_nro',       'like', "%$q%");
            });
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_novedad', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_novedad', '<=', $request->fecha_hasta);
        }

        $evidencias = $query->latest('fecha_novedad')->paginate(20);

        return view('evidencias.index', compact('evidencias'));
    }

    public function create()
    {
        $funcionario  = $this->usuarioActual();
        $nroSiguiente = (Evidencia::max('nro_novedad') ?? 0) + 1;
        $ahoraDisplay = now()->format('d/m/Y H:i:s');

        return view('evidencias.create', compact('funcionario', 'nroSiguiente', 'ahoraDisplay'));
    }

    public function store(StoreEvidenciaRequest $request)
    {
        $funcionario = $this->usuarioActual();

        $evidencia = Evidencia::create(array_merge($request->validated(), [
            'nro_novedad'      => (Evidencia::max('nro_novedad') ?? 0) + 1,
            'fecha_novedad'    => now(),
            'cod_funcionario'  => $funcionario->cod_funcionario,
            'grado'            => $funcionario->grado,
            'apellidos_nombre' => $funcionario->nombre_snapshot,
            'unidad'           => $funcionario->unidad,
            'operador_id'      => $funcionario->id,
            'estado'           => 'pendiente',
        ]));

        return redirect()
            ->route('evidencias.index')
            ->with('success', "Novedad N° {$evidencia->nro_novedad} registrada. Pendiente de completar Oficio de Entrega.");
    }

    // Solo accesible si la novedad está pendiente
    public function edit(Evidencia $evidencia)
    {
        if ($evidencia->estaEntregada()) {
            return redirect()
                ->route('evidencias.show', $evidencia)
                ->with('info', 'Esta novedad ya fue entregada y no puede modificarse.');
        }

        return view('evidencias.edit', compact('evidencia'));
    }

    // Completa la Sección 4 y bloquea el registro
    public function update(UpdateEvidenciaRequest $request, Evidencia $evidencia)
    {
        if ($evidencia->estaEntregada()) {
            return redirect()
                ->route('evidencias.show', $evidencia)
                ->with('info', 'Esta novedad ya fue entregada y no puede modificarse.');
        }

        $evidencia->update(array_merge($request->validated(), [
            'estado' => 'entregado',
        ]));

        return redirect()
            ->route('evidencias.show', $evidencia)
            ->with('success', "Novedad N° {$evidencia->nro_novedad} completada y bloqueada.");
    }

    public function show(Evidencia $evidencia)
    {
        return view('evidencias.show', compact('evidencia'));
    }
}
