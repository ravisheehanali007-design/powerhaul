{{-- ID Invoice --}}
<div class="mb-3">
    <label class="form-label">ID Invoice</label>
    <input type="text" name="id_invoice" class="form-control" 
           value="{{ old('id_invoice', $item->id_invoice ?? '') }}" required>
</div>

{{-- Nama Truk (Dari KatalogController Statis) --}}
<div class="mb-3">
    <label class="form-label">Nama Truk</label>
    <select name="id_truk" class="form-control" required>
        <option value="">-- Pilih Truk --</option>
        @foreach($truk_list as $t)
            <option value="{{ $t['id_truk'] }}" 
                {{ (old('id_truk', $item->id_truk ?? '') == $t['id_truk']) ? 'selected' : '' }}>
                {{ $t['nama_truk'] }}
            </option>
        @endforeach
    </select>
</div>

{{-- Quantity --}}
<div class="mb-3">
    <label class="form-label">Quantity</label>
    <input type="number" name="qty" class="form-control" 
           value="{{ old('qty', $item->qty ?? 1) }}" required>
</div>

{{-- Total Harga --}}
<div class="mb-3">
    <label class="form-label">Total Harga</label>
    <input type="number" name="total" class="form-control" 
           value="{{ old('total', $item->total ?? '') }}" required>
</div>

{{-- Pilihan Metode Pembayaran --}}
<div class="mb-3">
    <label class="form-label d-block">Metode Pembayaran</label>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="payment_method" id="method_cash" value="cash" 
            {{ (old('payment_method', ($item->pay_cash ?? 1) == 1 ? 'cash' : 'online') == 'cash') ? 'checked' : '' }}>
        <label class="form-check-label" for="method_cash">Cash</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="payment_method" id="method_online" value="online"
            {{ (old('payment_method', ($item->pay_cash ?? 0) == 0 ? 'online' : 'cash') == 'online') ? 'checked' : '' }}>
        <label class="form-check-label" for="method_online">Online Payment</label>
    </div>
</div>

{{-- Created At (Hanya jika ingin diinput manual) --}}
<div class="mb-3">
    <label class="form-label">Tanggal Transaksi</label>
    <input type="datetime-local" name="created_at" class="form-control" 
           value="{{ old('created_at', isset($item->created_at) ? \Carbon\Carbon::parse($item->created_at)->format('Y-m-d\TH:i') : '') }}">
</div>