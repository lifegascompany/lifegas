<!-- resources>views>livewire>lista-conversiones.blade.php -->
<div class="flex box-border">
    <div class="container mx-auto py-4">
        <x-custom-table>
            <x-slot name="titulo">
                <h2 class="text-gray-600 font-semibold text-2xl">Conversiones</h2>
                <span class="text-xs text-gray-500">Todos los registros de conversión</span>
            </x-slot>
            <x-slot name="btnAgregar">
                <button wire:click=""
                    class="bg-slate-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer">Agregar</button>
            </x-slot>
            <x-slot name="contenido">
                <!-- Contenido de la tabla aquí -->
                @if (count($conversiones))
                    <div class="overflow-x-auto bg-white rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vehículo
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asesor
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tecnico
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Creación
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($conversiones as $conve)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $conve->id ?? null }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                            {{ $conve->expediente->cliente->nombre . ' ' . $conve->expediente->cliente->apellido }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $conve->expediente->vehiculo->placa ?? null }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $conve->expediente->cita->asesor->name ?? null }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $conve->expediente->tecnico->name ?? 'No Asignado' }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            @php
                                                $colors = [
                                                    'en_proceso' => 'bg-yellow-100 text-yellow-800',
                                                    'completado' => 'bg-red-100 text-red-800',
                                                    'certificado' => 'bg-red-100 text-red-800',
                                                ];
                                                $labels = [
                                                    'en_proceso' => 'En Proceso',
                                                    'completado' => 'Completado',
                                                    'certificado' => 'Certficado',
                                                ];
                                            @endphp
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colors[$conve->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $labels[$conve->estado] ?? 'Desconocido' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $conve->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="flex justify-center items-center space-x-2">
                                                <!-- Botones de acción aquí -->
                                                <a wire:click="redirectToSolicitudRepuestos({{ $conve->id }})"
                                                    class="py-1 px-2 text-center rounded-md bg-green-200 font-bold text-black cursor-pointer hover:bg-green-300">
                                                    <i class="fa-solid fa-cart-plus"></i>
                                                </a>
                                                <a wire:click=""
                                                    class="py-1 px-2 text-center rounded-md bg-red-500 font-bold text-black cursor-pointer hover:bg-red-600">
                                                    <i class="fa-solid fa-sheet-plastic"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if ($conversiones->hasPages())
                        <div class="mt-2 bg-white px-5 py-5 border-t rounded-lg">
                            {{ $conversiones->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-6 py-4 text-center font-bold bg-teal-100 rounded-md">
                        No se encontró ningún registro.
                    </div>
                @endif
            </x-slot>
        </x-custom-table>
    </div>
</div>
