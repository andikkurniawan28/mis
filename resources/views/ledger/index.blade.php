@extends('template.sneat.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'ledger')) }}
@endsection

@section('ledger-active')
    {{ 'active' }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h4>List of <strong>@yield('title')</strong></h4>

                <!-- Form untuk Select2 dan Tanggal -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <select id="account_select" class="form-control select2" name="account_id">
                            <option value="">Select Account</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" id="start_date" class="form-control" placeholder="Start Date" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <?php
                        // Mengatur tanggal hari ini
                        $today = new DateTime();
                        // Menambahkan satu hari
                        $nextDay = $today->modify('+1 day')->format('Y-m-d');
                        ?>
                        <input type="date" id="end_date" class="form-control" placeholder="End Date" value="{{ $nextDay }}">
                    </div>
                    <div class="col-md-2">
                        <button id="filter_button" class="btn btn-primary">Filter</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hovered" id="ledger_table" width="100%">
                        <thead>
                            <tr>
                                <th>{{ ucwords(str_replace('_', ' ', 'time')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'description')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'debit')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'credit')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'balance')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'user')) }}</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_script')
    <script type="text/javascript">
        $(document).ready(function() {
            // Inisialisasi Select2
            $('#account_select').select2({
                theme: 'bootstrap',
                placeholder: "Select an account",
                allowClear: true // Mengaktifkan opsi clearable
            });

            // Inisialisasi DataTable kosong
            var table = $('#ledger_table').DataTable({
                layout: {
                    bottomStart: {
                        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
                    },
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "",
                    type: "GET",
                    data: function(d) {
                        d.account_id = $('#account_select').val();
                        d.start_date = $('#start_date').val();
                        d.end_date = $('#end_date').val();
                    }
                },
                order: [
                    [0, 'asc']
                ],
                columns: [{
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'debit',
                        name: 'debit'
                    },
                    {
                        data: 'credit',
                        name: 'credit'
                    },
                    {
                        data: 'balance',
                        name: 'balance'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                ],
                "bPaginate": false, // Menonaktifkan pagination
                "bFilter": false, // Menonaktifkan pencarian
                "bInfo": false, // Menonaktifkan informasi jumlah data
                "bServerSide": false, // Nonaktifkan server-side processing saat inisialisasi
            });

            // Event Listener untuk Filter Button
            $('#filter_button').on('click', function() {
                var account_id = $('#account_select').val();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();

                if (account_id && start_date && end_date) {
                    // Set ajax URL dengan parameter yang dibutuhkan dan reload DataTable
                    var url =
                        "{{ route('ledger.data', ['account_id' => ':account_id', 'start_date' => ':start_date', 'end_date' => ':end_date']) }}";
                    url = url.replace(':account_id', account_id)
                        .replace(':start_date', start_date)
                        .replace(':end_date', end_date);

                    table.ajax.url(url).load();
                } else {
                    alert('Please select an account and specify both start and end dates.');
                }
            });

        });
    </script>
@endsection
