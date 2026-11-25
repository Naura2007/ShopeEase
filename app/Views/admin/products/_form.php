<?php
// Nilai form: prioritas old() (isian sebelumnya), lalu data $product, lalu default.
$val = static fn (string $key, $default = '') => esc((string) (old($key, null, false) ?? ($product[$key] ?? $default)));
?>
<form method="post" action="<?= $action ?>" enctype="multipart/form-data">
  <?= csrf_field() ?>

  <div class="mb-3">
    <label class="form-label">Nama Produk</label>
    <input type="text" name="name" class="form-control" value="<?= $val('name') ?>" minlength="3" maxlength="150" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Kategori</label>
    <select name="id_category" class="form-select" required>
      <option value="">Pilih Kategori</option>
      <?php foreach ($categories as $c): ?>
        <option value="<?= (int) $c['id_category'] ?>" <?= $val('id_category') == $c['id_category'] ? 'selected' : '' ?>>
          <?= esc($c['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control" rows="4"><?= $val('description') ?></textarea>
  </div>

  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Harga (Rp)</label>
      <input type="number" name="price" class="form-control" min="0" step="0.01" value="<?= $val('price', 0) ?>" required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Stok</label>
      <input type="number" name="stock" class="form-control" min="0" value="<?= $val('stock', 0) ?>" required>
    </div>
  </div>

  <div class="mb-3">
    <label class="form-label">Status Produk</label>
    <select name="status" class="form-select">
      <option value="tersedia" <?= $val('status', 'tersedia') === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
      <option value="tidak_tersedia" <?= $val('status', 'tersedia') === 'tidak_tersedia' ? 'selected' : '' ?>>Tidak Tersedia</option>
    </select>
  </div>

  <div class="mb-4">
    <label class="form-label">Gambar Produk</label>
    <input type="file" name="images[]" class="form-control" accept="image/jpeg,image/png,image/webp" multiple>
    <small class="text-muted">Format JPG, PNG, WEBP. Maksimal 2 MB per gambar, hingga 5 gambar sekali unggah.</small>
  </div>

  <button type="submit" class="btn btn-primary"><?= $submitLabel ?? 'Simpan Produk' ?></button>
  <a href="<?= site_url('admin/products') ?>" class="btn btn-secondary">Kembali</a>
</form>
