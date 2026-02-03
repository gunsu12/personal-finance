@extends('adminlte::page')

@section('title', 'Spendings')

@section('content_header')
    <h1>Spendings</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('spendings.create') }}" class="btn btn-primary">Record New Spending</a>
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
                            <th>Code</th>
                            <th>Description/Notes</th>
                            <th>Budget Item</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($spendings as $spending)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($spending->spending_date)->format('Y-m-d') }}</td>
                                <td>{{ $spending->code }}</td>
                                <td>
                                    @if($spending->merchant)
                                        <strong>{{ $spending->merchant->name }}</strong><br>
                                    @endif
                                    {{ $spending->notes ?? '-' }}
                                </td>
                                <td>
                                    @if($spending->budgetItem)
                                        {{ $spending->budgetItem->description }} 
                                        <small class="text-muted">({{ $spending->budgetItem->budget->description }})</small>
                                    @else
                                        <span class="text-muted">Unbudgeted</span>
                                    @endif
                                </td>
                                <td>{{ number_format($spending->amount, 2) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $spending->transaction_methods)) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('spendings.edit', $spending->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('spendings.destroy', $spending->id) }}" method="POST" style="display:inline-block;">
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
