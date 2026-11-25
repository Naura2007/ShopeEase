<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<h3>Dashboard Operator</h3>
<p class="text-muted">Selamat datang, <?= esc(session('name')) ?>. Anda dapat mengelola produk dan kategori.</p>
<div class="row g-3">
  <div class="col-md-6">
    <a class="card border-0 shadow-sm text-decoration-none h-100" href="<?= site_url('admin/products') ?>">
      <div class="card-body"><h5>Product Management</h5><p class="text-muted mb-0">Kelola produk dan gambar.</p></div>
    </a>
  </div>
  <div class="col-md-6">
    <a class="card border-0 shadow-sm text-decoration-none h-100" href="<?= site_url('admin/categories') ?>">
      <div class="card-body"><h5>Kategori</h5><p class="text-muted mb-0">Kelola kategori produk.</p></div>
    </a>
  </div>
</div>
<?= $this->endSection() ?>
