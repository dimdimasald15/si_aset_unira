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
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use PHPUnit\Framework\Constraint\Count;

class PermintaanController extends BaseController
{
    protected $barang, $kategori, $uri, $stokbarang, $riwayatbarang, $ruang, $riwayattrx, $anggota, $permintaan;
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
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getVar('jenis_kat');
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);
            $builder = $this->db->table('permintaan p')->select('p.id,p.anggota_id, p.barang_id, a.unit_id, u.singkatan, a.nama_anggota, p.jml_barang, p. created_at, p.created_by, p.deleted_at, p.deleted_by, k.nama_kategori, b.nama_brg, u.singkatan, s.kd_satuan')
                ->join('anggota a', 'a.id = p.anggota_id')
                ->join('unit u', 'u.id = a.unit_id')
                ->join('barang b', 'b.id=p.barang_id')
                ->join('kategori k', 'k.id=b.kat_id')
                ->join('stok_barang sb', 'b.id=sb.barang_id')
                ->join('satuan s', 's.id=sb.satuan_id')
                ->join('ruang r', 'r.id=sb.ruang_id')
                ->where('r.id', 54)
                ->where('k.jenis', $jenis);

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder) use ($jenis, $isRestore) {
                    if ($isRestore) {
                        $builder->where('sb.deleted_at IS NOT NULL');
                        $builder->where('b.deleted_at IS NOT NULL');
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
                        <li><a class="dropdown-item" onclick="restore(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-undo"></i> Pulihkan</a>
                        </li>
                        <li><a class="dropdown-item" onclick="hapuspermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a>
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
                        <li><a class="dropdown-item" onclick="edit(' . $row->id . ')"><i class="fa fa-pencil-square-o"></i> Update Barang</a>
                        </li>
                        <li><a class="dropdown-item" onclick="upload(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="bi bi-image"></i> Update Gambar Barang</a>
                        </li>
                        <li><a class="dropdown-item" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-trash-o"></i> Hapus Barang</a>
                        </li>
                    </ul>
                </div>';
                    }
                })
                ->toJson(true);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampilsingleform()
    {
        if ($this->request->isAJAX()) {
            $saveMethod = $this->request->getGet('saveMethod');
            $nav = $this->request->getGet('nav');
            $jenis_kat = $this->request->getGet('jenis_kat');

            $data = [
                'saveMethod' => $saveMethod,
                'title' => 'Permintaan Barang',
                'nav' => $nav,
                'jenis_kat' => $jenis_kat,
            ];

            $msg = [
                'data' => view('permintaan/singleform', $data),
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

    public function pilihunit()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet('search');
            $level = $this->request->getGet('level');
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
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $jmldata = $this->request->getVar('jmlbrg');

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_anggota' => [
                    'label' => 'Nama anggota',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'level' => [
                    'label' => 'Level anggota',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'no_anggota' => [
                    'label' => 'Nomor anggota',
                    'rules' => 'required|is_unique[anggota.no_anggota]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada dan tidak boleh sama',
                    ],
                ],
                'unit_id' => [
                    'label' => 'Unit anggota',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'namaanggota' => $validation->getError('nama_anggota'),
                        'level' => $validation->getError('level'),
                        'noanggota' => $validation->getError('no_anggota'),
                        'unit' => $validation->getError('unit_id'),
                    ],
                ];
            } else {
                $jenistrx = $this->request->getVar('jenistrx');

                $validation =  \Config\Services::validation();
                $errors = array();
                for ($a = 1; $a <= $jmldata; $a++) {
                    $rules = [
                        'barang_id' . $a => [
                            'label' => 'Nama barang',
                            'rules' => 'required',
                            'errors' => [
                                'required' => "{field} form $a tidak boleh kosong",
                            ]
                        ],
                        'satuan_id' . $a => [
                            'label' => 'Nama satuan',
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
                        $errors = $validation->getErrors();
                    }
                }

                // check for errors
                if (!empty($errors)) {
                    $msg = [
                        'jmldata' => $jmldata,
                        'error' => $errors
                    ];
                } else {
                    $nama_anggota = $this->request->getVar('nama_anggota');
                    $level = $this->request->getVar('level');
                    $no_anggota = $this->request->getVar('no_anggota');
                    $unit_id = $this->request->getVar('unit_id');

                    $this->db->transStart();
                    $simpananggota = [
                        'nama_anggota' => $nama_anggota,
                        'no_anggota' => $no_anggota,
                        'level' => $level,
                        'unit_id' => $unit_id,
                    ];
                    $insert1 = $this->anggota->setInsertData($simpananggota);
                    $this->anggota->save($insert1);

                    $id = $this->anggota->insertID();
                    $anggota_id = array();
                    $barang_id = array();
                    $jml_barang = array();
                    for ($b = 1; $b <= $jmldata; $b++) {
                        array_push($anggota_id, $id);
                        array_push($barang_id, $this->request->getVar("barang_id$b"));
                        array_push($jml_barang, $this->request->getVar("jml_barang$b"));
                    }

                    for ($i = 0; $i < $jmldata; $i++) {
                        $simpanpermintaan = [
                            'anggota_id' => $anggota_id[$i],
                            'barang_id' => $barang_id[$i],
                            'jml_barang' => $jml_barang[$i],
                        ];

                        $insert2 = $this->permintaan->setInsertData($simpanpermintaan);

                        $this->permintaan->save($insert2);

                        $stokbrg = $this->db->table('stok_barang')->select('*')->where('barang_id', $barang_id[$i])->get()->getRowArray();
                        // var_dump($stokbrg);
                        // die;
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

                        $this->riwayattrx->inserthistori($stokbrg['id'], $stokbrg, $updatestok, $jenistrx . " " . $anggota_id[$i], $lastQuery, $field_update);
                    }
                    $this->db->transComplete();
                    if ($this->db->transStatus() === false) {
                        // Jika terjadi kesalahan pada transaction
                        $msg = ['error' => 'Gagal menyimpan data permintaan'];
                    } else {
                        // Jika berhasil disimpan
                        $msg = ['sukses' => "Sukses $jmldata data permintaan berhasil tersimpan"];
                    }
                }
            }

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
