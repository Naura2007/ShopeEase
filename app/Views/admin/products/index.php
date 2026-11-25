<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="mb-0">Product Management</h3>
    <p class="text-muted mb-0">Kelola katalog produk ShopEase</p>
  </div>
  <a href="<?= site_url('admin/products/create') ?>" class="btn btn-primary">+ Tambah Produk</a>
</div>

<form class="row g-2 mb-3" method="get" action="<?= site_url('admin/products') ?>">
  <div class="col-md-5">
    <input type="search" name="q" class="form-control" placeholder="Cari nama produk" value="<?= esc($keyword) ?>">
  </div>
  <div class="col-md-4">
    <select name="kategori" class="form-select">
      <option value="">Semua kategori</option>
      <?php foreach ($categories as $c): ?>
        <option value="<?= (int) $c['id_category'] ?>" <?= $kategori === (int) $c['id_category'] ? 'selected' : '' ?>>
          <?= esc($c['name']) ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-3 d-flex gap-2">
    <button class="btn btn-outline-primary w-100">Filter</button>
    <a href="<?= site_url('admin/products') ?>" class="btn btn-outline-secondary">Reset</a>
  </div>
</form>

<div class="card border-0 shadow-sm">
  <div class="card-body table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>No.</th><th>Nama Produk</th><th>Kategori</th>
          <th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $i => $product): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><strong><?= esc($product['name']) ?></strong></td>
            <td><?= esc($product['category_name']) ?></td>
            <td>Rp <?= number_format((float) $product['price'], 0, ',', '.') ?></td>
            <td><?= (int) $product['stock'] ?></td>
            <td>
              <?php if ($product['status'] === 'tersedia'): ?>
                <span class="badge bg-success">Tersedia</span>
              <?php else: ?>
                <span class="badge bg-secondary">Tidak Tersedia</span>
              <?php endif; ?>
            </td>
            <td class="text-nowrap">
              <a href="<?= site_url('admin/products/edit/' . $product['id_product']) ?>" class="btn btn-warning btn-sm">Edit</a>
              <form method="post" action="<?= site_url('admin/products/delete/' . $product['id_product']) ?>"
                    class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                <?= csrf_field() ?>
                <button class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($products)): ?>
          <tr><td colspan="7" class="text-center text-muted">Belum ada data produk.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
