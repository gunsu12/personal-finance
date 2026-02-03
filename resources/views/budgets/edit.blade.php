@extends('adminlte::page')

@section('title', 'Edit Budget')

@section('content_header')
    <h1>Edit Budget Plan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('budgets.update', $budget->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Month Period</label>
                    <select name="month_periode" class="form-control">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $budget->month_periode == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <label>Year</label>
                    <input type="number" name="year" class="form-control" value="{{ $budget->year }}" required>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" required>{{ $budget->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@stop
