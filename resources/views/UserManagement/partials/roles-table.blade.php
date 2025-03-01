<table class="responsive-table">
    <thead>
        <tr>
            <th>Role Name</th>
            <th>Users Assigned</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($roles as $role)
        <tr>
            <td>{{ $role->name }}</td>
            <td>{{ $role->users_count }} Users</td>
            <td class="actions">
                @if (strtolower($role->name) !== 'admin')
                    <a href="{{ route('roles.edit', $role->id) }}" class="action-btn edit">
                        <span class="material-icons">edit</span> <span class="btn-text">Edit</span>
                    </a>
                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete" onclick="return confirm('Are you sure?')">
                            <span class="material-icons">delete</span> <span class="btn-text">Delete</span>
                        </button>
                    </form>
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


