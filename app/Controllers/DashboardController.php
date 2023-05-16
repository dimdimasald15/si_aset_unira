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
        $segments = $this->uri->getSegments();
        $breadcrumb = [];
        $link = '';

        foreach ($segments as $segment) {
            $link .= '/' . $segment;
            $name = ucwords(str_replace('-', ' ', $segment));
            $breadcrumb[] = ['name' => $name, 'link' => $link];
        }

        $data = [
            'title' => 'Dashboard',
            'nav' => 'dashboard',
            // 'jenis_kat' => 'Barang Tetap',
            'breadcrumb' => $breadcrumb
        ];

        return view('dashboard/index', $data);
    }

    public function getcountbrg()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getGet('jenis_kat');
            $query = $this->db->table('barang b')->select('COUNT(b.nama_brg) as result, SUM(b.harga_jual * sb.sisa_stok) AS total_valuasi')
                ->join('stok_barang sb', 'b.id=sb.barang_id')
                ->join('kategori k', 'k.id=b.kat_id')
                ->where('k.jenis', $jenis)
                ->where('b.deleted_at is null')->get();
            $msg = $query->getRowArray();
            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
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
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
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
            if ($jenistrx == "Peminjaman") {
                $query = $this->db->table("$jenistrx")
                    ->select('SUM(CASE WHEN status = 0 THEN jml_barang ELSE 0 END) AS total_brg')
                    ->select('COUNT(DISTINCT CASE WHEN status = 0 THEN anggota_id END) AS pengguna')
                    ->where('status', 0)
                    ->where('deleted_at is null')
                    ->get();
            } else if ($jenistrx == "Permintaan") {
                $query = $this->db->table("$jenistrx")->select(' COUNT(DISTINCT anggota_id) as pengguna, SUM(jml_barang) as total_brg')->where('deleted_at is null')->get();
            }
            $data = $query->getRowArray();
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
