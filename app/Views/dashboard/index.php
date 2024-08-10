<?= $this->extend('/layouts/template') ?>

<?= $this->section('content') ?>
<section class="section">
  <div class="col-lg-12">
    <div class="row">
      <?php foreach ($cards as $card) : ?>
        <div class="col-6 col-lg-4 col-md-6">
          <div class="card shadow">
            <div class="card-body px-3 py-3">
              <div class="row" id="<?= $card['id'] ?>">
                <div class="col-md-4">
                  <div class="stats-icon <?= $card['color'] ?>">
                    <i class="fa <?= $card['icon'] ?>"></i>
                  </div>
                </div>
                <div class="col-md-8">
                  <h6 class="text-muted font-semibold"><?= $card['title'] ?></h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
  $(document).ready(function() {
    dashboard.getCards(<?= json_encode($cards) ?>);
  });
</script>
<?= $this->endSection() ?>