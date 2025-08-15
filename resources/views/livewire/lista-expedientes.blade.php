<div class="flex box-border">
    <div class="container mx-auto py-4">
        <x-table-expedientes>
            @if (count($expedientes))
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vehículo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asesor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Creación
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($expedientes as $expe)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $expe->id }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $expe->cliente->nombre . ' ' . $expe->cliente->apellido }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $expe->vehiculo->placa }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $expe->cita->asesor->name }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @php
                                            $colors = [
                                                '1' => 'bg-green-100 text-green-800',
                                                '2' => 'bg-yellow-100 text-yellow-800',
                                                '3' => 'bg-blue-100 text-blue-800',
                                                '4' => 'bg-red-100 text-red-800',
                                            ];
                                        @endphp
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colors[$expe->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ [
                                                1 => 'Por revisar',
                                                2 => 'Observado',
                                                3 => 'Aprobado',
                                                4 => 'Desaprobado',
                                            ][$expe->estado] ?? 'Desconocido' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $expe->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            <!-- Botones de acción aquí -->
                                            <a wire:click="verExpediente({{ $expe->id }})"
                                                class="py-1 px-2 text-center rounded-md bg-amber-300 font-bold text-black cursor-pointer hover:bg-amber-400">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if ($expedientes->hasPages())
                    <div class="mt-2 bg-white px-5 py-5 border-t rounded-lg">
                        {{ $expedientes->links() }}
                    </div>
                @endif
            @else
                <div class="px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                    No se encontró ningún registro.
                </div>
            @endif
        </x-table-expedientes>
    </div>

    <x-dialog-modal wire:model="open" wire:loading.attr="disabled" wire:target="">
        <x-slot name="title">
            Revision de Expediente
        </x-slot>

        <x-slot name="content">
            @if ($expedienteSeleccionado)
                <!-- Detalles del expediente -->
                <div class="mb-4  justify-between md:flex md:flex-row justify-content-center sm:block">
                    <h3 class="text-sm font-bold ">Cliente : </h3>
                    <span class="relative inline-block px-3  font-semibold text-black-900 leading-tight">
                        <span aria-hidden class="absolute inset-0 bg-lime-300 opacity-50 rounded-full"></span>
                        <span class="relative">{{ $expedienteSeleccionado->cliente->nombre }}
                            {{ $expedienteSeleccionado->cliente->apellido }}</span>
                    </span>
                    <h3 class="text-sm font-bold ">Vehiculo : </h3>
                    <span class="relative inline-block px-3  font-semibold text-black-900 leading-tight">
                        <span aria-hidden class="absolute inset-0 bg-blue-300 opacity-50 rounded-full"></span>
                        <span class="relative">{{ $expedienteSeleccionado->vehiculo->placa }}</span>
                    </span>
                    <h3 class="text-sm font-bold ">Fecha : </h3>
                    <p class="text-sm font-bold text-red-500">
                        {{ $expedienteSeleccionado->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <!-- Tipos de documento -->
                <div class="mb-4">
                    <x-label value="Tipo de documento:" />
                    <select wire:model="tipo_documento_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Seleccione...</option>
                        @foreach ($tiposDocumentos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre_tipo }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="tipo_documento_id" />
                </div>
                <!-- Selección de documento -->
                <div class="mb-4">
                    <x-label value="Archivos:" />
                    <x-input type="file" wire:model="documentoNuevo" multiple
                        accept=".jpg,.png,.jpeg,.gif,.bmp,.tif,.tiff" class="w-full" />
                    <x-input-error for="documentoNuevo" />
                    <x-input-error for="documentoNuevo.*" />
                </div>
                <div wire:loading wire:target="documentoNuevo"
                    class="my-4 w-full px-6 py-4 text-center font-bold bg-indigo-200 rounded-md">
                    Procesando sus documentos, espere un momento...
                </div>

                <!-- Galería de documentos -->
                <h1 class="pt-2  font-semibold sm:text-lg text-gray-900">Galeria de documentos:</h1>
                <hr />
                @php
                    $tieneNuevos = is_array($documentoNuevo) && count($documentoNuevo) > 0;
                    $tieneGuardados = $files && count($files) > 0;
                @endphp
                @if ($tieneGuardados || $tieneNuevos)
                    <section class="mt-4 overflow-hidden border-dotted border-2 text-gray-700">
                        <div class="px-5 py-2 mx-auto lg:px-32">
                            <div class="flex flex-wrap -m-1 md:-m-2">
                                {{-- Existentes (DB) --}}
                                @foreach ($files as $fil)
                                    <div class="flex flex-wrap w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
                                        <div class="w-full p-2 items-center justify-center">
                                            <img alt="doc"
                                                class="mx-auto object-cover object-center w-36 h-36 rounded-lg"
                                                src="{{ $fil->ruta }}">
                                            <button type="button"
                                                class="flex mx-auto mt-1 text-gray-600 hover:text-red-600"
                                                wire:click="deleteFile({{ $fil->id }})"
                                                wire:loading.attr="disabled" wire:target="deleteFile">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <p class="text-xs text-center mt-1">
                                                {{ optional($fil->tipoDocumento)->nombre_tipo }} •
                                                {{ $fil->extension }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- Nuevos (temporal) --}}
                                @if ($tieneNuevos)
                                    @foreach ($documentoNuevo as $key => $otro)
                                        <div class="flex flex-wrap w-full sm:w-1/2 md:w-1/3 lg:w-1/4">
                                            <div class="w-full p-2 items-center justify-center">
                                                <img alt="preview"
                                                    class="mx-auto object-cover object-center w-36 h-36 rounded-lg shadow-lg border-2 border-lime-500"
                                                    src="{{ $otro->temporaryUrl() }}">
                                                <button type="button"
                                                    class="flex mx-auto mt-1 text-gray-600 hover:text-red-600"
                                                    wire:click="deleteFileUpload({{ $key }})"
                                                    wire:loading.attr="disabled" wire:target="deleteFileUpload">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <p class="text-xs text-center mt-1">Nuevo</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </section>
                @else
                    <section class="h-full overflow-auto p-8 w-full flex flex-col">
                        <ul class="flex flex-1 flex-wrap -m-1">
                            <li class="h-full w-full text-center flex flex-col items-center justify-center">
                                <img class="mx-auto w-32"
                                    src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                                    alt="no data" />
                                <span class="text-sm text-gray-500">Aún no seleccionaste ningún archivo</span>
                            </li>
                        </ul>
                    </section>
                @endif
            @else
                <p class="text-gray-500">Cargando información...</p>
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)" class="mx-2">
                Cerrar
            </x-secondary-button>
            <x-button wire:click="subirDocumento" wire:loading.attr="disabled" 
            wire:target="subirDocumento,documentoNuevo,deleteFile,deleteFileUpload">
                Guardar
            </x-button>
        </x-slot>
    </x-dialog-modal>

</div>
