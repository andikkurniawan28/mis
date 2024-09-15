@extends('template.sneat.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'transaction')) }}
@endsection

@section('transaction-active')
    {{ 'active' }}
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h4>List of <strong>@yield('title')</strong></h4>
                <div class="btn-group" role="group" aria-label="manage">
                    <a href="{{ route('transaction.create') }}" class="btn btn-sm btn-primary">Create</a>
                </div>
                <div class="table-responsive">
                    <span class="half-line-break"></span>
                    <table class="table table-bordered table-hovered" id="transaction_table" width="100%">
                        <thead>
                            <tr>
                                <th>{{ strtoupper(str_replace('_', ' ', 'id')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'timestamp')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'category')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'supplier')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'customer')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'warehouse')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'grand_total')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'left')) }}</th>
                                <th>{{ ucwords(str_replace('_', ' ', 'action')) }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#transaction_table').DataTable({
                layout: {
                    bottomStart: {
                        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5'],
                    },
                },
                processing: true,
                serverSide: true,
                ajax: "{{ route('transaction.index') }}",
                order: [
                    [0, 'desc']
                ],
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'transaction_category_id',
                        name: 'transaction_category.name'
                    },
                    {
                        data: 'supplier_id',
                        name: 'supplier.name'
                    },
                    {
                        data: 'customer_id',
                        name: 'customer.name'
                    },
                    {
                        data: 'warehouse_id',
                        name: 'warehouse.name'
                    },
                    {
                        data: 'grand_total',
                        name: 'grand_total',
                        class: 'text-right',
                        render: function(data, type, row) {
                            return data === '-' ? '-' : parseFloat(data).toLocaleString('en-US', {
                                maximumFractionDigits: 0 // Menghapus angka di belakang koma
                            });
                        }
                    },
                    {
                        data: 'left',
                        name: 'left',
                        class: 'text-right',
                        render: function(data, type, row) {
                            return data === '-' ? '-' : parseFloat(data).toLocaleString('en-US', {
                                maximumFractionDigits: 0 // Menghapus angka di belakang koma
                            });
                        }
                    },
                    {
                        data: null,
                        name: 'actions',
                        render: function(data, type, row) {
                            return `
                                <div class="btn-group" role="group" aria-label="manage">
                                    <a href="{{ url('transaction') }}/${row.id}" class="btn btn-info btn-sm">Show</a>
                                    <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="${row.id}" data-name="${row.id}">Delete</button>
                                </div>
                            `;
                        }
                    }
                ]
            });

            // Event delegation for delete buttons
            $(document).on('click', '.delete-btn', function(event) {
                event.preventDefault();
                const transactionId = $(this).data('id');
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = $('<form>', {
                            method: 'POST',
                            action: `{{ url('transaction') }}/${transactionId}`
                        });

                        $('<input>', {
                            type: 'hidden',
                            name: '_method',
                            value: 'DELETE'
                        }).appendTo(form);

                        $('<input>', {
                            type: 'hidden',
                            name: '_token',
                            value: csrfToken
                        }).appendTo(form);

                        form.appendTo('body').submit();
                    }
                });
            });
        });
    </script>
@endsection
