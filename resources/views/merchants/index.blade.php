@extends('adminlte::page')

@section('title', 'Merchants')

@section('content_header')
    <h1>Merchants</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('merchants.create') }}" class="btn btn-primary">Add New Merchant</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($merchants as $merchant)
                            <tr>
                                <td>{{ $merchant->name }}</td>
                                <td>{{ $merchant->category ?? '-' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('merchants.edit', $merchant->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('merchants.destroy', $merchant->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
