<!DOCTYPE html>
<html>

<head>
  <title>Laporan Pemakaian</title>
  <!-- Page plugins -->
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/bootstrap.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/bootstrap-icons/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/app.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/css/mystyle/mystyle.css">
  <?= $this->renderSection('styles') ?>
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/iconly/bold.css">
  <link rel="stylesheet" href="<?= base_url() ?>/assets/vendors/DataTables/datatables.min.css">

  <!-- fontawesome -->
  <link href="<?= base_url() ?>/assets/vendors/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- <link href="<?= base_url() ?>/assets/vendors/fontawesome/all.min.css" rel="stylesheet" type="text/css"> -->
  <script src="<?= base_url() ?>/assets/vendors/jquery/jquery.min.js"></script>
</head>

<body>
  <style type="text/css">
    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border: 1px;
      width: 100%;
    }

    #customers td,
    #customers th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    #customers tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #customers tr:hover {
      background-color: #ddd;
    }

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }
  </style>
  <!-- <div class="row align-items-start">
    <div class="col">
      <img src="" alt="" style="">
    </div>
  </div> -->
  <center class="my-3" cellpadding="4">
    <h5>Laporan Data Barang</h4>
  </center>

  <h2>HTML TABLE:</h2>
  <table id="customers" class="table">
    <tr>
      <th>#</th>
      <th align="right">RIGHT align</th>
      <th align="left">LEFT align</th>
      <th>4A</th>
    </tr>
    <tr>
      <td>1</td>
      <td bgcolor="#cccccc" align="center" colspan="2">A1 ex<i>amp</i>le <a href="http://www.tcpdf.org">link</a> column span. One two tree four five six seven eight nine ten.<br />line after br<br /><small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla<ol>
          <li>first<ol>
              <li>sublist</li>
              <li>sublist</li>
            </ol>
          </li>
          <li>second</li>
        </ol><small color="#FF0000" bgcolor="#FFFF00">small small small small small small small small small small small small small small small small small small small small</small></td>
      <td>4B</td>
    </tr>
    <tr>
      <td>'.$subtable.'</td>
      <td bgcolor="#0000FF" color="yellow" align="center">A2 € &euro; &#8364; &amp; è &egrave;<br />A2 € &euro; &#8364; &amp; è &egrave;</td>
      <td bgcolor="#FFFF00" align="left">
        <font color="#FF0000">Red</font> Yellow BG
      </td>
      <td>4C</td>
    </tr>
    <tr>
      <td>1A</td>
      <td rowspan="2" colspan="2" bgcolor="#FFFFCC">2AA<br />2AB<br />2AC</td>
      <td bgcolor="#FF0000">4D</td>
    </tr>
    <tr>
      <td>1B</td>
      <td>4E</td>
    </tr>
    <tr>
      <td>1C</td>
      <td>2C</td>
      <td>3C</td>
      <td>4F</td>
    </tr>
  </table>
  <script script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js">
  </script>

  <!-- Optional Js -->
  <script src="<?= base_url() ?>/assets/vendors/DataTables/datatables.min.js"></script>
  <script src="<?= base_url() ?>/assets/vendors/DataTables/DataTables-1.13.3/js/jquery.dataTables.min.js"></script>
</body>

</html>