<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Capacitacion; // Se cambió Taller por Capacitacion

class CapacitacionAdmin extends Component
{
    // Propiedades adaptadas a tu modelo de Capacitacion
    public $tematica;
    public $nombre;
    public $descripcion;
    public $modalidad;
    public $fecha_inicio;
    public $fecha_fin;
    public $hora_inicio;
    public $hora_fin;
    public $cupos;
    public $imagen_destacada;
    public $capacitacion_id; // Se cambió taller_id por capacitacion_id
    public $editMode = false;

    protected $rules = [
        'tematica' => 'required|string|max:255',
        'nombre' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'modalidad' => 'required|in:presencial,virtual,hibrida',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'hora_inicio' => 'nullable', // Se hizo opcional si no es siempre necesario
        'hora_fin' => 'nullable', // Se hizo opcional si no es siempre necesario
        'cupos' => 'required|integer|min:1',
        'imagen_destacada' => 'nullable|string',
    ];

    public function crearCapacitacion()
    {
        $this->validate();
        Capacitacion::create([
            'tematica' => $this->tematica,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'modalidad' => $this->modalidad,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'cupos' => $this->cupos,
            'cupos_disponibles' => $this->cupos, // Se inicializan los cupos disponibles
            'imagen_destacada' => $this->imagen_destacada,
        ]);
        $this->resetForm();
        session()->flash('success', 'Capacitación creada correctamente.');
    }

    public function editarCapacitacion($id)
    {
        $capacitacion = Capacitacion::findOrFail($id);
        $this->capacitacion_id = $capacitacion->id;
        $this->tematica = $capacitacion->tematica;
        $this->nombre = $capacitacion->nombre;
        $this->descripcion = $capacitacion->descripcion;
        $this->modalidad = $capacitacion->modalidad;
        $this->fecha_inicio = $capacitacion->fecha_inicio;
        $this->fecha_fin = $capacitacion->fecha_fin;
        $this->hora_inicio = $capacitacion->hora_inicio;
        $this->hora_fin = $capacitacion->hora_fin;
        $this->cupos = $capacitacion->cupos;
        $this->imagen_destacada = $capacitacion->imagen_destacada;
        $this->editMode = true;
    }

    public function actualizarCapacitacion()
    {
        $this->validate();
        $capacitacion = Capacitacion::findOrFail($this->capacitacion_id);
        $capacitacion->update([
            'tematica' => $this->tematica,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'modalidad' => $this->modalidad,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'cupos' => $this->cupos,
            'imagen_destacada' => $this->imagen_destacada,
        ]);
        $this->resetForm();
        session()->flash('success', 'Capacitación actualizada correctamente.');
    }

    public function eliminarCapacitacion($id)
    {
        Capacitacion::destroy($id);
        session()->flash('success', 'Capacitación eliminada correctamente.');
    }

    public function cancelarEdicion()
    {
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset([
            'tematica',
            'nombre',
            'descripcion',
            'modalidad',
            'fecha_inicio',
            'fecha_fin',
            'hora_inicio',
            'hora_fin',
            'cupos',
            'imagen_destacada',
            'capacitacion_id',
            'editMode'
        ]);
    }

    public function render()
    {
        $capacitaciones = Capacitacion::latest()->get();
        return view('livewire.admin.capacitaciones-admin', compact('capacitaciones'));
    }
}
