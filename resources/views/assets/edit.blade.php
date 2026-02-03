@extends('adminlte::page')

@section('title', 'Edit Asset')

@section('content_header')
    <h1>Edit Asset</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('assets.update', $asset->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $asset->title }}" required>
                        </div>
                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" class="form-control" required>
                                <option value="gold" {{ $asset->type == 'gold' ? 'selected' : '' }}>Gold</option>
                                <option value="fund" {{ $asset->type == 'fund' ? 'selected' : '' }}>Mutual Fund</option>
                                <option value="stock" {{ $asset->type == 'stock' ? 'selected' : '' }}>Stock</option>
                                <option value="bonds" {{ $asset->type == 'bonds' ? 'selected' : '' }}>Bonds</option>
                                <option value="deposito" {{ $asset->type == 'deposito' ? 'selected' : '' }}>Deposito</option>
                                <option value="saving" {{ $asset->type == 'saving' ? 'selected' : '' }}>Saving</option>
                                <option value="cash" {{ $asset->type == 'cash' ? 'selected' : '' }}>Cash</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Description (Optional)</label>
                            <textarea name="description" class="form-control">{{ $asset->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" name="qty" class="form-control" step="0.0001" value="{{ $asset->qty }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <input type="text" name="unit" class="form-control" value="{{ $asset->unit }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Current Price (Per Unit)</label>
                            <input type="number" name="price" class="form-control" step="0.01" value="{{ $asset->price }}" required>
                            <small class="text-muted">Updating this will record a price history log.</small>
                        </div>
                        <div class="form-group">
                            <label>Expected Return (Value)</label>
                            <input type="number" name="expected_return" class="form-control" step="0.01" value="{{ $asset->expected_return }}">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Update Asset</button>
                    <a href="{{ route('assets.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop
