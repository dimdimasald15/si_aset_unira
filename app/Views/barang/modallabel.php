<style>
  .btn-close-white {
    color: white;
  }

  .card {
    height: auto;
  }

  .card-label {
    border: 4px solid var(--bs-success) !important;
    /* border-color: #1fa164; */
  }
</style>

<div class="modal fade" id="modallabel" tabindex="-1" aria-labelledby="labelBarangModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
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
              <div class="card-body text-center">
                <div class="row d-flex justify-content-between align-items-center">
                  <div class="col-9">
                    <div class="infobrg"></div>
                  </div>
                  <div class="col-3" id="qrcode">

                  </div>
                </div>
              </div>
              <div class="card-footer" style="background-color:#1fa164;"></div>
            </div>
          </div>
        </div>
        <div class="row d-flex justify-content-end mt-3">
          <div class="col-lg-4 d-flex justify-content-end align-items-center">
            <h6>Cetak banyak label ke dalam pdf</h6>
          </div>
          <div class="col-lg-2">
            <div class="input-group mb-3">
              <button class="btn btn-outline-success" type="button" id="minus-btn">-</button>
              <input type="number" class="form-control " id="qty-input" value="1">
              <button class="btn btn-outline-success" type="button" id="plus-btn">+</button>
            </div>
          </div>
          <div class="col-lg-3">
            <button class="btn btn-success" type="button" id="cetakpdf"><i class="fa fa-print"></i> Cetak PDF</button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" id="btn-download">Download</button>
      </div>
    </div>
  </div>
</div>
<script>
  var id = "<?= $id ?>";
  var title = $('#title');
  var kdbrg = '';


  // Get the card element
  var card = $('.card-label')[0];
  // Create a canvas element with the same dimensions as the card
  var canvas = document.createElement('canvas');
  canvas.width = card.clientWidth;
  canvas.height = card.clientHeight;
  // Draw the card onto the canvas
  var context = canvas.getContext('2d');
  context.fillStyle = '#ffffff';
  context.fillRect(0, 0, canvas.width, canvas.height);

  function downloadImage() {
    html2canvas(card).then(function(canvas) {
      // Convert the canvas to an image data URL
      var dataURL = canvas.toDataURL('image/png');
      // Create a download link
      var downloadLink = document.createElement('a');
      downloadLink.href = dataURL;
      downloadLink.download = `label-${kdbrg}.png`;
      // Trigger the download
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    });
  }

  function imgQR(qrCanvas, centerImage, factor) {
    var h = qrCanvas.height;
    //center size
    var cs = h * factor;
    // Center offset
    var co = (h - cs) / 2;
    var ctx = qrCanvas.getContext("2d");
    ctx.drawImage(centerImage, 0, 0, centerImage.width, centerImage.height, co, co, cs, cs + 10);
    ctx.strokeStyle = "#ffffff";
    ctx.lineWidth = 2 // ketebalan garis tepi 2 piksel
    ctx.strokeRect(co, co, cs, cs + 10); // membuat garis tepi persegi panjang di sekitar gambar
  }

  function cetakpdf() {
    var qty = parseInt($('#qty-input').val())
    var canvasArray = [];

    for (let i = 0; i < qty; i++) {
      var canvas = document.createElement('canvas');
      canvas.willReadFrequently = true;
      canvas.width = card.clientWidth;
      canvas.height = card.clientHeight;
      canvasArray.push(canvas);
    }

    var promises = [];
    for (let i = 0; i < qty; i++) {
      var canvas2 = canvasArray[i];
      var ctx = canvas2.getContext('2d');
      var scale = canvas2.width / card.clientWidth;
      console.log(scale);
      ctx.scale(scale, scale);
      promises.push(html2canvas(card, {
        canvas: canvas2,
        width: card.clientWidth,
        height: card.clientHeight,
        scale: scale,
        dpi: 600,
      }));
    }

    Promise.all(promises).then(function() {
      // console.log('promises');
      var docDefinition = {
        pageOrientation: 'landscape',
        content: []
      };
      var images = [];
      for (let i = 0; i < qty; i++) {
        images.push({
          image: canvasArray[i].toDataURL('image/png'),
          width: 350,
          margin: [10, 10, 10, 0]
        });
      }

      var content = [];
      for (let i = 0; i < qty; i += 2) {
        var row = [];
        for (let j = i; j < i + 2 && j < qty; j++) {
          row.push(images[j]);
        }
        content.push({
          columns: row,
          columnGap: 10
        });
      }

      docDefinition.content = content;
      pdfMake.createPdf(docDefinition).download(`labels-${kdbrg}.pdf`);
    });
  }



  $(document).ready(function() {
    $.ajax({
      type: "get",
      url: "<?= base_url() ?>/barangcontroller/getdatabarangbyid",
      data: {
        id: id
      },
      dataType: "json",
      success: function(response) {
        // set title
        $('#title').text('Cetak Label Barang - ' + response.nama_brg);
        var kodebarang = response.kode_brg;
        kdbrg = kodebarang.split(".").join("-");
        const logo = "<?= base_url() ?>/assets/images/logo/logounira.jpg";
        namabrg = response.nama_brg;

        $('.infobrg').append(`
          <hr>
          <div class="row m-0 d-flex justify-content-start align-items-center">
          <div class="col-lg-2"><img src=${logo} class="mx-auto d-block" alt="Logo" width="75%"></div>
          <div class="col-lg-10"><h3>Universitas Islam Raden Rahmat Malang</h3></div>
          </div>
          <hr>
          <h5>${response.nama_brg}</h5>
          <hr>
          <h5>${kodebarang}</h5>
          <hr>
          <h6>Sarana dan Prasarana UNIRA Malang</h6>
          <hr>
          `);

        const icon = new Image();
        icon.onload = function() {
          // create qr code with logo
          var qrcode = new QRCode('qrcode', {
            text: `<?= base_url() ?>/public/detail-barang/${kdbrg}`,
            width: 200,
            height: 200,
            correctLevel: QRCode.CorrectLevel.H,
            colorDark: "#000000",
            colorLight: "#ffffff",
          });
          imgQR(qrcode._oDrawing._elCanvas, this, 0.2);
        }
        icon.src = logo;
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