@extends('template.sneat.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'show_payroll')) }}
@endsection

@section('payroll-active')
    {{ 'active' }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('payroll.index') }}">{{ ucwords(str_replace('_', ' ', 'payroll')) }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">@yield('title')</h5>
                        <a href="{{ route('payroll.index') }}" class="btn btn-primary">Back to List</a>
                    </div>
                    <div class="card-body">
                        <h6>Payroll Details</h6>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee</th>
                                                <th>Year</th>
                                                <th>Month</th>
                                                <th>Period From</th>
                                                <th>Period To</th>
                                                {{-- <th>Created At</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $payroll->id }}</td>
                                                <td>{{ $payroll->employee->name }}</td>
                                                <td>{{ $payroll->year }}</td>
                                                <td>{{ $payroll->month }}</td>
                                                <td>{{ $payroll->from }}</td>
                                                <td>{{ $payroll->to }}</td>
                                                {{-- <td>{{ $payroll->created_at->format('d M Y H:i:s') }}</td> --}}
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>

                                <h6>Salary Details</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Salary</th>
                                                <th>Attendance Credit</th>
                                                <th>Overtime</th>
                                                <th>Overtime Credit</th>
                                                <th>Leave</th>
                                                <th>Leave Credit</th>
                                                <th>Incentive</th>
                                                <th>Net Salary</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ number_format($payroll->salary, 0) }}</td>
                                                <td>{{ number_format($payroll->attendance_credit, 0) }}</td>
                                                <td>{{ number_format($payroll->overtime, 0) }}</td>
                                                <td>{{ number_format($payroll->overtime_credit, 0) }}</td>
                                                <td>{{ number_format($payroll->leave, 0) }}</td>
                                                <td>{{ number_format($payroll->leave_credit, 0) }}</td>
                                                <td>{{ number_format($payroll->incentive, 0) }}</td>
                                                <td>{{ number_format($payroll->net_salary, 0) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <button class="btn btn-primary" onclick="window.print()">Print Payroll</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
