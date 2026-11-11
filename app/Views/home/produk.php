<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="sec">
  <div class="wrap">
    <h1 class="h1s">Semua produk</h1>
    <nav class="filters" aria-label="Filter kategori">
      <a href="<?= base_url('produk') ?>" <?= ! $aktif ? 'aria-current="true"' : '' ?>>Semua</a>
      <?php foreach ($kategori as $k): ?>
        <a href="<?= base_url('produk') ?>?kategori=<?= urlencode($k) ?>" <?= strcasecmp((string) $aktif, $k) === 0 ? 'aria-current="true"' : '' ?>><?= esc($k) ?></a>
      <?php endforeach; ?>
    </nav>
    <?php if (empty($produk)): ?>
      <p>Belum ada produk di kategori ini. <a href="<?= base_url('produk') ?>">Lihat semua produk</a>.</p>
    <?php else: ?>
      <div class="grid">
        <?php foreach ($produk as $p): ?>
          <?= view('partials/product_card', ['p' => $p]) ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?= $this->endSection() ?>
