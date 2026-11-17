<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="sec">
  <div class="wrap auth">
    <h1 class="h1s">Masuk ke ShopEase</h1>

    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert--ok" role="status"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert--err" role="alert"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
      <div class="alert alert--err" role="alert">
        <?php foreach (session()->getFlashdata('errors') as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= site_url('login') ?>" method="post">
      <?= csrf_field() ?>
      <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="<?= esc(old('email')) ?>" placeholder="nama@email.com" required>
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="Masukkan password" required>
      </div>
      <button class="btn btn--full" type="submit">Login</button>
    </form>

    <p class="auth__alt">Belum punya akun? <a href="<?= site_url('register') ?>">Daftar di sini</a></p>
  </div>
</section>
<?= $this->endSection() ?>
