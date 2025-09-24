<div class="min-h-screen bg-black text-white p-6">
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Gestión de Capacitaciones</h1>

        @if (session()->has('success'))
            <div class="mb-4 p-2 bg-green-500 text-white rounded">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="{{ $editMode ? 'actualizarcapacitacion' : 'crearcapacitacion' }}" class="space-y-4 mb-8">
            <x-flux-input label="Temática" wire:model.defer="tematica" />
            @error('tematica')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror

            <x-flux-input label="Nombre" wire:model.defer="nombre" />
            @error('nombre')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror

            <x-flux-input label="Descripción" wire:model.defer="descripcion" textarea />
            @error('descripcion')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror

            <x-flux-select label="Modalidad" wire:model.defer="modalidad">
                <option value="presencial">Presencial</option>
                <option value="virtual">Virtual</option>
                <option value="hibrida">Híbrida</option>
            </x-flux-select>
            @error('modalidad')
                <span class="text-red-600 text-xs">{{ $message }}</span>
            @enderror

            <div class="flex gap-2">
                <div class="flex-1">
                    <x-flux-input label="Fecha inicio" type="date" wire:model.defer="fecha_inicio" />
                    @error('fecha_inicio')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex-1">
                    <x-flux-input label="Fecha fin" type="date" wire:model.defer="fecha_fin" />
                    @error('fecha_fin')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex gap-2">
                <div class="flex-1">
                    <x-flux-input label="Hora inicio" type="time" wire:model.defer="hora_inicio" />
                    @error('hora_inicio')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex-1">
                    <x-flux-input label="Hora fin" type="time" wire:model.defer="hora_fin" />
                    @error('hora_fin')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex gap-2">
                <div class="flex-1">
                    <x-flux-input label="Cupos" type="number" min="1" wire:model.defer="cupos" />
                    @error('cupos')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex-1">
                    <x-flux-input label="Imagen (URL)" wire:model.defer="imagen_destacada" />
                    @error('imagen_destacada')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex gap-2">
                <x-flux-button type="submit" color="primary">
                    {{ $editMode ? 'Actualizar capacitación' : 'Crear capacitación' }}
                </x-flux-button>
                @if ($editMode)
                    <x-flux-button type="button" color="neutral" wire:click="cancelarEdicion">Cancelar</x-flux-button>
                @endif
            </div>
        </form>

        <h2 class="text-xl font-semibold mb-2">Lista de Capacitaciones</h2>
        <div class="space-y-2">
            @forelse($capacitaciones as $capacitacion)
                <div class="p-4 border rounded bg-white dark:bg-zinc-800 text-black dark:text-white flex justify-between items-center">
                    <div>
                        <div class="font-bold">{{ $capacitacion->nombre }}</div>
                        <div class="text-sm text-gray-700 dark:text-gray-300">{{ $capacitacion->tematica }} - {{ ucfirst($capacitacion->modalidad) }}</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            {{ \Carbon\Carbon::parse($capacitacion->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($capacitacion->fecha_fin)->format('d/m/Y') }}
                        </div>
                        <div class="text-sm">Cupos disponibles: {{ $capacitacion->cupos_disponibles }} / {{ $capacitacion->cupos }}</div>
                    </div>
                    <div class="flex gap-2">
                        <x-flux-button color="warning" wire:click="editarcapacitacion({{ $capacitacion->id }})">Editar</x-flux-button>
                        <x-flux-button color="danger" wire:click="eliminarcapacitacion({{ $capacitacion->id }})"
                            onclick="return confirm('¿Seguro que deseas eliminar esta capacitación?')">Eliminar</x-flux-button>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500">No hay capacitaciones registradas.</div>
            @endforelse
        </div>
    </div>
</div>
