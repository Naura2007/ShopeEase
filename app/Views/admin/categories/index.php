<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h3 class="mb-0">Kategori Produk</h3>
    <p class="text-muted mb-0">Kelola kategori untuk produk ShopEase</p>
  </div>
  <a href="<?= site_url('admin/categories/create') ?>" class="btn btn-primary">+ Tambah Kategori</a>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr><th>No.</th><th>Nama</th><th>Slug</th><th>Deskripsi</th><th>Aksi</th></tr>
      </thead>
      <tbody>
        <?php foreach ($categories as $i => $c): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><strong><?= esc($c['name']) ?></strong></td>
            <td><code><?= esc($c['slug']) ?></code></td>
            <td><?= esc($c['description']) ?></td>
            <td class="text-nowrap">
              <a href="<?= site_url('admin/categories/edit/' . $c['id_category']) ?>" class="btn btn-warning btn-sm">Edit</a>
              <form method="post" action="<?= site_url('admin/categories/delete/' . $c['id_category']) ?>"
                    class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                <?= csrf_field() ?>
                <button class="btn btn-danger btn-sm">Hapus</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($categories)): ?>
          <tr><td colspan="5" class="text-center text-muted">Belum ada kategori.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
