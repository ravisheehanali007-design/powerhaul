<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mobil - POWERHAUL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-size: 28px; color: #000; font-weight: bold; }
        .booking-card { position: sticky; top: 20px; }
    </style>
</head>
<body>

<nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container d-flex justify-content-center">
        <a class="navbar-brand" href="/">POWERHAUL</a>
    </div>
</nav>

<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <a href="{{ url('/dashboard') }}" class="btn btn-secondary mb-3">&larr; Back to Search Results</a>

            <div class="card border-0 shadow-sm p-4 mb-4">
                <div class="d-flex gap-4 align-items-center">
                    <img src="{{ asset('images/' . ($mobil->foto ?? 'car1.png')) }}" width="300" class="img-fluid rounded shadow-sm">
                    <div>
                        <h3>{{ $mobil->nama_truk }} <small class="text-muted">{{ $mobil->tahun ?? '2022' }}</small></h3>
                        <p class="mt-2">
                            <strong>Status: </strong>
                            @if(strtolower($mobil->status ?? '') == 'tersedia')
                                <span class="badge bg-success">Tersedia</span>
                            @else
                                <span class="badge bg-danger">{{ $mobil->status ?? 'Tidak Tersedia' }}</span>
                            @endif
                        </p>
                        <div class="d-flex flex-wrap gap-4 mt-3">
                            <div>Merk: {{ $mobil->merk ?? 'Fuso' }}</div>
                            <div>Kapasitas: {{ $mobil->kapasitas ?? 'N/A' }}</div>
                            <div>Tipe Bak: {{ $mobil->tipe_bak ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <h5 class="mb-3 border-bottom pb-2">Overview</h5>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Exterior Color:</strong> {{ $mobil->ext_color ?? '-' }}</p>
                    <p><strong>Interior Color:</strong> {{ $mobil->int_color ?? '-' }}</p>
                    <p><strong>Bahan Bakar:</strong> {{ $mobil->bahan_bakar ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Plat Nomor:</strong> {{ $mobil->plat_nomor ?? '-' }}</p>
                    <p><strong>Air Conditioner:</strong> {{ ($mobil->ac ?? 0) == 1 ? 'True' : 'False' }}</p>
                    <p><strong>GPS:</strong> {{ ($mobil->gps ?? 0) == 1 ? 'True' : 'False' }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="booking-card bg-white border p-4 rounded shadow-sm">
                <h3 class="text-primary">Rp {{ number_format($mobil->harga, 0, ',', '.') }} <small class="fs-6 text-muted">/ hari</small></h3>
                <hr>

                <form action="{{ route('user.store_booking') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_truk" value="{{ $mobil->id_truk }}">
                    <input type="hidden" name="car_name" value="{{ $mobil->nama_truk }}">
                    <input type="hidden" name="total" id="total_hidden" value="{{ $mobil->harga }}">
                    <input type="hidden" name="additional_info" id="additional_hidden">
                    <input type="hidden" name="qty" value="1">

                    <label class="fw-bold">Pick Up Date</label>
                    <input type="date" name="pick_up" id="pick" class="form-control mb-2" required min="{{ date('Y-m-d') }}">
                    
                    <label class="fw-bold">Return Date</label>
                    <input type="date" name="return_date" id="return" class="form-control mb-3" required min="{{ date('Y-m-d') }}">

                    <h6 class="fw-bold">Additional Options:</h6>
                    @php
                        $options = [
                            ['label' => 'Jasa Bongkar Muat', 'price' => 75000],
                            ['label' => 'Pelindung Barang', 'price' => 40000],
                            ['label' => 'Asuransi', 'price' => 25000]
                        ];
                    @endphp

                    @foreach($options as $opt)
                    <div class="form-check">
                        <input class="form-check-input opt" type="checkbox" value="{{ $opt['price'] }}" data-label="{{ $opt['label'] }}">
                        <label class="form-check-label">{{ $opt['label'] }} (+Rp {{ number_format($opt['price'], 0, ',', '.') }})</label>
                    </div>
                    @endforeach

                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5>Total:</h5>
                        <h5 id="total_display" class="text-danger fw-bold">Rp {{ number_format($mobil->harga, 0, ',', '.') }}</h5>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold mt-3" 
                        {{ strtolower($mobil->status ?? '') != 'tersedia' ? 'disabled' : '' }}>
                        {{ strtolower($mobil->status ?? '') == 'tersedia' ? 'Rent Now' : 'Out of Stock' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const basePrice = {{ $mobil->harga ?? 0 }};
    const pickInput = document.getElementById("pick");
    const returnInput = document.getElementById("return");
    const opts = document.querySelectorAll(".opt");
    const totalDisplay = document.getElementById("total_display");
    const totalHidden = document.getElementById("total_hidden");
    const additionalHidden = document.getElementById("additional_hidden");

    function calculateTotal() {
        let pickDate = new Date(pickInput.value);
        let returnDate = new Date(returnInput.value);
        let days = 1;

        // Hitung selisih hari jika tanggal valid
        if (!isNaN(pickDate) && !isNaN(returnDate)) {
            let diffTime = returnDate - pickDate;
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            days = diffDays > 0 ? diffDays : 1;
        }

        let extra = 0;
        let labels = [];
        opts.forEach(c => {
            if(c.checked) {
                extra += parseInt(c.value);
                labels.push(c.getAttribute('data-label'));
            }
        });
        
        let total = (basePrice * days) + extra;
        totalDisplay.innerText = "Rp " + total.toLocaleString("id-ID");
        totalHidden.value = total;
        additionalHidden.value = labels.join(", ");
    }

    pickInput.addEventListener("change", calculateTotal);
    returnInput.addEventListener("change", calculateTotal);
    opts.forEach(chk => {
        chk.addEventListener("change", calculateTotal);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>