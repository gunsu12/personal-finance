@extends('adminlte::page')

@section('title', 'Edit Budget Item')

@section('content_header')
    <h1>Edit Budget Item</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('items.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name="description" class="form-control" value="{{ $item->description }}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" class="form-control" required>
                                <option value="konsumsi" {{ $item->type == 'konsumsi' ? 'selected' : '' }}>Konsumsi</option>
                                <option value="sewa" {{ $item->type == 'sewa' ? 'selected' : '' }}>Sewa</option>
                                <option value="pakaian" {{ $item->type == 'pakaian' ? 'selected' : '' }}>Pakaian</option>
                                <option value="utilitas" {{ $item->type == 'utilitas' ? 'selected' : '' }}>Utilitas</option>
                                <option value="hiburan" {{ $item->type == 'hiburan' ? 'selected' : '' }}>Hiburan</option>
                                <option value="lainnya" {{ $item->type == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" step="0.01" value="{{ $item->amount }}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Qty</label>
                            <input type="number" name="qty" class="form-control" value="{{ $item->qty }}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">Update Item</button>
                    </div>
                </div>
            </form>
            <div class="mt-3">
                <a href="{{ route('budgets.show', $item->budget_id) }}" class="btn btn-default">Back to Budget</a>
            </div>
        </div>
    </div>
@stop
