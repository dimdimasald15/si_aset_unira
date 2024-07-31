<?php

namespace App\Controllers;

use Exception;
use App\Models\Ruang;
use App\Models\Barang;
use App\Models\Anggota;
use App\Models\Kategori;
use App\Models\Permintaan;
use App\Models\StokBarang;
use App\Models\RiwayatBarang;
use App\Models\RiwayatTransaksi;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use PHPUnit\Framework\Constraint\Count;

class PermintaanController extends BaseController
{
    protected $barang;
    protected $kategori;
    protected $uri;
    protected $stokbarang;
    protected $riwayatbarang;
    protected $ruang;
    protected $riwayattrx;
    protected $anggota;
    protected $permintaan;
    public function __construct()
    {
        $this->barang = new Barang();
        $this->riwayatbarang = new RiwayatBarang();
        $this->kategori = new Kategori();
        $this->ruang = new Ruang();
        $this->stokbarang = new StokBarang();
        $this->riwayattrx = new RiwayatTransaksi();
        $this->anggota = new Anggota();
        $this->permintaan = new Permintaan();
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
            'title' => 'Permintaan Barang',
            'nav' => 'permintaan-barang',
            'jenis_kat' => 'Barang Persediaan',
            'breadcrumb' => $breadcrumb
        ];

        return view('permintaan/index', $data);
    }

    public function listdatapermintaan()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $jenis = $this->request->getVar('jenis_kat');
        $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);
        $builder = $this->db->table('permintaan p')->select('p.id, p.anggota_id, p.tgl_minta, p.keterangan, p.barang_id, a.unit_id, u.singkatan, a.nama_anggota, p.jml_barang, p.created_at, p.created_by, p.deleted_at, p.deleted_by, k.nama_kategori, b.nama_brg, u.singkatan, s.kd_satuan')
            ->join('anggota a', 'a.id = p.anggota_id')
            ->join('unit u', 'u.id = a.unit_id')
            ->join('barang b', 'b.id=p.barang_id')
            ->join('kategori k', 'k.id=b.kat_id')
            ->join('stok_barang sb', 'b.id=sb.barang_id')
            ->join('satuan s', 's.id=b.satuan_id')
            ->join('ruang r', 'r.id=sb.ruang_id')
            ->where('r.id', 54)
            ->where('k.jenis', $jenis);

        return DataTable::of($builder)
            ->addNumbering('no')
            ->filter(function ($builder) use ($jenis, $isRestore) {
                if ($isRestore) {
                    $builder->where('p.deleted_at IS NOT NULL');
                    $builder->where('k.jenis', $jenis);
                } else {
                    $builder->where('p.deleted_at', null);
                    $builder->where('b.deleted_at', null);
                    $builder->where('a.deleted_at', null);
                    $builder->where('u.deleted_at', null);
                    $builder->where('k.jenis', $jenis);
                }
            })
            ->postQuery(function ($builder) {
                $builder->orderBy('p.id', 'desc');
            })
            ->add('checkrow', function ($row) use ($isRestore) {
                if (!$isRestore) {
                    return '<input type="checkbox" name="id[]" class="checkrow" value="' . $row->id . '">';
                }
            })
            ->add('action', function ($row) use ($isRestore) {
                if ($isRestore) {
                    return '
                    <div class="btn-group mb-1">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="minta.restore(' . $row->id . ', ' . $row->barang_id . ',\'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-undo"></i> Pulihkan</a>
                        </li>
                        <li><a class="dropdown-item" onclick="minta.hapusPermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_anggota) . '\', \'54\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a>
                        </li>
                    </ul>
                    </div>
                    ';
                } else {
                    return '<div class="btn-group btn-group-sm mb-1">
                    <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="minta.getForm(\'' . htmlspecialchars("update") . '\',' . $row->id . ')"><i class="fa fa-pencil-square-o"></i> Update</a>
                        </li>
                        <li><a class="dropdown-item" onclick="minta.hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->jml_barang) . '\', \'' . htmlspecialchars($row->kd_satuan) . '\')"><i class="fa fa-trash-o"></i> Hapus</a>
                        </li>
                    </ul>
                </div>';
                }
            })
            ->toJson(true);
    }

    public function tampilform()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $saveMethod = $this->request->getGet('saveMethod');
        $jenis_kat = $this->request->getGet('jenis_kat');
        $id = $this->request->getGet('id');
        $minta = '';
        if ($id) {
            $minta = $this->getpermintaanbyid($id);
        }
        $data = [
            'id' => $id,
            'saveMethod' => $saveMethod,
            'title' => 'Permintaan Barang',
            'jenis_kat' => $jenis_kat,
            'minta' => $minta,
        ];
        $msg = [
            'data' => view('permintaan/form', $data),
        ];
        echo json_encode($msg);
    }

    public function getpermintaanbyid()
    {
        $id = $this->request->getGet('id');
        $builder = $this->db->table('permintaan p')->select('a.nama_anggota, a.no_anggota, a.unit_id, a.level, u.singkatan, p.id, p.barang_id, p.jml_barang, p.anggota_id, p.keterangan, p.tgl_minta, b.nama_brg, b.satuan_id, s.kd_satuan, sb.sisa_stok')
            ->join('anggota a', 'a.id=p.anggota_id')
            ->join('unit u', 'u.id=a.unit_id')
            ->join('barang b', 'b.id=p.barang_id')
            ->join('stok_barang sb', 'b.id=sb.barang_id')
            ->join('satuan s', 's.id=b.satuan_id')
            ->where('p.id', $id)
            ->get();
        $data = $builder->getRow();
        if (!empty($data)) {
            $jmldata = 1;
        } else {
            $jmldata = 0;
        }
        $msg = [
            'data' => $data,
            'jmldata' => $jmldata,
        ];
        return json_encode($msg);
    }
    public function tampilmodalcetak()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $jenis_kat = $this->request->getVar('jenis_kat');
        $opsi = $this->request->getVar('opsi');

        $data = [
            'title' => 'Cetak Permintaan Barang',
            'jenis_kat' => $jenis_kat,
            'opsi' => $opsi,
        ];

        $msg = [
            'data' => view('permintaan/modalcetak', $data)
        ];

        echo json_encode($msg);
    }

    public function pilihunit()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet('search');
            $level = $this->request->getGet('jenis_kat');
            if ($level && !empty($search)) {
                if ($level == "Mahasiswa") {
                    $dataunit = $this->db->table('unit')
                        ->select('*')
                        ->where('deleted_at', null)
                        ->whereIn('kategori_unit', ['Program Studi', 'Fakultas', 'Ormawa Ekstra Kampus', 'UKM', 'Ormawa Intra Kampus'])
                        ->like('singkatan', $search)
                        ->orderBy('singkatan', 'ASC')
                        ->get();
                } else if ($level == "Karyawan") {
                    $dataunit = $this->db->table('unit')
                        ->select('*')
                        ->where('deleted_at', null)
                        ->whereIn('kategori_unit', ['Divisi', 'Fakultas', 'Program Studi'])
                        ->like('singkatan', $search)
                        ->orderBy('singkatan', 'ASC')
                        ->get();
                }
            } else {
                $dataunit = $this->db->table('unit')->where('deleted_at', null)->orderBy('singkatan', 'ASC')->get();
            }
            // var_dump($dataunit);
            if ($dataunit->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($dataunit->getResultArray() as $row) {
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['singkatan'];

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

    public function pilihanggota()
    {
        if ($this->request->isAJAX()) {
            $jenistrxExists = array_key_exists('jenistrx', $this->request->getGet());

            $query = $this->db->table('anggota a')
                ->select('a.no_anggota, a.nama_anggota, a.level, u.singkatan')
                ->join('unit u', 'u.id=a.unit_id')
                ->where('u.deleted_at is null')
                ->where('a.deleted_at is null')
                ->orderBy('a.level', 'ASC')
                ->orderBy('a.nama_anggota', 'ASC');

            if ($jenistrxExists) {
                $query->where('a.level', 'Karyawan');
            }

            $msg = $query->get()->getResultArray();

            return $this->response->setJSON($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    function carianggota()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $search = $this->request->getGet('search');

        if (!empty($search)) {
            $dataanggota = $this->db->table('anggota a')
                ->select('a.id,a.nama_anggota, a.no_anggota, a.level, u.singkatan')
                ->join('unit u', 'u.id=a.unit_id')
                ->where('u.deleted_at is null')
                ->where('a.deleted_at is null')
                ->like('a.nama_anggota', $search)
                ->orderBy('a.nama_anggota', 'ASC')->get();
        }

        if ($dataanggota->getNumRows() > 0) {
            $list = [];
            $key = 0;
            foreach ($dataanggota->getResultArray() as $row) {
                $list[$key]['id'] = $row['id'];
                $list[$key]['text'] = $row['nama_anggota'];
                $list[$key]['level'] = $row['level'];
                $list[$key]['no'] = $row['no_anggota'];
                $list[$key]['unit'] = $row['singkatan'];

                $key++;
            }
        } else {
            $list = [
                ['id' => '', 'text' => 'Maaf keyword yang anda cari tidak ditemukan'],
            ];
        }
        echo json_encode($list);
    }
    private function validateGeneralFields()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'anggota_id' => [
                'label' => 'Nama peminta',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'tgl_minta' => [
                'label' => 'Tanggal minta',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            return $validation->getErrors();
        }
        return [];
    }
    private function validateItemFields($jmldata)
    {
        $validation = \Config\Services::validation();
        $errors = [];
        for ($a = 1; $a <= $jmldata; $a++) {
            $rules = [
                'barang_id' . $a => [
                    'label' => 'Nama barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} form $a tidak boleh kosong",
                    ]
                ],
                'jml_barang' . $a => [
                    'label' => 'Jumlah permintaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} form $a tidak boleh kosong",
                    ]
                ],
            ];
            if (!$this->validate($rules)) {
                $errors = array_merge($errors, $validation->getErrors());
            }
        }
        return $errors;
    }
    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $jmldata = $this->request->getVar('jmlbrg');
            $errors1 = $this->validateGeneralFields();
            // check for errors
            if (!empty($errors1)) {
                $msg = [
                    'jmldata' => $jmldata,
                    'error' => $errors1
                ];
            } else {
                $jenistrx = $this->request->getVar('jenistrx');
                $errors2 = $this->validateItemFields($jmldata);
                // check for errors
                if (!empty($errors2)) {
                    $msg = [
                        'jmldata' => $jmldata,
                        'error' => $errors2
                    ];
                } else {
                    $this->db->transStart();
                    $anggota_id = $this->request->getVar('anggota_id');
                    $barang_id = array();
                    $jml_barang = array();
                    for ($b = 1; $b <= $jmldata; $b++) {
                        array_push($barang_id, $this->request->getVar("barang_id$b"));
                        array_push($jml_barang, $this->request->getVar("jml_barang$b"));
                    }

                    for ($i = 0; $i < $jmldata; $i++) {
                        $simpanpermintaan = [
                            'anggota_id' => $anggota_id,
                            'barang_id' => $barang_id[$i],
                            'jml_barang' => $jml_barang[$i],
                            'tgl_minta' => $this->request->getVar('tgl_minta'),
                            'keterangan' => $this->request->getVar('keterangan'),
                        ];

                        $insert2 = $this->permintaan->setInsertData($simpanpermintaan);
                        $this->permintaan->save($insert2);
                        $permintaan_id = $this->permintaan->insertID();
                        $stokbrg = $this->db->table('stok_barang')->select('*')->where('barang_id', $barang_id[$i])->get()->getRowArray();
                        $ubahstok = [
                            'jumlah_keluar' => (intval($stokbrg['jumlah_keluar']) + intval($jml_barang[$i])),
                            'sisa_stok' => (intval($stokbrg['sisa_stok']) - intval($jml_barang[$i])),
                        ];
                        $updatestok = $this->stokbarang->setUpdateData($ubahstok);

                        //periksa perubahan data
                        $data_lama = $stokbrg;
                        $data_baru = $updatestok;
                        $field_update = [];
                        foreach ($data_baru as $key => $value) {
                            if (isset($data_lama[$key]) && $data_lama[$key] !== $value) {
                                $field_update[] = $key;
                            }
                        }
                        // update data ke database
                        $this->stokbarang->update($stokbrg['id'], $updatestok);

                        // Periksa apakah query terakhir adalah operasi update
                        $lastQuery = $this->db->getLastQuery();

                        $this->riwayattrx->inserthistori($stokbrg['id'], $stokbrg, $updatestok, $jenistrx . " " . $permintaan_id, $lastQuery, $field_update);
                    }

                    $this->db->transComplete();
                    if ($this->db->transStatus() === false) {
                        // Jika terjadi kesalahan pada transaction
                        $msg = ['error' => 'Gagal menyimpan data permintaan'];
                    } else {
                        // Jika berhasil disimpan
                        $msg = ['success' => "Sukses $jmldata data permintaan berhasil tersimpan"];
                    }
                }
            }

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }



    public function updatedata($id)
    {
        if ($this->request->isAJAX()) {
            $jmldata = $this->request->getVar('jmlbrg');
            $errors1 = $this->validateGeneralFields();
            // check for errors
            if (!empty($errors1)) {
                $msg = [
                    'jmldata' => $jmldata,
                    'error' => $errors1
                ];
            } else {
                $jenistrx = $this->request->getVar('jenistrx');
                $errors2 = $this->validateItemFields($jmldata);
                // check for errors
                if (!empty($errors2)) {
                    $msg = [
                        'jmldata' => $jmldata,
                        'error' => $errors2
                    ];
                } else {

                    $permintaanall = $this->db->table('permintaan p')->select('p.*, a.nama_anggota, a.no_anggota')->join('anggota a', 'a.id=p.anggota_id')->get()->getResultArray();

                    $this->db->transStart();

                    //Update Table stok barang
                    $permintaan = $this->permintaan->find($id);
                    $isUpdated = $permintaan['updated_at'];

                    if ($isUpdated == null) {
                        $histori_trx = $this->db->table('riwayat_transaksi rt')->select('rt.*,sb.jumlah_keluar, sb.sisa_stok, rt.stokbrg_id')->join('stok_barang sb', 'sb.id=rt.stokbrg_id')
                            ->where('sb.barang_id', $permintaan['barang_id'])
                            ->where('rt.jenis_transaksi', "Permintaan Barang " . $permintaan['id'])
                            ->orderBy('rt.id', 'DESC')
                            ->get()
                            ->getRowArray();
                        $oldval = json_decode($histori_trx['old_value']);
                        $ubahstok1 = [
                            'jumlah_keluar' => $oldval->jumlah_keluar,
                            'sisa_stok' => $oldval->sisa_stok,
                        ];
                    } else if ($isUpdated !== null) {
                        $histori_trx = $this->db->table('riwayat_transaksi rt')->select('rt.*, sb.sisa_stok, rt.stokbrg_id')->join('stok_barang sb', 'sb.id=rt.stokbrg_id')
                            ->where('sb.barang_id', $permintaan['barang_id'])
                            ->where('rt.jenis_transaksi', "Update Permintaan Barang " . $permintaan['id'])
                            ->orderBy('rt.id', 'DESC')
                            ->get()
                            ->getRowArray();
                        $oldval = json_decode($histori_trx['new_value']);
                        $ubahstok1 = [
                            'jumlah_keluar' => intval($oldval->jumlah_keluar) - intval($oldval->jumlah_keluar),
                            'sisa_stok' => intval($oldval->sisa_stok) + intval($oldval->jumlah_keluar),
                        ];
                    }

                    $stokbrg = $this->stokbarang->find($histori_trx['stokbrg_id']);

                    $updatestok1 = $this->stokbarang->setUpdateData($ubahstok1);
                    //periksa perubahan data
                    $data_lama1 = $stokbrg;
                    $data_baru1 = $updatestok1;
                    $field_update1 = [];
                    foreach ($data_baru1 as $key => $value) {
                        if (isset($data_lama1[$key]) && $data_lama1[$key] !== $value) {
                            $field_update1[] = $key;
                        }
                    }
                    // update data ke database
                    try {
                        $this->stokbarang->update($histori_trx['stokbrg_id'], $updatestok1);
                    } catch (Exception $e) {
                        $msg = ['error' => "Pembaruan 1 gagal: " . $e->getMessage()];
                    }
                    // Periksa apakah query terakhir adalah operasi update
                    $lastQuery = $this->db->getLastQuery();
                    try {
                        $this->riwayattrx->inserthistori($histori_trx['stokbrg_id'], $stokbrg, $updatestok1, "Update Barang Persediaan "  . $permintaan['id'], $lastQuery, $field_update1);
                    } catch (Exception $e) {
                        $msg = ['error' => "Insert ke riwayattrx 1 gagal: " . $e->getMessage()];
                    }

                    // update table permintaan
                    $barang_id = array();
                    $jml_barang = array();
                    for ($b = 1; $b <= $jmldata; $b++) {
                        array_push($barang_id, $this->request->getVar("barang_id$b"));
                        array_push($jml_barang, $this->request->getVar("jml_barang$b"));
                    }

                    //deklarasi variabel yang akan menampung permintaan dengan barang yang sudah ada.
                    $oldPermintaanAll = array();

                    for ($i = 0; $i < $jmldata; $i++) {
                        $data_ditemukan = false;
                        $isDeleted = false;
                        for ($j = 0; $j < count($permintaanall); $j++) {
                            if ($barang_id[$i] == $permintaanall[$j]['barang_id'] && $this->request->getVar('anggota_id') == $permintaanall[$j]['anggota_id'] && $permintaan['created_at'] == $permintaanall[$j]['created_at'] && $permintaanall[$j]['deleted_at'] == null) {

                                $data_ditemukan = true;
                                $isDeleted = false;

                                array_push($oldPermintaanAll, $permintaanall[$j]);
                            } else if (
                                $barang_id[$i] == $permintaanall[$j]['barang_id'] && $this->request->getVar('anggota_id') == $permintaanall[$j]['anggota_id'] &&
                                $permintaanall[$j]['deleted_at'] !== null
                            ) {
                                $data_ditemukan = true;
                                $isDeleted = true;
                            }
                        }

                        $oldpermintaan = end($oldPermintaanAll);

                        if (!$data_ditemukan) {
                            $ubahminta = [
                                'barang_id' => $barang_id[$i],
                                'jml_barang' => $jml_barang[$i],
                                'tgl_minta' => $this->request->getVar("tgl_minta"),
                                'keterangan' => $this->request->getVar("keterangan"),
                            ];
                            $updateminta = $this->permintaan->setUpdateData($ubahminta);

                            try {
                                $this->permintaan->update($id, $updateminta);
                            } catch (Exception $e) {
                                $msg = ['error' => "Pembaruan permintaan 'data tidak ditemukan' gagal: " . $e->getMessage()];
                            }
                        } else if ($data_ditemukan && !$isDeleted) {
                            $ubahminta = [];
                            if ($oldpermintaan['id'] !== $id) {
                                try {
                                    $this->permintaan->delete($id, true);
                                } catch (Exception $e) {
                                    $msg = ['error' => "Hapus 'data ditemukan dan tidak dihapus' gagal: " . $e->getMessage()];
                                }
                                $ubahminta = [
                                    'jml_barang' => intval($oldpermintaan['jml_barang']) + intval($jml_barang[$i]),
                                ];
                            } else {
                                $ubahminta = [
                                    'jml_barang' => $jml_barang[$i],
                                ];
                            }
                            $updateminta = $this->permintaan->setUpdateData($ubahminta);

                            try {
                                $this->permintaan->update($oldpermintaan['id'], $updateminta);
                            } catch (Exception $e) {
                                $msg = ['error' => "Pembaruan 'data ditemukan dan tidak dihapus' gagal: " . $e->getMessage()];
                            }
                        } else if ($data_ditemukan && $isDeleted) {
                            $ubahminta = [
                                'jml_barang' => intval($oldpermintaan['jml_barang']) + intval($jml_barang[$i]),
                                'tgl_minta' => $this->request->getVar("tgl_minta"),
                                'keterangan' => $this->request->getVar("keterangan"),
                                'deleted_by' => null,
                                'deleted_at' => null,
                            ];
                            $updateminta = $this->permintaan->setUpdateData($ubahminta);

                            try {
                                $this->permintaan->update($oldpermintaan['id'], $updateminta);
                            } catch (Exception $e) {
                                $msg = ['error' => "Pembaruan permintaan 'data ditemukan tetapi data dihapus' gagal: " . $e->getMessage()];
                            }
                        }

                        $newstokbrg = $this->db->table('stok_barang')->select('*')->where('barang_id', $barang_id[$i])->get()->getRowArray();

                        $ubahstok2 = [
                            'jumlah_keluar' => (intval($newstokbrg['jumlah_keluar']) + intval($jml_barang[$i])),
                            'sisa_stok' => (intval($newstokbrg['sisa_stok']) - intval($jml_barang[$i])),
                        ];

                        $updatestok2 = $this->stokbarang->setUpdateData($ubahstok2);
                        //periksa perubahan data
                        $data_lama2 = $newstokbrg;
                        $data_baru2 = $updatestok2;
                        $field_update2 = [];
                        foreach ($data_baru2 as $key => $value) {
                            if (isset($data_lama2[$key]) && $data_lama2[$key] !== $value) {
                                $field_update2[] = $key;
                            }
                        }
                        // update data ke database
                        try {
                            $this->stokbarang->update($newstokbrg['id'], $updatestok2);
                        } catch (Exception $e) {
                            $msg = ['error' => "Pembaruan stokbarang gagal: " . $e->getMessage()];
                        }

                        // Periksa apakah query terakhir adalah operasi update
                        $lastQuery = $this->db->getLastQuery();
                        try {
                            if (!$data_ditemukan) {
                                $this->riwayattrx->inserthistori($newstokbrg['id'], $newstokbrg, $updatestok2, "Update " . $jenistrx . " " . $permintaan['id'], $lastQuery, $field_update2);
                            } else {
                                $this->riwayattrx->inserthistori($newstokbrg['id'], $newstokbrg, $updatestok2, "Update " . $jenistrx . " " . $oldpermintaan['id'], $lastQuery, $field_update2);
                            }
                        } catch (Exception $e) {
                            $msg = ['error' => "Insert ke riwayattrx 2 gagal: " . $e->getMessage()];
                        }
                    }

                    $this->db->transComplete();
                    if ($this->db->transStatus() === false) {
                        // Jika terjadi kesalahan pada transaction
                        $msg = ['error' => 'Gagal mengubah data permintaan'];
                    } else {
                        // Jika berhasil disimpan
                        $msg = ['success' => "Sukses $jmldata data permintaan berhasil diperbarui"];
                    }
                }
            }

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function hapusdata($id)
    {
        if ($this->request->isAJAX()) {
            $nama_brg = $this->request->getVar('nama_brg');
            $nama_anggota = $this->request->getVar('nama_anggota');

            $datahapus = $this->permintaan->find($id);
            $datasarpras = $this->db->table('stok_barang')->select('*')
                ->where('barang_id', $datahapus['barang_id'])
                ->get()->getRowArray();
            try {
                //update table stokbarang
                $updatesarpras = [
                    'jumlah_keluar' => (intval($datasarpras['jumlah_keluar']) - intval($datahapus['jml_barang'])),
                    'sisa_stok' => (intval($datasarpras['sisa_stok']) + intval($datahapus['jml_barang'])),
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
                $this->riwayattrx->inserthistori($datasarpras['id'], $datasarpras, $updatesarpras, "tambah stok barang dari permintaan " . $id, $lastQuery, $field_update);
                //update data permintaan
                $updatehapus = [
                    'jml_barang' => 0,
                ];
                $ubahhapus = $this->permintaan->setUpdateData($updatehapus);
                // update data ke database
                $this->permintaan->update($id, $ubahhapus);
                $this->permintaan->setSoftDelete($id);
                $msg = [
                    'success' => "Data permintaan $nama_anggota dengan barang $nama_brg berhasil dihapus",
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
            $jmldata = count($id);
            $datahapus = array();
            $datasarpras = array();
            $updatehapus = array();
            //ambil data dari table stok barang dan table permintaan lalu masukkan ke dalam array baru
            for ($i = 0; $i < $jmldata; $i++) {
                array_push($datahapus, $this->permintaan->find($id[$i]));
                array_push($datasarpras,  $this->db->table('stok_barang')->select('*')
                    ->where('barang_id', $datahapus[$i]['barang_id'])
                    ->get()->getRowArray());

                $updatesarpras = [
                    'jumlah_keluar' => (intval($datasarpras[$i]['jumlah_keluar']) - intval($datahapus[$i]['jml_barang'])),
                    'sisa_stok' => (intval($datasarpras[$i]['sisa_stok']) + intval($datahapus[$i]['jml_barang'])),
                ];
                $ubahsarpras = $this->stokbarang->setUpdateData($updatesarpras);

                // update data ke database
                $this->stokbarang->update($datasarpras[$i]['id'], $ubahsarpras);
                $data_lama_sarpras = $datasarpras[$i];
                $data_baru_sarpras = $updatesarpras;
                $field_update = [];
                foreach ($data_baru_sarpras as $key => $value) {
                    if (isset($data_lama_sarpras[$key]) && $data_lama_sarpras[$key] !== $value) {
                        $field_update[] = $key;
                    }
                }
                $lastQuery = $this->db->getLastQuery();
                $this->riwayattrx->inserthistori($datasarpras[$i]['id'], $datasarpras[$i], $updatesarpras, "tambah stok barang dari permintaan " . $id[$i], $lastQuery, $field_update);
                //update data permintaan
                $updatehapus[$i] = [
                    'jml_barang' => 0,
                ];
                $ubahhapus = $this->permintaan->setUpdateData($updatehapus[$i]);
                // update data ke database
                $this->permintaan->update($id[$i], $ubahhapus);
                $this->permintaan->setSoftDelete($id[$i]);
            }
            $msg = [
                'success' => "$jmldata data $jenis berhasil dihapus secara temporary",
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
            $ids = $this->request->getVar('id');
            $idbrg = $this->request->getVar('barangId');
            $id = explode(",", $ids);
            $barang_id = explode(",", $idbrg);
            $restoredata = [
                'deleted_by' => null,
                'deleted_at' => null,
            ];

            if (count($id) === 1) {
                foreach ($id as $key => $idminta) {
                    $nama_brg = $this->request->getVar('nama_brg');
                    $historitrx1 = $this->db->table('riwayat_transaksi rt')->select('rt.stokbrg_id, rt.new_value, rt.old_value,sb.jumlah_keluar, sb.sisa_stok, rt.stokbrg_id')->join('stok_barang sb', 'sb.id=rt.stokbrg_id')
                        ->where('sb.barang_id', $barang_id[$key])
                        ->where('rt.jenis_transaksi', 'tambah stok barang dari permintaan ' . $idminta)
                        ->orderBy('rt.id', 'DESC')
                        ->get()
                        ->getRowArray();
                    $stoksarpras = $this->db->table('stok_barang')->select('*')
                        ->where('barang_id', $barang_id[$key])->orderBy('id', 'DESC')->get()->getRowArray();
                    //update table permintaan
                    $oldval = json_decode($historitrx1['old_value']);
                    $newval = json_decode($historitrx1['new_value']);
                    $jumlah_keluar_old = $oldval->jumlah_keluar;
                    $jumlah_keluar_new = $newval->jumlah_keluar;
                    $updateminta = [
                        'jml_barang' => intval($jumlah_keluar_old) - intval($jumlah_keluar_new),
                    ];
                    $dataminta = array_merge($updateminta, $restoredata);
                    $ubahminta = $this->permintaan->setUpdateData($dataminta);
                    $this->permintaan->update($idminta, $ubahminta);

                    //update table stok barang
                    $datastok = [
                        'jumlah_keluar' => intval($stoksarpras['jumlah_keluar']) + (intval($jumlah_keluar_old) - intval($jumlah_keluar_new)),
                        'sisa_stok' => intval($stoksarpras['sisa_stok']) - (intval($jumlah_keluar_old) - intval($jumlah_keluar_new)),
                    ];

                    $ubahstok = $this->stokbarang->setUpdateData($datastok);

                    $data_lama2 = $stoksarpras;
                    $data_baru2 = $datastok;
                    $field_update2 = [];
                    foreach ($data_baru2 as $key => $value) {
                        if (isset($data_lama2[$key]) && $data_lama2[$key] !== $value) {
                            $field_update2[] = $key;
                        }
                    }

                    $this->stokbarang->update($stoksarpras['id'], $ubahstok);

                    $lastQuery2 = $this->db->getLastQuery();

                    $this->riwayattrx->inserthistori($stoksarpras['id'], $stoksarpras, $datastok, "pemulihan data permintaan " . $idminta, $lastQuery2, $field_update2);

                    $msg = [
                        'success' => "Data Permintaan $jenis: $nama_brg berhasil dipulihkan",
                    ];
                }
            } else {
                foreach ($id as $key => $idminta) {
                    $historitrx1 = $this->db->table('riwayat_transaksi rt')->select('rt.stokbrg_id, rt.new_value, rt.old_value,sb.jumlah_keluar, sb.sisa_stok, rt.stokbrg_id')->join('stok_barang sb', 'sb.id=rt.stokbrg_id')->where('sb.barang_id', $barang_id[$key])
                        ->where('rt.jenis_transaksi', 'tambah stok barang dari permintaan ' . $idminta)
                        ->orderBy('rt.id', 'DESC')
                        ->get()
                        ->getRowArray();
                    $stokbrgID = $historitrx1['stokbrg_id'];
                    $stoksarpras = $this->db->table('stok_barang')->select('*')
                        ->where('id', $stokbrgID)
                        ->where('barang_id', $barang_id[$key])->orderBy('id', 'DESC')->get()->getRowArray();

                    $oldval = json_decode($historitrx1['old_value']);
                    $newval = json_decode($historitrx1['new_value']);
                    $jumlah_keluar_old = $oldval->jumlah_keluar;
                    $jumlah_keluar_new = $newval->jumlah_keluar;
                    $updateminta = [
                        'jml_barang' => intval($jumlah_keluar_old) - intval($jumlah_keluar_new),
                    ];
                    $dataminta = array_merge($updateminta, $restoredata);
                    $ubahminta = $this->permintaan->setUpdateData($dataminta);
                    $this->permintaan->update($idminta, $ubahminta);

                    //update table stok barang
                    $datastok = [
                        'jumlah_keluar' => intval($stoksarpras['jumlah_keluar']) + (intval($jumlah_keluar_old) - intval($jumlah_keluar_new)),
                        'sisa_stok' => intval($stoksarpras['sisa_stok']) - (intval($jumlah_keluar_old) - intval($jumlah_keluar_new)),
                    ];
                    $ubahstok = $this->stokbarang->setUpdateData($datastok);

                    $data_lama2 = $stoksarpras;
                    $data_baru2 = $datastok;
                    $field_update2 = [];
                    foreach ($data_baru2 as $key => $value) {
                        if (isset($data_lama2[$key]) && $data_lama2[$key] !== $value) {
                            $field_update2[] = $key;
                        }
                    }
                    $this->stokbarang->update($stoksarpras['id'], $ubahstok);

                    $lastQuery2 = $this->db->getLastQuery();

                    $this->riwayattrx->inserthistori($stoksarpras['id'], $stoksarpras, $datastok, "pemulihan data permintaan " . $idminta, $lastQuery2, $field_update2);
                }

                if (count($id) > 0) {
                    $msg = [
                        'success' => count($id) . " data permintaan " . strtolower($jenis) . " berhasil dipulihkan semuanya",
                    ];
                } else {
                    $msg = [
                        'error' => "Tidak ada data permintaan " . strtolower($jenis) . " yang bisa dipulihkan"
                    ];
                }
            }
            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function hapuspermanen($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($id != null) {
                $jenis = $this->request->getVar('jenis_kat');
                $nama_brg = $this->request->getVar('nama_brg');
                $this->permintaan->delete($id, true);
                $msg = [
                    'success' => "Data permintaan $jenis: $nama_brg berhasil dihapus secara permanen",
                ];
            } else {
                $this->permintaan->purgeDeleted();
                $jmlhapus = $this->permintaan->db->affectedRows();
                $msg = [
                    'success' => $jmlhapus . " data permintaan berhasil dihapus secara permanen",
                ];
            }
            return json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }
}
