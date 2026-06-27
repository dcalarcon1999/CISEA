<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\LogActividad;
use App\Models\User;
use App\Http\Requests\StoreEvidenciaRequest;
use App\Http\Requests\UpdateEvidenciaRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvidenciaController extends Controller
{
    private function usuarioActual(): User
    {
        return auth()->user();
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
        $nroSiguiente = (DB::table('contadores')->where('nombre', 'nro_orden')->value('valor') ?? 0) + 1;
        $ahoraDisplay = now()->format('d/m/Y H:i:s');

        return view('evidencias.create', compact('funcionario', 'nroSiguiente', 'ahoraDisplay'));
    }

    public function store(StoreEvidenciaRequest $request)
    {
        $validated   = $request->validated();
        $funcionario = $this->usuarioActual();

        $evidencia = DB::transaction(function () use ($validated, $funcionario) {
            $contador = DB::table('contadores')
                ->where('nombre', 'nro_orden')
                ->lockForUpdate()
                ->first();

            $nroOrden = $contador->valor + 1;

            DB::table('contadores')
                ->where('nombre', 'nro_orden')
                ->update(['valor' => $nroOrden]);

            return Evidencia::create(array_merge($validated, [
                'nro_novedad'      => $nroOrden,
                'fecha_novedad'    => now(),
                'cod_funcionario'  => $funcionario->cod_funcionario,
                'grado'            => $funcionario->grado,
                'apellidos_nombre' => $funcionario->nombre_snapshot,
                'unidad'           => $funcionario->unidad,
                'operador_id'      => $funcionario->id,
                'estado'           => 'pendiente',
            ]));
        });

        $destino = auth()->user()->hasRole('operador')
            ? route('constancias.index')
            : route('evidencias.index');

        return redirect($destino)
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
        LogActividad::create([
            'evidencia_id' => $evidencia->id,
            'user_id'      => auth()->id(),
            'accion'       => 'visualizacion',
            'descripcion'  => "Visualización del registro N° {$evidencia->nro_novedad}.",
            'ip_origen'    => request()->ip(),
            'created_at'   => now(),
        ]);

        return view('evidencias.show', compact('evidencia'));
    }

    public function acta(Evidencia $evidencia)
    {
        abort_unless($evidencia->estaEntregada(), 403, 'El acta solo está disponible para registros entregados.');

        $pdf = Pdf::loadView('evidencias.acta_pdf', compact('evidencia'))
                  ->setPaper('legal', 'portrait');

        $filename = 'Acta_Entrega_N' . $evidencia->nro_novedad . '_' . now()->format('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}
