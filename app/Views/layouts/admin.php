<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= esc($title ?? 'Admin ShopEase') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand navbar-dark bg-dark">
  <div class="container-fluid">
    <?php $home = session('role') === 'admin' ? 'admin' : 'operator'; ?>
    <a class="navbar-brand" href="<?= site_url($home) ?>">ShopEase Admin</a>
    <div class="navbar-nav me-auto">
      <a class="nav-link" href="<?= site_url('admin/products') ?>">Produk</a>
      <a class="nav-link" href="<?= site_url('admin/categories') ?>">Kategori</a>
    </div>
    <span class="navbar-text me-3"><?= esc(session('name')) ?> (<?= esc(session('role')) ?>)</span>
    <form method="post" action="<?= site_url('logout') ?>" class="m-0">
      <?= csrf_field() ?>
      <button class="btn btn-sm btn-light" type="submit">Logout</button>
    </form>
  </div>
</nav>

<main class="container py-4">
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach (session()->getFlashdata('errors') as $e): ?>
          <li><?= esc($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <?= $this->renderSection('content') ?>
</main>
</body>
</html>
