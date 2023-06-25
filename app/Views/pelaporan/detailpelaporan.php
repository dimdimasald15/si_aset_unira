<div class="media-body">
  <div class="email-scroll-area ps ps--active-y">
    <!-- email details  -->
    <div class="row">
      <div class="col-12">
        <div class="email-detail-head">
          <div class="card" role="tablist">
            <div class="card-header d-flex justify-content-between align-items-center">
              <div class="collapse-title media">
                <div class="pr-1">
                  <div class="avatar mr-75">
                    <img src="<?= base_url('uploads/default.jpg') ?>" alt="avtar img holder" width="30" height="30">
                  </div>
                </div>
                <div class="media-body-text mt-25">
                  <span class="text-primary nama"><?= $pelaporan->nama_anggota ?></span>
                  <span class="d-sm-inline d-none" id="noanggota">&lt; <?= $pelaporan->no_anggota ?> &gt;</span>
                  <small class="text-muted d-block" id="level"><?= $pelaporan->level ?></small>
                </div>
              </div>
              <div class="information d-sm-flex align-items-center">
                <small class="text-muted me-3" id="created_at"><?= $pelaporan->created_at ?></small>
                <span class="favorite text-secondary">
                  <svg class="bi" width="1.5em" height="1.5em" fill="currentColor">
                    <use xlink:href="<?= base_url() ?>assets/vendors/bootstrap-icons/bootstrap-icons.svg#star" />
                  </svg>
                </span>
              </div>
            </div>
            <!-- <div id="collapse7" role="tabpanel" aria-labelledby="headingCollapse7" class="collapse show"> -->
            <div class="card-content">
              <div class="card-body py-1">
                <p class="text-bold-500" id="title"><?= $pelaporan->title ?></p>
                <p id='deskripsi'>
                  <?= $pelaporan->deskripsi ?>
                </p>
                <p class="mb-0">Hormat kami,</p>
                <br>
                <p class="text-bold-500 nama"><?= $pelaporan->nama_anggota ?></p>
              </div>
              <div class="card-footer pt-0 border-top">
                <label class="sidebar-label">File foto kerusakan</label>
                <ul class="list-unstyled mb-0">
                  <li class="cursor-pointer pb-25" id="foto">
                    <img src="<?= base_url() ?>assets/images/foto_kerusakan/<?= $pelaporan->foto ?>" alt="<?= $pelaporan->foto ?>.png" width="400">
                    <small class="text-muted ms-1 attchement-text"><?= $pelaporan->foto ?></small>
                  </li>
                </ul>
              </div>
            </div>
            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var no_laporan = "<?= $no_laporan ?>";
    $.ajax({
      type: "post",
      url: "notification/getLaporanByNoLaporan",
      data: {
        no_laporan: no_laporan,
      },
      dataType: "json",
      success: function(response) {
        $('.nama').html(response.nama_anggota);
        $('#noanggota').html(`&lt; ${response.no_anggota} &gt;`);
        $('#level').html(response.level);
        $('#created_at').html(ubahTanggal(response.created_at));
        $('#title').html(response.title);
        $('#deskripsi').html(response.deskripsi);
        $('#foto').html(`
        <img src="<?= base_url() ?>assets/images/foto_kerusakan/${response.foto}" alt="${response.foto}.png" width="400">
                    <small class="text-muted ms-1 attchement-text">${response.foto}</small>
        `);
      }
    });
  });

  function ubahTanggal(date) {
    // array hari dan bulan
    const Hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    const Bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    // pemisahan tahun, bulan, hari, dan waktu
    if (date) {
      if (new Date(date).toDateString() === new Date().toDateString()) {
        const timestamp = new Date(date).getTime();
        const currentTimestamp = new Date().getTime();
        const timeDiff = currentTimestamp - timestamp;

        if (timeDiff < 60000) {
          return Math.floor(timeDiff / 1000) + " detik yang lalu";
        } else if (timeDiff < 3600000) {
          return Math.floor(timeDiff / 60000) + " menit yang lalu";
        } else if (timeDiff < 86400000) {
          return Math.floor(timeDiff / 3600000) + " jam yang lalu";
        }
      } else {
        const tahun = date.substr(0, 4);
        const bulan = date.substr(5, 2);
        const tgl = date.substr(8, 2);
        const jam = date.substr(11, 5);
        // const menit = date.substr(14, 2);
        const hari = new Date(date).getDay();
        return Hari[hari] + ", " + tgl + " " + Bulan[parseInt(bulan) - 1] + " " + tahun + " " + jam;
      }
    }

    return "";
  }
</script>