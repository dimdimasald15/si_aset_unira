<?php

namespace App\Controllers;

use App\Models\Barang;
use App\Models\RiwayatBarang;
use App\Models\Kategori;
use App\Models\Ruang;
use App\Models\StokBarang;
use App\Models\RiwayatTransaksi;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use PHPUnit\Framework\Constraint\Count;

class PengalokasianController extends BaseController
{
    protected $barang;
    protected $kategori;
    protected $uri;
    protected $stokbarang;
    protected $riwayatbarang;
    protected $ruang;
    protected $riwayattrx;
    public function __construct()
    {
        $this->barang = new Barang();
        $this->riwayatbarang = new RiwayatBarang();
        $this->kategori = new Kategori();
        $this->ruang = new Ruang();
        $this->stokbarang = new StokBarang();
        $this->riwayattrx = new RiwayatTransaksi();
        $this->uri = service('uri');
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
            'title' => 'Alokasi Barang Tetap',
            'nav' => 'alokasi-barang-tetap',
            'jenis_kat' => 'Barang Tetap',
            'breadcrumb' => $breadcrumb
        ];

        return view('alokasi/index', $data);
    }

    public function listdataalokasi()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getVar('jenis_kat');

            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);
            $builder = $this->db->table('stok_barang sb')
                ->select('sb.id, sb.barang_id, k.nama_kategori, b.nama_brg, b.harga_beli, b.kode_brg, jumlah_masuk, jumlah_keluar, sisa_stok, b.kat_id, sb.ruang_id, r.nama_ruang, satuan_id, s.kd_satuan, sb.created_at, sb.created_by, sb.deleted_at, sb.deleted_by')
                ->join('barang b', 'sb.barang_id = b.id')
                ->join('kategori k', 'b.kat_id = k.id')
                ->join('ruang r', 'sb.ruang_id = r.id')
                ->join('satuan s', 'sb.satuan_id = s.id')
                ->where('r.id !=', 54)
                ->where('k.jenis', $jenis);

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder, $request) use ($jenis, $isRestore) {
                    if (isset($request->barang) || isset($request->kategori) || isset($request->lokasi)) {
                        if ($request->barang) {
                            $builder->where('sb.barang_id', $request->barang);
                        }
                        if ($request->kategori) {
                            $builder->where('b.kat_id', $request->kategori);
                        }
                        if ($request->lokasi) {
                            $builder->where('sb.ruang_id', $request->lokasi);
                        }
                    }
                    if ($isRestore) {
                        $builder->where('sb.deleted_at IS NOT NULL');
                        $builder->where('k.jenis', $jenis);
                    } else {
                        $builder->where('sb.deleted_at', null);
                        $builder->where('b.deleted_at', null);
                        $builder->where('k.jenis', $jenis);
                    }
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('sb.id', 'desc');
                })
                ->add('checkrow', function ($row) use ($isRestore) {
                    if (!$isRestore) {
                        return '<input type="checkbox" name="id[]" class="checkrow" value="' . $row->id . '">';
                    }
                })
                ->add('action', function ($row) use ($isRestore, $jenis) {
                    if ($isRestore) {
                        return '
                    <div class="btn-group mb-1">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="restore(' . $row->id . ', ' . $row->barang_id . ',\'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-undo"></i> Pulihkan</a>
                        </li>
                        <li><a class="dropdown-item" onclick="hapuspermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_ruang) . '\', \'54\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a>
                        </li>
                    </ul>
                    </div>
                    ';
                    } else {
                        $action = '<div class="btn-group btn-group-sm mb-1">
                    <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="detailstokbarang(\'' . htmlspecialchars($row->kode_brg) . '\',' . $row->ruang_id . ')"><i class="fa fa-info-circle"></i> Detail Stok Barang</a>
                        </li>';
                        if ($jenis == "Barang Tetap") {
                            $action .= '<li><a class="dropdown-item" onclick="cetaklabel(' . $row->id . ')"><i class="fa fa-qrcode"></i> Cetak Label Barang</a>
                        </li>';
                        }
                        $action .= '
                        <li><a class="dropdown-item" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_ruang) . '\', \'54\')"><i class="fa fa-trash-o"></i> Hapus Barang</a>
                        </li>
                    </ul>
                </div>';

                        return $action;
                    }
                })
                ->toJson(true);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }
    public function pilihbarang()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet('search');
            $jenis = $this->request->getGet('jenis_kat');

            if ($jenis == 'Barang Tetap') {
                if (!empty($search)) {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')
                        ->like('b.nama_brg', $search)->get();
                } else {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')->get();
                }
            } else if ($jenis == 'Barang Persediaan') {
                if (!empty($search)) {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')
                        ->like('b.nama_brg', $search)->get();
                } else {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')->get();
                }
            }
            // var_dump($databarang);
            if ($databarang->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($databarang->getResultArray() as $row) {
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['nama_brg'];

                    $key++;
                }
            } else {
                $list = [
                    ['id' => '', 'text' => 'Maaf keyword yang anda cari tidak ditemukan'],
                ];
            }
            echo json_encode($list);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function pilihkategori()
    {
        if ($this->request->isAJAX()) {
            $caridata = $this->request->getGet('search');
            $jenis = $this->request->getGet('jenis_kat');
            $datakategori = '';
            if ($jenis == 'Barang Tetap') {
                if (!empty($caridata)) {
                    $datakategori = $this->db->table('kategori')
                        ->like('nama_kategori', $caridata)
                        ->where('jenis', $jenis)
                        ->where('SUBSTRING(kd_kategori, 1, 1) !=', 'A')
                        ->where('LENGTH(kd_kategori) >=', 7)
                        ->where('deleted_at', null)
                        ->orderBy('nama_kategori', 'ASC')
                        ->get();
                } else {
                    $datakategori = $this->db->table('kategori')
                        ->where('jenis', $jenis)
                        ->where('SUBSTRING(kd_kategori, 1, 1) !=', 'A')
                        ->where('LENGTH(kd_kategori) >=', 7)
                        ->where('deleted_at', null)
                        ->orderBy('nama_kategori', 'ASC')
                        ->get();
                }
            } else if ($jenis == 'Barang Persediaan') {
                if (!empty($caridata)) {
                    $datakategori = $this->db->table('kategori')
                        ->like('nama_kategori', $caridata)
                        ->where('jenis', $jenis)
                        ->where('LENGTH(kd_kategori) >=', 4)
                        ->where('deleted_at', null)
                        ->orderBy('nama_kategori', 'ASC')
                        ->get();
                } else {
                    $datakategori = $this->db->table('kategori')
                        ->where('jenis', $jenis)
                        ->where('LENGTH(kd_kategori) >=', 4)
                        ->where('deleted_at', null)
                        ->orderBy('nama_kategori', 'ASC')
                        ->get();
                }
            }

            if ($datakategori->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($datakategori->getResultArray() as $row) {
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['nama_kategori'];

                    $key++;
                }
            } else {
                $list = [
                    ['id' => '', 'text' => 'Maaf keyword yang anda cari tidak ditemukan'],
                ];
            }
            echo json_encode($list);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function pilihlokasi()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet('search');
            if (!empty($search)) {
                $datalokasi = $this->db->table('ruang')->where('deleted_at', null)->orderBy('nama_ruang', 'ASC')
                    ->like('nama_ruang', $search)->get();
            } else {
                $datalokasi = $this->db->table('ruang')->where('deleted_at', null)->orderBy('nama_ruang', 'ASC')->get();
            }
            // var_dump($datalokasi);
            if ($datalokasi->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($datalokasi->getResultArray() as $row) {
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['nama_ruang'];

                    $key++;
                }
            } else {
                $list = [
                    ['id' => '', 'text' => 'Maaf keyword yang anda cari tidak ditemukan'],
                ];
            }
            echo json_encode($list);
        } else {
            $data = [
                'message' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/html/error_404', $data);
        }
    }

    public function detailbarang($url)
    {
        $kdbrg = substr($url, 0, strrpos($url, "-")); // mendapatkan string "C-02-06-01-001"
        $kode_brg = str_replace('-', '.', $kdbrg);
        $ruang_id = substr($url, strrpos($url, "-") + 1); // mendapatkan string "6"

        $query   = $this->db->table('stok_barang sb')->select('sb.*, k.nama_kategori, b.nama_brg, b.kode_brg, b.foto_barang, b.harga_beli, b.harga_jual, b.asal, b.toko, b.instansi, b.no_seri, b.no_dokumen, b.merk, b.tgl_pembelian, b.warna, r.nama_ruang, satuan_id, s.kd_satuan, b.created_at, b.created_by, b.deleted_at')
            ->join('barang b', 'sb.barang_id = b.id')
            ->join('kategori k', 'b.kat_id = k.id')
            ->join('ruang r', 'sb.ruang_id = r.id')
            ->join('satuan s', 'sb.satuan_id = s.id')
            ->where('b.kode_brg', $kode_brg)
            ->where('sb.ruang_id', $ruang_id)
            ->groupBy('b.id')
            ->get();
        // dd($query->getRow());

        $result = $query->getRow();
        if ($result) {
            $title = 'Detail Barang ' . $result->nama_brg . ' di ' . $result->nama_ruang;
        } else {
            $title = 'Detail Barang';
        }

        $data = [
            'title' => $title,
            'barang' => $result,
        ];

        return view('barang/detailstokbarang', $data);
    }

    public function hapusdata($id)
    {
        if ($this->request->isAJAX()) {
            $nama_brg = $this->request->getVar('nama_brg');
            $idsarpras = $this->request->getVar('idsarpras');

            $datahapus = $this->stokbarang->find($id);
            $datasarpras = $this->db->table('stok_barang')->select('*')
                ->where('barang_id', $datahapus['barang_id'])
                ->where('ruang_id', $idsarpras)
                ->get()->getRowArray();
            try {
                $updatesarpras = [
                    'jumlah_keluar' => (intval($datasarpras['jumlah_keluar']) - intval($datahapus['jumlah_masuk'])),
                    'sisa_stok' => (intval($datasarpras['sisa_stok']) + intval($datahapus['jumlah_masuk'])),
                ];
                $ubahsarpras = $this->stokbarang->setUpdateData($updatesarpras);
                // update data ke database
                $this->stokbarang->update($datasarpras['id'], $ubahsarpras);
                $data_lama_sarpras = $datasarpras;
                $data_baru_sarpras = $updatesarpras;
                $field_update = [];
                foreach ($data_baru_sarpras as $key => $value) {
                    if (isset($data_lama_sarpras[$key]) && $data_lama_sarpras[$key] !== $value) {
                        $field_update[] = $key;
                    }
                }
                $lastQuery = $this->db->getLastQuery();
                $this->riwayattrx->inserthistori($datasarpras['id'], $datasarpras, $updatesarpras, "tambah stok barang dari ruang lain", $lastQuery, $field_update);
                $updatehapus = [
                    'jumlah_masuk' => 0,
                    'jumlah_keluar' => 0,
                    'sisa_stok' => 0,
                ];
                $ubahhapus = $this->stokbarang->setUpdateData($updatehapus);
                // update data ke database
                $this->stokbarang->update($id, $ubahhapus);
                $data_lama_hapus = $datahapus;
                $data_baru_hapus = $updatehapus;
                $field_update_hapus = [];
                foreach ($data_baru_hapus as $key => $value) {
                    if (isset($data_lama_hapus[$key]) && $data_lama_hapus[$key] !== $value) {
                        $field_update_hapus[] = $key;
                    }
                }
                $this->riwayattrx->inserthistori($id, $datahapus, $updatehapus, "pengembalian barang ke sarpras", $lastQuery, $field_update_hapus);

                $this->stokbarang->setSoftDelete($id);
                $msg = [
                    'sukses' => "Data barang : $nama_brg berhasil dihapus dan dikembalikan ke Sarana dan Prasarana",
                ];
                echo json_encode($msg);
            } catch (\Exception $e) {
                $msg = [
                    'error' => $e->getMessage(),
                ];
                echo json_encode($msg);
            }
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function multipledeletetemporary()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $jenis = strtolower($this->request->getVar('jenis_kat'));
            $idsarpras = $this->request->getVar('idsarpras');
            $jmldata = count($id);
            $datahapus = array();
            $datasarpras = array();
            for ($i = 0; $i < $jmldata; $i++) {
                array_push($datahapus, $this->stokbarang->find($id[$i]));
                array_push($datasarpras,  $this->db->table('stok_barang')->select('*')
                    ->where('barang_id', $datahapus[$i]['barang_id'])
                    ->where('ruang_id', $idsarpras)
                    ->get()->getRowArray());
            }
            $updatehapus = array();
            for ($j = 0; $j < $jmldata; $j++) {
                $updatesarpras = [
                    'jumlah_keluar' => (intval($datasarpras[$j]['jumlah_keluar']) - intval($datahapus[$j]['jumlah_masuk'])),
                    'sisa_stok' => (intval($datasarpras[$j]['sisa_stok']) + intval($datahapus[$j]['jumlah_masuk'])),
                ];
                $ubahsarpras = $this->stokbarang->setUpdateData($updatesarpras);

                // update data ke database
                $this->stokbarang->update($datasarpras[$j]['id'], $ubahsarpras);
                $data_lama_sarpras = $datasarpras[$j];
                $data_baru_sarpras = $updatesarpras;
                $field_update = [];
                foreach ($data_baru_sarpras as $key => $value) {
                    if (isset($data_lama_sarpras[$key]) && $data_lama_sarpras[$key] !== $value) {
                        $field_update[] = $key;
                    }
                }
                $lastQuery = $this->db->getLastQuery();
                $this->riwayattrx->inserthistori($datasarpras[$j]['id'], $datasarpras[$j], $updatesarpras, "tambah stok barang dari ruang lain", $lastQuery, $field_update);
                $updatehapus[$j] = [
                    'jumlah_masuk' => 0,
                    'jumlah_keluar' => 0,
                    'sisa_stok' => 0,
                ];
                $ubahhapus = $this->stokbarang->setUpdateData($updatehapus[$j]);
                // update data ke database
                $this->stokbarang->update($id[$j], $ubahhapus);
                $data_lama_hapus = $datahapus[$j];
                $data_baru_hapus = $updatehapus[$j];
                $field_update_hapus = [];
                foreach ($data_baru_hapus as $key => $value) {
                    if (isset($data_lama_hapus[$key]) && $data_lama_hapus[$key] !== $value) {
                        $field_update_hapus[] = $key;
                    }
                }
                $this->stokbarang->setSoftDelete($id[$j]);
                $this->riwayattrx->inserthistori($id[$j], $datahapus[$j], $updatehapus[$j], "pengembalian barang ke sarpras", $lastQuery, $field_update_hapus);
            }
            $msg = [
                'sukses' => "$jmldata data $jenis berhasil dihapus secara temporary",
            ];

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function restoredata($id = [])
    {
        if ($this->request->isAJAX()) {

            $jenis = $this->request->getVar('jenis_kat');
            $idsarpras = $this->request->getVar('idsarpras');
            $ids = $this->request->getVar('id');
            $idbrg = $this->request->getVar('barang_id');
            $id = explode(",", $ids);
            $barang_id = explode(",", $idbrg);
            $restoredata = [
                'deleted_by' => null,
                'deleted_at' => null,
            ];

            if (count($id) === 1) {
                $nama_brg = $this->request->getVar('nama_brg');
                $historitrx1 = $this->riwayattrx->select('old_value')->where('stokbrg_id', $id)->where('jenis_transaksi', 'pengembalian barang ke sarpras')->orderBy('id', 'DESC')->get()->getRowArray();
                $stoksarpras = $this->db->table('stok_barang')->select('*')
                    ->where('barang_id', $idbrg)
                    ->where('ruang_id', $idsarpras)->orderBy('id', 'DESC')->get()->getRowArray();

                $datalamastokbrg = $this->stokbarang->select('*')->where('id', $id)->get()->getRowArray();
                $historitrx = json_decode($historitrx1['old_value']);
                $jumlah_masuk1 = $historitrx->jumlah_masuk;
                $jumlah_keluar1 = $historitrx->jumlah_keluar;
                $sisa_stok1 = $historitrx->sisa_stok;
                $jumlah_keluar2 = intval($stoksarpras['jumlah_keluar']) + intval($historitrx->jumlah_masuk);
                $sisa_stok2 = intval($stoksarpras['sisa_stok']) - intval($historitrx->jumlah_masuk);
                $updatedata1 = [
                    'jumlah_masuk' => $jumlah_masuk1,
                    'jumlah_keluar' => $jumlah_keluar1,
                    'sisa_stok' => $sisa_stok1,
                ];
                $data1 = array_merge($updatedata1, $restoredata);
                $ubahdata1 = $this->stokbarang->setUpdateData($data1);
                //periksa perubahan data
                $data_lama1 = $datalamastokbrg;
                $data_baru1 = $data1;
                $field_update1 = [];
                foreach ($data_baru1 as $key => $value) {
                    if (isset($data_lama1[$key]) && $data_lama1[$key] !== $value) {
                        $field_update1[] = $key;
                    }
                }
                $this->stokbarang->update($id, $ubahdata1);

                $lastQuery1 = $this->db->getLastQuery();

                $this->riwayattrx->inserthistori($id, $datalamastokbrg, $data1, "pemulihan data $jenis", $lastQuery1, $field_update1);

                $data2 = [
                    'jumlah_keluar' => $jumlah_keluar2,
                    'sisa_stok' => $sisa_stok2,
                ];
                $ubahdata2 = $this->stokbarang->setUpdateData($data2);

                $data_lama2 = $stoksarpras;
                $data_baru2 = $data2;
                $field_update2 = [];
                foreach ($data_baru2 as $key => $value) {
                    if (isset($data_lama2[$key]) && $data_lama2[$key] !== $value) {
                        $field_update2[] = $key;
                    }
                }
                $this->stokbarang->update($stoksarpras['id'], $ubahdata2);

                $lastQuery2 = $this->db->getLastQuery();

                $this->riwayattrx->inserthistori($id, $stoksarpras, $data2, "pemulihan data $jenis", $lastQuery2, $field_update2);


                $msg = [
                    'sukses' => "Data $jenis: $nama_brg berhasil dipulihkan",
                ];
            } else {
                foreach ($id as $key => $stok_id) {
                    $historitrx1 = $this->riwayattrx->select('old_value')->where('stokbrg_id', $stok_id)->where('jenis_transaksi', 'pengembalian barang ke sarpras')->orderBy('id', 'DESC')->get()->getRowArray();
                    // var_dump($historitrx1);
                    $stoksarpras = $this->stokbarang->select('*')->where('barang_id', $barang_id[$key])->where('ruang_id', $idsarpras)->orderBy('id', 'DESC')->get()->getRowArray();
                    // var_dump($stoksarpras);
                    $datalamastokbrg = $this->stokbarang->select('*')->where('id', $stok_id)->get()->getRowArray();
                    $historitrx = json_decode($historitrx1['old_value']);
                    $jumlah_masuk1 = $historitrx->jumlah_masuk;
                    $jumlah_keluar1 = $historitrx->jumlah_keluar;
                    $sisa_stok1 = $historitrx->sisa_stok;
                    $jumlah_keluar2 = intval($stoksarpras['jumlah_keluar']) + intval($historitrx->jumlah_masuk);
                    $sisa_stok2 = intval($stoksarpras['sisa_stok']) - intval($historitrx->jumlah_masuk);
                    //pulihkan data stok barang dengan ruang_id sesuai
                    $updatedata1 = [
                        'jumlah_masuk' => $jumlah_masuk1,
                        'jumlah_keluar' => $jumlah_keluar1,
                        'sisa_stok' => $sisa_stok1,
                    ];
                    $data1 = array_merge($updatedata1, $restoredata);
                    $ubahdata1 = $this->stokbarang->setUpdateData($data1);
                    //periksa perubahan data
                    $data_lama1 = $datalamastokbrg;
                    $data_baru1 = $data1;
                    $field_update1 = [];
                    foreach ($data_baru1 as $key => $value) {
                        if (isset($data_lama1[$key]) && $data_lama1[$key] !== $value) {
                            $field_update1[] = $key;
                        }
                    }
                    $this->stokbarang->update($stok_id, $ubahdata1);

                    $lastQuery1 = $this->db->getLastQuery();

                    $this->riwayattrx->inserthistori($stok_id, $datalamastokbrg, $data1, "pemulihan data $jenis", $lastQuery1, $field_update1);

                    //update data stok barang dengan ruang_id 54
                    $data2 = [
                        'jumlah_keluar' => $jumlah_keluar2,
                        'sisa_stok' => $sisa_stok2,
                    ];
                    $ubahdata2 = $this->stokbarang->setUpdateData($data2);

                    $data_lama2 = $stoksarpras;
                    $data_baru2 = $data2;
                    $field_update2 = [];
                    foreach ($data_baru2 as $key => $value) {
                        if (isset($data_lama2[$key]) && $data_lama2[$key] !== $value) {
                            $field_update2[] = $key;
                        }
                    }
                    $this->stokbarang->update($stoksarpras['id'], $ubahdata2);

                    $lastQuery2 = $this->db->getLastQuery();

                    $this->riwayattrx->inserthistori($stoksarpras['id'], $stoksarpras, $data2, "pemulihan data $jenis", $lastQuery2, $field_update2);
                }


                if (count($id) > 0) {
                    $msg = [
                        'sukses' => count($id) . " data " . strtolower($jenis) . " berhasil dipulihkan semuanya",
                    ];
                } else {
                    $msg = [
                        'error' => "Tidak ada data " . strtolower($jenis) . " yang bisa dipulihkan"
                    ];
                }
            }

            return json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function hapuspermanen($id = [])
    {
        if ($this->request->isAJAX()) {
            $ids = $this->request->getVar('id');
            $jenis = $this->request->getVar('jenis_kat');
            $datastoklama = [];
            $id = explode(",", $ids);
            if (count($id) === 1) {
                $stoklama = $this->stokbarang->select('*')->where('id', $id)->get()->getRowArray();
                array_push($datastoklama, $stoklama);

                $nama_brg = $this->request->getVar('nama_brg');

                $this->stokbarang->delete($id, true);

                $lastQuery = $this->db->getLastQuery();

                $this->riwayattrx->inserthistori($id, $datastoklama, null, "penghapusan permanen stok " . strtolower($jenis), $lastQuery, null);

                $msg = [
                    'sukses' => "Data $jenis: $nama_brg berhasil dihapus secara permanen",
                ];
            } else {
                $datastok_lama = [];
                foreach ($id as $stokbrg_id) {
                    $stoklama = $this->stokbarang->select('*')->where('id', $stokbrg_id)->get()->getRowArray();
                    array_push($datastok_lama, $stoklama);

                    $this->stokbarang->delete($stokbrg_id, true);

                    $this->riwayattrx->deletehistorimultiple([$stokbrg_id], $datastok_lama, "penghapusan permanen stok " . strtolower($jenis));
                }

                $msg = [
                    'sukses' => count($id) . " data $jenis berhasil dihapus secara permanen",
                ];
            }

            return json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampiltransferform()
    {
        if ($this->request->isAJAX()) {
            $ids = $this->request->getVar('ids');
            $id = explode(",", $ids);
            $title = $this->request->getVar('title');
            $jenis_kat = $this->request->getVar('jenis_kat');
            $jmldata = $this->request->getVar('jmldata');
            $saveMethod = $this->request->getVar('saveMethod');
            $nav = $this->request->getVar('nav');
            $stoklama = [];
            foreach ($id as $idstokbrg) {
                $query = $this->db->table('stok_barang sb')->select('sb.*, b.nama_brg, r.nama_ruang, s.kd_satuan')
                    ->join('barang b', 'b.id=sb.barang_id')
                    ->join('ruang r', 'r.id=sb.ruang_id')
                    ->join('satuan s', 's.id=sb.satuan_id')
                    ->where('sb.id', $idstokbrg)
                    ->get()
                    ->getRowArray();
                $stoklama[] = $query;
            }

            $data = [
                'stoklama' => json_encode($stoklama),
                'title' => $title,
                'jenis_kat' => $jenis_kat,
                'jmldata' => $jmldata,
                'saveMethod' => $saveMethod,
                'nav' => $nav,
            ];

            $msg = [
                'data' => view('alokasi/formtransferbarang', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }
}
