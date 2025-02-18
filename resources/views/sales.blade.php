@extends('layouts.app')

@section('content')
    <h1>Process Sales</h1>

    @can('process sales')
        <form>
            <label for="product">Product:</label>
            <select id="product">
                <option>Item 1</option>
                <option>Item 2</option>
            </select>

            <button type="submit">Process Sale</button>
        </form>
    @else
        <p>You do not have permission to process sales.</p>
    @endcan
@endsection
