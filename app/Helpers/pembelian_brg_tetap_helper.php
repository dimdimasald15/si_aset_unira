<?php
if (!function_exists('calculateTotalHargaAndTanggal')) {
    function calculateTotalHargaAndTanggal($results)
    {
        $total_harga = [];
        $tgldibuat = [];
        foreach ($results as $row) {
            $total_harga[] = $row['jml_msk'] * $row['hrg_beli_brg'];
            $tgldibuat[] = format_tanggal($row['created_at']);
        }
        return [$total_harga, $tgldibuat];
    }
}

if (!function_exists('addExtraFields')) {
    function addExtraFields(&$results, $total_harga, $tgldibuat)
    {
        foreach ($results as $key => $row) {
            $results[$key]['total_harga'] = $total_harga[$key];
            $results[$key]['tgldibuat'] = $tgldibuat[$key];
        }
    }
}

if (!function_exists('groupAndSumResults')) {
    function groupAndSumResults($results)
    {
        $filterArray = [];
        foreach ($results as $row) {
            $nama_brg = $row['nama_brg'];
            if (isset($filterArray[$nama_brg])) {
                $filterArray[$nama_brg]['jml_msk'] += $row['jml_msk'];
                $filterArray[$nama_brg]['total_harga'] += $row['total_harga'];
            } else {
                $filterArray[$nama_brg] = [
                    'nama_brg' => $row['nama_brg'],
                    'kode_brg' => $row['kode_brg'],
                    'warna' => $row['warna'],
                    'hrg_beli_brg' => $row['hrg_beli_brg'],
                    'jml_msk' => $row['jml_msk'],
                    'total_harga' => $row['total_harga'],
                    'kd_satuan' => $row['kd_satuan'],
                    'created_at' => $row['created_at'],
                    'tgldibuat' => $row['tgldibuat'],
                ];
            }
        }
        return array_values($filterArray);
    }
}

if (!function_exists('groupDataByTanggal')) {
    function groupDataByTanggal($filterArray)
    {
        $groupedData = [];
        foreach ($filterArray as &$item) {
            $dateString = $item["tgldibuat"];
            $haritanggal = explode(" ", $dateString)[2] . " " . explode(" ", $dateString)[3];

            if (!isset($groupedData[$haritanggal])) {
                $groupedData[$haritanggal] = [];
            }
            $groupedData[$haritanggal][] = $item;
        }
        return $groupedData;
    }
}
