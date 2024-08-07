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
use Dompdf\Dompdf;
use App\Controllers\BaseController;
use Dompdf\Exception;
use Dompdf\Options;

class LaporanController extends BaseController
{
    protected $barang, $kategori, $uri, $stokbarang, $riwayatbarang, $ruang, $riwayattrx, $anggota, $permintaan, $peminjaman;

    public function __construct()
    {
        helper(['url', 'converter_helper']);
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
            ["id" => "peminjaman", "icon" => "fa-handshake-o", "color" => "pink", "title" => "Total Peminjam"],
            ["id" => "permintaan", "icon" => "fa-file-text-o", "color" => "orange", "title" => "Total Peminta"],
        ];
        $data = [
            'title' => 'Laporan',
            'nav' => 'laporan',
            'breadcrumb' => $breadcrumb,
            'cards' => $cards,
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
                ->join('satuan s', 'b.satuan_id = s.id')
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
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function hitungstokbarang($m, $y)
    {
        $builder = $this->db->table('stok_barang sb')
            ->select('sb.barang_id AS b_id, b.kode_brg, b.nama_brg, b.warna,  b.harga_jual, SUM(sb.sisa_stok) AS stok_terbaru, b.harga_jual * SUM(sb.sisa_stok) AS total_val, s.kd_satuan')
            ->join('barang b', 'b.id = sb.barang_id')
            ->join('kategori k', 'k.id = b.kat_id')
            ->join('satuan s', 'b.satuan_id = s.id')
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
        $results = $this->riwayatbarang->fetchPermintaanData(null, $m, $y, $jenis, true);
        return $this->prosesDataPermintaan($results);
    }

    private function permintaanbarang($tgl_permintaan, $jenis)
    {
        $results = $this->riwayatbarang->fetchPermintaanData($tgl_permintaan, null, null, $jenis, false);
        return $this->prosesDataPermintaan($results, $tgl_permintaan);
    }

    private function prosesDataPermintaan($results, $tgl_permintaan = null)
    {
        $hargabeli = [];
        $totalval = [];
        $tgldibuat = [];
        foreach ($results as $key => $val) {
            array_push($hargabeli, format_uang($val['harga_beli']));
            array_push($totalval, format_uang($val['total_val']));
            array_push($tgldibuat, format_tanggal($val['created_at']));
        }

        foreach ($results as $key => &$result) {
            $result['hargabeli'] = $hargabeli[$key];
            $result['totalval'] = $totalval[$key];
            $result['tgldibuat'] = $tgldibuat[$key];
        }

        $groupedData = [];

        foreach ($results as $key => &$item) {
            $dateString = $item["tgldibuat"];
            $haritanggal = $this->getFormattedDate($dateString, $tgl_permintaan);

            if (!isset($groupedData[$haritanggal])) {
                $groupedData[$haritanggal] = [];
            }
            $groupedData[$haritanggal][] = $item;
        }
        return $groupedData;
    }

    private function getFormattedDate($dateString, $tgl_permintaan)
    {
        if (empty($tgl_permintaan)) {
            return explode(" ", $dateString)[2] . " " . explode(" ", $dateString)[3];
        } else {
            return $dateString;
        }
    }

    private function applyDateFilters($builder, $m, $y)
    {
        if (empty($y)) {
            $builder->where('YEAR(rt.created_at)', date('Y'));
        } else if (!empty($m) && !empty($y)) {
            $builder->where("MONTH(rt.created_at)", $m);
            $builder->where("YEAR(rt.created_at)", $y);
        } else if (!empty($y)) {
            $builder->where("YEAR(rt.created_at)", $y);
        }
    }

    private function pembelian_brg_tetap($m, $y)
    {
        $builder = $this->riwayattrx->initializeBuilderPembelianBrgTetap();
        $this->applyDateFilters($builder, $m, $y);
        $builder->groupBy('rt.id')->orderBy('rt.created_at');
        $results = $builder->get()->getResultArray();

        list($total_harga, $tgldibuat) = calculateTotalHargaAndTanggal($results);
        addExtraFields($results, $total_harga, $tgldibuat);
        $filterArray = groupAndSumResults($results);
        return groupDataByTanggal($filterArray);
    }

    public function peminjamanbarang1($tgl_peminjaman, $jenis)
    {
        return $this->peminjaman->fetchPeminjamanData($tgl_peminjaman, null, null, $jenis);
    }

    public function peminjamanbarang2($m, $y, $jenis)
    {
        return $this->peminjaman->fetchPeminjamanData(null, $m, $y, $jenis);
    }

    public function get_logo()
    {
        $path = FCPATH . 'assets/images/logo/logounira.jpg';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    public function cetaklaporanpdf()
    {

        $bulan = $this->request->getVar('bulan');
        $tahun = $this->request->getVar('tahun');
        $keterangan = $this->request->getVar('keterangan');
        $jenis_kat = $this->request->getVar('jenis_kat');
        $filename = '';
        $logo = $this->get_logo();
        $css = file_get_contents(FCPATH . 'assets/css/mystyle/pdfstyle.css');

        // Instantiate and configure Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        try {
            // Generate data and HTML content based on parameters
            $htmlContent = '';
            if ($keterangan == "Semua Laporan") {
                $bulantahun = '';
                if (empty($bulan) && empty($tahun)) {
                    $bulantahun = "tahun " . date('Y');
                    $filename = 'laporan-aset-' . date('Y');
                } elseif (!empty($bulan) && !empty($tahun)) {
                    $bulantahun = "Bulan " . format_bulan($bulan) . " Tahun " . $tahun;
                    $filename = 'laporan-aset-' . $bulan . '-' . $tahun;
                } elseif (!empty($tahun)) {
                    $bulantahun = "tahun " . $tahun;
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
                    'logo' => $logo,
                    'css' => $css,
                ];
                // Load HTML content
                $htmlContent = view('laporan/laporanaset', $data);
            } else if ($keterangan == "Permintaan") {
                $opsi = $this->request->getVar('opsi');
                if ($opsi == "opsi1") {
                    $tgl_minta = $this->request->getVar('tgl_minta');
                    $haritanggal = format_tanggal($tgl_minta);
                    $tanggal = !empty($tgl_minta) ? date('d-m-Y', strtotime($tgl_minta)) : date('Y');
                    $filename = 'laporan-permintaan-' . $tanggal;
                    $permintaan = $this->permintaanbarang($tgl_minta, $jenis_kat);
                } else if ($opsi == "opsi2") {
                    $bulantahun = '';
                    if (empty($bulan) && empty($tahun)) {
                        $bulantahun = "tahun " . date('Y');
                        $filename = 'laporan-permintaan-' . date('Y');
                    } elseif (!empty($bulan) && !empty($tahun)) {
                        $bulantahun = "Bulan " . format_bulan($bulan) . " Tahun " . $tahun;
                        $filename = 'laporan-permintaan-' . $bulan . '-' . $tahun;
                    } elseif (!empty($tahun)) {
                        $bulantahun = "tahun " . $tahun;
                        $filename = 'laporan-permintaan-' . $tahun;
                    }
                    $permintaan = $this->hitungmintabarang($bulan, $tahun, "Barang Persediaan");
                }

                // Load HTML content
                $htmlContent = view('permintaan/cetakpdf', [
                    'title' => 'Laporan Permintaan Barang Persediaan',
                    'permintaan' => $permintaan,
                    'logo' => $logo,
                    'css' => $css,
                    'haritanggal' => !empty($haritanggal) ? $haritanggal : $bulantahun,
                    'opsi' => $opsi,
                ]);
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
                    if (empty($bulan) && empty($tahun)) {
                        $bulantahun = "tahun " . date('Y');
                        $filename = 'laporan-permintaan-' . date('Y');
                    } elseif (!empty($bulan) && !empty($tahun)) {
                        $bulantahun = "Bulan " . format_bulan($bulan) . " Tahun " . $tahun;
                        $filename = 'laporan-permintaan-' . $bulan . '-' . $tahun;
                    } elseif (!empty($tahun)) {
                        $bulantahun = "tahun " . $tahun;
                        $filename = 'laporan-permintaan-' . $tahun;
                    }
                    $peminjaman = $this->peminjamanbarang2($bulan, $tahun, $jenis_kat);
                }

                // Load HTML content
                $htmlContent = view('peminjaman/cetakpdf', [
                    'title' => 'Laporan Peminjaman Barang Tetap',
                    'peminjaman' => $peminjaman,
                    'logo' => $logo,
                    'css' => $css,
                    'haritanggal' => !empty($haritanggal) ? $haritanggal : $bulantahun,
                ]);
            }

            // Load HTML content into Dompdf
            $dompdf->loadHtml($htmlContent);

            // Set paper size and orientation
            $dompdf->setPaper('A4', 'portrait');

            // Render HTML as PDF
            $dompdf->render();

            // Output the generated PDF
            $dompdf->stream($filename, ['Attachment' => false]);
        } catch (Exception $e) {
            echo "An error occurred while rendering the PDF: " . $e->getMessage();
        }

        exit(0);
    }

    public function getdatachartpermintaan()
    {
        $m = $this->request->getGet('m');
        $y = $this->request->getGet('y');
        $initialArray = $this->permintaan->fetchChartData($m, $y);
        $result = $this->permintaan->initializeResultArray($initialArray, $m, $y);
        echo json_encode($result);
    }

    public function getdatatablepermintaan()
    {
        if ($this->request->isAJAX()) {
            $m = $this->request->getGet('m');
            $y = $this->request->getGet('y');
            $msg = [
                'data' => $this->permintaan->fetchDataTableLaporanPermintaan($m, $y),
            ];

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getcountbrg()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $jenis = $this->request->getGet('jenis_kat');
        $m = $this->request->getGet('m');
        $y = $this->request->getGet('y');
        $query = $this->db->table('barang b')
            ->select('COUNT(b.id) as result, SUM(b.harga_jual * sb.sisa_stok) AS total_valuasi')
            ->join('stok_barang sb', 'b.id=sb.barang_id')
            ->join('kategori k', 'k.id=b.kat_id')
            ->where('k.jenis', $jenis)
            ->where('b.deleted_at is null');

        if (!empty($m) && !empty($y)) {
            $query->where("MONTH(b.created_at)", $m);
            $query->where("YEAR(b.created_at)", $y);
        } else if (!empty($y)) {
            $query->where("YEAR(b.created_at)", $y);
        }

        $result = $query->get()->getRowArray();

        $msg = [
            'total_valuasi' => $result['total_valuasi'],
            'result' => $result['result']
        ];

        echo json_encode($msg);
    }


    public function getcountbrgkeluar()
    {
        if ($this->request->isAJAX()) {
            $jenistrx = $this->request->getGet('jenistrx');
            $m = $this->request->getGet('m');
            $y = $this->request->getGet('y');
            if ($jenistrx == "Peminjaman") {
                $query = $this->db->table("peminjaman")
                    ->select('SUM(CASE WHEN status = 0 THEN jml_barang ELSE 0 END) AS total_brg')
                    ->select('COUNT(DISTINCT CASE WHEN status = 0 THEN anggota_id END) AS pengguna')
                    ->where('status', 0);
            } else if ($jenistrx == "Permintaan") {
                $query = $this->db->table("permintaan")->select(' COUNT(DISTINCT anggota_id) as pengguna, SUM(jml_barang) as total_brg');
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
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }
}
