<div class="sm:px-6 w-full">
    <div class="px-4 md:px-10 py-4 md:py-7 mt-4">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0">
            <h2 tabindex="0" class="focus:outline-none text-base sm:text-lg md:text-xl lg:text-2xl font-bold leading-normal text-indigo-500">
                TODOS LOS VEHICULOS
            </h2>
            <div class="py-3 px-4 flex items-center text-sm font-medium leading-none text-gray-600 bg-gray-200 hover:bg-gray-300 cursor-pointer rounded-md">
                <p>mostrar :</p>
                <select wire:model.live="cant" aria-label="select" class="focus:text-indigo-600 focus:outline-none bg-transparent ml-1">
                    <option value="10" class="text-sm text-indigo-800">10</option>
                    <option value="20" class="text-sm text-indigo-800">20</option>
                    <option value="50" class="text-sm text-indigo-800">50</option>
                    <option value="100" class="text-sm text-indigo-800">100</option>
                </select>
                &nbsp;
                <p> registros</p>
            </div>
        </div>
    </div>
    <div class="bg-white py-4 md:py-7 px-4 md:px-8 xl:px-10">
        <div class="sm:flex items-center justify-between">
            <div class="flex bg-gray-200 items-center rounded-md lg:w-3/6 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
                <input class="bg-gray-50 outline-none block rounded-md border-indigo-500 w-full" type="text" wire:model.live="search" placeholder="buscar por placa o formato...">
            </div>
        </div>
        <div class="mt-7 overflow-x-auto rounded-lg shadow-md">
            {{$slot}}
        </div>
    </div>
</div>
