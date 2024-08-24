@extends('template.sneat.master')

@section('title', ucwords(str_replace('_', ' ', 'balance_sheet')))

@section('balance_sheet-active', 'active')

@section('content')

    <style>
        .account_group {
            padding-left: 0px;
        }

        .main_account {
            padding-left: 20;
        }

        .sub_account {
            padding-left: 40px;
        }

        .account {
            padding-left: 60px;
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h4><strong>@yield('title')</strong></h4>

                <!-- Form untuk Tahun dan Bulan -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="number" id="year" class="form-control" placeholder="Year" value="{{ date('Y') }}">
                    </div>
                    <div class="col-md-4">
                        <input type="number" id="month" class="form-control" placeholder="Month (1-12)"
                            value="{{ date('m') }}" min="1" max="12">
                    </div>
                    <div class="col-md-4">
                        <button id="submit_button" class="btn btn-primary">Generate Report</button>
                    </div>
                </div>

                <!-- Laporan Balance Sheet -->
                <div id="balance_sheet_report">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <td class="text-primary"><strong>Assets</strong></td>
                                        <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Level: account_group -->
                                    @foreach($account_groups->whereIn('name', ['Aktiva Lancar', 'Aktiva Tetap', 'Aktiva Lain-lain']) as $account_group)
                                        <tr>
                                            <td><div class="account_group text-dark"><strong>{{ $account_group->name }}</strong></div></td>
                                            <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                        </tr>
                                        <!-- Level: main_account -->
                                        @foreach($account_group->main_account as $main_account)
                                            <tr>
                                                <td><div class="main_account text-dark">{{ $main_account->name }}</div></td>
                                                <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                            </tr>
                                            <!-- Level: sub_account -->
                                            @foreach($main_account->sub_account as $sub_account)
                                                <tr>
                                                    <td><div class="sub_account text-dark">{{ $sub_account->name }}</div></td>
                                                    <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                                </tr>
                                                <!-- Level: account -->
                                                @foreach($sub_account->account as $account)
                                                    <tr>
                                                        <td><div class="account text-dark">{{ $account->name }}</div></td>
                                                        <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">

                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <td class="text-primary"><strong>Liabilities</strong></td>
                                        <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Level: account_group -->
                                    @foreach($account_groups->whereIn('name', ['Kewajiban Lancar', 'Kewajiban Jangka Panjang']) as $account_group)
                                        <tr>
                                            <td><div class="account_group text-dark"><strong>{{ $account_group->name }}</strong></div></td>
                                            <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                        </tr>
                                        <!-- Level: main_account -->
                                        @foreach($account_group->main_account as $main_account)
                                            <tr>
                                                <td><div class="main_account text-dark">{{ $main_account->name }}</div></td>
                                                <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                            </tr>
                                            <!-- Level: sub_account -->
                                            @foreach($main_account->sub_account as $sub_account)
                                                <tr>
                                                    <td><div class="sub_account text-dark">{{ $sub_account->name }}</div></td>
                                                    <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                                </tr>
                                                <!-- Level: account -->
                                                @foreach($sub_account->account as $account)
                                                    <tr>
                                                        <td><div class="account text-dark">{{ $account->name }}</div></td>
                                                        <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>

                            <br>

                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <td class="text-primary"><strong>Equity</strong></td>
                                        <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Level: account_group -->
                                    @foreach($account_groups->whereIn('name', ['Modal']) as $account_group)
                                        <tr>
                                            <td><div class="account_group text-dark"><strong>{{ $account_group->name }}</strong></div></td>
                                            <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                        </tr>
                                        <!-- Level: main_account -->
                                        @foreach($account_group->main_account as $main_account)
                                            <tr>
                                                <td><div class="main_account text-dark">{{ $main_account->name }}</div></td>
                                                <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                            </tr>
                                            <!-- Level: sub_account -->
                                            @foreach($main_account->sub_account as $sub_account)
                                                <tr>
                                                    <td><div class="sub_account text-dark">{{ $sub_account->name }}</div></td>
                                                    <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                                </tr>
                                                <!-- Level: account -->
                                                @foreach($sub_account->account as $account)
                                                    <tr>
                                                        <td><div class="account text-dark">{{ $account->name }}</div></td>
                                                        <td>{{ number_format(rand(1000000000,2000000000)) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#submit_button').on('click', function() {
                var year = $('#year').val();
                var month = $('#month').val();

                if (year && month >= 1 && month <= 12) {
                    $.ajax({
                        url: "{{ route('balance_sheet.data', ['year' => ':year', 'month' => ':month']) }}"
                            .replace(':year', year).replace(':month', month),
                        type: "GET",
                        success: function(response) {
                            var aktivaPasivaContent = '';
                            var modalContent = '';
                            var aktivaTotal = 0;
                            var pasivaTotal = 0;
                            var modalTotal = 0;

                            $.each(response.data, function(index, item) {
                                // Check if it's an Asset or Liability
                                if (item.type === 'Aktiva' || item.type === 'Pasiva') {
                                    aktivaPasivaContent += '<tr>';
                                    aktivaPasivaContent += '<td>' + item
                                        .account_group_name + '</td>';
                                    aktivaPasivaContent += '<td>' + item.account_name +
                                        '</td>';
                                    aktivaPasivaContent += '<td>' + item.final_balance
                                        .toFixed(2) + '</td>';
                                    aktivaPasivaContent += '</tr>';

                                    if (item.type === 'Aktiva') {
                                        aktivaTotal += item.final_balance;
                                    } else if (item.type === 'Pasiva') {
                                        pasivaTotal += item.final_balance;
                                    }
                                } else if (item.type === 'Modal') {
                                    modalContent += '<tr>';
                                    modalContent += '<td>' + item.account_group_name +
                                        '</td>';
                                    modalContent += '<td>' + item.account_name +
                                    '</td>';
                                    modalContent += '<td>' + item.final_balance.toFixed(
                                        2) + '</td>';
                                    modalContent += '</tr>';
                                    modalTotal += item.final_balance;
                                }
                            });

                            // Add totals
                            aktivaPasivaContent +=
                                '<tr><td><strong>Total Aktiva</strong></td><td></td><td>' +
                                aktivaTotal.toFixed(2) + '</td></tr>';
                            aktivaPasivaContent +=
                                '<tr><td><strong>Total Pasiva</strong></td><td></td><td>' +
                                pasivaTotal.toFixed(2) + '</td></tr>';

                            modalContent +=
                                '<tr><td><strong>Total Modal</strong></td><td></td><td>' +
                                modalTotal.toFixed(2) + '</td></tr>';

                            $('#aktiva_pasiva_content').html(
                                '<table class="table table-bordered">' +
                                aktivaPasivaContent + '</table>');
                            $('#modal_content').html('<table class="table table-bordered">' +
                                modalContent + '</table>');
                        },
                        error: function() {
                            alert('Error retrieving report data.');
                        }
                    });
                } else {
                    alert('Please enter a valid year and month (1-12).');
                }
            });
        });
    </script>
@endsection
