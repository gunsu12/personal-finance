@extends('adminlte::page')

@section('title', 'Record Cash Flow')

@section('content_header')
    <h1>Record Cash Flow</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('cash-flows.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" class="form-control" required>
                                <option value="debit">Debit (Income)</option>
                                <option value="credit">Credit (Expense)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Group</label>
                            <select name="group" class="form-control" required>
                                <option value="revenue">Revenue</option>
                                <option value="spending">Spending</option>
                                <option value="bonds">Bonds</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Transaction Notes</label>
                            <textarea name="transaction_notes" class="form-control" rows="3" placeholder="e.g. Salary, Grocery, etc."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Transaction Reference (Optional)</label>
                            <input type="text" name="transaction_refference" class="form-control" placeholder="e.g. Budget ID, Spending Code">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Record Cash Flow</button>
                    <a href="{{ route('cash-flows.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop
