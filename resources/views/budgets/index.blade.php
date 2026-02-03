@extends('adminlte::page')

@section('title', 'Budgeting')

@section('content_header')
    <h1>Budget Plans</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('budgets.create') }}" class="btn btn-primary">Create New Plan</a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Period</th>
                            <th>Year</th>
                            <th>Description</th>
                            <th>Total Budget</th>
                            <th>Already Spent</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($budgets as $budget)
                            <tr>
                                <td>{{ $budget->month_periode }}</td>
                                <td>{{ $budget->year }}</td>
                                <td>{{ $budget->description }}</td>
                                <td>{{ number_format($budget->total_budget, 2) }}</td>
                                <td>{{ number_format($budget->total_already_spended, 2) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('budgets.show', $budget->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('budgets.edit', $budget->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
