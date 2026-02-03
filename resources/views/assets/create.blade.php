@extends('adminlte::page')

@section('title', 'Add Asset')

@section('content_header')
    <h1>Add New Asset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('assets.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Gold Bar, BCA Stock" required>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" class="form-control" required>
                                <option value="gold">Gold</option>
                                <option value="fund">Mutual Fund</option>
                                <option value="stock">Stock</option>
                                <option value="bonds">Bonds</option>
                                <option value="deposito">Deposito</option>
                                <option value="saving">Saving</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description (Optional)</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" name="qty" class="form-control" step="0.0001" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input type="text" name="unit" class="form-control" placeholder="e.g. gram, lot" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Current Price (Per Unit)</label>
                            <input type="number" name="price" class="form-control" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Expected Return (Value)</label>
                            <input type="number" name="expected_return" class="form-control" step="0.01">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Save Asset</button>
                    <a href="{{ route('assets.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop
