@extends('layouts.app')

@section('title', 'Create Purchase')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create Purchase</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Purchases</div>
                    <div class="breadcrumb-item">Create</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('purchase.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="products" id="products" value="22"/>

                        <div class="card-header">
                            <h4>Create Purchases</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Payment Method</label>
                                        <select class="form-control" name="payment">
                                            <option value="Cash">Cash</option>
                                            <option value="Transfer">Transfer</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Supplier</label>
                                        <select class="form-control" name="supplier_id">
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="row">
                                <div class="col-md-4" style="background: #e3e6e8; padding: 24px 24px;">
                                    <div class="form-group">
                                        <label>Product</label>
                                        <select class="form-control" id="product_id">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Quantity</label>
                                        <input type="number" class="form-control" id="qty">
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input type="number" class="form-control" id="price">
                                    </div>
                                    <div class="form-group">
                                        <label>Unit</label>
                                        <select class="form-control" id="unit_id">
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success" id="add-btn" type="button">Add</button>
                                    </div>

                                </div>
                                <div class="col-md-8">
                                    <table class="table" id="product-table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th class="align-right">Total </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        var products = [];
        $(document).on("click", "#add-btn", function(e) {
            e.preventDefault();

            var unitName = $("#unit_id").find("option:selected").text();
            var productName = $("#product_id").find("option:selected").text();

            var productId = parseInt($("#product_id").val());
            var unitId = parseInt($("#unit_id").val());
            var qty = parseFloat($("#qty").val());
            var price = parseFloat($("#price").val());
            var total = qty * price;

            const productExists = products.some(product => product.product_id === productId);

            if (productExists) {

                for (let i = 0; i < products.length; i++) {
                    if (products[i].product_id === productId) {
                        products[i].qty += parseFloat(qty);
                        qty += products[i].qty;

                        break; // Break the loop once the product is found and updated
                    }
                }

                $("#product-table tbody")
                    .find(`#product-${productId}`)
                    .html(`
                    <td>${productName}</td>
                    <td>${qty} ${unitName}</td>
                    <td>${price}</td>
                    <td>${total}</td>`);
            } else {
                products.push({
                    "product_id": productId,
                    "unit_id": unitId,
                    "product_name": productName,
                    "unit_name": unitName,
                    "qty": qty,
                    "price": price,
                    "total": total,
                });

                $("#product-table tbody").append(`
                <tr id="product-${productId}">
                    <td>${productName}</td>
                    <td>${qty} ${unitName}</td>
                    <td>${price}</td>
                    <td>${total}</td>
                </tr>
            `);
            }

            $("#products").val(JSON.stringify(products));
        });
    </script>
@endpush
