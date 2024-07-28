<?php

if (!function_exists('format_tanggal')) {
  function format_tanggal($date)
  {
    date_default_timezone_set('Asia/Jakarta');
    // array hari dan bulan
    $Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
    $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    // pemisahan tahun, bulan, hari, dan waktu
    if (!empty($date)) {
      $tahun = substr($date, 0, 4);
      $bulan = substr($date, 5, 2);
      $tgl = substr($date, 8, 2);
      // $waktu = substr($date, 11, 5);
      $hari = date("w", strtotime($date));
      $result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun;
    } else {
      $result = "Tahun " . date('Y');
    }

    return $result;
  }
}

if (!function_exists('ubah_format_tanggal')) {
  function ubah_format_tanggal($tanggal_awal)
  {
    // Validasi format tanggal awal
    if (!preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $tanggal_awal)) {
      throw new Exception("Format tanggal awal tidak valid");
    }

    // Ubah format tanggal ke timestamp UNIX
    $timestamp = strtotime($tanggal_awal);

    // Ubah timestamp UNIX ke format Y-m-d
    $tanggal_baru = date("Y-m-d", $timestamp);

    return $tanggal_baru;
  }
}

if (!function_exists('format_uang')) {
  function format_uang($data)
  {
    $harga_formatted = 'Rp' . number_format($data, 0, ',', '.') . ',-';
    // echo $harga_formatted;
    return $harga_formatted;
  }
}

if (!function_exists('format_warna')) {
  function format_warna($hexacode)
  {
    $colors = array(
      'aliceblue' => '#F0F8FF',
      'antiquewhite' => '# FAEBD7',
      'aqua' => '#00FFFF',
      'aquamarine' => '#7FFFD4',
      'azure' => '#F0FFFF',
      'krem' => '#F5F5DC',
      'bisque' => '#FFE4C4',
      'hitam' => '#000000',
      'blanchedalmond' => '#FFEBCD',
      'biru' => '#0000FF',
      'blueviolet' => '#8A2BE2',
      'brown' => '#A52A2A',
      'burlywood' => '# DEB887',
      'cadetblue' => '#5F9EA0',
      'chartreuse' => '#7FFF00',
      'coklat' => '#D2691E',
      'koral' => '# FF7F50',
      'cornflowerblue' => '#6495ED',
      'cornsilk' => '#FFF8DC',
      'crimson' => '# DC143C',
      'cyan' => '#00FFFF',
      'darkblue' => '#00008B',
      'darkcyan' => '#008B8B',
      'darkgoldenrod' => '#B8860B',
      'darkgray' => '#A9A9A9',
      'darkgreen' => '#006400',
      'darkgrey' => '#A9A9A9',
      'darkkhaki' => '# BDB76B',
      'darkmagenta' => '#8B008B',
      'darkolivegreen' => '#556B2F',
      'darkorange' => '# FF8C00',
      'darkorchid' => '#9932CC',
      'darkred' => '#8B0000',
      'darksalmon' => '#E9967A',
      'darkseagreen' => '#8FBC8F',
      'darkslateblue' => '#483D8B',
      'darkslategray' => '#2F4F4F',
      'darkslategrey' => '#2F4F4F',
      'darkturquoise' => '#00CED1',
      'darkviolet' => '#9400D3',
      'deeppink' => '# FF1493',
      'deepskyblue' => '#00BFFF',
      'dimgray' => '#696969',
      'dimgrey' => '#696969',
      'dodgerblue' => '#1E90FF',
      'firebrick' => '#B22222',
      'floralwhite' => '#FFFAF0',
      'forestgreen' => '#228B22',
      'fuchsia' => '# FF00FF',
      'gainsboro' => '#DCDCDC',
      'ghostwhite' => '#F8F8FF',
      'gold' => '# FFD700',
      'goldenrod' => '# DAA520',
      'abu-abu' => '#808080',
      'hijau' => '#008000',
      'greenyellow' => '# ADFF2F',
      'abu-abu' => '#808080',
      'honeydew' => '#F0FFF0',
      'hotpink' => '# FF69B4',
      'indianred' => '# CD5C5C',
      'indigo' => '#4B0082',
      'ivory' => '#FFFFF0',
      'khaki' => '#F0E68C',
      'lavender' => '#E6E6FA',
      'lavenderblush' => '#FFF0F5',
      'lawngreen' => '#7CFC00',
      'lemonchiffon' => '#FFFACD',
      'lightblue' => '#ADD8E6',
      'lightcoral' => '#F08080',
      'lightcyan' => '#E0FFFF',
      'lightgoldenrodyellow' => '#FAFAD2',
      'lightgray' => '#D3D3D3',
      'lightgreen' => '#90EE90',
      'lightgrey' => '#D3D3D3',
      'lightpink' => '# FFB6C1',
      'lightsalmon' => '#FFA07A',
      'lightseagreen' => '#20B2AA',
      'lightskyblue' => '#87CEFA',
      'lightslategray' => '#778899',
      'lightslategrey' => '#778899',
      'lightsteelblue' => '#B0C4DE',
      'lightyellow' => '#FFFFE0',
      'lime' => '#00FF00',
      'limegreen' => '#32CD32',
      'linen' => '#FAF0E6',
      'magenta' => '# FF00FF',
      'maroon' => '#800000',
      'mediumaquamarine' => '#66CDAA',
      'mediumblue' => '#0000CD',
      'mediumorchid' => '# BA55D3',
      'mediumpurple' => '#9370D0',
      'mediumseagreen' => '#3CB371',
      'mediumslateblue' => '#7B68EE',
      'mediumspringgreen' => '#00FA9A',
      'mediumturquoise' => '#48D1CC',
      'mediumvioletred' => '#C71585',
      'midnightblue' => '#191970',
      'mintcream' => '#F5FFFA',
      'mistyrose' => '#FFE4E1',
      'moccasin' => '#FFE4B5',
      'navajowhite' => '#FFDEAD',
      'navy' => '#000080',
      'oldlace' => '#FDF5E6',
      'olive' => '#808000',
      'olivedrab' => '#6B8E23',
      'orange' => '#FFA500',
      'orangered' => '#FF4500',
      'anggrek' => '# DA70D6',
      'palegoldenrod' => '#EEE8AA',
      'palegreen' => '#98FB98',
      'paleturquoise' => '# AFEEEE',
      'palevioletred' => '# DB7093',
      'papayawhip' => '#FFEFD5',
      'peachpuff' => '# FFDAB9',
      'peru' => '# CD853F',
      'pink' => '# FFC0CB',
      'prem' => '#DDA0DD',
      'powderblue' => '#B0E0E6',
      'ungu' => '#800080',
      'merah' => '#FF0000',
      'rosybrown' => '# BC8F8F',
      'royalblue' => '#4169E1',
      'saddlebrown' => '#8B4513',
      'salmon' => '# FA8072',
      'sandybrown' => '#F4A460',
      'seagreen' => '#2E8B57',
      'seashell' => '#FFF5EE',
      'sienna' => '#A0522D',
      'silver' => '#C0C0C0',
      'skyblue' => '#87CEEB',
      'slateblue' => '#6A5ACD',
      'slategray' => '#708090',
      'slategrey' => '#708090',
      'snow' => '#FFFAFA',
      'springgreen' => '#00FF7F',
      'steelblue' => '#4682B4',
      'tan' => '#D2B48C',
      'teal' => '#008080',
      'thistle' => '#D8BFD8',
      'tomato' => '#FF6347',
      'turquoise' => '#40E0D0',
      'violet' => '#EE82EE',
      'wheat' => '#F5DEB3',
      'putih' => '#FFFFFF',
      'whitesmoke' => '#F5F5F5',
      'kuning' => '#FFFF00',
      'yellowgreen' => '#9ACD32'
    );
    $warna = [];
    foreach ($colors as $key => $row) {
      $warna[strtolower($row)] = $key;
    }
    $hexacode = strtolower($hexacode);
    if (isset($warna[$hexacode])) {
      return $warna[$hexacode];
    }

    return $hexacode;
  }
}

if (!function_exists('format_bulan')) {
  function format_bulan($string)
  {
    switch ($string) {
      case $string == 1:
        $bulan = "Januari";
        break;
      case $string == 2:
        $bulan = "Februari";
        break;
      case $string == 3:
        $bulan = "Maret";
        break;
      case $string == 4:
        $bulan = "April";
        break;
      case $string == 5:
        $bulan = "Mei";
        break;
      case $string == 6:
        $bulan = "Juni";
        break;
      case $string == 7:
        $bulan = "Juli";
        break;
      case $string == 8:
        $bulan = "Agustus";
        break;
      case $string == 9:
        $bulan = "September";
        break;
      case $string == 10:
        $bulan = "Oktober";
        break;
      case $string == 11:
        $bulan = "November";
        break;
      case $string == 12:
        $bulan = "Desember";
        break;
      default:
        return false;
    }

    return $bulan;
  }
}
if (!function_exists('isBulanTahun')) {
  function isBulanTahun($string)
  {
    $bulan = explode(" ", $string)[0];

    $month = "";
    switch ($bulan) {
      case $bulan === "Januari":
        $month = "January";
        break;
      case $bulan === "Februari":
        $month = "February";
        break;
      case $bulan === "Maret":
        $month = "March";
        break;
      case $bulan === "April":
        $month = "April";
        break;
      case $bulan === "Mei":
        $month = "May";
        break;
      case $bulan === "Juni":
        $month = "June";
        break;
      case $bulan === "Juli":
        $month = "July";
        break;
      case $bulan === "Agustus":
        $month = "August";
        break;
      case $bulan === "September":
        $month = "September";
        break;
      case $bulan === "Oktober":
        $month = "October";
        break;
      case $bulan === "November":
        $month = "November";
        break;
      case $bulan === "Desember":
        $month = "December";
        break;
      default:
        return false;
    }
    $timestamp = strtotime($month);
    // echo $month . " + " . ($timestamp) ? true : false;
    // die;
    // Jika konversi berhasil dan bulan serta tahun ada dalam string
    if ($timestamp !== false && strpos($month, date('F', $timestamp)) !== false) {
      return true;
    }

    return false;
  }
}

if (!function_exists('ubahTanggal')) {
  function ubahTanggal($date)
  {
    // echo date('Y-m-d', strtotime($date)) == date('Y-m-d') ? 'true' : 'false';
    date_default_timezone_set('Asia/Jakarta');
    // array hari dan bulan
    $Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
    $Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    // pemisahan tahun, bulan, hari, dan waktu
    if (!empty($date)) {
      if (date('Y-m-d', strtotime($date)) == date('Y-m-d')) {
        $timestamp = strtotime($date);
        $currentTimestamp = time();
        $timeDiff = $currentTimestamp - $timestamp;

        if ($timeDiff < 60) {
          $result = $timeDiff . " detik yang lalu";
        } elseif ($timeDiff < 3600) {
          $minutes = floor($timeDiff / 60);
          $result = $minutes . " menit yang lalu";
        } elseif ($timeDiff < 86400) {
          $hours = floor($timeDiff / 3600);
          $result = $hours . " jam yang lalu";
        }
      } else {
        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl = substr($date, 8, 2);
        // $waktu = substr($date, 11, 5);
        $hari = date("w", strtotime($date));
        $result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun;
      }
    }

    return $result;
  }
}
