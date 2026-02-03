@extends('adminlte::page')

@section('title', 'Create Budget')

@section('content_header')
    <h1>Create Budget Plan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('budgets.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Month Period</label>
                    <select name="month_periode" class="form-control">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>Year</label>
                    <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@stop
