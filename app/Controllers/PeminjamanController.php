<?php

namespace App\Controllers;

use Exception;
use App\Models\Ruang;
use App\Models\Barang;
use App\Models\Anggota;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\StokBarang;
use App\Models\RiwayatBarang;
use App\Models\RiwayatTransaksi;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;

class PeminjamanController extends BaseController
{
    protected $barang, $kategori, $uri, $stokbarang, $riwayatbarang, $ruang, $riwayattrx, $anggota, $peminjaman;
    public function __construct()
    {
        $this->barang = new Barang();
        $this->riwayatbarang = new RiwayatBarang();
        $this->kategori = new Kategori();
        $this->ruang = new Ruang();
        $this->stokbarang = new StokBarang();
        $this->riwayattrx = new RiwayatTransaksi();
        $this->anggota = new Anggota();
        $this->peminjaman = new Peminjaman();
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
            'title' => 'Peminjaman Barang Tetap',
            'nav' => 'peminjaman-barang-tetap',
            'jenis_kat' => 'Barang Tetap',
            'breadcrumb' => $breadcrumb
        ];

        return view('peminjaman/index', $data);
    }

    public function listdatapeminjaman()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getVar('jenis_kat');
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);
            $status = $this->request->getVar('status');
            $builder = $this->db->table('peminjaman p')->select('p.id, p.anggota_id, p.barang_id, p.jml_barang,p.keterangan, p.kondisi_pinjam, p.kondisi_kembali, p.jml_hari, p.tgl_pinjam, p.tgl_kembali, p.status, p.created_at, p.created_by, p.deleted_at, p.deleted_by, a.unit_id, a.nama_anggota, k.nama_kategori, b.nama_brg, u.singkatan, s.kd_satuan')
                ->join('anggota a', 'a.id = p.anggota_id')
                ->join('barang b', 'b.id=p.barang_id')
                ->join('kategori k', 'k.id=b.kat_id')
                ->join('unit u', 'u.id = a.unit_id')
                ->join('stok_barang sb', 'b.id=sb.barang_id')
                ->join('satuan s', 's.id=sb.satuan_id')
                ->where('k.jenis', $jenis);

            return DataTable::of($builder)
                ->filter(function ($builder) use ($jenis, $isRestore, $status) {
                    if ($isRestore && $status == 0) {
                        $builder->where('p.deleted_at IS NOT NULL');
                        $builder->where('k.jenis', $jenis);
                    } else if ($isRestore == 0 && $status == 0) {
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
                ->addNumbering('no')
                ->add('checkrow', function ($row) use ($isRestore) {
                    if (!$isRestore) {
                        $checkbox = '';
                        if ($row->status == 0) {
                            $checkbox .= '<input type="checkbox" name="id[]" class="checkrow" value="' . $row->id . '">';
                        }
                        return $checkbox;
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
                        <li><a class="dropdown-item" onclick="restore(' . $row->id . ', ' . $row->barang_id . ',\'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-undo"></i> Pulihkan</a>
                        </li>
                        <li><a class="dropdown-item" onclick="hapuspermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_anggota) . '\', \'54\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a>
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
                            <li><a class="dropdown-item" onclick="edit(' . $row->id . ',' . $row->status . ')"><i class="fa fa-pencil-square-o"></i> Update Peminjaman</a>
                                </li>';
                        if ($row->status == 0) {
                            $action .= '<li><a class="dropdown-item" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->jml_barang) . '\', \'' . htmlspecialchars($row->kd_satuan) . '\')"><i class="fa fa-trash-o"></i> Hapus Peminjaman</a>
                                </li>';
                        }
                        $action .= ' </ul>
                        </div>';
                        return $action;
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
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }

        $saveMethod = $this->request->getGet('saveMethod');
        $globalId = $this->request->getGet('globalId');
        $nav = $this->request->getGet('nav');
        $jenis_kat = $this->request->getGet('jenis_kat');
        $status = $this->request->getGet('status');

        $data = [
            'globalId' => $globalId ? $globalId : '',
            'saveMethod' => $saveMethod,
            'title' => 'Peminjaman Barang',
            'nav' => $nav,
            'jenis_kat' => $jenis_kat,
        ];

        if ($status == 1) {
            $view = view('peminjaman/formkembali', $data);
        } else {
            $view = view('peminjaman/singleform', $data);
        }

        $msg = [
            'data' => $view,
        ];

        echo json_encode($msg);
    }

    public function tampilformkembali()
    {
        if ($this->request->isAJAX()) {
            $saveMethod = $this->request->getGet('saveMethod');
            $nav = $this->request->getGet('nav');
            $jenis_kat = $this->request->getGet('jenis_kat');
            $formName = $this->request->getGet('formname');

            $data = [
                'saveMethod' => $saveMethod,
                'title' => 'Pengembalian Barang',
                'nav' => $nav,
                'jenis_kat' => $jenis_kat,
                'formName' => $formName,
            ];

            $msg = [
                'data' => view('peminjaman/formkembali', $data),
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

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $jmldata = $this->request->getVar('jmlbrg');

            $validation = \Config\Services::validation();
            $rules1 = array();
            $errors1 = array();
            if (array_key_exists('nama_anggota', $this->request->getVar())) {
                // melakukan sesuatu jika nama_anggota ada dalam $_POST
                $rules1 = [
                    'nama_anggota' => [
                        'label' => 'Nama peminjam baru',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ],
                    ],
                    'level' => [
                        'label' => 'Level peminjam baru',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ],
                    ],
                    'no_anggota' => [
                        'label' => 'Nomor ID peminjam baru',
                        'rules' => 'required|is_unique[anggota.no_anggota]',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                            'is_unique' => '{field} sudah ada dan tidak boleh sama',
                        ],
                    ],
                    'unit_id' => [
                        'label' => 'Unit peminjam baru',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ],
                    ],
                ];
            } else {
                // melakukan sesuatu jika nama_anggota tidak ada dalam $_POST
                $rules1 = [
                    'anggota_id' => [
                        'label' => 'Nama peminjam',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ],
                    ],
                ];
            }

            $rules1['tgl_pinjam'] = [
                'label' => 'Tanggal pinjam',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ];
            $rules1['keterangan'] = [
                'label' => 'Keterangan',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ];

            if (!$this->validate($rules1)) {
                $errors1 = $validation->getErrors();
            }
            // check for errors
            if (!empty($errors1)) {
                $msg = [
                    'jmldata' => $jmldata,
                    'error' => $errors1,
                ];
            } else {
                $jenistrx = $this->request->getVar('jenistrx');

                $validation =  \Config\Services::validation();
                $errors2 = array();
                for ($a = 1; $a <= $jmldata; $a++) {
                    $rules2 = [
                        'barang_id' . $a => [
                            'label' => 'Nama barang',
                            'rules' => 'required',
                            'errors' => [
                                'required' => "{field} form $a tidak boleh kosong",
                            ]
                        ],
                        'jml_barang' . $a => [
                            'label' => 'Jumlah peminjaman',
                            'rules' => 'required',
                            'errors' => [
                                'required' => "{field} form $a tidak boleh kosong",
                            ]
                        ],
                    ];
                    if (!$this->validate($rules2)) {
                        $errors2 = $validation->getErrors();
                    }
                }
                // check for errors
                if (!empty($errors2)) {
                    $msg = [
                        'jmldata' => $jmldata,
                        'error' => $errors2
                    ];
                } else {
                    $this->db->transStart();
                    $agg_id = '';
                    if (array_key_exists('nama_anggota', $_POST)) {
                        // melakukan sesuatu jika nama_anggota ada dalam $_POST
                        $nama_anggota = $this->request->getVar('nama_anggota');
                        $level = $this->request->getVar('level');
                        $no_anggota = $this->request->getVar('no_anggota');
                        $unit_id = $this->request->getVar('unit_id');

                        $simpananggota = [
                            'nama_anggota' => $nama_anggota,
                            'no_anggota' => $no_anggota,
                            'level' => $level,
                            'unit_id' => $unit_id,
                        ];
                        $insert1 = $this->anggota->setInsertData($simpananggota);
                        $this->anggota->save($insert1);

                        $agg_id = $this->anggota->insertID();
                    } else {
                        $agg_id = $this->request->getVar('anggota_id');
                    }

                    // $anggota_id = array();
                    $barang_id = array();
                    $jml_barang = array();
                    for ($b = 1; $b <= $jmldata; $b++) {
                        // array_push($anggota_id, $agg_id);
                        array_push($barang_id, $this->request->getVar("barang_id$b"));
                        array_push($jml_barang, $this->request->getVar("jml_barang$b"));
                    }

                    for ($i = 0; $i < $jmldata; $i++) {
                        $simpanpeminjaman = [
                            'anggota_id' => $agg_id,
                            'barang_id' => $barang_id[$i],
                            'jml_barang' => $jml_barang[$i],
                            'tgl_pinjam' => $this->request->getVar('tgl_pinjam'),
                            'keterangan' => $this->request->getVar('keterangan'),
                            'status' => 0,
                            'kondisi_pinjam' => 'Baik',
                        ];

                        $insert2 = $this->peminjaman->setInsertData($simpanpeminjaman);

                        $this->peminjaman->save($insert2);

                        $peminjaman_id = $this->peminjaman->insertID();

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

                        $this->riwayattrx->inserthistori($stokbrg['id'], $stokbrg, $updatestok, $jenistrx . " " . $peminjaman_id, $lastQuery, $field_update);
                    }

                    $this->db->transComplete();
                    if ($this->db->transStatus() === false) {
                        // Jika terjadi kesalahan pada transaction
                        $msg = ['error' => 'Gagal menyimpan data peminjaman'];
                    } else {
                        // Jika berhasil disimpan
                        $msg = ['sukses' => "Sukses $jmldata data peminjaman berhasil tersimpan"];
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

    public function tampilmodalcetak()
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }

        $jenis_kat = $this->request->getVar('jenis_kat');
        $opsi = $this->request->getVar('opsi');

        $data = [
            'title' => 'Cetak Peminjaman Barang',
            'jenis_kat' => $jenis_kat,
            'opsi' => $opsi,
        ];

        $msg = [
            'sukses' => view('peminjaman/modalcetak', $data)
        ];

        echo json_encode($msg);
    }

    public function pilihanggota()
    {
        if ($this->request->isAJAX()) {
            $query = $this->db->table('peminjaman p')->select('a.id, a.nama_anggota')->join('anggota a', 'a.id=p.anggota_id')
                ->where('p.status', 0)
                ->where('p.deleted_at is null')->groupBy('a.id')
                ->get();
            $msg = $query->getResultArray();

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getdatapeminjaman()
    {
        if ($this->request->isAJAX()) {
            $anggota_id = $this->request->getGet('anggota_id');
            $tgl_pinjam = $this->request->getGet('tglpinjam');

            $data = $this->db->table('peminjaman p')->select('a.nama_anggota, p.*, b.nama_brg, s.kd_satuan')
                ->join('anggota a', 'a.id=p.anggota_id')
                ->join('barang b', 'b.id=p.barang_id')
                ->join('stok_barang sb', 'b.id=sb.barang_id')
                ->join('satuan s', 's.id=sb.satuan_id')
                ->where('p.anggota_id', $anggota_id)
                ->like('p.tgl_pinjam', "$tgl_pinjam%")
                ->where('p.status', 0)
                ->where('p.deleted_at IS NULL')
                ->orderBy('id', 'ASC')
                ->get()->getResultArray();
            $jmldata = count($data);

            $msg = [
                'data' => $data,
                'jmldata' => $jmldata,
            ];
            if ($jmldata == 0) {
                $getnama = $this->db->table('anggota')->select('nama_anggota')
                    ->where('id', $anggota_id)
                    ->where('deleted_at IS NULL')
                    ->orderBy('id', 'ASC')
                    ->get()->getRow();

                $msg['nama_anggota'] = $getnama->nama_anggota;
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

    public function simpandatapengembalian()
    {
        if ($this->request->isAJAX()) {
            $jenistrx = $this->request->getVar('jenistrx');
            $jmldata = $this->request->getVar('jmldata');
            $saveMethod = $this->request->getVar('saveMethod');

            $validation =  \Config\Services::validation();
            $errors1 = [];
            $rules1 = [
                'anggota_id' => [
                    'label' => 'Nama peminjam',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'tgl_pinjam' => [
                    'label' => 'Tanggal peminjaman',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ];

            if (!$this->validate($rules1)) {
                $errors1 = $validation->getErrors();
            }
            // check for errors
            if (!empty($errors1)) {
                $msg = [
                    'jmldata' => $jmldata,
                    'error' => $errors1,
                ];
            } else {
                $errors2 = array();
                if ($saveMethod !== "update") {
                    for ($a = 0; $a < $jmldata; $a++) {
                        $rules2 = [
                            'kondisi_kembali' . $a => [
                                'label' => 'Kondisi kembali',
                                'rules' => 'required',
                                'errors' => [
                                    'required' => "{field} barang " . ($a + 1) . " tidak boleh kosong",
                                ]
                            ],
                            'tgl_kembali' . $a => [
                                'label' => 'Tanggal kembali',
                                'rules' => 'required',
                                'errors' => [
                                    'required' => "{field} barang " . ($a + 1) . " tidak boleh kosong",
                                ]
                            ],
                        ];
                        if (!$this->validate($rules2)) {
                            $errors2 = $validation->getErrors();
                        }
                    }
                }
                // check for errors
                if (!empty($errors2)) {
                    $msg = [
                        'jmldata' => $jmldata,
                        'error' => $errors2
                    ];
                } else {
                    $anggota_id = $this->request->getVar('anggota_id');
                    $tgl_pinjam = $this->request->getVar('tgl_pinjam');
                    // update data peminjaman
                    $id = $this->request->getVar('id');
                    $barang_id = $this->request->getVar('barang_id');
                    $jml_barang = $this->request->getVar('jml_barang');
                    $status = $this->request->getVar("status");
                    $tgl_kembali = array();
                    $kondisi_kembali = array();
                    for ($a = 0; $a < $jmldata; $a++) {
                        array_push($tgl_kembali, $this->request->getVar("tgl_kembali$a"));
                        array_push($kondisi_kembali, $this->request->getVar("kondisi_kembali$a"));
                    }

                    $this->db->transStart();
                    for ($i = 0; $i < $jmldata; $i++) {
                        $selisih_hari = date_diff(date_create($tgl_pinjam), date_create($tgl_kembali[$i]));
                        $pengembalian = [
                            'jml_hari' => $selisih_hari->format('%a'),
                            'kondisi_kembali' => $kondisi_kembali[$i],
                            'tgl_kembali' => $tgl_kembali[$i] ? $tgl_kembali : NULL,
                            'status' => $status[$i] == NULL ? 0 : $status[$i],
                        ];

                        $updatedata = $this->peminjaman->setUpdateData($pengembalian);
                        $this->peminjaman->update($id[$i],  $updatedata);
                        // update stok barang
                        $stokbrg = $this->db->table('stok_barang')->select('*')->where('barang_id', $barang_id[$i])->get()->getRowArray();
                        $namaTransaksi = "";
                        if ($saveMethod !== 'update') {
                            $ubahstok = [
                                'jumlah_keluar' => (intval($stokbrg['jumlah_keluar']) - intval($jml_barang[$i])),
                                'sisa_stok' => (intval($stokbrg['sisa_stok']) + intval($jml_barang[$i])),
                            ];
                            $namaTransaksi = $jenistrx . " " . $id[$i];
                        } else {
                            $ubahstok = [
                                'jumlah_keluar' => (intval($stokbrg['jumlah_keluar']) + intval($jml_barang[$i])),
                                'sisa_stok' => (intval($stokbrg['sisa_stok']) - intval($jml_barang[$i])),
                            ];
                            $namaTransaksi = "Update " . $jenistrx . " " . $id[$i];
                        }
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
                        // var_dump($lastQuery);

                        $this->riwayattrx->inserthistori($stokbrg['id'], $stokbrg, $updatestok, $namaTransaksi, $lastQuery, $field_update);
                    }

                    $this->db->transComplete();
                    if ($this->db->transStatus() === false) {
                        // Jika terjadi kesalahan pada transaction
                        $msg = ['error' => 'Gagal menyimpan data peminjaman'];
                    } else {
                        // Jika berhasil disimpan
                        $msg = ['sukses' => "Sukses $jmldata barang berhasil dikembalikan"];
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

    public function getpeminjamanbyid()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getGet('id');
            $builder = $this->db->table('peminjaman p')->select('a.nama_anggota, a.no_anggota, a.unit_id, a.level, u.singkatan, p.*, b.nama_brg, sb.satuan_id, sb.sisa_stok, s.kd_satuan')
                ->join('anggota a', 'a.id=p.anggota_id')
                ->join('unit u', 'u.id=a.unit_id')
                ->join('barang b', 'b.id=p.barang_id')
                ->join('stok_barang sb', 'b.id=sb.barang_id')
                ->join('satuan s', 's.id=sb.satuan_id')
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

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }
    public function updatedata($id)
    {
        if ($this->request->isAJAX()) {
            $jmldata = $this->request->getVar('jmlbrg');

            $validation = \Config\Services::validation();
            $rules1 = array();
            $errors1 = array();
            if (array_key_exists('nama_anggota', $this->request->getVar())) {
                // melakukan sesuatu jika nama_anggota ada dalam $_POST
                $rules1 = [
                    'nama_anggota' => [
                        'label' => 'Nama peminta baru',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ],
                    ],
                    'level' => [
                        'label' => 'Level peminta baru',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ],
                    ],
                    'no_anggota' => [
                        'label' => 'Nomor ID peminta baru',
                        'rules' => 'required|is_unique[anggota.no_anggota]',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                            'is_unique' => '{field} sudah ada dan tidak boleh sama',
                        ],
                    ],
                    'unit_id' => [
                        'label' => 'Unit peminta baru',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ],
                    ],
                ];
            } else {
                // melakukan sesuatu jika nama_anggota tidak ada dalam $_POST
                $rules1 = [
                    'anggota_id' => [
                        'label' => 'Nama peminta',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ],
                    ],
                ];
            }

            if (!$this->validate($rules1)) {
                $errors1 = $validation->getErrors();
            }
            // check for errors
            if (!empty($errors1)) {
                $msg = [
                    'jmldata' => $jmldata,
                    'error' => $errors1
                ];
            } else {
                $jenistrx = $this->request->getVar('jenistrx');

                $validation =  \Config\Services::validation();
                $errors2 = array();
                for ($a = 1; $a <= $jmldata; $a++) {
                    $rules2 = [
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
                    if (!$this->validate($rules2)) {
                        $errors2 = $validation->getErrors();
                    }
                }

                // check for errors
                if (!empty($errors2)) {
                    $msg = [
                        'jmldata' => $jmldata,
                        'error' => $errors2
                    ];
                } else {
                    //  else {
                    $peminjamanall = $this->db->table('peminjaman p')->select('p.*, a.nama_anggota, a.no_anggota')->join('anggota a', 'a.id=p.anggota_id')->get()->getResultArray();

                    $this->db->transStart();
                    //Update Table stok barang + riwayat transaksi stok barang
                    $peminjaman = $this->peminjaman->find($id);
                    $isUpdated = $peminjaman['updated_at'];
                    if ($isUpdated == null) {
                        $histori_trx = $this->db->table('riwayat_transaksi rt')->select('rt.old_value,sb.jumlah_keluar, sb.sisa_stok, rt.stokbrg_id')->join('stok_barang sb', 'sb.id=rt.stokbrg_id')
                            ->where('sb.barang_id', $peminjaman['barang_id'])
                            ->where('rt.jenis_transaksi', "Peminjaman Barang " . $peminjaman['id'])
                            ->orderBy('rt.id', 'DESC')
                            ->get()
                            ->getRowArray();
                        $oldval = json_decode($histori_trx['old_value']);
                        $ubahstok1 = [
                            'jumlah_keluar' => $oldval->jumlah_keluar,
                            'sisa_stok' => $oldval->sisa_stok,
                        ];
                    } else if ($isUpdated !== null) {
                        $histori_trx = $this->db->table('riwayat_transaksi rt')->select('rt.old_value,sb.jumlah_keluar, sb.sisa_stok, rt.stokbrg_id')->join('stok_barang sb', 'sb.id=rt.stokbrg_id')
                            ->where('sb.barang_id', $peminjaman['barang_id'])
                            ->where('rt.jenis_transaksi', "Update Peminjaman Barang " . $peminjaman['id'])
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

                    $ubahstok1 = [
                        'jumlah_keluar' => $oldval->jumlah_keluar,
                        'sisa_stok' => $oldval->sisa_stok,
                    ];
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
                        $this->stokbarang->update($stokbrg['id'], $updatestok1);
                    } catch (Exception $e) {
                        // echo "Pembaruan data stok gagal: " . $e->getMessage();
                        $msg = ['error' => "Pembaruan data stok gagal: " . $e->getMessage()];
                    }
                    // Periksa apakah query terakhir adalah operasi update
                    $lastQuery = $this->db->getLastQuery();

                    $this->riwayattrx->inserthistori($stokbrg['id'], $stokbrg, $updatestok1, "Update " . "Update Barang Tetap " . $peminjaman['id'], $lastQuery, $field_update1);

                    //update table peminjaman
                    $barang_id = array();
                    $jml_barang = array();
                    for ($b = 1; $b <= $jmldata; $b++) {

                        array_push($barang_id, $this->request->getVar("barang_id$b"));
                        array_push($jml_barang, $this->request->getVar("jml_barang$b"));
                    }

                    //deklarasi variabel yang akan menampung peminjaman dengan barang yang sudah ada.
                    $oldPeminjamanAll = array();
                    for ($i = 0; $i < $jmldata; $i++) {
                        $data_ditemukan = false;
                        $isDeleted = false;
                        for ($j = 0; $j < count($peminjamanall); $j++) {
                            if ($barang_id[$i] == $peminjamanall[$j]['barang_id'] && $this->request->getVar('anggota_id') == $peminjamanall[$j]['anggota_id'] && $peminjamanall[$j] && $peminjaman['created_at'] == $peminjamanall[$j]['created_at'] && ['deleted_at'] == null) {
                                $data_ditemukan = true;
                                $isDeleted = false;
                                array_push($oldPeminjamanAll, $peminjamanall[$j]);
                            } else if ($barang_id[$i] == $peminjamanall[$j]['barang_id'] && $this->request->getVar('anggota_id') == $peminjamanall[$j]['anggota_id'] && $peminjamanall[$j]['deleted_at'] !== null) {
                                $data_ditemukan = true;
                                $isDeleted = true;
                            }
                        }

                        $oldpeminjaman = end($oldPeminjamanAll);

                        if (!$data_ditemukan) {
                            $ubahpinjam = [
                                'barang_id' => $barang_id[$i],
                                'jml_barang' => $jml_barang[$i],
                                'tgl_pinjam' => $this->request->getVar("tgl_pinjam"),
                            ];
                            $updatepinjam = $this->peminjaman->setUpdateData($ubahpinjam);

                            $this->peminjaman->update($id, $updatepinjam);
                        } else if ($data_ditemukan && !$isDeleted) {
                            $ubahpinjam = array();
                            if ($oldpeminjaman['id'] !== $id) {
                                $this->peminjaman->delete($id, true);
                                $ubahpinjam = [
                                    'jml_barang' => intval($oldpeminjaman['jml_barang']) + intval($jml_barang[$i]),
                                ];
                            } else {
                                $ubahpinjam = [
                                    'jml_barang' => $jml_barang[$i],
                                ];
                            }
                            $ubahpinjam['tgl_pinjam'] = $this->request->getVar("tgl_pinjam");
                            $updatepinjam = $this->peminjaman->setUpdateData($ubahpinjam);

                            $this->peminjaman->update($oldpeminjaman['id'], $updatepinjam);
                        } else if ($data_ditemukan && $isDeleted) {
                            $ubahpinjam = [
                                'jml_barang' => intval($oldpeminjaman['jml_barang']) + intval($jml_barang[$i]),
                                'tgl_pinjam' => $this->request->getVar("tgl_pinjam"),
                                'deleted_by' => null,
                                'deleted_at' => null,
                            ];
                            $updatepinjam = $this->peminjaman->setUpdateData($ubahpinjam);

                            $this->peminjaman->update($oldpeminjaman['id'], $updatepinjam);
                        }
                        // update table stok barang lagi
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
                        $this->stokbarang->update($newstokbrg['id'], $updatestok2);
                        // Periksa apakah query terakhir adalah operasi update
                        $lastQuery = $this->db->getLastQuery();

                        if (!$data_ditemukan) {
                            $this->riwayattrx->inserthistori($newstokbrg['id'], $newstokbrg, $updatestok2, "Update " . $jenistrx . " " . $peminjaman['id'], $lastQuery, $field_update2);
                        } else {
                            $this->riwayattrx->inserthistori($newstokbrg['id'], $newstokbrg, $updatestok2, "Update " . $jenistrx . " " . $oldpeminjaman['id'], $lastQuery, $field_update2);
                        }
                    }

                    $this->db->transComplete();
                    if ($this->db->transStatus() === false) {
                        // Jika terjadi kesalahan pada transaction
                        $msg = ['error' => 'Gagal mengubah data peminjaman'];
                    } else {
                        // Jika berhasil disimpan
                        $msg = ['sukses' => "Sukses $jmldata data peminjaman berhasil terupdate"];
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

    public function hapusdata($id)
    {
        if ($this->request->isAJAX()) {
            $nama_brg = $this->request->getVar('nama_brg');
            $nama_anggota = $this->request->getVar('nama_anggota');

            $datahapus = $this->peminjaman->find($id);
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
                $this->riwayattrx->inserthistori($datasarpras['id'], $datasarpras, $updatesarpras, "tambah stok barang dari peminjaman " . $id, $lastQuery, $field_update);
                //update data peminjaman
                $updatehapus = [
                    'jml_barang' => 0,
                ];
                $ubahhapus = $this->peminjaman->setUpdateData($updatehapus);
                // update data ke database
                $this->peminjaman->update($id, $ubahhapus);
                $this->peminjaman->setSoftDelete($id);
                $msg = [
                    'sukses' => "Data peminjaman $nama_anggota dengan barang $nama_brg berhasil dihapus",
                ];
                echo json_encode($msg);
            } catch (\Exception $e) {
                $msg = [
                    'error' => $e->getMessage(),
                ];
                echo json_encode($msg);
            }
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
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
            //ambil data dari table stok barang dan table peminjaman lalu masukkan ke dalam array baru
            for ($i = 0; $i < $jmldata; $i++) {
                array_push($datahapus, $this->peminjaman->find($id[$i]));
                array_push($datasarpras,  $this->db->table('stok_barang')->select('*')
                    ->where('barang_id', $datahapus[$i]['barang_id'])
                    ->get()->getRowArray());
                // }

                // for ($j = 0; $j < $jmldata; $j++) {
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
                $this->riwayattrx->inserthistori($datasarpras[$i]['id'], $datasarpras[$i], $updatesarpras, "tambah stok barang dari peminjaman " . $id[$i], $lastQuery, $field_update);
                //update data peminjaman
                $updatehapus[$i] = [
                    'jml_barang' => 0,
                ];
                $ubahhapus = $this->peminjaman->setUpdateData($updatehapus[$i]);
                // update data ke database
                $this->peminjaman->update($id[$i], $ubahhapus);
                $this->peminjaman->setSoftDelete($id[$i]);
            }
            $msg = [
                'sukses' => "$jmldata data $jenis berhasil dihapus secara temporary",
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

    public function restoredata($id = [])
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getVar('jenis_kat');
            $ids = $this->request->getVar('id');
            $idbrg = $this->request->getVar('barang_id');
            $id = explode(",", $ids);
            $barang_id = explode(",", $idbrg);
            $restoredata = [
                'deleted_by' => null,
                'deleted_at' => null,
            ];

            if (count($id) === 1) {
                foreach ($id as $key => $idpinjam) {
                    $nama_brg = $this->request->getVar('nama_brg');
                    $historitrx1 = $this->db->table('riwayat_transaksi rt')->select('rt.stokbrg_id, rt.new_value, rt.old_value,sb.jumlah_keluar, sb.sisa_stok, rt.stokbrg_id')->join('stok_barang sb', 'sb.id=rt.stokbrg_id')
                        ->where('sb.barang_id', $barang_id[$key])
                        ->where('rt.jenis_transaksi', 'tambah stok barang dari peminjaman ' . $idpinjam)
                        ->orderBy('rt.id', 'DESC')
                        ->get()
                        ->getRowArray();
                    $stoksarpras = $this->db->table('stok_barang')->select('*')
                        ->where('barang_id', $barang_id[$key])->orderBy('id', 'DESC')->get()->getRowArray();

                    //update table peminjaman
                    $oldval = json_decode($historitrx1['old_value']);
                    $newval = json_decode($historitrx1['new_value']);
                    $jumlah_keluar_old = $oldval->jumlah_keluar;
                    $jumlah_keluar_new = $newval->jumlah_keluar;
                    $sisa_stok_old = $oldval->sisa_stok;
                    $updatepinjam = [
                        'jml_barang' => intval($jumlah_keluar_old) - intval($jumlah_keluar_new),
                    ];
                    $datapinjam = array_merge($updatepinjam, $restoredata);
                    $ubahpinjam = $this->peminjaman->setUpdateData($datapinjam);
                    $this->peminjaman->update($id, $ubahpinjam);

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

                    $this->riwayattrx->inserthistori($stoksarpras['id'], $stoksarpras, $datastok, "pemulihan data peminjaman " . $idpinjam, $lastQuery2, $field_update2);

                    $msg = [
                        'sukses' => "Data peminjaman $jenis: $nama_brg berhasil dipulihkan",
                    ];
                }
            } else {
                foreach ($id as $key => $idpinjam) {
                    $historitrx1 = $this->db->table('riwayat_transaksi rt')->select('rt.stokbrg_id, rt.new_value, rt.old_value,sb.jumlah_keluar, sb.sisa_stok, rt.stokbrg_id')->join('stok_barang sb', 'sb.id=rt.stokbrg_id')
                        ->where('sb.barang_id', $barang_id[$key])
                        ->where('rt.jenis_transaksi', 'tambah stok barang dari peminjaman ' . $idpinjam)
                        ->orderBy('rt.id', 'DESC')
                        ->get()
                        ->getRowArray();
                    $stoksarpras = $this->db->table('stok_barang')->select('*')
                        ->where('barang_id', $barang_id[$key])->orderBy('id', 'DESC')->get()->getRowArray();
                    //update table peminjaman
                    $oldval = json_decode($historitrx1['old_value']);
                    $newval = json_decode($historitrx1['new_value']);
                    $jumlah_keluar_old = $oldval->jumlah_keluar;
                    $jumlah_keluar_new = $newval->jumlah_keluar;
                    $sisa_stok_old = $oldval->sisa_stok;
                    $updatepinjam = [
                        'jml_barang' => intval($jumlah_keluar_old) - intval($jumlah_keluar_new),
                    ];
                    $datapinjam = array_merge($updatepinjam, $restoredata);
                    $ubahpinjam = $this->peminjaman->setUpdateData($datapinjam);
                    $this->peminjaman->update($id, $ubahpinjam);

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

                    $this->riwayattrx->inserthistori($stoksarpras['id'], $stoksarpras, $datastok, "pemulihan data peminjaman " . $idpinjam, $lastQuery2, $field_update2);
                }

                if (count($id) > 0) {
                    $msg = [
                        'sukses' => count($id) . " data peminjaman " . strtolower($jenis) . " berhasil dipulihkan semuanya",
                    ];
                } else {
                    $msg = [
                        'error' => "Tidak ada data peminjaman " . strtolower($jenis) . " yang bisa dipulihkan"
                    ];
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

    public function hapuspermanen($id = [])
    {
        if ($this->request->isAJAX()) {
            $ids = $this->request->getVar('id');
            $jenis = $this->request->getVar('jenis_kat');
            $datapeminjaman = [];
            $id = explode(",", $ids);
            if (count($id) === 1) {
                $peminjamanlama = $this->peminjaman->select('*')->where('id', $id)->get()->getRowArray();
                array_push($datapeminjaman, $peminjamanlama);

                $nama_brg = $this->request->getVar('nama_brg');

                $this->peminjaman->delete($id, true);

                $msg = [
                    'sukses' => "Data peminjaman $jenis: $nama_brg berhasil dihapus secara permanen",
                ];
            } else {
                $datapeminjaman = [];
                foreach ($id as $idpinjam) {
                    $stoklama = $this->peminjaman->select('*')->where('id', $idpinjam)->get()->getRowArray();
                    array_push($datapeminjaman, $stoklama);

                    $this->peminjaman->delete($idpinjam, true);
                }

                $msg = [
                    'sukses' => count($id) . " data $jenis berhasil dihapus secara permanen",
                ];
            }

            return json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }
}
