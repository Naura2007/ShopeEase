<?php
$val = static fn (string $key, $default = '') => esc((string) (old($key, null, false) ?? ($category[$key] ?? $default)));
?>
<form method="post" action="<?= $action ?>">
  <?= csrf_field() ?>
  <div class="mb-3">
    <label class="form-label">Nama Kategori</label>
    <input type="text" name="name" class="form-control" value="<?= $val('name') ?>" minlength="3" maxlength="100" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Deskripsi</label>
    <textarea name="description" class="form-control" rows="3"><?= $val('description') ?></textarea>
  </div>
  <button type="submit" class="btn btn-primary"><?= $submitLabel ?></button>
  <a href="<?= site_url('admin/categories') ?>" class="btn btn-secondary">Kembali</a>
</form>
