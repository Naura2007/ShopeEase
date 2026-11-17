<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="sec">
  <div class="wrap auth">
    <h1 class="h1s">Buat akun ShopEase</h1>

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="alert alert--err" role="alert">
        <?php foreach (session()->getFlashdata('errors') as $e): ?><div><?= esc($e) ?></div><?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form action="<?= site_url('register') ?>" method="post">
      <?= csrf_field() ?>
      <div class="field">
        <label for="name">Nama lengkap</label>
        <input id="name" type="text" name="name" value="<?= esc(old('name')) ?>" required>
      </div>
      <div class="field">
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="<?= esc(old('email')) ?>" placeholder="nama@email.com" required>
      </div>
      <div class="field">
        <label for="phone">Nomor telepon</label>
        <input id="phone" type="text" name="phone" value="<?= esc(old('phone')) ?>" placeholder="08xxxxxxxxxx">
      </div>
      <div class="field">
        <label for="address">Alamat</label>
        <textarea id="address" name="address" rows="2"><?= esc(old('address')) ?></textarea>
      </div>
      <div class="field">
        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="Minimal 8 karakter" required>
      </div>
      <div class="field">
        <label for="password_confirm">Konfirmasi password</label>
        <input id="password_confirm" type="password" name="password_confirm" required>
      </div>
      <button class="btn btn--full" type="submit">Daftar sekarang</button>
    </form>

    <p class="auth__alt">Sudah punya akun? <a href="<?= site_url('login') ?>">Login di sini</a></p>
  </div>
</section>
<?= $this->endSection() ?>
