<div class="pelaporan-detail"></div>

<div class="email-user-list list-group ps ps--active-y">
  <?php if (count($pelaporan) > 0) { ?>
    <ul class="users-list-wrapper media-list data_pelaporan">
      <?php
      $fotoRandom = rand(1, 6);
      foreach ($pelaporan as $row) : ?>
        <li class="media <?= (!$row['viewed_by_admin']) ? '' : 'mail-read' ?>">
          <div class="user-action">
            <div class="checkbox-con me-3">
              <div class="checkbox checkbox-shadow checkbox-sm">
                <input type="checkbox" name="id[]" class='form-check-input checkrow' value="<?= $row['id'] ?>">
                <label for="checkboxsmall2"></label>
              </div>
            </div>
            <span class="favorite <?= !$row['viewed_by_admin'] ? 'text-warning' : '' ?>">
              <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                <use xlink:href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.svg#<?= !$row['viewed_by_admin'] ? 'envelope-fill' : 'envelope-open' ?>" />
              </svg>
            </span>
          </div>
          <div class="pr-50">
            <div class="avatar">
              <img class="rounded-circle" src="<?= base_url('uploads/default.jpg') ?>" alt="Generic placeholder image">
            </div>
          </div>
          <div class="media-body" onclick="detaillaporan('<?= $row['no_laporan'] ?>', <?= $angka ?>)">
            <div class="user-details">
              <div class="mail-items">
                <?php if ($row['level'] == 'Mahasiswa') { ?>
                  <span class="list-group-item-text"><?= $row['nama_anggota'] . " (NIM. " . $row['no_anggota'] . ")" ?></span>
                <?php } else { ?>
                  <span class="list-group-item-text"><?= $row['nama_anggota'] . " (NIDN/NIY. " . $row['no_anggota'] . ")" ?></span>
                <?php } ?>
              </div>
              <div class="mail-meta-item">
                <span class="float-right">
                  <span class="mail-date text-black"><?= ubahTanggal($row['created_at']) ?></span>
                </span>
              </div>
            </div>
            <div class="mail-message">
              <p class="list-group-item-text mb-0 text-black">
                <?= $row['title'] ?>
              </p>
              <div class="mail-meta-item">
                <span class="float-right">
                  <span class="bullet bullet-danger bullet-sm"></span>
                </span>
              </div>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
      <!-- email user list end -->
    </ul>
  <?php } else { ?>
    <div class="users-list-wrapper media-list">
      <div class="container" style="text-align: center !important;color:#607080 !important;margin-top:150px;">
        <i class="bi bi-folder-x fs-1"></i>
        <br>
        <h5 style="color: #607080 !important;">No matching records found</h5>
      </div>
    </div>
  <?php } ?>

</div>

<script>
  $(document).ready(function() {
    $('.badge-notification').html("<?= $belumdibaca ?>");

  });

  function detaillaporan(string) {
    $('.email-user-list').hide(500);
    $('.email-action').addClass('d-none', true);

    $.ajax({
      // type: "post",
      url: "notification/tampildetailpelaporan/" + string,
      dataType: "json",
      success: function(response) {
        $('.pelaporan-detail').empty();
        $('.pelaporan-detail').html(response.data).show(500);
      }
    });
  }
</script>