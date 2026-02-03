@extends('adminlte::page')

@section('title', 'Edit Cash Flow')

@section('content_header')
    <h1>Edit Cash Flow</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('cash-flows.update', $cashFlow->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" class="form-control" required>
                                <option value="debit" {{ $cashFlow->type == 'debit' ? 'selected' : '' }}>Debit (Income)</option>
                                <option value="credit" {{ $cashFlow->type == 'credit' ? 'selected' : '' }}>Credit (Expense)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Group</label>
                            <select name="group" class="form-control" required>
                                <option value="revenue" {{ $cashFlow->group == 'revenue' ? 'selected' : '' }}>Revenue</option>
                                <option value="spending" {{ $cashFlow->group == 'spending' ? 'selected' : '' }}>Spending</option>
                                <option value="bonds" {{ $cashFlow->group == 'bonds' ? 'selected' : '' }}>Bonds</option>
                                <option value="others" {{ $cashFlow->group == 'others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" step="0.01" min="0" value="{{ $cashFlow->amount }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Transaction Notes</label>
                            <textarea name="transaction_notes" class="form-control" rows="3">{{ $cashFlow->transaction_notes }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Transaction Reference (Optional)</label>
                            <input type="text" name="transaction_refference" class="form-control" value="{{ $cashFlow->transaction_refference }}">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Update Cash Flow</button>
                    <a href="{{ route('cash-flows.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop
