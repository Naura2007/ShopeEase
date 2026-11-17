<header class="nav">
  <div class="wrap nav__in">
    <a class="logo" href="<?= base_url('/') ?>">Shop<span>Ease</span></a>
    <nav class="nav__links" aria-label="Menu utama">
      <a href="<?= base_url('produk') ?>">Produk</a>
      <a href="<?= base_url('/') ?>#cara-belanja">Cara belanja</a>
      <a href="<?= base_url('/') ?>#promo">Promo</a>
      <a href="<?= base_url('tentang') ?>">Tentang</a>
    </nav>

    <?php if (session()->get('isLoggedIn')): ?>
      <div class="nav__user">
        <span>Hai, <?= esc(session()->get('name')) ?></span>
        <?php if (session()->get('role') === 'admin'): ?><a href="<?= site_url('admin') ?>">Dashboard</a><?php endif; ?>
        <?php if (session()->get('role') === 'operator'): ?><a href="<?= site_url('operator') ?>">Dashboard</a><?php endif; ?>
        <form action="<?= site_url('logout') ?>" method="post">
          <?= csrf_field() ?>
          <button class="btn btn--sm btn--line" type="submit">Logout</button>
        </form>
      </div>
    <?php else: ?>
      <div class="nav__user">
        <a href="<?= site_url('login') ?>">Login</a>
        <a class="btn btn--sm" href="<?= site_url('register') ?>">Daftar</a>
      </div>
    <?php endif; ?>
  </div>
</header>
