<style>
  .btn-close-white {
    color: white;
  }
</style>

<div class="modal fade" id="modalqrcode" tabindex="-1" aria-labelledby="qrcodeBarangModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title white" id="title"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modal-body-qrcode">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  var id = "<?= $_GET['id'] ?>";

  var title = $('#title');
  $(document).ready(function() {});
</script>