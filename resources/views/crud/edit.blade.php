@extends('layouts.admin')

@section('content')

<h2 class="mb-4">Edit {{ $title }}</h2>

<div class="card shadow">
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route($route.'.update', $item->{$primaryKey}) }}" method="POST">
            @csrf
            @method('PUT')

            @foreach ($fields as $field)
                {{-- Lewati field yang tidak boleh di-edit secara manual --}}
                @if ($field === $primaryKey || $field === 'nama_truk' || $field === 'nama_pelanggan' || $field === 'created_at')
                    @continue
                @endif

                <div class="mb-3" id="container_{{ $field }}">
                    <label class="form-label">
                        @if($field === 'fname') Nama Lengkap
                        @elseif($field === 'id_truk') Pilih Alat Berat
                        @elseif($field === 'nik') Pilih Pelanggan
                        @elseif($field === 'online_method') Metode Pembayaran
                        @elseif($field === 'pay_online') Status Payment
                        @else 
                            {{ ucwords(str_replace('_',' ', $field)) }}
                        @endif
                    </label>

                    {{-- 1. LOGIKA DROPDOWN ALAT BERAT (Untuk Invoice & Detail Penyewaan) --}}
                    @if ($field === 'id_truk')
                        <select name="id_truk" class="form-control" required>
                            <option value="">-- Pilih Alat Berat --</option>
                            @isset($alatberat)
                                @foreach($alatberat as $truk)
                                    <option value="{{ $truk->id_truk }}" {{ old('id_truk', $item->id_truk) == $truk->id_truk ? 'selected' : '' }}>
                                        {{ $truk->nama_truk }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>

                    {{-- 2. LOGIKA DROPDOWN PELANGGAN (Untuk Invoice, Pembayaran, Detail) --}}
                    @elseif ($field === 'nik')
                        <select name="nik" class="form-control" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @isset($pelanggan)
                                @foreach($pelanggan as $p)
                                    <option value="{{ $p->nik }}" {{ old('nik', $item->nik) == $p->nik ? 'selected' : '' }}>
                                        {{ $p->nik }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>

                    {{-- 3. LOGIKA STATUS STOK (Untuk Stok Alat Berat) --}}
                    @elseif ($field === 'status')
                        <select name="status" class="form-control" required>
                            <option value="tersedia" {{ old('status', strtolower($item->status)) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="tidak tersedia" {{ old('status', strtolower($item->status)) === 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>

                    {{-- 4. LOGIKA STATUS SEWA (Untuk Detail Penyewaan) --}}
                    @elseif ($field === 'status_sewa')
                        <select name="status_sewa" class="form-control" required>
                            @foreach(['pending', 'disewa', 'selesai', 'dibatalkan'] as $st)
                                <option value="{{ $st }}" {{ old('status_sewa', $item->status_sewa) === $st ? 'selected' : '' }}>
                                    {{ ucfirst($st) }}
                                </option>
                            @endforeach
                        </select>

                    {{-- 5. LOGIKA METODE PEMBAYARAN & PAYMENT STATUS --}}
                    @elseif ($field === 'online_method' || $field === 'pay_online')
                        <select name="{{ $field }}" class="form-control">
                            @if($field === 'pay_online')
                                <option value="Cash" {{ old('pay_online', $item->pay_online) === 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Online" {{ old('pay_online', $item->pay_online) === 'Online' ? 'selected' : '' }}>Online</option>
                            @else
                                <option value="Cash Payment" {{ old('online_method', $item->online_method) === 'Cash Payment' ? 'selected' : '' }}>Cash Payment</option>
                                <option value="Online Payment" {{ old('online_method', $item->online_method) === 'Online Payment' ? 'selected' : '' }}>Online Payment</option>
                            @endif
                        </select>

                    {{-- 6. LOGIKA TANGGAL (Pick Up, Return, Tgl Pembayaran) --}}
                    @elseif (str_contains($field, 'date') || str_contains($field, 'pick_up') || str_contains($field, 'tgl'))
                        <input type="date" name="{{ $field }}" 
                               value="{{ old($field, isset($item->$field) ? date('Y-m-d', strtotime($item->$field)) : '') }}" 
                               class="form-control" required>

                    {{-- 7. INPUT BIASA (Text & Number) --}}
                    @else
                        <input 
                            type="{{ in_array($field, ['qty', 'total', 'harga', 'tahun', 'jumlah_sewa']) ? 'number' : 'text' }}" 
                            name="{{ $field }}" 
                            value="{{ old($field, $item->$field) }}" 
                            class="form-control" 
                            required
                        >
                    @endif
                </div>
            @endforeach

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route($route.'.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paySelect = document.getElementById('pay_online');
        const methodDiv = document.getElementById('container_online_method');

        if (paySelect && methodDiv) {
            function toggleMethod() {
                methodDiv.style.display = (paySelect.value === 'Online') ? 'block' : 'none';
            }
            toggleMethod();
            paySelect.addEventListener('change', toggleMethod);
        }
    });
</script>

@endsection