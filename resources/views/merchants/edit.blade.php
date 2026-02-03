@extends('adminlte::page')

@section('title', 'Edit Merchant')

@section('content_header')
    <h1>Edit Merchant</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('merchants.update', $merchant->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $merchant->name }}" required>
                </div>
                <div class="form-group">
                    <label>Category (Optional)</label>
                    <input type="text" name="category" class="form-control" value="{{ $merchant->category }}">
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Update Merchant</button>
                    <a href="{{ route('merchants.index') }}" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop
