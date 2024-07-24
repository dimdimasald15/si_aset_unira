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
use App\Controllers\BaseController;
use PHPUnit\Framework\Constraint\Count;

class DashboardController extends BaseController
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
        $breadcrumb = $this->getBreadcrumb();
        $cards = [
            ["id" => "brgtetap", "icon" => "fa-cubes", "color" => "purple", "title" => "Barang Tetap"],
            ["id" => "brgpersediaan", "icon" => "fa-shopping-basket", "color" => "blue", "title" => "Barang Persediaan"],
            ["id" => "gedung", "icon" => "fa-building-o", "color" => "red", "title" => "Gedung"],
            ["id" => "peminjaman", "icon" => "fa-handshake-o", "color" => "pink", "title" => "Total Peminjam"],
            ["id" => "permintaan", "icon" => "fa-file-text-o", "color" => "orange", "title" => "Total Peminta"],
            ["id" => "ruang", "icon" => "fa-map-marker", "color" => "green", "title" => "Ruang"],
        ];
        $data = [
            'title' => 'Dashboard',
            'nav' => 'dashboard',
            'breadcrumb' => $breadcrumb,
            'cards' => $cards
        ];

        return view('dashboard/index', $data);
    }

    public function getcountbrg()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getGet('jenis_kat');
            $select1 = "SUM(b.harga_jual * sb.sisa_stok) AS total_valuasi";
            $select2 = "count(b.id) as result";
            $query1 = $this->db->table('barang b')->select($select1)
                ->join('stok_barang sb', 'b.id=sb.barang_id')
                ->join('kategori k', 'k.id=b.kat_id')
                ->where('k.jenis', $jenis)
                ->where('b.deleted_at is null')->get();
            $result1 = $query1->getRowArray();

            $query2 = $this->db->table('barang b')->select($select2)
                ->join('kategori k', 'k.id=b.kat_id')
                ->where('k.jenis', $jenis)
                ->where('b.deleted_at is null')->get();
            $result2 = $query2->getRowArray();

            $msg = [
                'total_valuasi' => $result1['total_valuasi'],
                'result' => $result2['result']
            ];

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getcountgedung()
    {
        if ($this->request->isAJAX()) {
            $query = $this->db->table('gedung')->select('COUNT(nama_gedung) as result')->where('deleted_at is null')->get();
            $msg = $query->getRowArray();
            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getcountruang()
    {
        if ($this->request->isAJAX()) {
            $query = $this->db->table('ruang')->select('COUNT(nama_ruang) as result')->where('deleted_at is null')->get();
            $msg = $query->getRowArray();
            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getcountbrgkeluar()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $jenistrx = $this->request->getGet('jenistrx');
        if ($jenistrx == "Peminjaman") {
            $query = $this->db->table("peminjaman")
                ->select('SUM(CASE WHEN status = 0 THEN jml_barang ELSE 0 END) AS total_brg')
                ->select('COUNT(DISTINCT CASE WHEN status = 0 THEN anggota_id END) AS pengguna')
                ->where('status', 0)
                ->where('deleted_at is null')
                ->get();
        } elseif ($jenistrx == "Permintaan") {
            $query = $this->db->table("permintaan")->select(' COUNT(DISTINCT anggota_id) as pengguna, SUM(jml_barang) as total_brg')->where('deleted_at is null')->get();
        }
        $data = $query->getRowArray();
        $msg = [
            'data' => $data,
            'jenistrx' => $jenistrx
        ];
        echo json_encode($msg);
    }
}
