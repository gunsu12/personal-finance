@extends('adminlte::page')

@section('title', 'Asset Details')

@section('content_header')
    <h1>Asset Details: {{ $asset->title }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <h3 class="profile-username text-center">{{ $asset->title }}</h3>
                    <p class="text-muted text-center">{{ ucfirst($asset->type) }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Quantity</b> <a class="float-right">{{ number_format($asset->qty, 4) }} {{ $asset->unit }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Current Price</b> <a class="float-right">{{ number_format($asset->price, 2) }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Total Value</b> <a class="float-right">{{ number_format($asset->sub_total, 2) }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Expected Return</b> <a class="float-right">{{ number_format($asset->expected_return, 2) }}</a>
                        </li>
                    </ul>

                    <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-primary btn-block"><b>Edit</b></a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Description</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        {{ $asset->description ?? 'No description provided.' }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Price History</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Change</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asset->logs()->latest()->get() as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                    <td>{{ number_format($log->price, 2) }}</td>
                                    <td>
                                        <!-- Calculate change if needed, or just show value -->
                                        -
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
