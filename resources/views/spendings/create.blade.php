@extends('adminlte::page')

@section('title', 'Record Spending')

@section('content_header')
    <h1>Record Spending</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('spendings.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="spending_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Transaction Method</label>
                            <select name="transaction_methods" class="form-control" required>
                                <option value="cash">Cash</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="debit_card">Debit Card</option>
                                <option value="transfer">Transfer</option>
                                <option value="ewallet">E-Wallet</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Merchant</label>
                            <div class="input-group">
                                <select name="merchant_id" class="form-control select2">
                                    <option value="">-- Select Merchant --</option>
                                    @foreach($merchants as $merchant)
                                        <option value="{{ $merchant->id }}">
                                            {{ $merchant->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <a href="{{ route('merchants.create') }}" class="btn btn-outline-secondary" title="Add New Merchant"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Budget Item (Optional)</label>
                            <select name="budget_item_id" class="form-control select2">
                                <option value="">-- Unbudgeted / General --</option>
                                @foreach($budgets as $budget)
                                    <optgroup label="{{ $budget->description }} ({{ $budget->month_periode }}/{{ $budget->year }})">
                                        @foreach($budget->budgetItems as $item)
                                            <option value="{{ $item->id }}" {{ (isset($defaultBudgetItemId) && $defaultBudgetItemId == $item->id) ? 'selected' : '' }}>
                                                {{ $item->description }} (Remaining: {{ number_format($item->sub_total, 2) }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Link this spending to a planned budget item.</small>
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea name="notes" class="form-control" placeholder="e.g. Starbucks, Uber, etc."></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Record Spending</button>
                    <a href="{{ route('spendings.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css">
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap'
            });
        });
    </script>
@stop
