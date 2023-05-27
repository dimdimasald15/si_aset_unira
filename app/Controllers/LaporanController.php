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
use App\Libraries\MyPDF;
use Dompdf\Dompdf;
use Dompdf\FontMetrics;
use App\Controllers\BaseController;
use PHPUnit\Framework\Constraint\Count;


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

    public function konversiuang($data)
    {
        $harga_formatted = 'Rp ' . number_format($data, 0, ',', '.') . ',-';
        return $harga_formatted;
    }

    public function hitungstokbarang($m, $y)
    {
        $builder = $this->db->table('stok_barang sb')
            ->select('sb.barang_id AS b_id, b.kode_brg, b.nama_brg, b.harga_jual, SUM(sb.sisa_stok) AS stok_terbaru, b.harga_jual * SUM(sb.sisa_stok) AS total_val, s.kd_satuan')
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
        $builder->groupBy('b_id');

        $results = $builder->get()->getResultArray();
        $hargajual = [];
        $totalval = [];
        foreach ($results as $key => $val) {
            array_push($hargajual, $this->konversiuang($val['harga_jual']));
            array_push($totalval, $this->konversiuang($val['total_val']));
        }

        foreach ($results as $key => &$result) {
            // Tambahkan elemen "hargajual" ke setiap elemen $results
            $result['hargajual'] = $hargajual[$key];
            $result['totalval'] = $totalval[$key];
        }

        // echo "<pre>";
        // var_dump($results);
        // echo "</pre>";
        // die;
        return $results;
    }

    public function cetaklaporanpdf()
    {
        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $keterangan = $this->request->getVar('keterangan');
        // Panggil fungsi hitungstokbarang() dan simpan hasilnya dalam variabel $brgtetap
        $brgtetap = '';
        if ($keterangan == "Semua Laporan") {
            $brgtetap = $this->hitungstokbarang($bulan, $tahun);
        }

        $filename = '';
        if (empty($tahun)) {
            $filename = date('y-m-d-H-i-s') . '-laporan-aset-' . $bulan . '-' . date('Y');
        } else if (!empty($bulan) && !empty($tahun)) {
            $filename = date('y-m-d-H-i-s') . '-laporan-aset-' . $bulan . '-' . $tahun;
        } else if (!empty($tahun)) {
            $filename = date('y-m-d-H-i-s') . '-laporan-aset-' . $tahun;
        }
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set(['isRemoteEnabled' => true]);
        $dompdf->setOptions($options);

        $data = [
            'title' => 'Laporan Aset',
            'brgtetap' => $brgtetap,
            'keterangan' => $keterangan,
        ];
        // load HTML content
        $dompdf->loadHtml(view('laporan/laporanaset', $data));

        // (optional) setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // render html as PDF
        $dompdf->render();

        // output the generated pdf
        $dompdf->stream($filename, ['Attachment' => 0]);
    }

    public function getdatapermintaan()
    {
        if ($this->request->isAJAX()) {
            $builder = $this->db->table('permintaan p')
                ->select('u.nama_unit, COUNT(p.barang_id) AS count_brg, 
            GROUP_CONCAT(CONCAT(b.nama_brg, " (", p.jml_barang, " ", s.kd_satuan, ")") SEPARATOR ", ") AS nama_brg, GROUP_CONCAT(DISTINCT a.nama_anggota SEPARATOR ", ") AS nama_anggota, CONCAT(MONTH(p.created_at), "/", YEAR(p.created_at)) AS bulan_tahun, 
            (SELECT SUM(p2.jml_barang * b2.harga_beli) FROM permintaan p2 JOIN barang b2 ON b2.id = p2.barang_id JOIN anggota a2 ON a2.id=p2.anggota_id JOIN unit u2 ON u2.id=a2.unit_id WHERE a2.unit_id = a.unit_id AND p2.deleted_at IS NULL AND b2.deleted_at IS NULL) AS total_valuasi')
                ->join('anggota a', 'a.id=p.anggota_id')
                ->join('unit u', 'a.unit_id = u.id')
                ->join('barang b', 'b.id=p.barang_id')
                ->join('stok_barang sb', 'b.id=sb.barang_id')
                ->join('satuan s', 'sb.satuan_id = s.id')
                ->where('p.deleted_at', null)
                ->where('b.deleted_at', null)
                ->groupBy('a.unit_id');

            $permintaan = $builder->get()->getResultArray();
            $msg = [
                'data' => $permintaan,
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

    public function get_data_permintaan()
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
                ->groupBy('a.unit_id');

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
