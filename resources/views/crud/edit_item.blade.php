@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    {{-- BAGIAN ATAS: HEADER KUNING (MODE EDIT) DAN DATA INDUK --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #ffc107;">
            <h6 class="m-0 font-weight-bold text-dark">Edit Detail Penyewaan: {{ $itemInduk->id_detail }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">ID DETAIL</label>
                    <input type="text" class="form-control bg-light border-0 shadow-sm" value="{{ $itemInduk->id_detail }}" readonly>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">ID PEMBAYARAN</label>
                    <input type="text" class="form-control bg-light border-0 shadow-sm" value="{{ $itemInduk->id_pembayaran }}" readonly>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">NAMA PELANGGAN</label>
                    <input type="text" class="form-control bg-light border-0 shadow-sm" value="{{ $itemInduk->nama_pelanggan ?? 'N/A' }}" readonly>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">PICK UP</label>
                    <input type="text" class="form-control bg-light border-0 shadow-sm" value="{{ $itemInduk->pick_up }}" readonly>
                </div>

                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">RETURN DATE</label>
                    <input type="text" class="form-control bg-light border-0 shadow-sm" value="{{ $itemInduk->return_date }}" readonly>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN BAWAH: FORM EDIT RINCIAN --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route($route.'.update_item', $rincian->id_rincian) }}" method="POST">
                @csrf
                @method('PUT')
                
                <h5 class="text-center mb-4 fw-bold text-muted">UBAH DATA RINCIAN</h5>

                <div class="mb-3">
    <label class="form-label fw-bold">ALAT BERAT / BARANG</label>
    {{-- Cari nama truk yang sedang terpilih berdasarkan id_truk --}}
    @php 
        $trukTerpilih = $alatberat->where('id_truk', $rincian->id_truk)->first();
    @endphp
    
    {{-- Value hanya menampilkan Nama Truk saja --}}
    <input type="text" class="form-control bg-light border-0 shadow-sm" 
           value="{{ $trukTerpilih->nama_truk ?? 'N/A' }}" 
           readonly>
           
    {{-- Input hidden sangat penting agar id_truk tetap terkirim ke controller saat update --}}
    <input type="hidden" name="id_truk" id="id_truk" value="{{ $rincian->id_truk }}">

    {{-- Hidden input untuk harga_satuan tetap diperlukan agar perhitungan JS 'Banyaknya x Harga' tetap jalan --}}
    <input type="hidden" id="harga_satuan" value="{{ $trukTerpilih->harga ?? 0 }}">
</div>

                <div class="mb-3">
                    <label class="form-label fw-bold">BANYAKNYA</label>
                    <input type="number" name="banyaknya" id="banyaknya" class="form-control" 
                           value="{{ $rincian->banyaknya }}" min="1" required>
                </div>

                {{-- Hidden field untuk harga satuan guna perhitungan JS --}}
                <input type="hidden" name="harga_satuan" id="harga_satuan" value="{{ $rincian->jumlah / ($rincian->banyaknya ?: 1) }}">

                <div class="mb-3">
                    <label class="form-label fw-bold text-warning">JUMLAH (TOTAL HARGA ITEM)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-warning text-white">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" class="form-control bg-light fw-bold" 
                               value="{{ $rincian->jumlah }}" readonly>
                    </div>
                </div>

                <div class="mt-4 pt-3 d-flex justify-content-end gap-2 border-top">
                    <button type="submit" class="btn btn-warning px-4 shadow-sm text-dark fw-bold">
                        <i class="fas fa-save"></i> Perbarui Detail
                    </button>
                    <a href="{{ route($route.'.show', $itemInduk->id_detail) }}" class="btn btn-secondary px-4 shadow-sm">
                        Batal
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