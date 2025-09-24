<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Capacitacion;

class MisCapacitacionesController extends Controller
{
    public function index()
    {
        // Obtener el usuario autenticado.
        $user = Auth::user();

        // Si el usuario existe, obtener sus capacitaciones. Si no, devolver una colección vacía.
        $capacitaciones = $user ? $user->capacitaciones : collect();

        return view('mis-capacitaciones', compact('capacitaciones'));
    }

    public function eliminar($capacitacionId)
    {
        $user = Auth::user();

        // Usar el nombre de relación correcto en minúsculas.
        $user->capacitaciones()->detach($capacitacionId);

        // Disminuir el cupo_actual de la capacitación.
        $capacitacion = Capacitacion::find($capacitacionId);
        if ($capacitacion && $capacitacion->cupo_actual > 0) {
            $capacitacion->decrement('cupo_actual');
        }

        // Redirigir a la ruta correcta.
        return redirect()->route('mis-capacitaciones')->with('success', 'Inscripción eliminada correctamente.');
    }
}
