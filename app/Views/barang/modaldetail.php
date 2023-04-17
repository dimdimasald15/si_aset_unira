<style>
  .btn-close-white {
    color: white;
  }
</style>

<div class="modal fade" id="modaldetail" tabindex="-1" aria-labelledby="detailBarangModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title white" id="nmbrg"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modal-body-detail">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var id = "<?= $_GET['id'] ?>";

    var nmbrg = $('#nmbrg');
    var title = $('#title');

    $.ajax({
      type: "post",
      url: "<?= base_url() ?>/barangcontroller/getbarangbyany",
      data: {
        id: id,
      },
      dataType: "json",
      success: function(response) {
        console.log(response);
        let tgl = new Date(response.tgl_pembelian);
        let buying_date = '';
        if (response.tgl_pembelian !== null) {
          buying_date = tgl.toLocaleString("id-ID", {
            weekday: "long",
            day: "numeric",
            month: "long",
            year: "numeric"
          });
        } else {
          buying_date = '-';
        }

        nmbrg.html(`Detail Barang ${response.nama_brg}`);

        $('.modal-body-detail').append(`
        <div class="card mb-3">
        ${response.foto_barang ? `<img src="<?= base_url() ?>/assets/images/foto_barang/${response.foto_barang}" alt="Gambar Barang" class="rounded mx-auto d-block" style="width:300px; height:auto;">` : `<img src="https://via.placeholder.com/150x150.png?text=No+Image" alt="No Image" class="rounded mx-auto d-block">`}
          <div class="card-body">
            <h5 class="card-title">${response.nama_brg}</h5>
            <div class="card-text mb-3">
              <div class="row mt-3">
                <div class="col-4">Kode Barang</div>
                <div class="col-8">:  ${response.kode_brg}</div>
              </div>
              <div class="row mt-2">
                <div class="col-4">Kategori Barang</div>
                <div class="col-8">:  ${response.nama_kategori}</div>
              </div>
              <div class="row mt-2">
                <div class="col-auto">Deskripsi Barang</div>
              </div>
              <ul>
                <li>
                  <div class="row mt-2">
                    <div class="col-5">Asal Barang</div>
                    <div class="col-7">
                    : ${response.asal} di ${response.toko ? response.toko : (response.instansi ? response.instansi : "tidak ada informasi asal")}
                    </div>
                  </div>
                </li>
                ${(response.no_seri !== "" && response.no_dokumen !== "" && response.no_seri !== null && response.no_dokumen !== null) ? 
                `<li class="noseri">
                  <div class="row mt-2">
                    <div class="col-5">Nomor Seri</div>
                    <div class="col-7">: ${response.no_seri}</div>
                  </div>
                </li>
                <li class="nodoc">
                  <div class="row mt-2">
                    <div class="col-5">Nomor Dokumen</div>
                    <div class="col-7">: ${response.no_dokumen}</div>
                  </div>
                </li>` : ''}
                <li>
                  <div class="row mt-2">
                    <div class="col-5">Merk</div>
                    <div class="col-7">:  ${response.merk}</div>
                  </div>
                </li>
                <li>
                  <div class="row mt-2">
                    <div class="col-5">Warna</div>
                    <div class="col-7 d-flex">:&nbsp; <div id="circle" style="width: 50px;height: 25px;border-radius: 10%;border: 2px solid rgba(0, 0, 0, 0.5);background-color: ${response.warna};box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);"></div></div>
                  </div>
                </li>
                <li>
                  <div class="row mt-2">
                    <div class="col-5">Harga Beli</div>
                    <div class="col-7">: Rp ${new Intl.NumberFormat('id-ID').format(response.harga_beli)}</div>
                  </div>
                </li>
                <li>
                  <div class="row mt-2">
                    <div class="col-5">Harga Jual</div>
                    <div class="col-7">:  Rp ${new Intl.NumberFormat('id-ID').format(response.harga_jual)}</div>
                  </div>
                </li>
                <li>
                  <div class="row mt-2">
                    <div class="col-5">Tanggal Pembelian</div>
                    <div class="col-7">: ${buying_date}</div>
                  </div>
                </li>
              </ul>`);

        if (response.updated_at !== null) {
          const lastUpdate = moment(response.updated_at).fromNow();
          $('.modal-body-detail').append(`
          </div>
            <p class="card-text"><small class="text-body-secondary" id="lastupdate"> Terakhir update pada ${lastUpdate}, di-update oleh ${response.updated_by}</small></p>
          </div>
        </div>`)

        } else {
          const createdAt = moment(response.created_at).fromNow();
          $('.modal-body-detail').append(`
          </div>
            <p class="card-text"><small class="text-body-secondary" id="lastupdate">Dibuat oleh ${response.created_by} pada ${createdAt}</small></p>
          </div>
        </div>`)
        }
      }
    });
  });
</script>