@extends('layouts.app')

@section('content')
    <h1>Sales Reports</h1>

    @can('view reports')
        <p>Here you can view all sales reports.</p>
        <button>Download Report</button>
    @else
        <p>You do not have permission to view reports.</p>
    @endcan
@endsection
