<style>
  .btn-close-white {
    color: white;
  }

  .card {
    height: auto;
  }

  .card-label {
    border: 4px solid var(--bs-success) !important;
    border-radius: 15px !important;
    /* border-color: #1fa164; */
  }
</style>

<div class="modal fade" id="modalcetakpeminjaman" tabindex="-1" aria-labelledby="labelBarangModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content ">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="title"><?= $title ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="peminjaman-barang/cetak" method="post" onSubmit="pinjam.downloadPdf(this,event)">
        <div class="modal-body modal-body-label">
          <div class="container">
            <?= csrf_field(); ?>
            <div class="row d-flex justify-content-center">
              <div class="col-md-12">
                <input type="hidden" name="jenis_kat" value="<?= $jenis_kat ?>">
                <input type="hidden" name="keterangan" value="Peminjaman">
                <input type="hidden" name="opsi" value="<?= $opsi ?>">
                <div class="row g-2 mb-1">
                  <?php if ($opsi == "opsi1") { ?>
                    <div class="col-md-12">
                      <label for="tglpinjam" class="form-label">Tanggal Peminjaman</label>
                      <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-calendar-plus"></i></span>
                        <input type="date" class="form-control" id="tglpinjam" name="tgl_pinjam">
                        <div class="invalid-feedback errtglpinjam"></div>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="row my-3">
                      <div class="col-sm-6 d-flex justify-content-start">
                        <label class="col-sm-3 col-form-label" for="selectbulan">Bulan</label>
                        <div class="col-sm-9">
                          <select id="selectbulan" name="bulan" class="form-select"></select>
                        </div>
                      </div>
                      <div class="col-sm-6 d-flex justify-content-start">
                        <label class="col-sm-3 col-form-label" for="selecttahun">Tahun</label>
                        <div class="col-sm-9">
                          <select id="selecttahun" name="tahun" class="form-select"></select>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
                <div class="viewalert">
                  <div class="alert alert-info" role="alert">
                    <div class="row">
                      <div class="col-sm-2 d-flex align-items-center justify-content-end">
                        <p class="fs-1"><i class="bi bi-info-circle"></i></p>
                      </div>
                      <div class="col-sm-9 p-0">
                        <p>Jika anda ingin melakukan pencetakan laporan sepanjang tahun <?= date('Y') ?>, maka anda dapat mengosongkan form <?= $opsi == "opsi1" ? 'pilih tanggal' : 'pilih bulan dan tahun' ?> di atas. Lalu anda dapat menekan tombol cetak laporan peminjaman di bawah ini.</p>
                      </div>
                      <div class="col-sm-1">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn-download"><i class="fa fa-download"></i> Cetak Laporan Peminjaman</button>
          </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(document).ready(function() {
    initializeMonthAndYears()
  });
</script>