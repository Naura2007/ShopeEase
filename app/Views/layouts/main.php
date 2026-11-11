<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'ShopEase') ?></title>
  <meta name="description" content="ShopEase: toko online dengan keranjang belanja, diskon real-time, dan transaksi 24 jam.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/shopease.css') ?>">
</head>
<body>
  <a class="skip" href="#konten">Lewati ke konten</a>
  <?= $this->include('partials/navbar') ?>

  <main id="konten">
    <?= $this->renderSection('content') ?>
  </main>

  <?= $this->include('partials/footer') ?>
  <script src="<?= base_url('assets/js/shopease.js') ?>" defer></script>
</body>
</html>
