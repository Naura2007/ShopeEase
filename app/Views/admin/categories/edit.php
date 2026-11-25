<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="card border-0 shadow-sm" style="max-width:640px">
  <div class="card-header bg-warning"><h4 class="mb-0">Edit Kategori</h4></div>
  <div class="card-body p-4">
    <?= view('admin/categories/_form', [
        'category'    => $category,
        'action'      => site_url('admin/categories/update/' . $category['id_category']),
        'submitLabel' => 'Update Kategori',
    ]) ?>
  </div>
</div>
<?= $this->endSection() ?>
