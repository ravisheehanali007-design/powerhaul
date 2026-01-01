@extends('layouts.admin')

@section('content')
{{-- CARD UTAMA DATA INDUK --}}
<div class="card shadow mb-4">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Penyewaan: {{ $item->id_detail }}</h5>
        {{-- Tombol Edit Data Induk --}}
        
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($fields as $field)
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold text-muted small text-uppercase">
                        {{ ucwords(str_replace('_', ' ', $field)) }}
                    </label>
                    <input type="text" 
                           class="form-control bg-light border-0 shadow-sm" 
                           value="{{ $item->$field ?? '-' }}" 
                           readonly>
                </div>
            @endforeach
        </div>

        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <a href="{{ route($route.'.create_item', $item->id_detail) }}" class="btn btn-primary shadow-sm">
    <i class="fas fa-plus"></i> Tambah Item Rincian
</a>
<a href="{{ route($route.'.print', $item->id_detail) }}" class="btn btn-info px-4 shadow-sm text-white" target="_blank">
        <i class="fas fa-print me-1"></i> Cetak
    </a>
            <a href="{{ route($route.'.index') }}" class="btn btn-secondary shadow-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

{{-- TABEL RINCIAN --}}
<div class="card shadow mb-4">
    <div class="card-header bg-light py-3">
        <h6 class="m-0 font-weight-bold text-primary">Rincian Item Penyewaan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-success text-center">
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Alat Berat</th>
                        <th>Banyaknya</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
    @php $totalKeseluruhan = 0; @endphp
    {{-- Gunakan $rincian, bukan $item agar semua data dari MySQL muncul --}}
    @foreach($rincian as $index => $row)
        @php $totalKeseluruhan += $row->jumlah; @endphp
        <tr>
            <td class="text-center">{{ $index + 1 }}</td>
            <td>
                {{-- Cek apakah nama_truk ada, jika tidak tampilkan ID-nya untuk cek --}}
                @if($row->nama_truk)
                    {{ $row->nama_truk }}
                @else
                    <span class="text-danger">N/A (ID: {{ $row->id_truk }} Tidak Ditemukan)</span>
                @endif
            </td>
            <td class="text-center">{{ $row->banyaknya }} Unit</td>
            <td class="text-end">Rp {{ number_format($row->jumlah / ($row->banyaknya ?: 1), 0, ',', '.') }}</td>
            <td class="text-end">Rp {{ number_format($row->jumlah, 0, ',', '.') }}</td>
            <td class="text-center">
                <div class="d-flex justify-content-center gap-2" role="group">
                    {{-- TOMBOL UBAH / EDIT --}}
                    <a href="{{ route($route.'.edit_item', $row->id_rincian) }}" class="btn btn-warning btn-sm" title="Ubah Item">
                        <i class="fas fa-edit"></i>
                    </a>

                    {{-- TOMBOL HAPUS --}}
                    <form action="{{ route($route.'.destroy_item', $row->id_rincian) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
                <tfoot>
                    <tr class="fw-bold bg-light">
                        <td colspan="4" class="text-end">Total Harga</td>
                        <td class="text-right text-success fw-bold">
    Rp {{ number_format($rincian->sum('jumlah'), 0, ',', '.') }}
</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection