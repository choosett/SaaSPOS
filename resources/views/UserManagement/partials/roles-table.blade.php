<div class="bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-sm">
            <thead class="bg-[#0E3EA8] text-white uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Role Name</th>
                    <th class="px-4 py-3 text-left">Users Assigned</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($roles as $role)
                <tr class="border-b hover:bg-blue-50 transition">
                    <td class="px-4 py-3 font-medium">{{ $role->name }}</td>
                    <td class="px-4 py-3">{{ $role->users_count }} Users</td>

                    <!-- ✅ Actions -->
                    <td class="px-4 py-3 flex justify-center items-center gap-2">
                        @if (strtolower($role->name) !== 'admin')
                            <a href="{{ route('roles.edit', $role->id) }}" 
                               class="action-btn edit bg-blue-600 text-white px-3 py-1 rounded-md flex items-center gap-1 hover:bg-blue-700 transition">
                                <span class="material-icons">edit</span> Edit
                            </a>

                            <button class="action-btn delete delete-btn bg-red-600 text-white px-3 py-1 rounded-md flex items-center gap-1 hover:bg-red-700 transition"
                                    data-url="{{ route('roles.destroy', $role->id) }}">
                                <span class="material-icons">delete</span> Delete
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500 py-4">No roles found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

<!-- ✅ Pagination -->
<div class="flex justify-between items-center text-xs text-gray-600 p-3 bg-gray-100">
    <p>
        Showing {{ $roles->firstItem() }} to {{ $roles->lastItem() }} 
        @if($roles instanceof \Illuminate\Pagination\LengthAwarePaginator)
            of {{ $roles->total() }}
        @endif
        entries
    </p>

    <div class="flex items-center gap-2">
        @if ($roles->onFirstPage())
            <button class="px-3 py-1 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">← Prev</button>
        @else
            <a href="{{ $roles->previousPageUrl() }}" 
               class="pagination-link px-3 py-1 bg-[#0E3EA8] text-white rounded-md shadow-md hover:bg-blue-900 transition ajax-pagination">← Prev</a>
        @endif
        
        <span class="text-gray-700 font-semibold">{{ $roles->currentPage() }}</span>

        @if ($roles->hasMorePages())
            <a href="{{ $roles->nextPageUrl() }}" 
               class="pagination-link px-3 py-1 bg-[#0E3EA8] text-white rounded-md shadow-md hover:bg-blue-900 transition ajax-pagination">Next →</a>
        @else
            <button class="px-3 py-1 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">Next →</button>
        @endif
    </div>
</div>

</div>

