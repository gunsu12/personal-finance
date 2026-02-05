@extends('adminlte::page')

@section('title', 'Budgeting')

@section('content_header')
    <h1>Budget Plans</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <a href="{{ route('budgets.create') }}" class="btn btn-primary">Create New Plan</a>
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#copyBudgetModal">
                    Copy Budget
                </button>
            </div>
            
            <form action="{{ route('budgets.index') }}" method="GET" class="mb-0">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <!-- Copy Budget Modal -->
            <div class="modal fade" id="copyBudgetModal" tabindex="-1" role="dialog" aria-labelledby="copyBudgetModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="copyBudgetModalLabel">Copy Budget Plan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('budgets.copy') }}" method="POST">
                            <div class="modal-body">
                                @csrf
                                <div class="form-group">
                                    <label>Source Budget</label>
                                    <select name="source_budget_id" class="form-control" required>
                                        @foreach($budgets as $budget)
                                            <option value="{{ $budget->id }}">{{ $budget->description }} ({{ $budget->month_periode }}/{{ $budget->year }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>New Description</label>
                                    <input type="text" name="description" class="form-control" required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Month Period</label>
                                            <input type="number" name="month_periode" class="form-control" min="1" max="12" required value="{{ date('n') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Year</label>
                                            <input type="number" name="year" class="form-control" min="2000" required value="{{ date('Y') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Copy Budget</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
            <div class="mt-3">
                {{ $budgets->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@stop
