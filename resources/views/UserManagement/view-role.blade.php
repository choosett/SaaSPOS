@extends('layouts.app')

@section('title', 'View Role')

@section('content')
<div class="page-container">
    <h1 class="page-title">Role Details</h1>

    <p><strong>Role Name:</strong> {{ $role->name }}</p>

    <a href="{{ route('allroles.index') }}" class="btn btn-secondary">Back to Roles</a>
</div>
@endsection
