<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card border-0 shadow-sm">
  <div class="card-header bg-primary text-white"><h4 class="mb-0">Tambah Produk</h4></div>
  <div class="card-body p-4">
    <?= view('admin/products/_form', [
        'product'    => [],
        'categories' => $categories,
        'action'     => site_url('admin/products/store'),
    ]) ?>
  </div>
</div>
<?= $this->endSection() ?>
