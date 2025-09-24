<x-layouts.app :title="__('Mis Capacitaciones')">
    <div class="min-h-screen" style="background: url('/fondodash.png') no-repeat center center fixed; background-size: cover;">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">Mis Capacitaciones</h1>
            @if($capacitaciones->isEmpty())
                <div class="mb-2 p-2 bg-blue-100 text-blue-800 rounded">No estás inscrito en ninguna capacitación.</div>
            @else
                <div class="space-y-4">
                    @foreach($capacitaciones as $capacitacion)
                        <div class="p-4 border rounded-xl bg-white dark:bg-zinc-800 flex justify-between items-center">
                            <div>
                                <div class="font-semibold text-lg">{{ $capacitacion->nombre }}</div>
                                <div>{{ $capacitacion->descripcion }}</div>
                                <div class="text-sm text-gray-500">{{ $capacitacion->fecha_inicio }} - {{ $capacitacion->fecha_fin }}</div>
                            </div>
                            <form method="POST" action="{{ route('mis-capacitaciones.eliminar', $capacitacion->id) }}" onsubmit="return confirm('¿Seguro que deseas eliminar tu inscripción a esta capacitación?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded transition-colors duration-200">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>

