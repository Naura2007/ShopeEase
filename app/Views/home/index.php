<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<section class="hero">
  <div class="wrap hero__in">
    <div class="hero__txt">
      <h1>Belanja tanpa antre, kapan saja.</h1>
      <p class="lead">Pilih produk, masukkan ke keranjang, lalu bayar dari rumah. Toko ShopEase buka 24 jam, dan info diskon langsung tampil begitu berubah.</p>
      <div class="row">
        <a class="btn" href="<?= base_url('produk') ?>">Lihat semua produk</a>
        <a class="btn btn--line" href="#cara-belanja">Cara belanja</a>
      </div>
    </div>

    <aside class="cart" aria-label="Contoh keranjang belanja">
      <h2>Coba keranjangnya</h2>
      <ul class="cart__list">
        <?php foreach ($demo as $p):
          $final = $p['harga'] * (100 - $p['diskon']) / 100; ?>
          <li>
            <span class="dot" style="background:<?= esc($p['warna']) ?>"></span>
            <span class="cart__nm"><?= esc($p['nama']) ?><small>Rp<?= number_format($final, 0, ',', '.') ?></small></span>
            <span class="qty">
              <button type="button" data-dec aria-label="Kurangi <?= esc($p['nama']) ?>">−</button>
              <output data-qty data-harga="<?= (int) $final ?>">0</output>
              <button type="button" data-inc aria-label="Tambah <?= esc($p['nama']) ?>">+</button>
            </span>
          </li>
        <?php endforeach; ?>
      </ul>
      <p class="cart__tot">Total <strong id="total">Rp0</strong></p>
      <button class="btn btn--full" type="button" id="checkout" disabled>Checkout</button>
      <p class="cart__msg" id="cartMsg" role="status"></p>
    </aside>
  </div>
</section>

<section class="sec" id="produk">
  <div class="wrap">
    <div class="sec__head">
      <h2>Diskon minggu ini</h2>
      <a href="<?= base_url('produk') ?>">Semua produk</a>
    </div>
    <div class="grid">
      <?php foreach ($unggulan as $p): ?>
        <?= view('partials/product_card', ['p' => $p]) ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="sec sec--tint" id="cara-belanja">
  <div class="wrap">
    <h2>Empat langkah sampai pesanan tiba</h2>
    <ol class="steps">
      <?php foreach ($langkah as $l): ?>
        <li><h3><?= esc($l['judul']) ?></h3><p><?= esc($l['isi']) ?></p></li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="sec">
  <div class="wrap">
    <h2>Satu toko, tiga jenis pengguna</h2>
    <div class="roles">
      <?php foreach ($peran as $r): ?>
        <div><h3><?= esc($r['nama']) ?></h3><p><?= esc($r['isi']) ?></p></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="sec sec--ink" id="promo">
  <div class="wrap promo">
    <div>
      <h2>Dapat info diskon lebih dulu</h2>
      <p>Masukkan email Anda. Kami kirim kabar saat ada promo baru.</p>
    </div>
    <form action="<?= base_url('berlangganan') ?>" method="post" novalidate>
      <?= csrf_field() ?>
      <label for="email">Alamat email</label>
      <div class="row">
        <input id="email" name="email" type="email" value="<?= esc(old('email')) ?>" placeholder="nama@email.com" required>
        <button class="btn btn--sun" type="submit">Kirim info promo</button>
      </div>
      <?php if (session()->getFlashdata('success')): ?>
        <p class="flash flash--ok" role="status"><?= session()->getFlashdata('success') ?></p>
      <?php elseif (session()->getFlashdata('error')): ?>
        <p class="flash flash--err" role="alert"><?= esc(session()->getFlashdata('error')) ?></p>
      <?php endif; ?>
    </form>
  </div>
</section>

<?= $this->endSection() ?>
