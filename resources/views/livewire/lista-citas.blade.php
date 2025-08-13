<div class="flex box-border">
    <div class="container mx-auto py-4">
        <x-table-citas>
            @if (count($citas))
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vehículo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Motivo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Creación</th>                              
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($citas as $cita)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $cita->id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $cita->cliente->nombre . ' ' . $cita->cliente->apellido }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $cita->vehiculo->placa }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $cita->fecha_cita->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        @php
                                            $colors = [
                                                'aceptada' => 'bg-green-100 text-green-800',
                                                'rechazada' => 'bg-red-100 text-red-800',
                                                'pendiente' => 'bg-yellow-100 text-yellow-800'
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colors[$cita->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $cita->estado }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $cita->motivo }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $cita->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="flex justify-center items-center space-x-2">                                        
                                            {{--
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                            <button wire:click="marcarAceptada({{ $cita->id }})" class="text-green-600 hover:text-green-900">
                                                Aceptar
                                            </button>
                                            <button wire:click="marcarRechazada({{ $cita->id }})" class="text-red-600 hover:text-red-900">
                                                Rechazar
                                            </button>
                                            --}}
                                            <button wire:click="$emit('deleteContrato',{{ $cita->id }})"
                                                class="group flex py-2 px-2 text-center items-center rounded-md bg-green-700 font-bold text-white cursor-pointer hover:bg-green-800 hover:animate-pulse">
                                                <i class="fa fa-pencil"></i>
                                                <span
                                                    class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute  translate-y-full opacity-0 m-4 mx-auto z-50">
                                                    Aceptar
                                                </span>
                                            </button>
                                            <button wire:click="$emit('deleteContrato',{{ $cita->id }})"
                                                class="group flex py-2 px-2 text-center items-center rounded-md bg-red-500 font-bold text-white cursor-pointer hover:bg-red-700 hover:animate-pulse">
                                                <i class="fas fa-times-circle"></i>
                                                <span
                                                    class="group-hover:opacity-100 transition-opacity bg-gray-800 px-1 text-sm text-gray-100 rounded-md absolute  translate-y-full opacity-0 m-4 mx-auto z-50">
                                                    Rechazar
                                                </span>
                                            </button>
                                        </div>                          
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if ($citas->hasPages())
                    <div class="mt-2 bg-white px-5 py-5 border-t rounded-lg">
                        {{ $citas->links() }}
                    </div>
                @endif
            @else
                <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                    No se encontró ningún registro.
                </div>
            @endif
        </x-table-citas>
    </div>
</div>
