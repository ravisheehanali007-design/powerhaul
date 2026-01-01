{{-- resources/views/partials/fields/pembayaran.blade.php --}}

<div class="mb-3">
    <label class="form-label">Nama Pelanggan</label>
    <select name="nik" class="form-control" required>
        <option value="">-- Pilih Pelanggan --</option>
        @foreach($pelanggan as $p)
            <option value="{{ $p->nik }}" {{ old('nik') == $p->nik ? 'selected' : '' }}>
                {{ $p->nama }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Tanggal Pembayaran</label>
    <input type="date" name="tgl_pembayaran" class="form-control" value="{{ old('tgl_pembayaran') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Jumlah Sewa</label>
    <input type="number" name="jumlah_sewa" class="form-control" value="{{ old('jumlah_sewa') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Payment</label>
    <select name="pay_online" class="form-control" required>
        <option value="Cash" {{ old('pay_online') == 'Cash' ? 'selected' : '' }}>Cash</option>
        <option value="Online" {{ old('pay_online') == 'Online' ? 'selected' : '' }}>Online</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Dompet Digital (Jika Online)</label>
    <select name="online_method" class="form-control">
        <option value="">-- Pilih Metode --</option>
        <option value="GoPay">GoPay</option>
        <option value="OVO">OVO</option>
        <option value="DANA">DANA</option>
        <option value="ShopeePay">ShopeePay</option>
    </select>
</div>