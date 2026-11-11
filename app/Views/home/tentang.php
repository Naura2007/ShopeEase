<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="sec">
  <div class="wrap prose">
    <h1 class="h1s">Tentang ShopEase</h1>
    <p>ShopEase memindahkan jual beli dari toko fisik ke layar Anda. Pembeli tidak perlu datang ke penjual, dan penjual tidak perlu mencetak brosur setiap kali ada promo.</p>
    <p>Informasi produk, stok, dan diskon diperbarui langsung di website, sehingga yang Anda lihat selalu yang terbaru. Transaksi bisa dilakukan 24 jam, selama ada koneksi internet.</p>
    <p><a class="btn" href="<?= base_url('produk') ?>">Mulai belanja</a></p>
  </div>
</section>
<?= $this->endSection() ?>
