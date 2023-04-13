<?php

namespace App\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\StokBarang;
use App\Models\RiwayatTransaksi;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;

class StokbarangController extends BaseController
{
    protected $barang, $kategori, $uri, $stokbarang, $riwayattrx;

    public function __construct()
    {
        $this->barang = new Barang();
        $this->stokbarang = new StokBarang();
        $this->riwayattrx = new RiwayatTransaksi();
        $this->kategori = new Kategori();
        $this->uri = service('uri');
    }

    public function indexbarangtetapmasuk()
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
            'title' => 'Barang Tetap Masuk',
            'nav' => 'barang-tetap-masuk',
            'breadcrumb' => $breadcrumb
        ];

        return view('stokbarang/indextetap', $data);
    }

    public function listdatastokbarang()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getVar('jenis_kat');
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);
            $builder = $this->db->table('stok_barang sb')
                ->select('sb.id, sb.barang_id, k.nama_kategori, b.nama_brg, b.harga_beli, b.kode_brg, jumlah_masuk,sisa_stok, b.kat_id, sb.ruang_id, r.nama_ruang, satuan_id, s.kd_satuan, sb.created_at, sb.created_by, sb.deleted_at')
                ->join('barang b', 'sb.barang_id = b.id')
                ->join('kategori k', 'b.kat_id = k.id')
                ->join('ruang r', 'sb.ruang_id = r.id')
                ->join('satuan s', 'sb.satuan_id = s.id')
                ->where('k.jenis', $jenis);

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder, $request) use ($jenis, $isRestore) {
                    $builder->where('sb.deleted_at', null);
                    if (isset($request->barang) || isset($request->kategori) || isset($request->lokasi)) {
                        if ($request->barang) {
                            $builder->where('b.barang_id', $request->barang);
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
                        $builder->where('k.jenis', $jenis);
                    }
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('sb.id', 'desc');
                })
                ->add('action', function ($row) use ($isRestore) {
                    if ($isRestore) {
                        return '
                    <div class="btn-group mb-1">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="restore(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\')"><i class="fa fa-undo"></i> Pulihkan</a>
                        </li>
                        <li><a class="dropdown-item" onclick="hapuspermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a>
                        </li>
                    </ul>
                    </div>
                    ';
                    } else {
                        return ' <div class="btn-group btn-group-sm mb-1">
                        <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu shadow-lg">
                            <li><a class="dropdown-item" onclick="detailbarang(' . $row->id . ')"><i class="fa fa-info-circle"></i> Detail Stok Barang</a>
                            </li>
                            <li><a class="dropdown-item" onclick="edit(' . $row->id . ')"><i class="fa fa-pencil-square-o"></i> Update Barang</a>
                            </li>
                            <li><a class="dropdown-item" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\')"><i class="fa fa-trash-o"></i> Hapus Barang</a>
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

    public function pilihbarang()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet('search');
            $jenis = $this->request->getGet('jenis_kat');

            if ($jenis == 'Barang Tetap') {
                if (!empty($search)) {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg')->join('kategori k', 'k.id = b.kat_id')->where('k.jenis', $jenis)
                        ->like('b.nama_brg', $search)->get();
                } else {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg')->join('kategori k', 'k.id = b.kat_id')->where('k.jenis', $jenis)->get();
                }
            } else if ($jenis == 'Barang Persediaan') {
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
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function pilihkategori()
    {
        if ($this->request->isAJAX()) {
            $caridata = $this->request->getGet('search');
            $jenis = $this->request->getGet('jenis_kat');
            if ($jenis == 'Barang Tetap') {
                if (!empty($caridata)) {
                    $datakategori = $this->db->table('kategori')
                        ->like('nama_kategori', $caridata)
                        ->where('jenis', $jenis)
                        ->where('SUBSTRING(kd_kategori, 1, 1) !=', 'A')
                        ->where('LENGTH(kd_kategori) >=', 7)
                        ->get();
                } else {
                    $datakategori = $this->db->table('kategori')
                        ->where('jenis', $jenis)
                        ->where('SUBSTRING(kd_kategori, 1, 1) !=', 'A')
                        ->where('LENGTH(kd_kategori) >=', 7)
                        ->get();
                }
            } else if ($jenis == 'Barang Persediaan') {
                if (!empty($caridata)) {
                    $datakategori = $this->db->table('kategori')
                        ->like('nama_kategori', $caridata)
                        ->where('jenis', $jenis)
                        ->where('LENGTH(kd_kategori) >=', 4)
                        ->get();
                } else {
                    $datakategori = $this->db->table('kategori')
                        ->where('jenis', $jenis)
                        ->where('LENGTH(kd_kategori) >=', 4)
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
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function pilihlokasi()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet('search');
            if (!empty($search)) {
                $datalokasi = $this->db->table('ruang')
                    ->like('nama_ruang', $search)->get();
            } else {
                $datalokasi = $this->db->table('ruang')->get();
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

    public function pilihsatuan()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet('search');
            $datasatuan = $this->db->table('satuan')
                ->like('kd_satuan', $search)->get();
            // var_dump($datasatuan);
            if ($datasatuan->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($datasatuan->getResultArray() as $row) {
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['kd_satuan'];

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

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'barang_id' => [
                    'label' => 'Nama barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'ruang_id' => [
                    'label' => 'Nama ruang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'satuan_id' => [
                    'label' => 'Nama satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jumlah_masuk' => [
                    'label' => 'Jumlah masuk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'idbrg' => $validation->getError('barang_id'),
                        'lokasi' => $validation->getError('ruang_id'),
                        'satuan' => $validation->getError('satuan_id'),
                        'jmlmasuk' => $validation->getError('jumlah_masuk'),
                    ],
                ];
            } else {
                $barang_id = $this->request->getVar('barang_id');
                $nama_brg = $this->barang->select('nama_brg')->where('id', $barang_id)->get()->getRow();

                $simpandata = [
                    'barang_id' => $barang_id,
                    'ruang_id' => $this->request->getVar('ruang_id'),
                    'satuan_id' => $this->request->getVar('satuan_id'),
                    'jumlah_masuk' => $this->request->getVar('jumlah_masuk'),
                ];

                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertdata = $this->stokbarang->setInsertData($simpandata);
                // Simpan data ke database
                $this->stokbarang->save($insertdata);

                $stokbrg_id = $this->stokbarang->insertID();
                $jenistrx = $this->request->getVar('jenis_transaksi');

                $lastQuery = $this->db->getLastQuery();

                $this->riwayattrx->inserthistori($stokbrg_id, null, $simpandata, $jenistrx, $lastQuery, null);

                $msg = ['sukses' => "Data stok barang $nama_brg berhasil tersimpan"];
            }
            echo json_encode($msg);
        } else {
            $data = [
                'message' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/html/error_404', $data);
        }
    }
}
