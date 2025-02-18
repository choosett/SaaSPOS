@extends('layouts.app')

@section('content')
    <h1>POS System</h1>

    @role('cashier')
        <p>Welcome to the POS system. Scan products to proceed.</p>
    @else
        <p>You are not authorized to use the POS system.</p>
    @endrole
@endsection
