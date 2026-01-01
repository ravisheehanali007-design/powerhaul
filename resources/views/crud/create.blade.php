@extends('layouts.admin')

@section('content')

<h2 class="mb-4">Tambah {{ $title }}</h2>

<div class="card shadow">
    <div class="card-body">

        <form action="{{ route($route.'.store') }}" method="POST">
            @csrf

            {{-- Loop Field Dinamis --}}
            @foreach ($fields as $field)
                <div class="mb-3">
    <label class="form-label">
        @if($field === 'tgl_pembayaran') Tanggal Pembayaran
        @elseif($field === 'pay_online') Payment
        @elseif($field === 'online_method') Dompet Digital
        @elseif($field === 'id_pembayaran') ID Pembayaran
        @elseif($field === 'nik')
            {{ ($route === 'invoice' || $route === 'detailpenyewaan' || $route === 'pembayaran') ? 'Nama Pelanggan' : 'NIK' }}
        @else 
            {{ ucwords(str_replace('_',' ', $field)) }}
        @endif
    </label>

    {{-- 1. LOGIKA KHUSUS NIK --}}
    @if ($field === 'nik')
        @if ($route === 'invoice')
            {{-- Dropdown Khusus Invoice: Menampilkan Nama dan NIK --}}
            <select name="nik" class="form-control" required>
                <option value="">-- Pilih Pelanggan --</option>
                @isset($pelanggan)
                    @foreach($pelanggan as $p)
                        <option value="{{ $p->nik }}" {{ old('nik') == $p->nik ? 'selected' : '' }}>
                            {{ $p->nik }}
                        </option>
                    @endforeach
                @endisset
            </select>
        @elseif ($route === 'detailpenyewaan' || $route === 'pembayaran')
            {{-- Dropdown Standar untuk rute lain --}}
            <select name="nik" class="form-control" required>
                <option value="">-- Pilih Pelanggan --</option>
                @isset($pelanggan)
                    @foreach($pelanggan as $p)
                        <option value="{{ $p->nik }}" {{ old('nik') == $p->nik ? 'selected' : '' }}>
                            {{ $p->nama_pelanggan }}
                        </option>
                    @endforeach
                @endisset
            </select>
        @else
            {{-- Input Manual jika bukan rute transaksi --}}
            <input type="text" name="nik" value="{{ old('nik') }}" class="form-control" required>
        @endif

    {{-- 2. INPUT TANGGAL --}}
    @elseif ($field === 'pick_up' || $field === 'return_date' || str_contains($field, 'tanggal') || str_contains($field, 'tgl'))
        <input type="date" name="{{ $field }}" value="{{ old($field) }}" class="form-control" required>

    {{-- 3. LOGIKA DROPDOWN INVOICE --}}
    @elseif ($route === 'invoice')
        @if ($field === 'id_truk')
            <select name="id_truk" class="form-control" required>
                <option value="">-- Pilih Alat Berat --</option>
                @isset($alatberat)
                    @foreach($alatberat as $truk)
                        <option value="{{ $truk->id_truk }}" {{ old('id_truk') == $truk->id_truk ? 'selected' : '' }}>
                            {{ $truk->nama_truk }}
                        </option>
                    @endforeach
                @endisset
            </select>
        @elseif ($field === 'online_method')
            <select name="online_method" class="form-control">
                <option value="Cash Payment" {{ old('online_method') == 'Cash Payment' ? 'selected' : '' }}>Cash Payment</option>
                <option value="Online Payment" {{ old('online_method') == 'Online Payment' ? 'selected' : '' }}>Online Payment</option>
            </select>
        @elseif ($field === 'status')
            <select name="status" class="form-control" required>
                <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Success" {{ old('status') == 'Success' ? 'selected' : '' }}>Success</option>
                <option value="Cancel" {{ old('status') == 'Cancel' ? 'selected' : '' }}>Cancel</option>
            </select>
        @else
            <input type="{{ in_array($field, ['total', 'qty']) ? 'number' : 'text' }}" 
                   name="{{ $field }}" value="{{ old($field) }}" class="form-control" required>
        @endif

    {{-- 4. LOGIKA DETAIL PENYEWAAN --}}
    @elseif ($route === 'detailpenyewaan')
        @if ($field === 'id_truk')
            <select name="id_truk" class="form-control" required>
                <option value="">-- Pilih Alat Berat --</option>
                @isset($alatberat)
                    @foreach($alatberat as $truk)
                        <option value="{{ $truk->id_truk }}" {{ old('id_truk') == $truk->id_truk ? 'selected' : '' }}>
                            {{ $truk->nama_truk }} ({{ $truk->id_truk }})
                        </option>
                    @endforeach
                @endisset
            </select>
        @elseif ($field === 'status_sewa')
            <select name="status_sewa" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="pending" {{ old('status_sewa') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="disewa" {{ old('status_sewa') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                <option value="selesai" {{ old('status_sewa') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        @else
            <input type="text" name="{{ $field }}" value="{{ old($field) }}" class="form-control" required>
        @endif

    {{-- 5. LOGIKA DEFAULT (PEMBAYARAN DLL) --}}
    @else
        @if ($field === 'pay_online')
            <select name="pay_online" id="pay_online" class="form-control" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="Cash" {{ old('pay_online') == 'Cash' ? 'selected' : '' }}>Cash</option>
                <option value="Online" {{ old('pay_online') == 'Online' ? 'selected' : '' }}>Online</option>
            </select>
        @elseif ($field === 'online_method')
            <select name="online_method" id="online_method" class="form-control">
                <option value="">-- Pilih Metode --</option>
                <option value="GoPay" {{ old('online_method') == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                <option value="OVO" {{ old('online_method') == 'OVO' ? 'selected' : '' }}>OVO</option>
                <option value="DANA" {{ old('online_method') == 'DANA' ? 'selected' : '' }}>DANA</option>
            </select>
        @elseif (in_array($field, ['jumlah_sewa', 'harga', 'total', 'qty', 'tahun']))
            <input type="number" name="{{ $field }}" value="{{ old($field) }}" class="form-control" required>
        @else
            <input type="text" name="{{ $field }}" value="{{ old($field) }}" class="form-control" required>
        @endif
    @endif
</div>
            @endforeach

            {{-- Error Handling --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="{{ route($route.'.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

{{-- Script Otomatis Sembunyikan Dompet Digital --}}
@if($route === 'pembayaran')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paySelect = document.getElementById('pay_online');
        const methodField = document.getElementById('online_method');
        
        if(paySelect && methodField) {
            const methodDiv = methodField.parentElement;
            function toggleMethod() {
                methodDiv.style.display = paySelect.value === 'Online' ? 'block' : 'none';
            }
            paySelect.addEventListener('change', toggleMethod);
            toggleMethod();
        }
    });
</script>
@endif

@endsection