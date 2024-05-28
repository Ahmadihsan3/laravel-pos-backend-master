@extends('layouts.app')

@section('title', 'Edit Purchase')

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
                <h1>Edit Purchase</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Purchases</div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('purchase.update', ['id' => $purchase->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="products" id="products" value="">

                        <div class="card-header">
                            <h4>Edit Purchase</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table" id="product-table">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th class="align-right">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchaseDetails as $detail)
                                                <tr id="product-{{ $detail->product_id }}">
                                                    <td>{{ $detail->product->name }}</td>
                                                    <td contenteditable="true" class="editable-qty">{{ $detail->quantity }} {{ $detail->unit->name }}</td>
                                                    <td contenteditable="true" class="editable-price">{{ $detail->price }}</td>
                                                    <td>{{ $detail->total_price }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
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

$(document).on("input", ".editable-qty, .editable-price", function() {
    var row = $(this).closest("tr");
    var qty = parseFloat(row.find(".editable-qty").text());
    var price = parseFloat(row.find(".editable-price").text());
    var total = qty * price;
    row.find("td:last").text(total);

    var productId = parseInt(row.attr('id').split('-')[1]);
    products = products.map(product => {
        if (product.product_id === productId) {
            product.qty = qty;
            product.price = price;
            product.total = total;
        }
        return product;
    });

    $("#products").val(JSON.stringify(products));
});

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

                break;
            }
        }

        $("#product-table tbody")
            .find(`#product-${productId}`)
            .html(`
            <td>${productName}</td>
            <td contenteditable="true" class="editable-qty">${qty} ${unitName}</td>
            <td contenteditable="true" class="editable-price">${price}</td>
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
            <td contenteditable="true" class="editable-qty">${qty} ${unitName}</td>
            <td contenteditable="true" class="editable-price">${price}</td>
            <td>${total}</td>
        </tr>
    `);
    }

    $("#products").val(JSON.stringify(products));
});

// Initialize products array with existing purchase details
$(document).ready(function() {
    @foreach ($purchaseDetails as $detail)
    products.push({
        "product_id": {{ $detail->product_id }},
        "unit_id": {{ $detail->unit_id }},
        "product_name": "{{ $detail->product->name }}",
        "unit_name": "{{ $detail->unit->name }}",
        "qty": {{ $detail->quantity }},
        "price": {{ $detail->price }},
        "total": {{ $detail->total_price }},
    });
    @endforeach

    $("#products").val(JSON.stringify(products));
});

    </script>
@endpush
