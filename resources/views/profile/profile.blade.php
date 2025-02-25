@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="profile-container">
    <!-- ✅ Profile ID Card -->
    <div class="id-card">
        <div class="id-card-header">
            <img src="https://cdn-icons-png.flaticon.com/512/147/147144.png" alt="Profile Picture" class="id-card-avatar">
            <div>
                <h3 class="id-card-name">{{ $user->name }}</h3>
                <p class="id-card-role">{{ ucfirst($user->role) }}</p>
            </div>
        </div>

        <div class="id-card-body">
            <div class="id-card-info">
                <label>Name:</label>
                <p>{{ $user->name }}</p>
            </div>
            <div class="id-card-info">
                <label>Phone Number:</label>
                <p>{{ $user->phone ?? 'N/A' }}</p>
            </div>
            <div class="id-card-info">
                <label>Email:</label>
                <p>{{ $user->email }}</p>
            </div>
            <div class="id-card-info">
                <label>User Name:</label>
                <p>{{ $user->username ?? 'N/A' }}</p>
            </div>
            <div class="id-card-info">
                <label>Joined At:</label>
                <p>{{ $user->created_at->format('Y-m-d') }}</p>
            </div>
            <div class="id-card-info">
                <label>Business Name:</label>
                <p>{{ $user->business_name ?? 'N/A' }}</p>
            </div>
            <div class="id-card-info">
                <label>Role:</label>
                <p>{{ ucfirst($user->role) }}</p>
            </div>
        </div>
    </div>

    <!-- ✅ Edit Profile Button -->
    <div class="flex justify-center mt-4">
        <a href="{{ route('profile.edit') }}" class="id-card-btn edit">Edit Profile</a>
    </div>
</div>

@endsection

