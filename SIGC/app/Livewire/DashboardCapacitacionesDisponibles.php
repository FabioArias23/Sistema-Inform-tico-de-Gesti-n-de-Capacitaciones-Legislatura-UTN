<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Capacitacion;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\Auth;

class DashboardCapacitacionesDisponibles extends Component
{
    public $capacitacionesDisponibles = [];
    public $inscripciones = [];

    public function mount()
    {
        $this->actualizarListas();
    }

    public function inscribirse($tallerId)
    {
        $user = Auth::user();
        if (!$user) return;
        // Evitar inscripciones duplicadas
        if (Inscripcion::where('user_id', $user->id)->where('capacitacion_id', $tallerId)->exists()) {
            session()->flash('error', 'Ya estás inscrito en este taller.');
            return;
        }
        // Actualizar cupo_actual
        $taller = Capacitacion::find($tallerId);
        if ($taller->cupo_actual >= $taller->cupo_maximo) {
            session()->flash('error', 'El taller ya no tiene cupo disponible.');
            return;
        }
        Inscripcion::create([
            'user_id' => $user->id,
            'taller_id' => $tallerId,
        ]);
        $taller->increment('cupo_actual');
        session()->flash('success', 'Inscripción realizada correctamente.');
        $this->actualizarListas();
    }

    public function actualizarListas()
    {
        $user = Auth::user();
        $this->inscripciones = Inscripcion::where('user_id', $user->id ?? 0)->pluck('capacitacion_id')->toArray();
        $this->capacitacionesDisponibles = Capacitacion::whereColumn('cupo_actual', '<', 'cupo_maximo')->get();
    }

    public function render()
    {
        return view('livewire.dashboard-capacitaciones-disponibles', [
            'capacitacionesDisponibles' => $this->capacitacionesDisponibles,
            'inscripciones' => $this->inscripciones,
        ]);
    }
}
