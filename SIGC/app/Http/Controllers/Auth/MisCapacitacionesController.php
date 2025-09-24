<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Capacitacion;

class MisCapacitacionesController extends Controller
{
    public function index()
    {
        // Usar la relación correcta 'talleres' en el modelo User
        $capacitaciones = Auth::user()->capacitaciones ?? collect();
        return view('mis-capacitaciones', compact('capacitaciones'));
    }

    public function eliminar($capacitacionId)
    {
        $user = Auth::user();
        $user->Capacitaciones()->detach($capacitacionId);
        // Disminuir el cupo_actual del taller
        $capacitacion = \App\Models\Capacitacion::find($capacitacionId);
        if ($capacitacion && $capacitacion->cupo_actual > 0) {
            $capacitacion->decrement('cupo_actual');
        }
        return redirect()->route('mis-talleres')->with('success', 'Inscripción eliminada correctamente.');
    }
}
