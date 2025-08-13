<div class="mb-4">
    <button wire:click="$set('open',true)"
        class="bg-slate-600 px-6 py-4 rounded-md text-white font-semibold tracking-wide cursor-pointer">Agregar</button>

    <x-dialog-modal wire:model="open">
        <x-slot name="title">
            <h1 class="text-xl font-bold">Crear Nueva Cita</h1>
        </x-slot>

        <x-slot name="content">
            <!-- Cliente -->
            <div class="bg-gray-50 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-blue-800 border-b pb-1 mb-3">👤 Datos del Cliente</h3>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-input label="Nombres" type="text" class="w-full" placeholder="Nombre completo"
                            wire:model="nombre" />
                        <x-input-error for="nombre" class="mt-1" />
                    </div>
                    <div>
                        <x-input label="Apellidos" type="text" class="w-full" placeholder="Apellido completo"
                            wire:model="apellido" />
                        <x-input-error for="apellido" class="mt-1" />
                    </div>
                    <div>
                        <x-input label="Documento" type="text" class="w-full" placeholder="DNI o documento"
                            wire:model="documento" />
                        <x-input-error for="documento" class="mt-1" />
                    </div>
                    <div>
                        <x-input label="Teléfono" type="tel" class="w-full" placeholder="Número de contacto"
                            wire:model="telefono" />
                        <x-input-error for="telefono" class="mt-1" />
                    </div>
                    <div>
                        <x-input label="Correo" type="email" class="w-full" placeholder="correo@ejemplo.com"
                            wire:model="email" />
                        <x-input-error for="email" class="mt-1" />
                    </div>
                    <div>
                        <x-input label="Dirección" type="text" class="w-full" placeholder="Dirección completa"
                            wire:model="direccion" />
                        <x-input-error for="direccion" class="mt-1" />
                    </div>
                </div>
            </div>

            <!-- Vehículo -->
            <div class="bg-gray-50 p-4 rounded-lg shadow mt-4">
                <h3 class="text-lg font-semibold text-green-800 border-b pb-1 mb-3">🚗 Datos del Vehículo</h3>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-input label="Marca" placeholder="Ej. Toyota" class="w-full" type="text"
                            wire:model="marca" />
                        <x-input-error for="marca" class="mt-1" />
                    </div>
                    <div>
                        <x-input label="Modelo" placeholder="Ej. Corolla" class="w-full" type="text"
                            wire:model="modelo" />
                        <x-input-error for="modelo" class="mt-1" />
                    </div>
                    <div>
                        <x-input label="Año" placeholder="Ej. 2022" class="w-full" type="number"
                            wire:model="anio" />
                        <x-input-error for="anio" class="mt-1" />
                    </div>
                    <div>
                        <x-input label="Placa" placeholder="ABC123" class="w-full" type="text" wire:model="placa" />
                        <x-input-error for="placa" class="mt-1" />
                    </div>
                    <div>
                        <x-input label="Serie" placeholder="N° Motor" class="w-full" type="text"
                            wire:model="serie" />
                        <x-input-error for="serie" class="mt-1" />
                    </div>
                    <div>
                        <x-input label="Color" placeholder="Ej. Rojo" class="w-full" type="text"
                            wire:model="color" />
                        <x-input-error for="color" class="mt-1" />
                    </div>
                </div>
                <div class="mt-3">
                    <x-input label="Combustible" placeholder="Combustible" type="text" class="w-full"
                        wire:model="combustible" list="items" />
                    <datalist id="items">
                        <option value="GASOLINA">GASOLINA</option>
                        <option value="BI-COMBUSTIBLE GNV">BI-COMBUSTIBLE GNV</option>
                        <option value="BI-COMBUSTIBLE GLP">BI-COMBUSTIBLE GLP</option>
                        <option value="GNV">GNV</option>
                        <option value="GLP">GLP</option>
                        <option value="DIESEL">DIESEL</option>
                    </datalist>
                    <x-input-error for="combustible" class="mt-1" />
                </div>
            </div>

            <!-- Cita -->
            <div class="bg-gray-50 p-4 rounded-lg shadow mt-4">
                <h3 class="text-lg font-semibold text-yellow-800 border-b pb-1 mb-3">📅 Datos de la Cita</h3>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-input label="Fecha de Cita" type="date" class="w-full" wire:model="fecha_cita" />
                        <x-input-error for="fecha_cita" class="mt-1" />
                    </div>

                    <div>
                        <x-input label="Motivo" placeholder="Motivo de la cita" class="w-full" type="text"
                            wire:model="motivo" />
                        <x-input-error for="motivo" class="mt-1" />
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open',false)" class="mx-2">
                Cancelar
            </x-secondary-button>
            <x-button wire:click="crearCita" wire:loading.attr="disabled" wire:target="crearCita">
                Guardar
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
