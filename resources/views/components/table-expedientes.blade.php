<div class="bg-gray-200 p-8 rounded-xl w-full">
    <div class="pb-6">
        <!-- Título -->
        <div class="px-2 w-64 mb-4 md:w-full">
            <h2 class="text-gray-600 font-semibold text-2xl">Expedientes</h2>
            <span class="text-xs text-gray-500">Todos los expedientes</span>
        </div>

        <!-- Filtros -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <!-- Mostrar entradas -->
            <div class="flex bg-gray-50 items-center p-2 rounded-md">
                <span>Mostrar</span>
                <select wire:model="cant"
                    class="bg-gray-50 mx-2 border border-indigo-500 rounded-md outline-none w-20">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>Entradas</span>
            </div>

            <!-- Estado -->
            <div class="flex bg-gray-50 items-center p-2 rounded-md">
                <span>Estado:</span>
                <select wire:model="es"
                    class="bg-gray-50 mx-2 border border-indigo-500 rounded-md outline-none w-40">
                    <option value="">SELECCIONE</option>
                    <option value="1">Por revisar</option>
                    <option value="2">Observado</option>
                    <option value="3">Aprobado</option>
                    <option value="4">Desaprobado</option>
                </select>
            </div>

            <!-- Búsqueda -->
            <div class="flex bg-gray-50 items-center lg:w-3/6 p-2 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
                <input type="text" wire:model.live="search"
                    class="bg-gray-50 outline-none rounded-md border border-indigo-500 w-full ml-2"
                    placeholder="Buscar...">
            </div>
        </div>
        <div class="mt-7 overflow-x-auto rounded-lg shadow-md">
            {{$slot}}
        </div>
    </div>