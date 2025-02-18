@extends('layouts.app')

@section('content')
    <h1>Manage Users</h1>

    @can('manage users')
        <button>Add New User</button>

        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->getRoleNames()->first() }}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p>You do not have permission to manage users.</p>
    @endcan
@endsection
