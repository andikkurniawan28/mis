@extends('template.sneat.master')

@section('title', ucwords(str_replace('_', ' ', 'balance_sheet')))

@section('balance_sheet-active', 'active')

@section('content')

    <style>
        .account_group {
            padding-left: 0px;
        }

        .main_account {
            padding-left: 20px;
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
                            <table class="table table-bordered table-sm" id="assets_table">
                                <thead>
                                    <tr>
                                        <td class="text-primary"><strong>Assets</strong></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan diisi oleh JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">

                            <table class="table table-bordered table-sm" id="liabilities_table">
                                <thead>
                                    <tr>
                                        <td class="text-primary"><strong>Liabilities</strong></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan diisi oleh JavaScript -->
                                </tbody>
                            </table>

                            <br>

                            <table class="table table-bordered table-sm" id="equity_table">
                                <thead>
                                    <tr>
                                        <td class="text-primary"><strong>Equity</strong></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan diisi oleh JavaScript -->
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("additional_script")
    <script>
        $(document).ready(function() {
            $('#submit_button').click(function() {
                var year = $('#year').val();
                var month = $('#month').val();
                var url = "{{ url('balance_sheet/data') }}/" + year + "/" + month;  // Bangun URL dengan parameter

                $.ajax({
                    url: url,
                    method: "GET",
                    data: {
                        year: year,
                        month: month
                    },
                    success: function(response) {
                        // Bersihkan tabel sebelum mengisi data
                        $('#assets_table tbody').empty();
                        $('#liabilities_table tbody').empty();
                        $('#equity_table tbody').empty();

                        // Inisialisasi total
                        var total_assets = 0;
                        var total_liabilities = 0;
                        var total_equity = 0;

                        // Render kolom Assets
                        var assets_html = '';
                        $.each(response.data, function(index, account_group) {
                            if (['Aktiva Lancar', 'Aktiva Tetap', 'Aktiva Lain-lain'].includes(account_group.name)) {
                                var group_total = account_group.balance_sheet;

                                assets_html += `
                                    <tr>
                                        <td><div class="account_group text-dark"><strong>${account_group.name}</strong></div></td>
                                        <td>${number_format(group_total)}</td>
                                    </tr>`;

                                total_assets += group_total;

                                $.each(account_group.main_account, function(index, main_account) {
                                    var main_total = main_account.balance_sheet;

                                    assets_html += `
                                        <tr>
                                            <td><div class="main_account text-dark">${main_account.name}</div></td>
                                            <td>${number_format(main_total)}</td>
                                        </tr>`;

                                    total_assets += main_total;

                                    $.each(main_account.sub_account, function(index, sub_account) {
                                        var sub_total = sub_account.balance_sheet;

                                        assets_html += `
                                            <tr>
                                                <td><div class="sub_account text-dark">${sub_account.name}</div></td>
                                                <td>${number_format(sub_total)}</td>
                                            </tr>`;

                                        total_assets += sub_total;

                                        $.each(sub_account.account, function(index, account) {
                                            var account_total = account.balance_sheet;

                                            assets_html += `
                                                <tr>
                                                    <td><div class="account text-dark">${account.name}</div></td>
                                                    <td>${number_format(account_total)}</td>
                                                </tr>`;

                                            total_assets += account_total;
                                        });
                                    });
                                });
                            }
                        });
                        $('#assets_table tbody').append(assets_html);
                        $('#assets_table tbody').append(`
                            <tr>
                                <td><strong>Total Assets</strong></td>
                                <td><strong>${number_format(total_assets)}</strong></td>
                            </tr>
                        `);

                        // Render kolom Liabilities
                        var liabilities_html = '';
                        $.each(response.data, function(index, account_group) {
                            if (['Kewajiban Lancar', 'Kewajiban Jangka Panjang'].includes(account_group.name)) {
                                var group_total = account_group.balance_sheet;

                                liabilities_html += `
                                    <tr>
                                        <td><div class="account_group text-dark"><strong>${account_group.name}</strong></div></td>
                                        <td>${number_format(group_total)}</td>
                                    </tr>`;

                                total_liabilities += group_total;

                                $.each(account_group.main_account, function(index, main_account) {
                                    var main_total = main_account.balance_sheet;

                                    liabilities_html += `
                                        <tr>
                                            <td><div class="main_account text-dark">${main_account.name}</div></td>
                                            <td>${number_format(main_total)}</td>
                                        </tr>`;

                                    total_liabilities += main_total;

                                    $.each(main_account.sub_account, function(index, sub_account) {
                                        var sub_total = sub_account.balance_sheet;

                                        liabilities_html += `
                                            <tr>
                                                <td><div class="sub_account text-dark">${sub_account.name}</div></td>
                                                <td>${number_format(sub_total)}</td>
                                            </tr>`;

                                        total_liabilities += sub_total;

                                        $.each(sub_account.account, function(index, account) {
                                            var account_total = account.balance_sheet;

                                            liabilities_html += `
                                                <tr>
                                                    <td><div class="account text-dark">${account.name}</div></td>
                                                    <td>${number_format(account_total)}</td>
                                                </tr>`;

                                            total_liabilities += account_total;
                                        });
                                    });
                                });
                            }
                        });
                        $('#liabilities_table tbody').append(liabilities_html);
                        $('#liabilities_table tbody').append(`
                            <tr>
                                <td><strong>Total Liabilities</strong></td>
                                <td><strong>${number_format(total_liabilities)}</strong></td>
                            </tr>
                        `);

                        // Render kolom Equity
                        var equity_html = '';
                        $.each(response.data, function(index, account_group) {
                            if (account_group.name === 'Modal') {
                                var group_total = account_group.balance_sheet;

                                equity_html += `
                                    <tr>
                                        <td><div class="account_group text-dark"><strong>${account_group.name}</strong></div></td>
                                        <td>${number_format(group_total)}</td>
                                    </tr>`;

                                total_equity += group_total;

                                $.each(account_group.main_account, function(index, main_account) {
                                    var main_total = main_account.balance_sheet;

                                    equity_html += `
                                        <tr>
                                            <td><div class="main_account text-dark">${main_account.name}</div></td>
                                            <td>${number_format(main_total)}</td>
                                        </tr>`;

                                    total_equity += main_total;

                                    $.each(main_account.sub_account, function(index, sub_account) {
                                        var sub_total = sub_account.balance_sheet;

                                        equity_html += `
                                            <tr>
                                                <td><div class="sub_account text-dark">${sub_account.name}</div></td>
                                                <td>${number_format(sub_total)}</td>
                                            </tr>`;

                                        total_equity += sub_total;

                                        $.each(sub_account.account, function(index, account) {
                                            var account_total = account.balance_sheet;

                                            equity_html += `
                                                <tr>
                                                    <td><div class="account text-dark">${account.name}</div></td>
                                                    <td>${number_format(account_total)}</td>
                                                </tr>`;

                                            total_equity += account_total;
                                        });
                                    });
                                });
                            }
                        });
                        $('#equity_table tbody').append(equity_html);
                        $('#equity_table tbody').append(`
                            <tr>
                                <td><strong>Total Equity</strong></td>
                                <td><strong>${number_format(total_equity)}</strong></td>
                            </tr>
                        `);
                    }
                });
            });
        });

        function number_format(number) {
            if (number < 0) {
                return `(${Math.abs(number).toLocaleString('en-US')})`;
            }
            return number.toLocaleString('en-US');
        }
    </script>
@endsection


