@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- BAGIAN ATAS: HEADER HIJAU DAN DATA INDUK --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #198754;">
            <h6 class="m-0 font-weight-bold text-white">Detail Penyewaan: {{ $item->id_detail }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Baris Data Induk (Readonly) --}}
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">ID DETAIL</label>
                    <input type="text" class="form-control bg-light border-0 shadow-sm" value="{{ $item->id_detail }}" readonly>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">ID PEMBAYARAN</label>
                    <input type="text" class="form-control bg-light border-0 shadow-sm" value="{{ $item->id_pembayaran }}" readonly>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">NAMA PELANGGAN</label>
                    <input type="text" class="form-control bg-light border-0 shadow-sm" value="{{ $item->nama_pelanggan ?? 'N/A' }}" readonly>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">PICK UP</label>
                    <input type="text" class="form-control bg-light border-0 shadow-sm" value="{{ $item->pick_up }}" readonly>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">RETURN DATE</label>
                    <input type="text" class="form-control bg-light border-0 shadow-sm" value="{{ $item->return_date }}" readonly>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN BAWAH: FORM INPUT RINCIAN BARU --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route($route.'.store_item') }}" method="POST">
                @csrf
                <input type="hidden" name="id_detail" value="{{ $item->id_detail }}">
                
                <h5 class="text-center mb-4 fw-bold text-muted">INPUT RINCIAN BARU</h5>

                <div class="mb-3">
                    <label class="form-label fw-bold">ALAT BERAT / BARANG</label>
                    <select name="id_truk" id="id_truk" class="form-control" required>
                        <option value="">---Pilih Alat Berat---</option>
                        @foreach($alatberat as $truk)
                            <option value="{{ $truk->id_truk }}" data-harga="{{ $truk->harga }}">
                                {{ $truk->nama_truk }} - Rp {{ number_format($truk->harga, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">BANYAKNYA</label>
                    <input type="number" name="banyaknya" id="banyaknya" class="form-control" placeholder="0" min="1" required>
                </div>

                <input type="hidden" name="harga_satuan" id="harga_satuan" value="0">

                <div class="mb-3">
                    <label class="form-label fw-bold text-success">JUMLAH (TOTAL HARGA ITEM)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-success text-white">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" class="form-control bg-light fw-bold" readonly placeholder="0">
                    </div>
                </div>

                <div class="mt-4 pt-3 d-flex justify-content-end gap-2 border-top">
                    <button type="submit" class="btn btn-success px-4 shadow-sm">
                        <i class="fas fa-save"></i> Simpan Detail
                    </button>
                    
                    
                    <a href="{{ route($route.'.show', $item->id_detail) }}" class="btn btn-secondary px-4 shadow-sm">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const idTrukSelect = document.getElementById('id_truk');
        const inputBanyaknya = document.getElementById('banyaknya');
        const inputHargaSatuan = document.getElementById('harga_satuan');
        const inputJumlah = document.getElementById('jumlah');

        function hitung() {
            const qty = parseFloat(inputBanyaknya.value) || 0;
            const harga = parseFloat(inputHargaSatuan.value) || 0;
            inputJumlah.value = qty * harga;
        }

        idTrukSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            inputHargaSatuan.value = selected.getAttribute('data-harga') || 0;
            hitung();
        });

        inputBanyaknya.addEventListener('input', hitung);
    });
</script>
@endsection