@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="page-container">
    <h1 class="page-title">Edit Role</h1>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Role Name:</label>
            <input type="text" name="name" id="name" value="{{ $role->name }}" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Role</button>
    </form>
</div>
@endsection
