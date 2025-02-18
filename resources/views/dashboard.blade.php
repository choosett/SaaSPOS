@extends('layouts.app')

@section('content')
    <h1>Welcome to POS SaaS</h1>

    @role('admin')
        <p>You are logged in as an <strong>Admin</strong>.</p>
    @elserole('manager')
        <p>You are logged in as a <strong>Manager</strong>.</p>
    @elserole('cashier')
        <p>You are logged in as a <strong>Cashier</strong>.</p>
    @else
        <p>You do not have a role assigned.</p>
    @endrole
@endsection
