@extends('adminlte::page')

@section('title', 'Budget Details')

@section('content_header')
    <h1>Budget Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $budget->description }} ({{ $budget->month_periode }}/{{ $budget->year }})</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Total Budget:</strong> {{ number_format($budget->total_budget, 2) }}</p>
                    <p><strong>Spent:</strong> {{ number_format($budget->total_already_spended, 2) }}</p>
                </div>
            </div>
            
            <hr>
            <h4>Items</h4>
            <hr>
            <h4>Budget Items</h4>
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-sm mb-4">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($budget->budgetItems as $item)
                            <tr>
                                <td>{{ $item->description }}</td>
                                <td>{{ ucfirst($item->type) }}</td>
                                <td>{{ number_format($item->amount, 2) }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ number_format($item->sub_total, 2) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-xs btn-warning">Edit</a>
                                        <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @if($budget->budgetItems->isEmpty())
                            <tr><td colspan="6" class="text-center">No items found.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <hr>
            <h5>Add New Item</h5>
            <form action="{{ route('budgets.items.store', $budget->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" placeholder="e.g. Groceries" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" class="form-control" required>
                                <option value="konsumsi">Konsumsi</option>
                                <option value="sewa">Sewa</option>
                                <option value="pakaian">Pakaian</option>
                                <option value="utilitas">Utilitas</option>
                                <option value="hiburan">Hiburan</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" step="0.01" placeholder="0.00" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="number" name="qty" class="form-control" value="1" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="d-none d-md-block">&nbsp;</label>
                        <button type="submit" class="btn btn-success btn-block">Add Item</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
