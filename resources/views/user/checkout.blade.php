<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Place Order - Powerhaul</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .header-title { text-align: center; font-weight: bold; padding: 40px 0; font-size: 24px; text-transform: uppercase; }
        .form-section { background: #fff; border-radius: 4px; padding: 40px; border: 1px solid #e0e0e0; margin-bottom: 50px; }
        .section-title { font-size: 20px; font-weight: bold; margin-bottom: 25px; color: #333; }
        .form-label { font-weight: 500; color: #555; font-size: 14px; }
        .form-control { border-radius: 4px; padding: 10px; border: 1px solid #ddd; background-color: #fafafa; }
        .order-summary-box { border: 1px solid #ddd; padding: 20px; border-radius: 4px; margin-top: 20px; }
        .btn-order { background: #ff3d00; border: none; padding: 15px; font-weight: bold; font-size: 16px; border-radius: 4px; transition: 0.3s; }
        .btn-order:hover { background: #e63600; }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .total-row { border-top: 2px solid #eee; padding-top: 15px; margin-top: 15px; font-weight: bold; font-size: 18px; }
        .product-name { color: red; font-weight: bold; }
    </style>
</head>
<body>

<div class="header-title">POWERHAUL</div>

<div class="container" style="max-width: 1000px;">
    <div class="form-section">
        <form action="{{ route('user.place_order') }}" method="POST">
            @csrf
            
            {{-- Hidden Data - Sinkron dengan BookingController --}}
            <input type="hidden" name="order_id" value="{{ $order_id }}">
            <input type="hidden" name="id_truk" value="{{ $id_truk }}">
            <input type="hidden" name="qty" value="{{ $qty }}">
            <input type="hidden" name="pick_up" value="{{ $pick_up }}">
            <input type="hidden" name="return_date" value="{{ $return_date }}">
            <input type="hidden" name="total" value="{{ $car_price }}">
            

            <div class="row">
                <div class="col-md-12">
                    <h4 class="section-title">Billing details</h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">First name *</label>
                            <input type="text" name="fname" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Last name *</label>
                            <input type="text" name="lname" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">NIK *</label>
                            <input type="text" name="nik" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Country *</label>
                            <input type="text" name="country" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City *</label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Street Address *</label>
                            <input type="text" name="streetaddress" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Kode Pos *</label>
                            <input type="text" name="kodepos" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Phone *</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Order notes (optional)</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5">
                    <h4 class="section-title">Your order</h4>
                    <div class="order-summary-box">
                        <div class="summary-item border-bottom pb-2 mb-3">
                            <strong>Product</strong>
                            <strong>Subtotal</strong>
                        </div>
                        <div class="summary-item">
                            <span>Cars: <span class="product-name">{{ $car_name }}</span> × {{ $qty }}</span>
                        </div>
                        <div class="summary-item mt-3">
                            <div>
                                <strong>Check In:</strong><br>
                                <small class="text-muted">{{ $pick_up }}</small>
                            </div>
                            <span>Rp {{ number_format($car_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-item mt-2">
                            <div>
                                <strong>Check Out:</strong><br>
                                <small class="text-muted">{{ $return_date }}</small>
                            </div>
                        </div>
                        <div class="summary-item total-row">
                            <span>Total</span>
                            <span class="text-danger">Rp {{ number_format($car_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-4 p-3 border rounded bg-light">
                        <h5 class="section-title mb-3" style="font-size: 16px;">Payment Method</h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_cash" value="cash" checked>
                            <label class="form-check-label" for="pay_cash">Pay with Cash</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="pay_online" value="online">
                            <label class="form-check-label" for="pay_online">Online Payment</label>
                        </div>
                        
                    </div>

                    <button type="submit" class="btn btn-order text-white w-100 mt-4">PLACE ORDER</button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>