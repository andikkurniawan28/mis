@extends('template.sneat.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'create_repayment')) }}
@endsection

@section('repayment-active')
    {{ 'active' }}
@endsection

@section('content')
    <style>
        #repayment-details-table {
            width: 100%;
        }

        #repayment-details-table th,
        #repayment-details-table td {
            text-align: center;
            padding: 8px;
        }

        /* Define column widths */
        #repayment-details-table .col-material {
            width: 30%;
        }

        #repayment-details-table .col-qty {
            width: 15%;
        }

        #repayment-details-table .col-price {
            width: 20%;
        }

        #repayment-details-table .col-discount {
            width: 15%;
        }

        #repayment-details-table .col-total {
            width: 20%;
        }

        #repayment-details-table th:last-child,
        #repayment-details-table td:last-child {
            width: auto;
            /* For Action column */
        }
    </style>


    <script>
        function handleRepaymentCategoryChange(selectElement) {
            const repaymentCategoryId = selectElement.value;
            // console.log('Selected Repayment Category ID:', repaymentCategoryId);
            const apiUrl = `/api/generate_repayment_id/${repaymentCategoryId}`;
            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // console.log('Data fetched from API:', data);

                    // Asumsikan response dari API mengandung property `repayment_id`
                    if (data.repayment_id) {
                        // Menetapkan nilai repayment_id di input
                        document.getElementById('id').value = data.repayment_id;
                        deal_with = data.repayment_category.deal_with;
                        supplier_select = document.getElementById('supplier-select');
                        customer_select = document.getElementById('customer-select');
                        if(deal_with === "suppliers"){
                            supplier_select.style.display = "block";
                            customer_select.style.display = "none";
                        }
                        else if(deal_with === "customers"){
                            supplier_select.style.display = "none";
                            customer_select.style.display = "block";
                        }
                    }
                })
                .catch(error => {
                    console.error('There has been a problem with your fetch operation:', error);
                });
        }

        function handleSupplierOrCustomerChange() {
            const repaymentCategoryId = document.getElementById('repayment_category_id').value;
            const supplierId = document.getElementById('supplier_id').value;
            const customerId = document.getElementById('customer_id').value;

            let selectedId = supplierId || customerId; // Pilih ID dari supplier atau customer yang terpilih
            if (repaymentCategoryId && selectedId) {
                const apiUrl = `/api/generate_unpaid_transaction/${repaymentCategoryId}/${selectedId}`;

                fetch(apiUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Cetak response ke console
                        console.log('Response from unpaid transaction API:', data);
                        if (Array.isArray(data.data)) {
                            populateRepaymentTable(data.data); // Panggil fungsi dengan array transaksi
                        } else {
                            console.error('Unexpected data format:', data); // Tampilkan pesan kesalahan jika format tidak sesuai
                        }
                    })
                    .catch(error => {
                        console.error('There has been a problem with your fetch operation:', error);
                    });
            }
        }

        function populateRepaymentTable(transactions) {
            const tableBody = document.querySelector('#repayment-details-table tbody');
            tableBody.innerHTML = ''; // Kosongkan isi table body

            transactions.forEach(item => {
                let newRow = `
                    <tr>
                        <td>
                            <input type="text" name="details[${item.id}][transaction_id]" id="details[${item.id}][transaction_id]" value="${item.id}" class="form-control" readonly>
                        </td>
                        <td>
                            <input type="text" name="details[${item.id}][left]" id="details[${item.id}][left]" value="${item.left}" class="form-control" readonly>
                        </td>
                        <td>
                            <input type="number" name="details[${item.id}][discount]" id="details[${item.id}][discount]" value="0" class="form-control discount" oninput="updateTotal(${item.id})">
                        </td>
                        <td>
                            <input type="number" id="details[${item.id}][paid]" value="${item.left}" class="form-control paid" oninput="updateTotal(${item.id})">
                        </td>
                        <td>
                            <input type="number" name="details[${item.id}][total]" id="details[${item.id}][total]" value="${item.left}" class="form-control total" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-row">Remove</button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', newRow);
            });
        }

        function updateTotal(id) {
            const paidInput = document.getElementById(`details[${id}][paid]`);
            const discountInput = document.getElementById(`details[${id}][discount]`);
            const totalInput = document.getElementById(`details[${id}][total]`);

            const paid = parseFloat(paidInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;
            const total = paid + discount;

            totalInput.value = total.toFixed(0); // Update total dengan hasil paid + discount
        }

        document.addEventListener('DOMContentLoaded', function() {
            let rowCount = 1;

            // Initialize Select2 for dynamically added rows
            function initializeSelect2() {
                $('.select2').select2({
                    placeholder: "Select an option",
                    theme: 'bootstrap',
                    allowClear: true,
                    width: "100%"
                });
            }

            initializeSelect2(); // Initialize for existing rows

            // Ketika repayment category berubah
            document.getElementById('repayment_category_id').addEventListener('change', function() {
                handleRepaymentCategoryChange(this);
            });

            // Ketika supplier atau customer berubah
            document.getElementById('supplier_id').addEventListener('change', handleSupplierOrCustomerChange);
            document.getElementById('customer_id').addEventListener('change', handleSupplierOrCustomerChange);

            // document.getElementById('add-row').addEventListener('click', function() {
            //     let tableBody = document.querySelector('#repayment-details-table tbody');
            //     let newRow = "";
            //     tableBody.insertAdjacentHTML('beforeend', newRow);
            //     initializeSelect2(); // Re-initialize Select2 for new row
            //     rowCount++;

            //     // Fetch material info for the newly added select element
            //     const newMaterialSelect = tableBody.querySelector(`tr:last-child .material-select`);
            //     // fetchMaterialInfo(newMaterialSelect);
            //     updateTotal(); // Update totals after adding new row
            // });


            document.querySelector('#repayment-details-table').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                    updateTotal(); // Update totals after removing a row
                }
            });

            document.querySelector('#repayment-details-table').addEventListener('input', function(e) {
                if (e.target.classList.contains('qty') || e.target.classList.contains('price') || e.target
                    .classList
                    .contains('discount')) {
                    let row = e.target.closest('tr');
                    let qty = parseFloat(row.querySelector('.qty').value) || 0;
                    let price = parseFloat(row.querySelector('.price').value) || 0;
                    let discount = parseFloat(row.querySelector('.discount').value) || 0;
                    let total = (qty * price) - discount;
                    row.querySelector('.total').value = total.toFixed(0);
                    updateTotal(); // Update totals when values change
                }
            });

            // Safely adding event listeners to 'taxes', 'freight', and 'discount' inputs
            const taxesInput = document.getElementById('taxes');
            const freightInput = document.getElementById('freight');
            const discountInput = document.getElementById('discount');
            const paidInput = document.getElementById('paid');

            if (taxesInput) {
                taxesInput.addEventListener('input', updateTotal);
            }

            if (freightInput) {
                freightInput.addEventListener('input', updateTotal);
            }

            if (discountInput) {
                discountInput.addEventListener('input', updateTotal);
            }

            if (paidInput) {
                paidInput.addEventListener('input', updateTotal);
            }

            updateTotal(); // Initial totals calculation
        });
    </script>
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a
                        href="{{ route('repayment.index') }}">{{ ucwords(str_replace('_', ' ', 'repayment')) }}</a></li>
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
                        <form action="{{ route('repayment.store') }}" method="POST" id="repayment-form">
                            @csrf @method('POST')

                            <div class="container-xxl flex-grow-1 container-p-y">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="repayment_category_id">
                                                {{ ucwords(str_replace('_', ' ', 'repayment_category')) }}
                                            </label>
                                            <select width="100%" id="repayment_category_id"
                                                name="repayment_category_id" class="form-control select2" required
                                                onChange="handleRepaymentCategoryChange(this)">
                                                <option disabled selected>Select a
                                                    {{ ucwords(str_replace('_', ' ', 'repayment_category')) }}</option>
                                                @foreach ($repayment_categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="id">
                                                {{ ucwords(str_replace('_', ' ', 'ID')) }}
                                            </label>
                                            <input type="text" class="form-control" name="id" id="id"
                                                value="" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3" style="display: none;" id="supplier-select">
                                            <label for="supplier_id">
                                                {{ ucwords(str_replace('_', ' ', 'supplier')) }}
                                            </label>
                                            <select width="100%" id="supplier_id" name="supplier_id"
                                                class="form-control select2" onChange="handleSupplierOrCustomerChange(this)">
                                                <option disabled selected>Select a
                                                    {{ ucwords(str_replace('_', ' ', 'supplier')) }}</option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3" style="display: none;" id="customer-select">
                                            <label for="customer_id">
                                                {{ ucwords(str_replace('_', ' ', 'customer')) }}
                                            </label>
                                            <select width="100%" id="customer_id" name="customer_id"
                                                class="form-control select2" onChange="handleSupplierOrCustomerChange(this)">
                                                <option disabled selected>Select a
                                                    {{ ucwords(str_replace('_', ' ', 'customer')) }}</option>
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <br>
                                        <table class="table table-bordered" id="repayment-details-table">
                                            <thead>
                                                <tr>
                                                    <th class="col-id">ID</th>
                                                    <th class="col-last">Left</th>
                                                    <th class="col-discount">Discount</th>
                                                    <th class="col-paid">Paid</th>
                                                    <th class="col-total">Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>

                                        <!-- Total Calculation -->
                                        <table class="table table-bordered mt-4">
                                            <thead>
                                                <tr>
                                                    <th>Grand Total</th>
                                                    <th>Gateway</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="grand-total"><input type="number" name="grand_total" id="grand_total" class="form-control" readonly></td>
                                                    <td>
                                                        <select width="100%" id="payment_gateway_id" name="payment_gateway_id"
                                                            class="form-control select2">
                                                            <option disabled selected>Select a {{ ucwords(str_replace('_', ' ', 'payment_gateway')) }}</option>
                                                            @foreach ($payment_gateways as $payment_gateway)
                                                                <option value="{{ $payment_gateway->id }}">{{ $payment_gateway->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <br>

                                        <button type="submit" class="btn btn-primary" id="submit-button"
                                            disabled>Submit</button>

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
