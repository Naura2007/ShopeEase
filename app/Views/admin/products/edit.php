<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card border-0 shadow-sm">
  <div class="card-header bg-warning"><h4 class="mb-0">Edit Produk</h4></div>
  <div class="card-body p-4">
    <?= view('admin/products/_form', [
        'product'     => $product,
        'categories'  => $categories,
        'action'      => site_url('admin/products/update/' . $product['id_product']),
        'submitLabel' => 'Update Produk',
    ]) ?>
  </div>
</div>

<div class="card border-0 shadow-sm mt-4">
  <div class="card-body">
    <h5>Gambar Produk</h5>
    <?php if (empty($images)): ?>
      <p class="text-muted mb-0">Belum ada gambar. Unggah gambar lewat form di atas.</p>
    <?php else: ?>
      <div class="row g-3">
        <?php foreach ($images as $img): ?>
          <div class="col-6 col-md-3">
            <div class="card h-100">
              <img src="<?= esc(base_url('uploads/products/' . $img['image'])) ?>"
                   class="card-img-top" style="height:150px;object-fit:cover" alt="Gambar produk">
              <div class="card-body p-2 d-flex flex-column gap-2">
                <?php if ((int) $img['is_primary'] === 1): ?>
                  <span class="badge bg-success">Gambar utama</span>
                <?php else: ?>
                  <form method="post" action="<?= site_url('admin/products/image/primary/' . $img['id_image']) ?>">
                    <?= csrf_field() ?>
                    <button class="btn btn-sm btn-outline-success w-100">Jadikan utama</button>
                  </form>
                <?php endif; ?>
                <form method="post" action="<?= site_url('admin/products/image/delete/' . $img['id_image']) ?>"
                      onsubmit="return confirm('Hapus gambar ini?')">
                  <?= csrf_field() ?>
                  <button class="btn btn-sm btn-outline-danger w-100">Hapus</button>
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<?= $this->endSection() ?>
