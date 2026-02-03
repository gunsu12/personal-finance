@extends('adminlte::page')

@section('title', 'Assets')

@section('content_header')
    <h1>My Assets</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('assets.create') }}" class="btn btn-primary">Add New Asset</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
            <div class="row mb-3">
                 <div class="col-md-4">
                    <div class="info-box bg-success">
                        <span class="info-box-icon"><i class="fas fa-coins"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Wealth</span>
                            <span class="info-box-number">{{ number_format($totalWealth, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Title</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Current Price</th>
                            <th>Sub Total</th>
                            <th>Exp. Return</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assets as $asset)
                            <tr>
                                <td>{{ ucfirst($asset->type) }}</td>
                                <td>{{ $asset->title }}</td>
                                <td>{{ number_format($asset->qty, 4) }}</td>
                                <td>{{ $asset->unit }}</td>
                                <td>{{ number_format($asset->price, 2) }}</td>
                                <td>{{ number_format($asset->sub_total, 2) }}</td>
                                <td>{{ number_format($asset->expected_return, 2) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('assets.show', $asset->id) }}" class="btn btn-sm btn-info">Details</a>
                                        <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" style="display:inline-block;">
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
