<div id="usersTableContainer" data-fetch-url="{{ route('users.index') }}">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-sm">
                <thead class="bg-[#017e84] text-white uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 text-left">Username</th>
                        <th class="px-4 py-3 text-left">Name</th>
                        <th class="px-4 py-3 text-left">Role</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Created At</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($users as $user)
                    <tr class="border-b hover:bg-[#017e84]/10 transition">
                        <td class="px-4 py-3">{{ $user->username }}</td>
                        <td class="px-4 py-3 font-medium">{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td class="px-4 py-3 text-[#017e84]">{{ $user->getRoleNames()->implode(', ') ?: 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>

                        <!-- ✅ Styled Active/Inactive Status -->
                        <td class="px-4 py-3 text-center">
                            <span class="user-status px-3 py-1 text-xs font-semibold rounded-full border transition-all cursor-pointer"
                                  data-user-id="{{ $user->id }}"
                                  style="border: 2px solid {{ $user->status == 'active' ? '#10B981' : '#EF4444' }};
                                         color: {{ $user->status == 'active' ? '#10B981' : '#EF4444' }};">
                                {{ $user->status == 'active' ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-center text-gray-600">
                            {{ $user->created_at ? $user->created_at->format('Y-m-d') : 'N/A' }}
                        </td>

                        <!-- ✅ Actions -->
                        <td class="px-4 py-3 flex justify-center items-center gap-2">
                            <a href="{{ route('users.edit', $user->id) }}" 
                               class="action-btn edit bg-[#017e84] text-white px-3 py-1 rounded-md flex items-center gap-1 hover:bg-[#015a5e] transition">
                                <span class="material-icons">edit</span> Edit
                            </a>

                            <button class="peer border border-[#017e84] text-[#017e84] px-3 py-1 rounded-md flex items-center gap-1 transition hover:bg-[#017e84] hover:text-white">
    <span class="material-icons">visibility</span> View
</button>


                            <button class="action-btn delete delete-btn bg-red-600 text-white px-3 py-1 rounded-md flex items-center gap-1 hover:bg-red-700 transition"
                                    data-url="{{ route('users.destroy', $user->id) }}">
                                <span class="material-icons">delete</span> Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-4">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ✅ Pagination -->
        <div class="flex justify-between items-center text-xs text-gray-600 p-3 bg-gray-100">
            <p>
                Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} 
                @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    of {{ $users->total() }}
                @endif
                entries
            </p>

            <div class="flex items-center gap-2">
                @if ($users->onFirstPage())
                    <button class="px-3 py-1 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">← Prev</button>
                @else
                    <a href="{{ $users->previousPageUrl() }}" 
                       class="pagination-link px-3 py-1 bg-[#017e84] text-white rounded-md shadow-md hover:bg-[#015a5e] transition">← Prev</a>
                @endif
                
                <span class="text-gray-700 font-semibold">{{ $users->currentPage() }}</span>

                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" 
                       class="pagination-link px-3 py-1 bg-[#017e84] text-white rounded-md shadow-md hover:bg-[#015a5e] transition">Next →</a>
                @else
                    <button class="px-3 py-1 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">Next →</button>
                @endif
            </div>
        </div>
    </div>
</div>
