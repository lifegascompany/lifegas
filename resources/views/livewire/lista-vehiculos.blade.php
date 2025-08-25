<div>
    <x-table-vehiculos>
        @if ($vehiculos->count())
            <table class="w-full whitespace-nowrap table-auto">
                <thead class="bg-slate-600 font-bold text-white">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left">
                            #
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            Cliente
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            Taller
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            Placa
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            Marca
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            Modelo
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            Documentos
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($vehiculos as $veh)
                        <tr tabindex="0" class="focus:outline-none bg-white h-16 hover:bg-gray-100">
                            <td class="px-6 py-4 text-left">
                                <div class="flex items-center">
                                    <div class="bg-indigo-200 rounded-md w-7 h-7 flex flex-shrink-0 justify-center items-center text-indigo-900">
                                        {{ $veh->id }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-left">
                                <p class="text-sm font-medium leading-none text-gray-600">
                                    {{ $veh->cliente->nombre . ' ' . $veh->cliente->apellido }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-left">
                                <p class="text-sm leading-none text-gray-600">
                                    Lifegas Company
                                </p>
                            </td>
                            <td class="px-6 py-4 text-left">
                                <p class="text-sm leading-none text-gray-600 p-2 bg-green-200 rounded-full inline-block">
                                    {{ $veh->placa }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-left">
                                <p class="text-sm font-medium leading-none text-gray-600">
                                    {{ $veh->marca }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-left">
                                <p class="text-sm font-medium leading-none text-gray-600">
                                    {{ $veh->modelo }}
                                </p>
                            </td>
                            <td class="px-6 py-4 text-left">
                                <div class="relative text-center" x-data="{ menu: false }">
                                    <button type="button" x-on:click="menu = ! menu" id="menu-button"
                                        aria-expanded="true" aria-haspopup="true" data-te-ripple-init
                                        data-te-ripple-color="light"
                                        class="hover:animate-pulse inline-block rounded-full bg-amber-400 p-2 uppercase leading-normal text-white shadow-md transition duration-150 ease-in-out hover:bg-amber-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-amber-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-amber-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            fill="currentColor" class="h-4 w-4">
                                            <path fill-rule="evenodd" d="M19.5 21a3 3 0 003-3V9a3 3 0 00-3-3h-5.379a.75.75 0 01-.53-.22L11.47 3.66A2.25 2.25 0 009.879 3H4.5a3 3 0 00-3 3v12a3 3 0 003 3h15zm-6.75-10.5a.75.75 0 00-1.5 0v4.19l-1.72-1.72a.75.75 0 00-1.06 1.06l3 3a.75.75 0 001.06 0l3-3a.75.75 0 10-1.06-1.06l-1.72 1.72V10.5z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <div x-show="menu" x-on:click.away="menu = false"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="opacity-100 scale-100"
                                        x-transition:leave-end="opacity-0 scale-95"
                                        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-gray-300 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-40"
                                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                        tabindex="-1">
                                        <div class="" role="none">
                                            <a href="{{ route('manual.pdf', $veh->id) }}" target="__blank"
                                                rel="noopener noreferrer"
                                                class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center rounded-t-md hover:cursor-pointer">
                                                <i class="fas fa-eye"></i>
                                                <span>Manual</span>
                                            </a>
                                            <a href="{{ route('vehiculo.pdf', $veh->id) }}" target="__blank"
                                                rel="noopener noreferrer"
                                                class="flex px-4 py-2 text-sm text-indigo-700 hover:bg-slate-600 hover:text-white justify-between items-center hover:cursor-pointer">
                                                <i class="fas fa-eye"></i>
                                                <span>Carta Garantia</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- Sección de paginación mejorada --}}
            @if ($vehiculos->hasPages())
                <div class="py-4 px-2 bg-white">
                    {{ $vehiculos->withQueryString()->links() }}
                </div>
            @endif
        @else
            <div class="p-4 w-full bg-indigo-300 items-center flex justify-center rounded-lg">
                <p class="text-indigo-900 font-bold">No se encontró ningún vehículo</p>
            </div>
        @endif
    </x-table-vehiculos>
</div>
