@extends('template.sneat.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'create_title')) }}
@endsection

@section('title-active')
    {{ 'active' }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route("title.index") }}">{{ ucwords(str_replace('_', ' ', 'title')) }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">@yield("title")</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">@yield('title')</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route("title.store") }}" method="POST">
                            @csrf @method("POST")

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="sub_department">
                                    {{ ucwords(str_replace('_', ' ', 'sub_department')) }}
                                </label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" id="sub_department" name="sub_department_id" width="100%" required>
                                        <option disabled selected>Select a {{ ucwords(str_replace('_', ' ', 'sub_department')) }} :</option>
                                        @foreach ($sub_departments as $sub_department)
                                            <option value="{{ $sub_department->id }}">{{ $sub_department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="level">
                                    {{ ucwords(str_replace('_', ' ', 'level')) }}
                                </label>
                                <div class="col-sm-10">
                                    <select class="form-control select2" id="level" name="level_id" width="100%" required>
                                        <option disabled selected>Select a {{ ucwords(str_replace('_', ' ', 'level')) }} :</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="name">
                                    {{ ucwords(str_replace('_', ' ', 'name')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old("name") }}" required autofocus>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_script')
<script type="text/javascript">
    $(document).ready(function() {
        $('#sub_department').select2({
            theme: 'bootstrap',
            placeholder: "Select a sub_department"
        });
        $('#level').select2({
            theme: 'bootstrap',
            placeholder: "Select a level"
        });
    });
</script>
@endsection
