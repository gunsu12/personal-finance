@extends('adminlte::page')

@section('title', 'Add Merchant')

@section('content_header')
    <h1>Add Merchant</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('merchants.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Starbucks" required>
                </div>
                <div class="form-group">
                    <label>Category (Optional)</label>
                    <input type="text" name="category" class="form-control" placeholder="e.g. Food & Beverage">
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Save Merchant</button>
                    <a href="{{ route('merchants.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop
