@extends('adminlte::page')

@section('title', 'Cash Flows')

@section('content_header')
    <h1>Cash Flows</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('cash-flows.create') }}" class="btn btn-primary">Record New Cash Flow</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Group</th>
                            <th>Amount</th>
                            <th>Notes</th>
                            <th>Reference</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cashFlows as $cashFlow)
                            <tr>
                                <td>{{ $cashFlow->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <span class="badge badge-{{ $cashFlow->type == 'debit' ? 'success' : 'danger' }}">
                                        {{ ucfirst($cashFlow->type) }}
                                    </span>
                                </td>
                                <td>{{ ucfirst($cashFlow->group) }}</td>
                                <td>{{ number_format($cashFlow->amount, 2) }}</td>
                                <td>{{Str::limit($cashFlow->transaction_notes, 50) }}</td>
                                <td>{{ $cashFlow->transaction_refference ?? '-' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('cash-flows.edit', $cashFlow->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('cash-flows.destroy', $cashFlow->id) }}" method="POST" style="display:inline-block;">
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
            <div class="mt-3">
                {{ $cashFlows->links() }}
            </div>
        </div>
    </div>
@stop
