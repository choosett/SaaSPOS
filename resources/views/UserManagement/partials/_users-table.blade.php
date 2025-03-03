<table class="responsive-table">
    <thead>
        <tr>
            <th>Username</th>
            <th>Name</th>
            <th>Role</th>
            <th>Email</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Last Login</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
        <tr>
            <td>{{ $user->username }}</td>
            <td class="font-semibold">{{ $user->first_name }} {{ $user->last_name }}</td>
            <td>{{ $user->getRoleNames()->implode(', ') ?: 'N/A' }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <span class="status-badge {{ $user->status == 'active' ? 'active' : 'inactive' }}">
                    {{ ucfirst($user->status ?? 'Inactive') }}
                </span>
            </td>
            <td>{{ $user->created_at ? $user->created_at->format('Y-m-d') : 'N/A' }}</td>
            <td>{{ $user->last_login ? $user->last_login->format('Y-m-d H:i') : 'Never' }}</td>
            <td class="actions">
            <a href="{{ route('users.edit', $user->id) }}" class="action-btn edit">
    <span class="material-icons">edit</span> 
    <span class="btn-text">Edit</span>
</a>


                <button class="action-btn view"><span class="material-icons">visibility</span> <span class="btn-text">View</span></button>
                <button class="action-btn delete delete-btn"
        data-url="{{ route('users.destroy', $user->id) }}">
    <span class="material-icons">delete</span>
    <span class="btn-text">Delete</span>
</button>

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center text-gray-500 py-4">No users found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- ✅ Pagination -->
<div class="flex justify-between items-center text-sm text-gray-600 mt-4">
    <p class="text-xs">
        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} 
        @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
            of {{ $users->total() }}
        @endif
        entries
    </p>

    <div class="pagination-controls flex items-center space-x-2">
        @if ($users->onFirstPage())
            <button class="pagination-btn prev-btn disabled">← Prev</button>
        @else
            <a href="{{ $users->previousPageUrl() }}" class="pagination-btn prev-btn">← Prev</a>
        @endif
        
        <span class="current-page">{{ $users->currentPage() }}</span>

        @if ($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}" class="pagination-btn next-btn">Next →</a>
        @else
            <button class="pagination-btn next-btn disabled">Next →</button>
        @endif
    </div>
</div>
