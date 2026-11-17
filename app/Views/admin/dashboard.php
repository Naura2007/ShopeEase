<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="sec"><div class="wrap">
  <h1 class="h1s">Dashboard Admin</h1>
  <p>Halo, <?= esc(session('name')) ?>. Halaman ini hanya bisa dibuka oleh role admin.</p>
</div></section>
<?= $this->endSection() ?>
