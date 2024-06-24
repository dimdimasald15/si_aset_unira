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
  }
</style>

<div class="modal fade" id="modallabel" tabindex="-1" aria-labelledby="labelBarangModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title text-white" id="title"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body modal-body-label">
      </div>
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-11">
            <div class="card card-label">
              <div class="card-body p-2">
                <div class="row d-flex justify-content-between align-items-center">
                  <div class="col-lg-auto">
                    <div class="infobrg"></div>
                  </div>
                  <div class="col-lg-auto text-center px-4">
                    <div class="row mt-4 mb-2" id="qrcode"></div>
                    <div class="row text-center" id="urlqr"></div>
                  </div>
                </div>
              </div>
              <div class="card-footer pb-2 pt-1" style="background-color:#1fa164;color:white !important;">
                <div class="row text-center">
                  <h5 class="text-white">SARANA & PRASARANA <br> UNIVERSITAS ISLAM RADEN RAHMAT MALANG</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row d-flex justify-content-end mt-3">
          <div class="col-sm-4 d-flex justify-content-start align-items-center">
            <h6>Cetak banyak label ke dalam pdf</h6>
          </div>
          <div class="col-sm-4">
            <div class="input-group mb-3">
              <button class="btn btn-outline-success" type="button" onClick="util.minusBtn($('#qty-input').val())">-</button>
              <input type="number" class="form-control " id="qty-input" value="1">
              <button class="btn btn-outline-success" type="button" onClick="util.plusBtn()">+</button>
            </div>
          </div>
          <div class="col-sm-4">
            <button class="btn btn-success" type="button" onClick="barang.downloadLabelPdf()"><i class="fa fa-print"></i> Cetak PDF</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onClick="barang.downloadLabelImg()"><i class="fa fa-download"></i> Download Gambar</button>
      </div>
    </div>
  </div>
</div>
<script>
  var id = "<?= $id ?>";
  var kdbrg = '';
  var idlokasi = '';

  // Get the card element
  var card = $('.card-label')[0];

  $(document).ready(function() {
    $.ajax({
      type: "get",
      url: `${nav}/getdatastokbarangbyid`,
      data: {
        id: id
      },
      dataType: "json",
      success: function(response) {
        // set title
        var kodebarang = response.kode_brg;
        idlokasi = response.ruang_id;
        kdbrg = kodebarang.split(".").join("-");
        const logo = `${BASE_URL}assets/images/logo/logounira.jpg`;
        namabrg = response.nama_brg;
        const urlqrcode = `${BASE_URL}detail-barang/${kdbrg}-${idlokasi}`;
        const dateStr = response.tgl_pembelian;
        const date = new Date(dateStr);
        const options = {
          day: 'numeric',
          month: 'long',
          year: 'numeric'
        };
        const tglbeli = date.toLocaleDateString('id-ID', options);

        $('#title').text(
          `Cetak Label Barang - ${response.kode_brg} - ${response.nama_ruang}`
        );

        const icon = new Image();
        icon.onload = function() {
          // create qr code with logo
          var qrcode = new QRCode('qrcode', {
            text: `${urlqrcode}`,
            width: 500,
            height: 500,
            correctLevel: QRCode.CorrectLevel.H,
            colorDark: "#000000",
            colorLight: "#ffffff",
          });
          util.imgQR(qrcode._oDrawing._elCanvas, this, 0.2);
        }
        icon.src = logo;

        $('#urlqr').append(`<p class="fs-5 fw-bolder fst-italic">${kodebarang}.${idlokasi}</p>`);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    });
  });
</script>