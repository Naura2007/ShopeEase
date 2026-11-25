<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card border-0 shadow-sm" style="max-width:640px">
  <div class="card-header bg-primary text-white"><h4 class="mb-0">Tambah Kategori</h4></div>
  <div class="card-body p-4">
    <?= view('admin/categories/_form', [
        'category'    => [],
        'action'      => site_url('admin/categories/store'),
        'submitLabel' => 'Simpan Kategori',
    ]) ?>
  </div>
</div>
<?= $this->endSection() ?>
