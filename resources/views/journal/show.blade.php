@extends('template.sneat.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'show_journal')) }}
@endsection

@section('journal-active')
    {{ 'active' }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('journal.index') }}">{{ ucwords(str_replace('_', ' ', 'journal')) }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">@yield('title')</h5>
                        <a href="{{ route('journal.index') }}" class="btn btn-primary">Back to List</a>
                    </div>
                    <div class="card-body">
                        <h4>Invoice Details</h4>
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Timestamp</th>
                                            <th>Admin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $journal->id }}</td>
                                            <td>{{ $journal->created_at->format('d M Y') }}</td>
                                            <td>{{ $journal->created_at }}</td>
                                            <td>{{ $journal->user->name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>

                                <h5>Journal Details</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Account ID</th>
                                            <th>Account Name</th>
                                            <th>Description</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($journal->journal_detail as $detail)
                                            <tr>
                                                <td>{{ $detail->account->id }}</td>
                                                <td>{{ $detail->account->name }}</td>
                                                <td>{{ $detail->description }}</td>
                                                <td>{{ number_format($detail->debit, 2) }}</td>
                                                <td>{{ number_format($detail->credit, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3">Total</th>
                                            <th>{{ number_format($journal->journal_detail->sum('debit'), 2) }}</th>
                                            <th>{{ number_format($journal->journal_detail->sum('credit'), 2) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <br>
                                <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
