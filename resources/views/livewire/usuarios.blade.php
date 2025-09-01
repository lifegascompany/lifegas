<div>
    <div class="container mx-auto py-4">
        <x-custom-table>
            <x-slot name="titulo">
                <h2 class="text-teal-600 font-bold text-3xl flex items-center gap-2">
                    <i class="fas fa-user fa-xl"></i>
                    &nbsp;Usuarios

                </h2>
            </x-slot>

            <x-slot name="btnAgregar">
            </x-slot>

            <x-slot name="contenido">
                @if (count($usuarios))
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="overflow-x-auto">
                                <table class="w-full whitespace-nowrap rounded-lg overflow-hidden shadow">
                                    <thead class="bg-slate-600 border-b font-bold text-white">
                                        <tr>
                                            <th scope="col"
                                                class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                                wire:click="order('id')">
                                                Id
                                                @if ($sort == 'id')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-numeric-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fas fa-sort-numeric-down-alt float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th scope="col"
                                                class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                                wire:click="order('name')">
                                                Nombre
                                                @if ($sort == 'name')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th scope="col"
                                                class="text-sm font-medium font-semibold text-white px-6 py-4 text-left"
                                                wire:click="order('email')">
                                                correo
                                                @if ($sort == 'email')
                                                    @if ($direction == 'asc')
                                                        <i class="fas fa-sort-alpha-up-alt float-right mt-0.5"></i>
                                                    @else
                                                        <i class="fas fa-sort-alpha-down-alt float-right mt-0.5"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort float-right mt-0.5"></i>
                                                @endif
                                            </th>
                                            <th scope="col"
                                                class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                                Rol
                                            </th>
                                            <th scope="col"
                                                class="text-sm font-medium font-semibold text-white px-6 py-4 text-left">
                                                Acciones
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($usuarios as $item)
                                            <tr tabindex="0"
                                                class="focus:outline-none h-16 border border-slate-300 rounded hover:bg-gray-300">
                                                <td class="pl-5">
                                                    <div class="flex items-center">
                                                        <p class="text-slate-900 p-1 bg-slate-200 rounded-md">
                                                            {{ strtoupper($item->id) }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="pl-2">
                                                    <div class="flex items-center">
                                                        <p class="text-sm font-medium leading-none text-gray-600 mr-2">
                                                            {{ $item->name }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="pl-2">
                                                    <div class="flex items-center">
                                                        <p class="text-sm leading-none text-gray-600 ml-2">
                                                            {{ $item->email }}
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="pl-2">
                                                    <div class="flex items-center">
                                                        <p class="text-sm leading-none text-gray-600 ml-2">
                                                            @if ($item->roles)
                                                                @foreach ($item->roles as $rol)
                                                                    <span>{{ $rol->name }}</span>
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="pl-2">
                                                    <div class="flex items-center justify-center">
                                                        <p class="text-gray-900 whitespace-no-wrap">
                                                            <button wire:click="editarUsuario({{ $item->id }})"
                                                                class="px-2 py-2 bg-slate-600 rounded-md flex items-center justify-center">
                                                                <i class="fas fa-pen text-white"></i>
                                                            </button>
                                                        </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if ($usuarios->hasPages())
                        <div>
                            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-2 overflow-x-auto">
                                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                                    <div class="px-5 py-5 bg-white border-t">
                                        {{ $usuarios->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="px-6 py-4 text-center font-bold bg-slate-200 rounded-md">
                        No se encontro ningun registro.
                    </div>
                @endif
            </x-slot>

        </x-custom-table>
    </div>

    <!-- Modal para editar usuario -->
    <x-dialog-modal wire:model="editando" wire:loading.attr="disabled">
        <x-slot name="title" class="font-bold">
            <h1 class="text-xl font-bold"><i class="fa-solid fa-user-pen text-white"></i> &nbsp;Editar Usuario</h1>
        </x-slot>

        <x-slot name="content">
            <div class="mb-4">
                <x-label value="Nombre:" />
                <x-input wire:model="name" type="text" class="w-full" />
                <x-input-error for="name" />
            </div>
            <div class="mb-4">
                <x-label value="Email:" />
                <x-input wire:model="email" type="text" class="w-full" />
                <x-input-error for="email" />
            </div>

            <div class="mb-4">
                <x-label value="Roles:" />
                @if (isset($roles))
                    @foreach ($roles as $key => $rol)
                        <div class="flex items-center pl-3">
                            <input wire:model="selectedRoles" id="{{ $rol->id . 'checkbox' }}" type="checkbox"
                                value="{{ $rol->name }}"
                                class="w-4 h-4 text-slate-600 bg-slate-100 border-gray-300 rounded outline-none  focus:ring-slate-600">
                            <label for="{{ $rol->id . 'checkbox' }}"
                                class="py-2 ml-2 text-sm font-medium text-gray-900 ">
                                {{ $rol->name }}
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>
            <x-input-error for="selectedRoles" />



        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('editando',false)" class="mx-2">
                Cancelar
            </x-secondary-button>
            <x-button wire:click="actualizar" wire:loading.attr="disabled" wire:target="actualizar">
                Actualizar
            </x-button>

        </x-slot>

    </x-dialog-modal>
</div>
