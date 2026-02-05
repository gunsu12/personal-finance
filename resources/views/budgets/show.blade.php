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
                <div class="col-lg-6 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ number_format($budget->total_budget, 0, ',', '.') }}</h3>
                            <p>Total Budget</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ number_format($budget->total_already_spended, 0, ',', '.') }}</h3>
                            <p>Total Spent</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4>Budget Items</h4>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addItemModal">
                    <i class="fas fa-plus"></i> Add New Item
                </button>
            </div>
            
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



            <!-- Modal -->
            <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addItemModalLabel">Add New Budget Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="add-item-form" action="{{ route('budgets.items.store', $budget->id) }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control" placeholder="e.g. Groceries" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" name="amount" class="form-control" step="0.01" placeholder="0.00" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Qty</label>
                                            <input type="number" name="qty" class="form-control" value="1" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script>
        document.getElementById('add-item-form').addEventListener('submit', function(e) {
            const btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
        });
    </script>
@stop
