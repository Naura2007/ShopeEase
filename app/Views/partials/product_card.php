<?php $final = $p['harga'] * (100 - $p['diskon']) / 100; ?>
<article class="card">
  <div class="card__img" style="background:<?= esc($p['warna']) ?>">
    <span><?= esc($p['kategori']) ?></span>
    <?php if ($p['diskon'] > 0): ?><b class="tag">-<?= (int) $p['diskon'] ?>%</b><?php endif; ?>
  </div>
  <h3><?= esc($p['nama']) ?></h3>
  <p class="price">
    Rp<?= number_format($final, 0, ',', '.') ?>
    <?php if ($p['diskon'] > 0): ?><s>Rp<?= number_format($p['harga'], 0, ',', '.') ?></s><?php endif; ?>
  </p>
  <button class="btn btn--line" type="button" data-add>Tambah ke keranjang</button>
</article>
