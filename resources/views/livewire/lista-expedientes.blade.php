<!-- resources/views/livewire/lista-expedientes.blade.php -->
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tecnico</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Creación</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($expedientes as $expe)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $expe->id ?? NULL }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $expe->cliente->nombre . ' ' . $expe->cliente->apellido }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $expe->vehiculo->placa ?? NULL }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $expe->cita->asesor->name ?? NULL }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $expe->tecnico->name ?? 'No Asignado' }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @php
                                            $colors = [
                                                'en_evaluacion'         => 'bg-yellow-100 text-yellow-800',
                                                'evaluacion_rechazada'  => 'bg-red-100 text-red-800',
                                                'aprobado_conversion'   => 'bg-blue-100 text-blue-800',
                                                'en_conversion'         => 'bg-indigo-100 text-indigo-800',
                                                'conversion_completada' => 'bg-green-100 text-green-800',
                                                'en_control_calidad'    => 'bg-purple-100 text-purple-800',
                                                'listo_para_entrega'    => 'bg-teal-100 text-teal-800',
                                                'entregado'             => 'bg-green-100 text-green-800',
                                                'cancelado'             => 'bg-red-100 text-red-800',
                                            ];
                                            $labels = [
                                                'en_evaluacion'         => 'En Evaluación',
                                                'evaluacion_rechazada'  => 'Evaluación Rechazada',
                                                'aprobado_conversion'   => 'Aprobado para Conversión',
                                                'en_conversion'         => 'En Conversión',
                                                'conversion_completada' => 'Conversión Completada',
                                                'en_control_calidad'    => 'En Control de Calidad',
                                                'listo_para_entrega'    => 'Listo para Entrega',
                                                'entregado'             => 'Entregado',
                                                'cancelado'             => 'Cancelado',
                                            ];
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $colors[$expe->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $labels[$expe->estado] ?? 'Desconocido' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $expe->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            <!-- Botones de acción aquí -->
                                            <a wire:click="verExpediente({{ $expe->id }})"
                                                class="py-1 px-2 text-center rounded-md bg-amber-300 font-bold text-black cursor-pointer hover:bg-amber-400">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a wire:click="verEvaluacion({{ $expe->id }})"
                                                class="py-1 px-2 text-center rounded-md bg-green-200 font-bold text-black cursor-pointer hover:bg-green-300">
                                                <i class="fa-solid fa-car-side"></i>
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
                <div class="px-6 py-4 text-center font-bold bg-teal-100 rounded-md">
                    No se encontró ningún registro.
                </div>
            @endif
        </x-table-expedientes>
    </div>

    <!-- Modal para ver y subir documentos y asignar tecnico -->
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

                <!-- Asignación de técnico -->
                <div class="mb-4">
                    <x-label value="Asignar Tecnico:" />
                    <select wire:model="tecnico_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        <option value="">Seleccione...</option>
                        @foreach ($tecnicos as $tec)
                            <option value="{{ $tec->id }}">{{ $tec->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="tecnico_id" />
                </div>

                <span class="text-sm text-gray-500">Revisar todos los tipo de documentos y de que forma se cargaran , todo junto o sectorizado.</span>
                <!-- Tipos de documento -->
                <div class="mb-4">
                    <x-label value="Tipo de documento:" />
                    <select wire:model="tipo_documento_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md">
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
                    class="my-4 w-full px-6 py-4 text-center font-bold bg-teal-100 rounded-md">
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

    <!-- Modal para registrar evaluacion -->
    <x-dialog-modal wire:model="openevaluar" wire:loading.attr="disabled" wire:target="" maxWidth="4xl">
        <x-slot name="title">
            <h2 class="text-lg font-bold text-center">FICHA DE RECEPCIÓN DEL VEHÍCULO</h2>
        </x-slot>

        <x-slot name="content">
            <!-- OPCIONES -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-2 text-sm mb-4">
                <label class="flex items-center space-x-1">
                    <input type="checkbox"
                        class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600"
                        wire:model="instalacion">
                    <span>Instalación</span>
                </label>
                <label class="flex items-center space-x-1">
                    <input type="checkbox"
                        class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600"
                        wire:model="cambio_tanque">
                    <span>Cambio de tanque</span>
                </label>
                <label class="flex items-center space-x-1">
                    <input type="checkbox"
                        class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600"
                        wire:model="revision">
                    <span>Revisión quinquenal</span>
                </label>
                <label class="flex items-center space-x-1">
                    <input type="checkbox"
                        class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600"
                        wire:model="certificacion">
                    <span>Certificación</span>
                </label>
                <label class="flex items-center space-x-1">
                    <input type="checkbox"
                        class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600"
                        wire:model="servicio">
                    <span>Servicio</span>
                </label>
            </div>
            <!-- SEPARADOR -->
            <div class="border-t border-gray-300 pt-4"></div>
            <!-- CLIENTE Y DNI -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm mb-2">
                <div class="flex items-center col-span-2">
                    <x-label value="Cliente / Propietario:" class="mr-2"/>
                    <x-input wire:model="cliente" class="flex-1" />
                </div>
                <div class="flex items-center">
                    <x-label value="DNI:" class="mr-2"/>
                    <x-input wire:model="dni" class="flex-1" />
                </div>
            </div>
            <!-- DATOS DE CLIENTE Y VEHICULO -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[36%_36%_22%] gap-6">
                <div class="space-y-2">
                    <div class="flex items-center">
                        <!--span class="w-24">Teléf. Fijo:</span-->
                        <x-label value="Teléf. Fijo:" class="w-24 mr-2"/>
                        <x-input wire:model="telefono_fijo" class="flex-1" />
                    </div>
                    <div class="flex items-center">
                        <!--span class="w-24">Placa Actual:</span-->
                        <x-label value="Placa Actual:" class="w-24 mr-2"/>
                        <x-input wire:model="placa_actual" class="flex-1" />
                    </div>
                    <div class="flex items-center">
                        <!--span class="w-24">Marca:</span-->
                        <x-label value="Marca:" class="w-24 mr-2"/>
                        <x-input wire:model="marca" class="flex-1" />
                    </div>
                    <div class="flex items-center">
                        <!--span class="w-24">Modelo:</span-->
                        <x-label value="Modelo:" class="w-24 mr-2"/>
                        <x-input wire:model="modelo" class="flex-1" />
                    </div>
                    <div class="flex items-center">
                        <!--span class="w-24">Año:</span-->
                        <x-label value="Año:" class="w-24 mr-2"/>
                        <x-input wire:model="anio" class="flex-1" />
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <!--span class="w-24">Teléf. Móvil:</span-->
                        <x-label value="Teléf. Móvil:" class="w-24 mr-2"/>
                        <x-input wire:model="telefono_movil" class="flex-1" />
                    </div>
                    <div class="flex items-center">
                        <!--span class="w-24">Placa Anterior:</span-->
                        <x-label value="Placa Anterior:" class="w-24 mr-2"/>
                        <x-input wire:model="placa_anterior" class="flex-1" />
                    </div>
                    <div class="flex items-center">
                        <!--span class="w-24">N° Motor:</span-->
                        <x-label value="N° Motor:" class="w-24 mr-2"/>
                        <x-input wire:model="motor" class="flex-1" />
                    </div>
                    <div class="flex items-center">
                        <!--span class="w-24">Color:</span-->
                        <x-label value="Color:" class="w-24 mr-2"/>
                        <x-input wire:model="color" class="flex-1" />
                    </div>
                    <div class="flex items-center">
                        <!--span class="w-24">Combustible:</span-->
                        <x-label value="Combustible:" class="w-24 mr-2"/>
                        <x-input wire:model="combustible" class="flex-1" />
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="border border-gray-300 rounded p-3 text-sm">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" wire:model="inyectado"
                                class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600">
                            <span>Inyectado</span>
                        </label>
                        <label class="mt-2 flex items-center space-x-2">
                            <input type="checkbox" wire:model="carburado"
                                class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600">
                            <span>Carburado</span>
                        </label>
                        <label class="mt-2 flex items-center space-x-2">
                            <input type="checkbox" wire:model="monopunto"
                                class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600">
                            <span>Monopunto</span>
                        </label>
                        <div class="flex items-center">
                            <!--span>Motor de:</span-->
                            <x-label value="Motor de:" class="mr-2"/>
                            <x-input wire:model="motor_tipo" class="w-20" />
                        </div>
                        <div class="mt-2 flex items-center space-x-2">
                            <span>3CIL</span> <input type="checkbox" wire:model="cil3"
                                class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600">
                            <input type="checkbox" wire:model=""
                                class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600"><span>.........CIL</span>
                            <input type="checkbox" wire:model=""
                                class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600">
                        </div>
                    </div>
                    <div class="">
                        <!--span class="w-24">Kilometraje:</span-->
                        <x-label value="Kilometraje:" class=""/>
                        <x-input wire:model="kilometraje" class="flex-1" />
                    </div>
                </div>
            </div>
            <!-- Tabla checklist -->
            {{-- 
            <div class="flex flex-col md:flex-row mt-4 border rounded-lg">
                <!-- 1° Columna -->
                <div class="flex-1 border-r border-gray-300 flex flex-col justify-between text-center">
                    <div class="p-4">
                        <h2 class="text-lg font-bold mb-4">ORDEN DE TRABAJO</h2>
                        <p>Nº ..........................................</p>
                    </div>
                    <div class="mt-4 border-t border-gray-300"></div>
                    <div class="p-4">
                        <p class="text-sm mt-8">Con la presente yo y/o en representación autorizo el trabajo a
                            realizarse en mi vehículo</p>
                    </div>
                    <div class="mt-auto p-4">
                        <div class="mt-8 border-b border-gray-500 pb-2"></div>
                        <p class="text-xs mt-2">FIRMA AUTORIZADA<br>(CLIENTE)</p>
                        <div class="mt-28 border-b border-gray-500 pb-2"></div>
                        <p class="text-xs mt-2">RECIBÍ CONFORME<br>(CLIENTE)</p>
                    </div>
                </div>
                <!-- 2° Columna -->
                <div class="flex-1 p-4 border-r border-gray-300 flex flex-col items-center justify-between">
                    <div class="mt-16">
                        <img src="{{ asset('images/carro.png') }}" alt="Medidor de gasolina"
                            class="">
                    </div>
                </div>
                <!-- 3° Columna -->
                <div class="flex-1">
                    <div class="grid grid-cols-[3fr_1fr_1fr] text-xs border-b border-gray-300">
                        <div class="text-left px-4"></div>
                        <div class="text-center border-l border-r border-gray-300">SI</div>
                        <div class="text-center">NO</div>
                    </div>

                    @php
                        $accesorios = [
                            'Tarjeta de propiedad',
                            'SOAT',
                            'Llave de contacto',
                            'Espejos',
                            'Antena',
                            'Plumillas',
                            'Vasos',
                            'Emblemas',
                            'Tapa Combustible',
                            'Batería',
                            'Seguro de Batería',
                            'Claxon',
                            'Tapa Aceite',
                            'Tapa Radiador',
                            'Barita de Capot',
                            'Espejo Anterior',
                            'Tapasoles',
                            'Radio',
                            'Reproductor de CD',
                            'Parlantes',
                            'Cenicero',
                            'Encendedor',
                            'Pisos',
                            'Fundas o Forros',
                            'Cinturones',
                            'Llanta de Repuesto',
                            'Gata y Palanca',
                            'Llave de Ruedas',
                            'Triángulo',
                            'Extintor',
                            'Linterna',
                            'Herramientas',
                            'Botiquín',
                        ];
                    @endphp

                    @foreach ($accesorios as $accesorio)
                        <div class="grid grid-cols-[3fr_1fr_1fr] text-xs border-b border-gray-200 last:border-b-0">
                            <div class="px-4">{{ $accesorio }}</div>
                            <div class="text-center border-l border-r border-gray-300">
                                <input type="checkbox"
                                    class="w-3 h-3 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600">
                            </div>
                            <div class="text-center">
                                <input type="checkbox"
                                    class="w-3 h-3 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none focus:ring-slate-600">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            --}}

            <!-- PARA CREAR EVALUACION -->
            <div class="flex items-center mt-2">
                <x-label value="Resultado:" class="mr-2"/>
                <!--x-input wire:model="" class="flex-1" /-->
                <select wire:model="resultado" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="">Seleccione...</option>
                        <option value="apto">Apto</option>
                        <option value="no apto">No apto</option>
                </select>
                <x-input-error for="resultado" class="mt-1" />
            </div>
            <div class="col-span-2">
                <x-label value="Observaciones:" />
                <textarea wire:model="observaciones" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" style="height: 100px;"></textarea>
                <x-input-error for="observaciones" class="mt-1" />
            </div>


        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('openevaluar', false)" class="mx-2">
                Cancelar
            </x-secondary-button>
            <x-button wire:click="guardarEvaluacion" wire:loading.attr="disabled" 
            wire:target="guardarEvaluacion">
                Guardar
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>

