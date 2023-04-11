<?= $this->extend('layouts/error') ?>

<?= $this->section('content') ?>
<div class="error-page container">
    <div class="col-md-8 col-12 offset-md-2">
        <img class="img-error" src="<?= base_url() ?>/assets/images/samples/404 error with person looking for-bro.png" alt="Not Found">
        <div class="text-center">
            <h1 class="error-title">PAGE NOT FOUND</h1>
            <p class='fs-5 text-gray-600'><?= $msg ?></p>
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-lg btn-outline-success mb-5 mt-3">Go Home</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>