@extends('template.sneat.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'edit_service')) }}
@endsection

@section('service-active')
    {{ 'active' }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route("service.index") }}">{{ ucwords(str_replace('_', ' ', 'service')) }}</a></li>
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
                        <form action="{{ route("service.update", $service->id) }}" method="POST">
                            @csrf @method("PUT")

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="name">
                                    {{ ucwords(str_replace('_', ' ', 'name')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old("name", $service->name) }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="sell_price">
                                    {{ ucwords(str_replace('_', ' ', 'sell_price')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="number" step="any" class="form-control" id="sell_price" name="sell_price" value="{{ old("sell_price", $service->sell_price) }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="buy_price">
                                    {{ ucwords(str_replace('_', ' ', 'buy_price')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="number" step="any" class="form-control" id="buy_price" name="buy_price" value="{{ old("buy_price", $service->buy_price) }}">
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
