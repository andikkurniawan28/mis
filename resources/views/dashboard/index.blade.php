@extends('template.sneat.master')

@section('dashboard-active')
    {{ 'active' }}
@endsection

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4>{{ ucwords(str_replace(' ', '_', 'dashboard')) }}</h4>

        <div class="row">

            {{--  --}}

        </div>
    </div>
    <!-- / Content -->
@endsection

@section('additional_script')

@endsection
