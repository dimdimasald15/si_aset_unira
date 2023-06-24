<?php

namespace App\Controllers;

use App\Models\Barang;
use App\Models\RiwayatBarang;
use App\Models\Kategori;
use App\Models\Ruang;
use App\Models\StokBarang;
use App\Models\RiwayatTransaksi;
use App\Models\Anggota;
use App\Models\Permintaan;
use App\Models\Peminjaman;
use \Hermawan\DataTables\DataTable;
use DateTime;
use CodeIgniter\I18n\Time;
use CodeIgniter\I18n\IntlFormat;
use Dompdf\Dompdf;
use App\Controllers\BaseController;


class LaporanController extends BaseController
{
    protected $barang, $kategori, $uri, $stokbarang, $riwayatbarang, $ruang, $riwayattrx, $anggota, $permintaan, $peminjaman;

    public function __construct()
    {
        helper('url');
        $session = session();
        $this->barang = new Barang();
        $this->riwayatbarang = new RiwayatBarang();
        $this->kategori = new Kategori();
        $this->ruang = new Ruang();
        $this->stokbarang = new StokBarang();
        $this->riwayattrx = new RiwayatTransaksi();
        $this->anggota = new Anggota();
        $this->permintaan = new Permintaan();
        $this->peminjaman = new Peminjaman();
        $this->uri = service('uri');
        if (isset($session->username)) {
            return redirect()->to('admin/dashboard');
        } else {
            // jika variabel $_SESSION['username'] belum didefinisikan, redirect ke halaman login
            return redirect()->to('/auth');
        }
    }

    public function index()
    {
        $segments = $this->uri->getSegments();
        $breadcrumb = [];
        $link = '';

        foreach ($segments as $segment) {
            $link .= '/' . $segment;
            $name = ucwords(str_replace('-', ' ', $segment));
            $breadcrumb[] = ['name' => $name, 'link' => $link];
        }

        $data = [
            'title' => 'Laporan',
            'nav' => 'laporan',
            'breadcrumb' => $breadcrumb
        ];

        return view('laporan/index', $data);
    }

    public function getdatalokasibrg()
    {
        if ($this->request->isAJAX()) {
            $builder = $this->db->table('stok_barang sb')
                ->select('sb.ruang_id, sb.created_at, sb.created_by, r.nama_ruang, s.nama_satuan, count(sb.barang_id) as count_brg, GROUP_CONCAT(CONCAT(b.nama_brg, " (", sb.sisa_stok, " ", s.kd_satuan, ")") SEPARATOR ", ") AS nama_brg, 
                (SELECT SUM(sb2.sisa_stok * b2.harga_jual) FROM stok_barang sb2 JOIN barang b2 ON b2.id = sb2.barang_id WHERE sb2.ruang_id = sb.ruang_id AND sb2.deleted_at IS NULL AND b2.deleted_at IS NULL) AS total_valuasi')
                ->join('barang b', 'b.id=sb.barang_id')
                ->join('kategori k', 'k.id=b.kat_id ')
                ->join('ruang r', 'sb.ruang_id = r.id')
                ->join('satuan s', 'sb.satuan_id = s.id')
                ->where('sb.deleted_at', null)
                ->where('b.deleted_at', null)
                ->where('k.jenis', "Barang Tetap")
                ->groupBy('sb.ruang_id')
                ->orderBy('sb.id', 'desc');

            $lokasi = $builder->get()->getResultArray();
            $msg = [
                'data' => $lokasi,
            ];

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }



    public function hitungstokbarang($m, $y)
    {
        $builder = $this->db->table('stok_barang sb')
            ->select('sb.barang_id AS b_id, b.kode_brg, b.nama_brg, b.warna,  b.harga_jual, SUM(sb.sisa_stok) AS stok_terbaru, b.harga_jual * SUM(sb.sisa_stok) AS total_val, s.kd_satuan')
            ->join('barang b', 'b.id = sb.barang_id')
            ->join('kategori k', 'k.id = b.kat_id')
            ->join('satuan s', 'sb.satuan_id = s.id')
            ->where('k.jenis', 'Barang Tetap');
        if (empty($y)) {
            $builder->where('YEAR(sb.created_at)', date('Y'));
        } else if (!empty($m) && !empty($y)) {
            $builder->where("MONTH(sb.created_at)", $m);
            $builder->where("YEAR(sb.created_at)", $y);
        } else if (!empty($y)) {
            $builder->where("YEAR(sb.created_at)", $y);
        }
        $builder->where('k.deleted_at', null)
            ->where('b.deleted_at', null)
            ->where('sb.deleted_at', null)
            ->groupBy('b_id');

        $results = $builder->get()->getResultArray();
        $hargajual = [];
        $totalval = [];
        helper('converter_helper');
        foreach ($results as $key => $val) {
            array_push($hargajual, format_uang($val['harga_jual']));
            array_push($totalval, format_uang($val['total_val']));
        }

        foreach ($results as $key => &$result) {
            // Tambahkan elemen "hargajual" ke setiap elemen $results
            $result['hargajual'] = $hargajual[$key];
            $result['totalval'] = $totalval[$key];
        }

        return $results;
    }

    private function getkategoriaset($jenis)
    {
        $builder = $this->db->table('kategori')
            ->select('id,kd_kategori, nama_kategori, deskripsi, created_by, created_at, deleted_by, deleted_at')
            ->where('jenis', $jenis)
            ->where('deleted_at', null);

        $results = $builder->get()->getResult();
        return $results;
    }
    private function hitungmintabarang($m, $y, $jenis)
    {
        $builder = $this->db->table('riwayat_barang rb')
            ->select('rb.id, rb.barang_id AS b_id, b.nama_brg,b.kode_brg, b.warna, p.anggota_id, p.barang_id, a.unit_id, u.singkatan, a.nama_anggota, SUM(p.jml_barang) AS jml_barang, p.created_at, p.created_by, CAST(
            REPLACE(
                COALESCE(
                    IF(JSON_EXTRACT(rb.old_value, \'$.harga_beli\') IS NULL,
                        (
                            SELECT JSON_EXTRACT(rb2.old_value, \'$.harga_beli\')
                            FROM riwayat_barang rb2
                            WHERE rb2.barang_id = rb.barang_id
                            AND YEAR(rb2.created_at) < YEAR(rb.created_at)
                            ORDER BY YEAR(rb2.created_at) DESC
                            LIMIT 1
                        ),
                        JSON_EXTRACT(rb.new_value, \'$.harga_beli\')
                    ),
                    b.harga_beli
                ),
                \'"\',
                \'\'
            ) AS UNSIGNED
            ) AS harga_beli, SUM(p.jml_barang) * harga_beli AS total_val, s.kd_satuan')
            ->join('barang b', 'b.id = rb.barang_id')
            ->join('kategori k', 'k.id = b.kat_id')
            ->join('stok_barang sb', 'b.id=sb.barang_id')
            ->join('satuan s', 's.id=sb.satuan_id')
            ->join('permintaan p', 'p.barang_id = b.id')
            ->join('anggota a', 'a.id = p.anggota_id')
            ->join('unit u', 'u.id = a.unit_id')
            ->where('k.jenis', $jenis);
        if (empty($y)) {
            $builder->where('YEAR(p.created_at)', date('Y'));
        } else if (!empty($m) && !empty($y)) {
            $builder->where("MONTH(p.created_at)", $m);
            $builder->where("YEAR(p.created_at)", $y);
        } else if (!empty($y)) {
            $builder->where("YEAR(p.created_at)", $y);
        }
        $builder->where('k.deleted_at', null)
            ->where('b.deleted_at', null)
            ->where('sb.deleted_at', null)
            ->where('p.deleted_at', null)
            ->groupBy('b.kode_brg');

        $results = $builder->get()->getResultArray();

        $hargabeli = [];
        $totalval = [];
        $tgldibuat = [];
        helper('converter_helper');
        foreach ($results as $key => $val) {
            array_push($hargabeli, format_uang($val['harga_beli']));
            array_push($totalval, format_uang($val['total_val']));
            array_push($tgldibuat, format_tanggal($val['created_at']));
        }

        foreach ($results as $key => &$result) {
            // Tambahkan elemen "hargabeli" ke setiap elemen $results
            $result['hargabeli'] = $hargabeli[$key];
            $result['totalval'] = $totalval[$key];
            $result['tgldibuat'] = $tgldibuat[$key];
        }

        // Array untuk menyimpan data yang telah dikelompokkan
        $groupedData = [];

        // Perulangan untuk mengelompokkan data berdasarkan bulan
        foreach ($results as $key => &$item) {
            // Ambil bulan saja dari tanggal
            $dateString = $item["tgldibuat"];
            if (empty($tgl_permintaan)) {
                $haritanggal = explode(" ", $dateString)[2] . " " . explode(" ", $dateString)[3];
            } else if (!empty($tgl_permintaan)) {
                $haritanggal = $dateString;
            }
            // Tambahkan data ke dalam array sesuai dengan bulan
            if (!isset($groupedData[$haritanggal])) {
                $groupedData[$haritanggal] = [];
            }
            $groupedData[$haritanggal][] = $item;
        }
        return $groupedData;
    }

    private function pembelian_brg_tetap($m, $y)
    {
        helper('converter_helper');
        $builder = $this->db->table('riwayat_transaksi rt')->select('rt.id, b.kode_brg, b.nama_brg, b.warna, rb.field AS field_rb,
        CASE 
            WHEN rb.field="Semua Field" THEN CAST(REPLACE(JSON_EXTRACT(rb.new_value, \'$.harga_beli\'),\'"\',\'\') AS UNSIGNED)
            ELSE CAST(REPLACE(JSON_EXTRACT(rb.new_value, \'$.harga_beli\'),\'"\',\'\') AS UNSIGNED)
        END AS hrg_beli_brg, rt.jenis_transaksi, rt.field AS field_rt, CASE 
            WHEN rt.jenis_transaksi = "Tambah Stok Barang Tetap Masuk di Sarpras" THEN CAST(REPLACE(JSON_EXTRACT(rt.new_value, \'$.jumlah_masuk\'),\'"\',\'\') AS SIGNED)-CAST(REPLACE(JSON_EXTRACT(rt.old_value, \'$.jumlah_masuk\'),\'"\',\'\') AS SIGNED)
            ELSE CAST(REPLACE(JSON_EXTRACT(rt.new_value, \'$.jumlah_masuk\'),\'"\',\'\') AS UNSIGNED)
            END AS jml_msk, s.kd_satuan, rt.created_at')
            ->join('stok_barang sb', 'sb.id=rt.stokbrg_id')
            ->join('satuan s', 's.id=sb.satuan_id')
            ->join('barang b', 'b.id=sb.barang_id')
            ->join('riwayat_barang rb', 'b.id=rb.barang_id')
            ->join('kategori k', 'k.id=b.kat_id')
            ->where('(rt.field LIKE "%jumlah_masuk%" OR rt.field = "Semua Field")')
            ->where('(rt.jenis_transaksi LIKE "%Barang tetap masuk%")')
            ->where('( CASE
            WHEN b.nama_brg IN (
                SELECT b.nama_brg FROM riwayat_transaksi rt
                JOIN stok_barang sb ON sb.id = rt.stokbrg_id
                JOIN barang b ON b.id = sb.barang_id
                WHERE rt.jenis_transaksi IN ("barang tetap masuk", "Tambah Stok Barang Tetap Masuk di Sarpras", "Update barang tetap masuk")
                GROUP BY nama_brg
                HAVING COUNT(DISTINCT rt.jenis_transaksi) = 3
            ) THEN (rt.jenis_transaksi <> "barang tetap masuk" OR rt.field <> "Semua field")
            WHEN b.nama_brg IN (
                SELECT b.nama_brg
                FROM riwayat_transaksi rt
                JOIN stok_barang sb ON sb.id = rt.stokbrg_id
                JOIN barang b ON b.id = sb.barang_id
                WHERE rt.jenis_transaksi IN ("barang tetap masuk", "Update barang tetap masuk")
                GROUP BY nama_brg
                HAVING COUNT(DISTINCT rt.jenis_transaksi) = 2
            ) THEN (rt.jenis_transaksi <> "barang tetap masuk" OR rt.field <> "Semua field")
            WHEN b.nama_brg IN (
                SELECT b.nama_brg FROM riwayat_transaksi rt
                JOIN stok_barang sb ON sb.id = rt.stokbrg_id
                JOIN barang b ON b.id = sb.barang_id
                WHERE rt.jenis_transaksi IN ("barang tetap masuk", "Tambah Stok Barang Tetap Masuk di Sarpras")
                GROUP BY nama_brg
                HAVING COUNT(DISTINCT rt.jenis_transaksi) = 2
            ) THEN 1
            WHEN b.nama_brg IN (
                SELECT b.nama_brg FROM riwayat_transaksi rt
                JOIN stok_barang sb ON sb.id = rt.stokbrg_id
                JOIN barang b ON b.id = sb.barang_id
                WHERE rt.jenis_transaksi = "barang tetap masuk"
                GROUP BY nama_brg
                HAVING COUNT(DISTINCT rt.jenis_transaksi) = 1
            ) THEN (rt.jenis_transaksi = "barang tetap masuk" OR rt.field = "Semua field")
        END)');
        // $builder->where('YEAR(rt.created_at)', date('Y'));
        if (empty($y)) {
            $builder->where('YEAR(rt.created_at)', date('Y'));
        } else if (!empty($m) && !empty($y)) {
            $builder->where("MONTH(rt.created_at)", $m);
            $builder->where("YEAR(rt.created_at)", $y);
        } else if (!empty($y)) {
            $builder->where("YEAR(rt.created_at)", $y);
        }
        $builder->groupBy('rt.id')
            ->orderBy('b.nama_brg', 'DESC');

        $results = $builder->get()->getResultArray();
        $total_harga = [];
        $tgldibuat = [];
        foreach ($results as $key => $row) {
            array_push($total_harga, $row['jml_msk'] * $row['hrg_beli_brg']);
            array_push($tgldibuat, format_tanggal($row['created_at']));
        }
        // Menambahkan elemen 'total_harga' ke dalam array $results
        foreach ($results as $key => $row) {
            $results[$key]['total_harga'] = $total_harga[$key];
            $results[$key]['tgldibuat'] = $tgldibuat[$key];
        }
        // Membuat array baru untuk menyimpan hasil pengelompokan dan penjumlahan
        $filterArray = [];

        // Melakukan pengelompokan dan penjumlahan
        foreach ($results as $row) {
            $nama_brg = $row['nama_brg'];
            $kode_brg = $row['kode_brg'];
            $warna = $row['warna'];
            $kd_satuan = $row['kd_satuan'];
            $hrg_beli_brg = $row['hrg_beli_brg'];
            $created_at = $row['created_at'];
            $tgldibuat = $row['tgldibuat'];

            // Jika sudah ada dalam $filterArray, tambahkan jml_msk dan total_harga
            if (isset($filterArray[$nama_brg])) {
                $filterArray[$nama_brg]['jml_msk'] += $row['jml_msk'];
                $filterArray[$nama_brg]['total_harga'] += $row['total_harga'];
            } else {
                // Jika belum ada dalam $filterArray, inisialisasi dengan nilai awal
                $filterArray[$nama_brg] = [
                    'nama_brg' => $nama_brg,
                    'kode_brg' => $kode_brg,
                    '$warna' => $warna,
                    'hrg_beli_brg' => $hrg_beli_brg,
                    'jml_msk' => $row['jml_msk'],
                    'total_harga' => $row['total_harga'],
                    'kd_satuan' => $kd_satuan,
                    'created_at' => $created_at,
                    'tgldibuat' => $tgldibuat,
                ];
            }
        }
        // Mengubah $filterArray menjadi array indeks numerik
        $filterArray = array_values($filterArray);
        // Array untuk menyimpan data yang telah dikelompokkan
        $groupedData = [];
        // Perulangan untuk mengelompokkan data berdasarkan bulan
        foreach ($filterArray as $key => &$item) {
            // Ambil bulan saja dari tanggal
            $dateString = $item["tgldibuat"];
            if (empty($tgl_permintaan)) {
                $haritanggal = explode(" ", $dateString)[2] . " " . explode(" ", $dateString)[3];
            } else if (!empty($tgl_permintaan)) {
                $haritanggal = $dateString;
            }
            // Tambahkan data ke dalam array sesuai dengan bulan
            if (!isset($groupedData[$haritanggal])) {
                $groupedData[$haritanggal] = [];
            }
            $groupedData[$haritanggal][] = $item;
        }
        return $groupedData;
    }

    public function peminjamanbarang1($tgl_peminjaman, $jenis)
    {
        $builder = $this->db->table('peminjaman p')->select('p.id, p.anggota_id, p.barang_id, p.jml_barang, p.kondisi_pinjam, p.kondisi_kembali, p.jml_hari, p.tgl_pinjam, p.tgl_kembali,p.keterangan, p.status, p.created_at, p.created_by, a.nama_anggota, b.nama_brg, u.singkatan, s.kd_satuan')
            ->join('anggota a', 'a.id = p.anggota_id')
            ->join('barang b', 'b.id=p.barang_id')
            ->join('kategori k', 'k.id=b.kat_id')
            ->join('unit u', 'u.id = a.unit_id')
            ->join('stok_barang sb', 'b.id=sb.barang_id')
            ->join('satuan s', 's.id=sb.satuan_id')
            ->where('k.jenis', $jenis);

        if (empty($tgl_peminjaman)) {
            $builder->where('YEAR(p.created_at)', date('Y'));
        } else if (!empty($tgl_peminjaman)) {
            $builder->like("p.created_at", $tgl_peminjaman . "%");
        }
        $builder->where('k.deleted_at', null)
            ->where('b.deleted_at', null)
            ->where('sb.deleted_at', null)
            ->where('p.deleted_at', null)
            ->orderBy('p.id', 'ASC');

        $results = $builder->get()->getResultArray();
        $tgldibuat = [];
        helper('converter_helper');
        foreach ($results as $key => $val) {
            array_push($tgldibuat, format_tanggal($val['created_at']));
        }

        foreach ($results as $key => &$result) {
            $result['tgldibuat'] = $tgldibuat[$key];
        }

        // Array untuk menyimpan data yang telah dikelompokkan
        $groupedData = [];

        // Perulangan untuk mengelompokkan data berdasarkan bulan
        foreach ($results as $key => &$item) {
            // Ambil bulan saja dari tanggal
            $dateString = $item["tgldibuat"];
            if (empty($tgl_permintaan)) {
                $haritanggal = explode(" ", $dateString)[2] . " " . explode(" ", $dateString)[3];
            } else if (!empty($tgl_permintaan)) {
                $haritanggal = $dateString;
            }
            // Tambahkan data ke dalam array sesuai dengan bulan
            if (!isset($groupedData[$haritanggal])) {
                $groupedData[$haritanggal] = [];
            }
            $groupedData[$haritanggal][] = $item;
        }
        return $groupedData;
    }

    public function peminjamanbarang2($m, $y, $jenis)
    {
        $builder = $this->db->table('peminjaman p')->select('p.id, p.anggota_id, p.barang_id, p.jml_barang, p.kondisi_pinjam, p.kondisi_kembali, p.jml_hari, p.tgl_pinjam, p.tgl_kembali, p.status, p.created_at, p.created_by, a.nama_anggota, b.nama_brg, u.singkatan, s.kd_satuan')
            ->join('anggota a', 'a.id = p.anggota_id')
            ->join('barang b', 'b.id=p.barang_id')
            ->join('kategori k', 'k.id=b.kat_id')
            ->join('unit u', 'u.id = a.unit_id')
            ->join('stok_barang sb', 'b.id=sb.barang_id')
            ->join('satuan s', 's.id=sb.satuan_id')
            ->where('k.jenis', $jenis);

        if (empty($y)) {
            $builder->where('YEAR(p.created_at)', date('Y'));
        } else if (!empty($m) && !empty($y)) {
            $builder->where("MONTH(p.created_at)", $m);
            $builder->where("YEAR(p.created_at)", $y);
        } else if (!empty($y)) {
            $builder->where("YEAR(p.created_at)", $y);
        }
        $builder->where('k.deleted_at', null)
            ->where('b.deleted_at', null)
            ->where('sb.deleted_at', null)
            ->where('p.deleted_at', null);

        $results = $builder->get()->getResultArray();
        $tgldibuat = [];
        helper('converter_helper');
        foreach ($results as $key => $val) {
            array_push($tgldibuat, format_tanggal($val['created_at']));
        }

        foreach ($results as $key => &$result) {
            $result['tgldibuat'] = $tgldibuat[$key];
        }

        // Array untuk menyimpan data yang telah dikelompokkan
        $groupedData = [];

        // Perulangan untuk mengelompokkan data berdasarkan bulan
        foreach ($results as $key => &$item) {
            // Ambil bulan saja dari tanggal
            $dateString = $item["tgldibuat"];
            if (empty($tgl_permintaan)) {
                $haritanggal = explode(" ", $dateString)[2] . " " . explode(" ", $dateString)[3];
            } else if (!empty($tgl_permintaan)) {
                $haritanggal = $dateString;
            }
            // Tambahkan data ke dalam array sesuai dengan bulan
            if (!isset($groupedData[$haritanggal])) {
                $groupedData[$haritanggal] = [];
            }
            $groupedData[$haritanggal][] = $item;
        }
        return $groupedData;
    }

    private function permintaanbarang($tgl_permintaan, $jenis)
    {
        $builder = $this->db->table('riwayat_barang rb')
            ->select("rb.id, rb.barang_id AS b_id, b.nama_brg,  p.anggota_id, p.barang_id, a.unit_id, u.singkatan, a.nama_anggota, p.jml_barang, p.created_at, p.created_by")
            ->select("CAST(
                REPLACE(
                    COALESCE(
                        IF(JSON_EXTRACT(rb.old_value, '$.harga_beli') IS NULL,
                            (
                                SELECT JSON_EXTRACT(rb2.old_value, '$.harga_beli')
                                FROM riwayat_barang rb2
                                WHERE rb2.barang_id = rb.barang_id
                                AND YEAR(rb2.created_at) < YEAR(rb.created_at)
                                ORDER BY YEAR(rb2.created_at) DESC
                                LIMIT 1
                            ),
                            JSON_EXTRACT(rb.new_value, '$.harga_beli')
                        ),
                        b.harga_beli
                    ),
                    '\"',
                    ''
                ) AS UNSIGNED
            ) AS harga_beli", false)
            ->select("p.jml_barang * harga_beli AS total_val, s.kd_satuan", false)
            ->join('barang b', 'b.id = rb.barang_id')
            ->join('kategori k', 'k.id = b.kat_id')
            ->join('stok_barang sb', 'b.id=sb.barang_id')
            ->join('satuan s', 's.id=sb.satuan_id')
            ->join('permintaan p', 'p.barang_id = b.id')
            ->join('anggota a', 'a.id = p.anggota_id')
            ->join('unit u', 'u.id = a.unit_id')
            ->where('jenis', $jenis)
            ->whereIn('rb.id', function ($subquery) {
                $subquery->select('MAX(id)')
                    ->from('riwayat_barang')
                    ->groupBy('barang_id');
            });
        // ->orderBy('rb.id', 'DESC');
        if (empty($tgl_permintaan)) {
            $builder->where('YEAR(p.created_at)', date('Y'));
        } else if (!empty($tgl_permintaan)) {
            $builder->like("p.created_at", "$tgl_permintaan%");
        }
        $builder->where('k.deleted_at', null)
            ->where('b.deleted_at', null)
            ->where('sb.deleted_at', null)
            ->where('p.deleted_at', null);

        $results = $builder->get()->getResultArray();

        $hargabeli = [];
        $totalval = [];
        $tgldibuat = [];
        helper('converter_helper');
        foreach ($results as $key => $val) {
            array_push($hargabeli, format_uang($val['harga_beli']));
            array_push($totalval, format_uang($val['total_val']));
            array_push($tgldibuat, format_tanggal($val['created_at']));
        }

        foreach ($results as $key => &$result) {
            // Tambahkan elemen "hargabeli" ke setiap elemen $results
            $result['hargabeli'] = $hargabeli[$key];
            $result['totalval'] = $totalval[$key];
            $result['tgldibuat'] = $tgldibuat[$key];
        }

        // Array untuk menyimpan data yang telah dikelompokkan
        $groupedData = [];

        // Perulangan untuk mengelompokkan data berdasarkan bulan
        foreach ($results as $key => &$item) {
            // Ambil bulan saja dari tanggal
            $dateString = $item["tgldibuat"];
            if (empty($tgl_permintaan)) {
                $haritanggal = explode(" ", $dateString)[2] . " " . explode(" ", $dateString)[3];
            } else if (!empty($tgl_permintaan)) {
                $haritanggal = $dateString;
            }
            // Tambahkan data ke dalam array sesuai dengan bulan
            if (!isset($groupedData[$haritanggal])) {
                $groupedData[$haritanggal] = [];
            }
            $groupedData[$haritanggal][] = $item;
        }
        return $groupedData;
    }



    public function cetaklaporanpdf()
    {
        helper('converter_helper');
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $keterangan = $this->request->getVar('keterangan');
        $jenis_kat = $this->request->getVar('jenis_kat');
        $filename = '';

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set(['isRemoteEnabled' => true]);
        $dompdf->setOptions($options);
        // Panggil fungsi hitungstokbarang() dan simpan hasilnya dalam variabel $brgtetap
        $brgtetap = '';
        if ($keterangan == "Semua Laporan") {
            $bulantahun = '';
            if (empty($bulan) & empty($tahun)) {
                $bulantahun = "tahun " . date('Y');
                $filename = 'laporan-aset-' . date('Y');
            } else if (!empty($bulan) && !empty($tahun)) {
                $bulantahun = "Bulan " . format_bulan($bulan) . " Tahun " . date('Y');
                $filename = 'laporan-aset-' . $bulan . '-' . $tahun;
            } else if (!empty($tahun)) {
                $bulantahun = "tahun " . date('Y');
                $filename = 'laporan-aset-' . $tahun;
            }

            $brgtetap = $this->hitungstokbarang($bulan, $tahun);
            $kat_tetap = $this->getkategoriaset("Barang Tetap");
            $kat_sedia = $this->getkategoriaset("Barang Persediaan");
            $permintaan = $this->hitungmintabarang($bulan, $tahun, "Barang Persediaan");
            $belibrgtetap = $this->pembelian_brg_tetap($bulan, $tahun);
            $data = [
                'kat_tetap' => $kat_tetap,
                'kat_sedia' => $kat_sedia,
                'brgtetap' => $brgtetap,
                'permintaan' => $permintaan,
                'belibrgtetap' => $belibrgtetap,
                'bulantahun' => $bulantahun,
                'title' => 'Laporan Aset',
            ];
            // load HTML content
            $dompdf->loadHtml(view('laporan/laporanaset', $data));
        } else if ($keterangan == "Permintaan") {
            $opsi = $this->request->getVar('opsi');
            if ($opsi == "opsi1") {
                $tgl_minta = $this->request->getVar('tgl_minta');
                $haritanggal = format_tanggal($tgl_minta);
                $tanggal = !empty($tgl_minta) ? date('d-m-Y', strtotime($tgl_minta)) : date('Y');
                // if ($haritanggal) {
                $filename = 'laporan-permintaan-' . $tanggal;
                // }
                $permintaan = $this->permintaanbarang($tgl_minta, $jenis_kat);
            } else if ($opsi == "opsi2") {
                $bulantahun = '';
                if (empty($bulan) & empty($tahun)) {
                    $bulantahun = "tahun " . date('Y');
                    $filename = 'laporan-permintaan-' . date('Y');
                } else if (!empty($bulan) && !empty($tahun)) {
                    $bulantahun = "Bulan " . format_bulan($bulan) . " Tahun " . date('Y');
                    $filename = 'laporan-permintaan-' . $bulan . '-' . $tahun;
                } else if (!empty($tahun)) {
                    $bulantahun = "tahun " . date('Y');
                    $filename = 'laporan-permintaan-' . $tahun;
                }
                $permintaan = $this->hitungmintabarang($bulan, $tahun, "Barang Persediaan");
            }

            // load HTML content
            $dompdf->loadHtml(view('permintaan/cetakpdf', [
                'title' => 'Laporan Permintaan Barang Persediaan',
                'permintaan' => $permintaan,
                'haritanggal' => $haritanggal ? $haritanggal : $bulantahun,
                'opsi' => $opsi,
            ]));
        } else if ($keterangan == "Peminjaman") {
            $opsi = $this->request->getVar('opsi');
            if ($opsi == "opsi1") {
                $tgl_pinjam = $this->request->getVar('tgl_pinjam');
                $haritanggal = format_tanggal($tgl_pinjam);
                $tanggal = !empty($tgl_pinjam) ? date('d-m-Y', strtotime($tgl_pinjam)) : date('Y');

                $filename = 'laporan-peminjaman-' . $tanggal;
                $peminjaman = $this->peminjamanbarang1($tgl_pinjam, $jenis_kat);
            } else if ($opsi == "opsi2") {
                $bulantahun = '';
                if (empty($bulan) & empty($tahun)) {
                    $bulantahun = "tahun " . date('Y');
                    $filename = 'laporan-permintaan-' . date('Y');
                } else if (!empty($bulan) && !empty($tahun)) {
                    $bulantahun = "Bulan " . format_bulan($bulan) . " Tahun " . date('Y');
                    $filename = 'laporan-permintaan-' . $bulan . '-' . $tahun;
                } else if (!empty($tahun)) {
                    $bulantahun = "tahun " . date('Y');
                    $filename = 'laporan-permintaan-' . $tahun;
                }
                $peminjaman = $this->peminjamanbarang2($bulan, $tahun, $jenis_kat);
            }

            // load HTML content
            $dompdf->loadHtml(view('peminjaman/cetakpdf', [
                'title' => 'Laporan Peminjaman Barang Tetap',
                'peminjaman' => $peminjaman,
                'haritanggal' => $haritanggal ? $haritanggal : $bulantahun,
            ]));
        }
        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, ['Attachment' => 0]);
    }

    public function get_data_chart_permintaan()
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
        helper('converter_helper');
        $m = $this->request->getVar('m');
        $y = $this->request->getVar('y');
        $builder = $this->db->table('permintaan p')
            ->select('u.singkatan,CONCAT(MONTH(p.created_at), "/", YEAR(p.created_at)) AS bulan_tahun, 
            (SELECT SUM(p2.jml_barang * b2.harga_beli) FROM permintaan p2 JOIN barang b2 ON b2.id = p2.barang_id JOIN anggota a2 ON a2.id=p2.anggota_id JOIN unit u2 ON u2.id=a2.unit_id WHERE a2.unit_id = a.unit_id AND p2.deleted_at IS NULL AND b2.deleted_at IS NULL) AS total_valuasi')
            ->join('anggota a', 'a.id=p.anggota_id')
            ->join('unit u', 'a.unit_id = u.id')
            ->join('barang b', 'b.id=p.barang_id')
            ->join('stok_barang sb', 'b.id=sb.barang_id')
            ->join('satuan s', 'sb.satuan_id = s.id');
        if (empty($y)) {
            $builder->where('YEAR(p.created_at)', date('Y'));
        } else if (!empty($m) && !empty($y)) {
            $builder->where("MONTH(p.created_at)", $m);
            $builder->where("YEAR(p.created_at)", $y);
        } else if (!empty($y)) {
            $builder->where("YEAR(p.created_at)", $y);
        }
        $builder->where('p.deleted_at', null)
            ->where('b.deleted_at', null)
            ->groupBy('a.unit_id')
            ->orderBy('bulan_tahun', 'ASC');
        $initialArray = $builder->get()->getResultArray();
        //Dapatkan bulan pertama untuk tampilan grafik
        $firstmonth = $initialArray[0]['bulan_tahun'];
        list($bulan1, $tahun1) = explode('/', $firstmonth);

        foreach ($initialArray as $data) {
            $bulanTahun = $data['bulan_tahun'];
            list($bulan, $tahun) = explode('/', $bulanTahun);
            // $startMonth = intval(date('m', strtotime($bulanTahun)));
            $startMonth = $bulan1;
            $endMonth = "";
            if (empty($y)) {
                $endMonth = intval(date('m'));
            } else if (!empty($m) && !empty($y)) {
                $endMonth = $startMonth;
            } else if (!empty($y)) {
                $endMonth = intval(date('m'));
            }
            $datas = [];
            $newData = [
                "singkatan" => $data["singkatan"],
                "total_valuasi" => 0
            ];
            for ($m = $startMonth; $m <= $endMonth; $m++) {
                // $datas[] = format_bulan($m);
                if (!isset($datas[format_bulan($m)])) {
                    $datas[format_bulan($m)] = [];
                }
                $newData['totalval'] = format_uang($newData['total_valuasi']);
                $newData['bulan_tahun'] = format_bulan($m) . ' ' . $tahun;
                $resultArray1[format_bulan($m)][] = $newData;
            }
        }

        // Perulangan untuk mengelompokkan data berdasarkan bulan
        foreach ($initialArray as $item) {
            $bulanTahun = $item['bulan_tahun'];
            list($bulan, $tahun) = explode('/', $bulanTahun);
            if (!isset($resultArray2[format_bulan($bulan)])) {
                $resultArray2[format_bulan($bulan)] = [];
            }
            $item['totalval'] = format_uang($item['total_valuasi']);
            $item['bulan_tahun'] = format_bulan($bulan) . ' ' . $tahun;
            $resultArray2[format_bulan($bulan)][] = $item;
        }

        foreach ($resultArray1 as $key => &$value) {
            // Mengambil 'singkatan' dari $resultArray1 sebagai referensi key
            $singkatan1 = array_column($value, 'singkatan');
            // Mengambil 'singkatan' dan data lainnya dari $resultArray2
            $singkatan2 = array_column($resultArray2[$key], 'singkatan');
            $singkatan1 = array_column($value, 'singkatan');
            $data2 = $resultArray2[$key];
            // Menggabungkan array menggunakan key 'singkatan' sebagai referensi
            $merged = array_combine($singkatan1, $value);
            foreach ($singkatan2 as $index => $singkatan) {
                if (array_key_exists($singkatan, $merged)) { // Mengganti data pada key yang sama
                    $merged[$singkatan] = $data2[$index];
                } else {
                    // Menambahkan data baru jika key tidak ada
                    $merged[$singkatan] = $data2[$index];
                }
            }
            // Mengganti nilai $value dengan array yang telah digabungkan
            $value = array_values($merged);
        }

        echo json_encode($resultArray1);
    }

    public function get_data_table_permintaan()
    {
        if ($this->request->isAJAX()) {
            $m = $this->request->getGet('m');
            $y = $this->request->getGet('y');

            $builder = $this->db->table('permintaan p')
                ->select('u.nama_unit, COUNT(p.barang_id) AS count_brg, 
        GROUP_CONCAT(CONCAT(b.nama_brg, " (", p.jml_barang, " ", s.kd_satuan, ")") SEPARATOR ", ") AS nama_brg, GROUP_CONCAT(DISTINCT a.nama_anggota SEPARATOR ", ") AS nama_anggota, CONCAT(MONTH(p.created_at), "/", YEAR(p.created_at)) AS bulan_tahun, 
        (SELECT SUM(p2.jml_barang * b2.harga_beli) FROM permintaan p2 JOIN barang b2 ON b2.id = p2.barang_id JOIN anggota a2 ON a2.id=p2.anggota_id JOIN unit u2 ON u2.id=a2.unit_id WHERE a2.unit_id = a.unit_id AND p2.deleted_at IS NULL AND b2.deleted_at IS NULL) AS total_valuasi')
                ->join('anggota a', 'a.id=p.anggota_id')
                ->join('unit u', 'a.unit_id = u.id')
                ->join('barang b', 'b.id=p.barang_id')
                ->join('stok_barang sb', 'b.id=sb.barang_id')
                ->join('satuan s', 'sb.satuan_id = s.id');
            if (empty($y)) {
                $builder->where('YEAR(p.created_at)', date('Y'));
            } else if (!empty($m) && !empty($y)) {
                $builder->where("MONTH(p.created_at)", $m);
                $builder->where("YEAR(p.created_at)", $y);
            } else if (!empty($y)) {
                $builder->where("YEAR(p.created_at)", $y);
            }
            $builder->where('p.deleted_at', null)
                ->groupBy('a.unit_id')
                ->orderBy('bulan_tahun', 'DESC');

            $array = $builder->get()->getResultArray();


            $msg = [
                'data' => $array,
            ];

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getcountbrg()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getGet('jenis_kat');
            $m = $this->request->getGet('m');
            $y = $this->request->getGet('y');
            $query = $this->db->table('barang b')->select('COUNT(b.nama_brg) as result, SUM(b.harga_jual * sb.sisa_stok) AS total_valuasi')
                ->join('stok_barang sb', 'b.id=sb.barang_id')
                ->join('kategori k', 'k.id=b.kat_id');
            if (!empty($m) && !empty($y)) {
                $query->where("MONTH(b.created_at)", $m);
                $query->where("YEAR(b.created_at)", $y);
            } else if (!empty($y)) {
                $query->where("YEAR(b.created_at)", $y);
            }
            $query->where('k.jenis', $jenis)
                ->where('b.deleted_at is null');
            $msg = $query->get()->getRowArray();
            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getcountbrgkeluar()
    {
        if ($this->request->isAJAX()) {
            $jenistrx = $this->request->getGet('jenistrx');
            $m = $this->request->getGet('m');
            $y = $this->request->getGet('y');
            if ($jenistrx == "Peminjaman") {
                $query = $this->db->table("$jenistrx")
                    ->select('SUM(CASE WHEN status = 0 THEN jml_barang ELSE 0 END) AS total_brg')
                    ->select('COUNT(DISTINCT CASE WHEN status = 0 THEN anggota_id END) AS pengguna')
                    ->where('status', 0);
            } else if ($jenistrx == "Permintaan") {
                $query = $this->db->table("$jenistrx")->select(' COUNT(DISTINCT anggota_id) as pengguna, SUM(jml_barang) as total_brg');
            }
            if (!empty($m) && !empty($y)) {
                $query->where("MONTH(created_at)", $m);
                $query->where("YEAR(created_at)", $y);
            } else if (!empty($y)) {
                $query->where("YEAR(created_at)", $y);
            }
            $query->where('deleted_at is null');
            $data = $query->get()->getRowArray();
            $msg = [
                'data' => $data,
                'jenistrx' => $jenistrx
            ];
            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }
}
