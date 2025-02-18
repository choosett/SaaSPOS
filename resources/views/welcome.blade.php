@extends('layouts.app')

@section('content')
    <h1>Welcome to POS SaaS</h1>

    @auth
        <p>Hello, {{ auth()->user()->name }}!</p>

        <ul>
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>

            @role('admin')
                <li><a href="{{ route('admin.users') }}">Manage Users</a></li>
                <li><a href="{{ route('reports') }}">View Reports</a></li>
            @endrole

            @role('manager')
                <li><a href="{{ route('sales') }}">Process Sales</a></li>
            @endrole

            @role('cashier')
                <li><a href="{{ route('pos') }}">POS System</a></li>
            @endrole

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </li>
        </ul>
    @else
        <p>Please <a href="{{ route('login') }}">Login</a> or <a href="{{ route('register') }}">Register</a> to continue.</p>
    @endauth
@endsection
