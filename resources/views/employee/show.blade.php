@extends('template.sneat.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'show_employee')) }}
@endsection

@section('employee-active')
    {{ 'active' }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('employee.index') }}">{{ ucwords(str_replace('_', ' ', 'employee')) }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">@yield('title')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="id">{{ ucwords(str_replace('_', ' ', 'id')) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id" value="{{ $employee->id }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">{{ ucwords(str_replace('_', ' ', 'name')) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" value="{{ $employee->name }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="address">{{ ucwords(str_replace('_', ' ', 'address')) }}</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="address" readonly>{{ $employee->address }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="place_of_birth">{{ ucwords(str_replace('_', ' ', 'place_of_birth')) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="place_of_birth" value="{{ $employee->place_of_birth }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="birthday">{{ ucwords(str_replace('_', ' ', 'birthday')) }}</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="birthday" value="{{ $employee->birthday }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="title">{{ ucwords(str_replace('_', ' ', 'title')) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="title" value="{{ $employee->title->name }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="employee_status">{{ ucwords(str_replace('_', ' ', 'employee_status')) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="employee_status" value="{{ $employee->employee_status->name }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="education">{{ ucwords(str_replace('_', ' ', 'education')) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="education" value="{{ $employee->education->name }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="campus">{{ ucwords(str_replace('_', ' ', 'campus')) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="campus" value="{{ $employee->campus->name }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="major">{{ ucwords(str_replace('_', ' ', 'major')) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="major" value="{{ $employee->major->name }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="religion">{{ ucwords(str_replace('_', ' ', 'religion')) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="religion" value="{{ $employee->religion->name }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="marital_status">{{ ucwords(str_replace('_', ' ', 'marital_status')) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="marital_status" value="{{ $employee->marital_status->name }}" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="bank">{{ ucwords(str_replace('_', ' ', 'bank')) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="bank" value="{{ $employee->bank->name }}" readonly>
                            </div>
                        </div>

                        @foreach($employee_identities as $employee_identity)
                        @php $column_name = str_replace(' ', '_', $employee_identity->name); @endphp
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="{{ $column_name }}">{{ ucwords(str_replace('_', ' ', $employee_identity->name)) }}</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="{{ $column_name }}" value="{{ $employee->{$column_name} }}" readonly>
                            </div>
                        </div>
                        @endforeach

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <a href="{{ route('employee.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
