<div class="mb-3">
    <label class="form-label">ID Truk</label>
    <input type="text"
           name="id_truk"
           class="form-control"
           value="{{ old('id_truk', $item->id_truk ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Nama Truk</label>
    <input type="text"
           name="nama_truk"
           class="form-control"
           value="{{ old('nama_truk', $item->nama_truk ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Merk</label>
    <input type="text"
           name="merk"
           class="form-control"
           value="{{ old('merk', $item->merk ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Harga</label>
    <input type="number"
           name="harga"
           class="form-control"
           value="{{ old('harga', $item->harga ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Tahun</label>
    <input type="number"
           name="tahun"
           class="form-control"
           value="{{ old('tahun', $item->tahun ?? '') }}"
           min="1990"
           max="{{ date('Y') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select" required>
        <option value="">-- Pilih Status --</option>
        <option value="tersedia"
            {{ old('status', $item->status ?? '') == 'tersedia' ? 'selected' : '' }}>
            Tersedia
        </option>
        <option value="disewa"
            {{ old('status', $item->status ?? '') == 'disewa' ? 'selected' : '' }}>
            Disewa
        </option>
        <option value="perawatan"
            {{ old('status', $item->status ?? '') == 'perawatan' ? 'selected' : '' }}>
            Perawatan
        </option>
    </select>
</div>

