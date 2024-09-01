@extends('template.sneat.master')

@section('title')
    {{ ucwords(str_replace('_', ' ', 'create_transaction')) }}
@endsection

@section('transaction-active')
    {{ 'active' }}
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}">{{ ucwords(str_replace('_', ' ', 'transaction')) }}</a></li>
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
                        <form action="{{ route('transaction.store') }}" method="POST" id="transaction-form">
                            @csrf @method('POST')

                            {{-- <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="id">
                                    {{ ucwords(str_replace('_', ' ', 'id')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="id" name="id" value="{{ $id }}" readonly>
                                </div>
                            </div> --}}

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="transaction_category_id">
                                    {{ ucwords(str_replace('_', ' ', 'transaction_category')) }}
                                </label>
                                <div class="col-sm-10">
                                    <select id="transaction_category_id" name="transaction_category_id" class="form-control select2" required>
                                        <option disabled selected>Select a transaction category</option>
                                        @foreach($transaction_categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Add other fields here, e.g., user_id, payment_term_id, etc. -->

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="valid_until">
                                    {{ ucwords(str_replace('_', ' ', 'valid_until')) }}
                                </label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" id="valid_until" name="valid_until" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <table class="table table-bordered" id="transaction-details-table">
                                        <thead>
                                            <tr>
                                                <th>Material</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Discount</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="details[0][material_id]" class="form-control select2" required>
                                                        <option disabled selected>Select a material</option>
                                                        @foreach($materials as $material)
                                                            <option value="{{ $material->id }}">{{ $material->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                {{-- <td>
                                                    <input type="number" name="details[0][item_order]" class="form-control" required>
                                                </td> --}}
                                                <td>
                                                    <input type="number" name="details[0][qty]" class="form-control qty" step="0.01" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="details[0][price]" class="form-control price" step="0.01" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="details[0][discount]" class="form-control discount" step="0.01" required>
                                                </td>
                                                <td>
                                                    <input type="number" name="details[0][total]" class="form-control total" step="0.01" readonly>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <br>

                                    <button type="button" id="add-row" class="btn btn-success">Add Row</button>

                                    <!-- Total Calculation -->
                                    <table class="table table-bordered mt-4">
                                        <thead>
                                            <tr>
                                                <th>Total Subtotal</th>
                                                <th>Total Taxes</th>
                                                <th>Total Freight</th>
                                                <th>Total Discount</th>
                                                <th>Grand Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td id="total-subtotal">0.00</td>
                                                <td id="total-taxes">0.00</td>
                                                <td id="total-freight">0.00</td>
                                                <td id="total-discount">0.00</td>
                                                <td id="grand-total">0.00</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <br>

                                    <button type="submit" class="btn btn-primary" id="submit-button" disabled>Submit</button>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let rowCount = 1;

            // Initialize Select2 for dynamically added rows
            function initializeSelect2() {
                $('.select2').select2({
                    placeholder: "Select an option",
                    theme: 'bootstrap',
                    allowClear: true
                });
            }

            initializeSelect2(); // Initialize for existing rows

            function updateTotals() {
                let totalSubtotal = 0;
                let totalTaxes = parseFloat(document.getElementById('taxes').value) || 0;
                let totalFreight = parseFloat(document.getElementById('freight').value) || 0;
                let totalDiscount = parseFloat(document.getElementById('discount').value) || 0;

                document.querySelectorAll('.total').forEach(function (input) {
                    totalSubtotal += parseFloat(input.value) || 0;
                });

                const grandTotal = totalSubtotal + totalTaxes + totalFreight - totalDiscount;
                document.getElementById('total-subtotal').textContent = totalSubtotal.toFixed(2);
                document.getElementById('grand-total').textContent = grandTotal.toFixed(2);

                // Enable/Disable submit button based on totals
                const submitButton = document.getElementById('submit-button');
                if (totalSubtotal > 0 && grandTotal >= 0) {
                    submitButton.disabled = false;
                } else {
                    submitButton.disabled = true;
                }
            }

            document.getElementById('add-row').addEventListener('click', function () {
                let tableBody = document.querySelector('#transaction-details-table tbody');
                let newRow = `
                    <tr>
                        <td>
                            <select name="details[${rowCount}][material_id]" class="form-control select2" required>
                                <option disabled selected>Select a material</option>
                                @foreach($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="details[${rowCount}][qty]" class="form-control qty" step="0.01" required>
                        </td>
                        <td>
                            <input type="number" name="details[${rowCount}][price]" class="form-control price" step="0.01" required>
                        </td>
                        <td>
                            <input type="number" name="details[${rowCount}][discount]" class="form-control discount" step="0.01" required>
                        </td>
                        <td>
                            <input type="number" name="details[${rowCount}][total]" class="form-control total" step="0.01" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-row">Remove</button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', newRow);
                initializeSelect2(); // Re-initialize Select2 for new row
                rowCount++;
                updateTotals(); // Update totals after adding new row
            });

            document.querySelector('#transaction-details-table').addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('tr').remove();
                    updateTotals(); // Update totals after removing a row
                }
            });

            document.querySelector('#transaction-details-table').addEventListener('input', function (e) {
                if (e.target.classList.contains('qty') || e.target.classList.contains('price') || e.target.classList.contains('discount')) {
                    let row = e.target.closest('tr');
                    let qty = parseFloat(row.querySelector('.qty').value) || 0;
                    let price = parseFloat(row.querySelector('.price').value) || 0;
                    let discount = parseFloat(row.querySelector('.discount').value) || 0;
                    let total = (qty * price) - discount;
                    row.querySelector('.total').value = total.toFixed(2);
                    updateTotals(); // Update totals when values change
                }
            });

            document.getElementById('taxes').addEventListener('input', updateTotals);
            document.getElementById('freight').addEventListener('input', updateTotals);
            document.getElementById('discount').addEventListener('input', updateTotals);

            updateTotals(); // Initial totals calculation
        });
    </script>
@endsection
