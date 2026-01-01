

{{-- Dropdown Nama Truk / Alat Berat --}}
<div class="mb-3">
    <label class="form-label">Nama Truk</label>
    <select name="nik" class="form-control" required>
        <option value="">-- Pilih Pelanggan --</option>
        @foreach($truk as $t)
            <option value="{{ $t->nik }}" 
                {{ (old('nik', $item->nik ?? '') == $t->nik) ? 'selected' : '' }}>
                {{ $t->nama_pelanggan }}
            </option>
        @endforeach
    </select>
</div>

{{-- Total Harga --}}
<div class="mb-3">
    <label class="form-label">Total</label>
    <input type="number" 
           name="total" 
           class="form-control" 
           value="{{ old('total', $item->total ?? '') }}" 
           required>
</div>
