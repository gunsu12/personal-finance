@extends('adminlte::page')

@section('title', 'Cash Flow Details')

@section('content_header')
    <h1>Cash Flow Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Transaction Details
            </h3>
            <div class="card-tools">
                <a href="{{ route('cash-flows.index') }}" class="btn btn-default btn-sm">Back to List</a>
                <a href="{{ route('cash-flows.edit', $cashFlow->id) }}" class="btn btn-warning btn-sm">Edit</a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $cashFlow->id }}</dd>

                <dt class="col-sm-3">Date</dt>
                <dd class="col-sm-9">{{ $cashFlow->created_at->format('d M Y H:i') }}</dd>

                <dt class="col-sm-3">Type</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-{{ $cashFlow->type == 'debit' ? 'success' : 'danger' }}">
                        {{ ucfirst($cashFlow->type) }}
                    </span>
                </dd>

                <dt class="col-sm-3">Group</dt>
                <dd class="col-sm-9">{{ ucfirst($cashFlow->group) }}</dd>

                <dt class="col-sm-3">Amount</dt>
                <dd class="col-sm-9">{{ number_format($cashFlow->amount, 2) }}</dd>

                <dt class="col-sm-3">Notes</dt>
                <dd class="col-sm-9">{{ $cashFlow->transaction_notes ?: '-' }}</dd>

                <dt class="col-sm-3">Reference</dt>
                <dd class="col-sm-9">{{ $cashFlow->transaction_refference ?: '-' }}</dd>
            </dl>
        </div>
        <div class="card-footer">
            <form action="{{ route('cash-flows.destroy', $cashFlow->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
@stop
