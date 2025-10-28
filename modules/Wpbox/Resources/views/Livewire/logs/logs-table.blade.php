<div wire:navigate.scroll="false">

    <div class="mb-4">
        <label for="user_id" class="block text-sm font-medium text-gray-700">Filtrar por usuario:</label>
        <select id="user_id" wire:model.live="userId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <option value="">Todos</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    
                    <th class="px-4 py-2">Usuario</th>
                    <th class="px-4 py-2">IP</th>
                    <th class="px-4 py-2">Actividad</th>
                    <th class="px-4 py-2">Última actividad</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                    <tr>
                     
                        <td class="px-4 py-2">{{ $log->user ? $log->user->name : '-' }}</td>
                        <td class="px-4 py-2">{{ $log->ip_address }}</td>
                        <td class="px-4 py-2">{{ $log->actividad }}</td>
                        <td class="px-4 py-2">{{ $log->last_activity }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center">No hay registros</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
                <nav class="d-flex justify-content-begin" aria-label="...">
                                  {{ $logs->links() }}
                </nav>
    
      
      
    </div>
</div>
