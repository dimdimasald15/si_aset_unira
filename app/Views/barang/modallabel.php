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

<div class="modal fade" id="modallabel" tabindex="-1" aria-labelledby="labelBarangModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success">
        <h5 class="modal-title white" id="title"></h5>
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
                  <div class="col-lg-auto text-center" style="padding: 0px 80px">
                    <div class="row my-2" id="qrcode"></div>
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
              <button class="btn btn-outline-success" type="button" id="minus-btn">-</button>
              <input type="number" class="form-control " id="qty-input" value="1">
              <button class="btn btn-outline-success" type="button" id="plus-btn">+</button>
            </div>
          </div>
          <div class="col-sm-4">
            <button class="btn btn-success" type="button" id="cetakpdf"><i class="fa fa-print"></i> Cetak PDF</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btn-download"><i class="fa fa-download"></i> Download Gambar</button>
      </div>
    </div>
  </div>
</div>
<script>
  var id = "<?= $id ?>";
  var title = $('#title');
  var kdbrg = '';
  var idlokasi = '';

  // Get the card element
  var card = $('.card-label')[0];

  function downloadImage() {
    html2canvas(card).then(function(canvas) {
      // Convert the canvas to an image data URL
      var dataURL = canvas.toDataURL('image/png');
      // Create a download link
      var downloadLink = document.createElement('a');
      downloadLink.href = dataURL;
      downloadLink.download = `label-${kdbrg}-${idlokasi}.png`;
      // Trigger the download
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    });
  }

  function imgQR(qrCanvas, centerImage, factor) {
    var h = qrCanvas.height;
    //center size
    var cs = (h * factor);
    // Center offset
    var co = (h - cs) / 2;
    var ctx = qrCanvas.getContext("2d");
    ctx.drawImage(centerImage, 0, 0, centerImage.width, (centerImage.height - 50), co, co, cs, cs + 10);
    ctx.strokeStyle = "#ffffff";
    ctx.lineWidth = 15 // ketebalan garis tepi 2 piksel
    ctx.strokeRect(co, co, cs, cs + 10); // membuat garis tepi persegi panjang di sekitar gambar
  }

  function cetakpdf() {
    // Menampilkan tombol loading
    $('#cetakpdf').attr('disabled', 'disabled');
    $('#cetakpdf').html('<i class="fa fa-spin fa-spinner"></i> Loading...');

    var qty = parseInt($('#qty-input').val())
    var canvasArray = [];

    for (let i = 0; i < qty; i++) {
      var canvas = document.createElement('canvas');
      canvas.willReadFrequently = true;
      canvas.width = 400;
      canvas.height = 570;
      canvasArray.push(canvas);
    }

    var promises = [];
    for (let i = 0; i < qty; i++) {
      var canvas2 = canvasArray[i];
      var ctx = canvas2.getContext('2d');
      var scale = canvas2.width / card.clientWidth;
      // var scale = 1;
      ctx.scale(scale, scale);
      ctx.imageSmoothingQuality = "High";
      promises.push(html2canvas(card, {
        canvas: canvas2,
        width: card.clientWidth,
        height: card.clientHeight,
        scale: scale,
        dpi: 144,
      }));
    }

    Promise.all(promises).then(function() {
      var docDefinition = {
        pageSize: 'A4',
        pageMargins: [10, 10, 10, 10],
        pageOrientation: 'portrait',
        content: []
      };
      var images = [];
      for (let i = 0; i < qty; i++) {
        images.push({
          image: canvasArray[i].toDataURL('image/png'),
          width: 130,
          margin: [10, 10, 10, 10]
        });
      }

      var content = [];
      for (let i = 0; i < qty; i += 4) {
        var row = [];
        for (let j = i; j < i + 4 && j < qty; j++) {
          row.push(images[j]);
        }
        content.push({
          columns: row,
          columnGap: 10,
        });
      }

      docDefinition.content = content;

      // Menghilangkan tombol loading dan mengembalikan teks tombol
      $('#cetakpdf').removeAttr('disabled');
      $('#cetakpdf').html('Cetak PDF');

      pdfMake.createPdf(docDefinition).download(`labels-${kdbrg}-${idlokasi}.pdf`);

      // Membuat objek PDF menggunakan pdfMake
      // var pdfDoc = pdfMake.createPdf(docDefinition);

      // Mendapatkan blob PDF
      // pdfDoc.getBlob(function(blob) {
      //   // Membuat URL objek blob dari data PDF
      //   var blobUrl = URL.createObjectURL(blob);
      //   // Membuka pratinjau PDF di jendela baru
      //   var previewWindow = window.open(blobUrl, '_blank');
      //   if (previewWindow == null || typeof(previewWindow) === 'undefined') {
      //     alert('Pratinjau PDF diblokir oleh peramban. Harap izinkan jendela popup untuk melihat pratinjau.');
      //   } else {
      //     // Membebaskan URL objek blob saat jendela pratinjau ditutup
      //     previewWindow.addEventListener('beforeunload', function() {
      //       URL.revokeObjectURL(blobUrl);
      //     });
      //   }
      // });
    });
  }

  $(document).ready(function() {
    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/barangcontroller/getdatastokbarangbyid",
      data: {
        id: id
      },
      dataType: "json",
      success: function(response) {
        // set title
        var kodebarang = response.kode_brg;
        idlokasi = response.ruang_id;
        kdbrg = kodebarang.split(".").join("-");
        const logo = "<?= base_url('assets/images/logo/logounira.jpg') ?>";
        namabrg = response.nama_brg;
        const urlqrcode = `<?= base_url() ?>detail-barang/${kdbrg}-${idlokasi}`;
        const dateStr = response.tgl_pembelian;
        const date = new Date(dateStr);
        const options = {
          day: 'numeric',
          month: 'long',
          year: 'numeric'
        };
        const tglbeli = date.toLocaleDateString('id-ID', options);

        $('#title').text(`Cetak Label Barang - ${response.kode_brg} - ${response.nama_ruang}`);

        $('.infobrg').append(`
        <div class="row d-flex justify-content-start text-center">
        <h3>${response.nama_brg.toUpperCase()}</h3>
        <h4>(${response.nama_ruang.toUpperCase()})</h4>
        </div>`);

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
          imgQR(qrcode._oDrawing._elCanvas, this, 0.2);
        }
        icon.src = logo;

        $('#urlqr').append(`<p class="fs-5" style="font-style:italic;color:black;">${urlqrcode}</p>`);
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert(xhr.status, +"\n" + xhr.responseText + "\n" + thrownError);
      }
    });

    $('#btn-download').on('click', function(e) {
      e.preventDefault();
      downloadImage();
    })

    // Add click event listeners to the plus and minus buttons
    $('#plus-btn').on('click', function() {
      var qtyplus = $('#qty-input').val();
      qtyplus++;
      $('#qty-input').val(qtyplus);
    })
    $('#minus-btn').on('click', function() {
      qtymin = $('#qty-input').val();
      if ($('#qty-input').val() > 1) {
        qtymin--;
        $('#qty-input').val(qtymin);
      }
      //  else qtymin = 0;
    })

    $('#cetakpdf').on('click', function(e) {
      e.preventDefault();
      cetakpdf();
    })

  });
</script>