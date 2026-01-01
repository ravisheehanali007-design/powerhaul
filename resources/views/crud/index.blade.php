@extends('layouts.admin')

@section('content')

<h2 class="mb-4">Daftar {{ $title }}</h2>

<div class="card shadow">
    <div class="card-body">

        <a href="{{ route($route.'.create') }}" class="btn btn-primary mb-3">
            Tambah {{ $title }}
        </a>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark text-center">
                    <tr>
                        @foreach($headers as $header)
                            <th>{{ $header }}</th>
                        @endforeach
                        <th width="140">Aksi</th>
                        
                        @if($route === 'detailpenyewaan')
                            <th width="160">Keterangan</th>
                        @endif
                    </tr>
                </thead>

                <tbody>
                    @forelse($data as $row)
                    <tr>
                        @foreach($fields as $field)
                            <td>
                                {{-- 1. LOGIKA KHUSUS KOLOM TOTAL --}}
                                @if($field === 'total')
                                    @if($route === 'invoice')
                                        {{-- KHUSUS INVOICE: Ambil langsung dari kolom 'total' di database MySQL --}}
                                        <span>
                                            Rp {{ number_format($row->total ?? 0, 0, ',', '.') }}
                                        </span>
                                    @else
                                        {{-- KHUSUS DETAIL PENYEWAAN: Hitung Real-Time dari Tabel Rincian --}}
                                        @php
                                            $currentId = $row->{$primaryKey} ?? $row->id_detail;
                                            $totalRealTime = DB::table('rincian_penyewaan')
                                                ->where('id_detail', $currentId)
                                                ->sum('jumlah');
                                        @endphp
                                        <span>
                                            Rp {{ number_format($totalRealTime, 0, ',', '.') }}
                                        </span>
                                    @endif

                                {{-- 2. FORMAT RUPIAH HARGA STANDAR --}}
                                @elseif($field === 'harga' || $field === 'jumlah_sewa')
                                    Rp {{ number_format($row->$field ?? 0, 0, ',', '.') }}

                                {{-- 3. BADGE STATUS --}}
                                @elseif($field === 'status')
                                    @php
                                        $statusValue = $row->status ?? 'Pending';
                                        $statusLower = strtolower($statusValue);
                                    @endphp
                                    <span class="badge bg-{{ 
                                        ($statusLower === 'tersedia' || $statusLower === 'success' || $statusLower === 'lunas') ? 'success' : 
                                        ($statusLower === 'disewa' || $statusLower === 'tidak tersedia' || $statusLower === 'pending' ? 'warning text-dark' : 'secondary') 
                                    }}">
                                        {{ ucfirst($statusValue) }}
                                    </span>

                                {{-- 4. DATA LAINNYA --}}
                                @else
                                    {{ $row->$field ?? '-' }}
                                @endif
                            </td>
                        @endforeach

                        {{-- KOLOM AKSI --}}
                        <td>
                            <a href="{{ route($route.'.edit', $row->{$primaryKey}) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route($route.'.destroy', $row->{$primaryKey}) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>

                        {{-- KOLOM KETERANGAN (Hanya muncul jika di menu Detail Penyewaan) --}}
                        @if($route === 'detailpenyewaan')
                        <td class="text-center">
                            <a href="{{ route($route.'.show', $row->{$primaryKey}) }}" class="btn btn-info btn-sm text-white">Detail</a>
                            <a href="{{ route($route.'.print', $row->{$primaryKey}) }}" class="btn btn-secondary btn-sm" target="_blank">Cetak</a>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($headers) + ($route === 'detailpenyewaan' ? 2 : 1) }}" class="text-center">
                            Data {{ $title }} tidak tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection