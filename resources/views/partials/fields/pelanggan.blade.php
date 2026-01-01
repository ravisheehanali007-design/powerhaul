<div class="mb-3">
    <label class="form-label">NIK</label>
    <input type="text"
           name="nik"
           class="form-control"
           value="{{ old('nik', $item->nik ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text"
           name="nama"
           class="form-control"
           value="{{ old('nama', $item->nama ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Country</label>
    <input type="text"
           name="country"
           class="form-control"
           value="{{ old('country', $item->country ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">City</label>
    <input type="text"
           name="city"
           class="form-control"
           value="{{ old('city', $item->city ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Nomor HP</label>
    <input type="text"
           name="no_hp"
           class="form-control"
           value="{{ old('no_hp', $item->no_hp ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email"
           name="email"
           class="form-control"
           value="{{ old('email', $item->email ?? '') }}"
           required>
</div>

<div class="mb-3">
    <label class="form-label">Alamat</label>
    <textarea name="alamat"
              class="form-control"
              rows="3"
              required>{{ old('alamat', $item->alamat ?? '') }}</textarea>
</div>
