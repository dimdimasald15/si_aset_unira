<?php

namespace App\Controllers;

use App\Models\Ruang;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\StokBarang;
use App\Models\RiwayatTransaksi;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;

class StokbarangController extends BaseController
{
    protected $ruang, $barang, $kategori, $uri, $stokbarang, $riwayattrx;

    public function __construct()
    {
        $this->ruang = new Ruang();
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
                ->select('sb.id, sb.barang_id, k.nama_kategori, b.nama_brg, b.harga_beli, b.kode_brg, jumlah_masuk,sisa_stok, b.kat_id, sb.ruang_id, r.nama_ruang, satuan_id, s.kd_satuan, sb.created_at, sb.created_by, sb.deleted_at, sb.deleted_by')
                ->join('barang b', 'sb.barang_id = b.id')
                ->join('kategori k', 'b.kat_id = k.id')
                ->join('ruang r', 'sb.ruang_id = r.id')
                ->join('satuan s', 'sb.satuan_id = s.id')
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
                        <li><a class="dropdown-item" onclick="restore(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-undo"></i> Pulihkan</a>
                        </li>
                        <li><a class="dropdown-item" onclick="hapuspermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a>
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
                            <li><a class="dropdown-item" onclick="detailstokbarang(\'' . htmlspecialchars($row->kode_brg) . '\',' . $row->ruang_id . ')"><i class="fa fa-info-circle"></i> Detail Stok Barang</a>
                            </li>
                            <li><a class="dropdown-item" onclick="cetaklabel(' . $row->id . ')"><i class="fa fa-qrcode"></i> Cetak Label Barang</a>
                            </li>
                            <li><a class="dropdown-item" onclick="edit(' . $row->id . ')"><i class="fa fa-pencil-square-o"></i> Update Barang</a>
                            </li>
                            <li><a class="dropdown-item" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-trash-o"></i> Hapus Barang</a>
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

        return view('stokbarang/detailstokbarang', $data);
    }

    public function tampillabelbarang()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $data = [
                'id' => $id,
            ];
            $msg = [
                'sukses' => view('stokbarang/modallabel', $data),
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

    public function getdatastokbarangbyid()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $stokbrg = $this->db->table('stok_barang sb')->select('sb.*, k.nama_kategori, b.nama_brg, b.kode_brg, b.foto_barang, b.harga_beli, b.harga_jual, b.asal, b.toko, b.instansi, b.no_seri, b.no_dokumen, b.merk, b.tgl_pembelian, b.warna, r.nama_ruang, satuan_id, s.kd_satuan, b.created_at, b.created_by, b.deleted_at')
                ->join('barang b', 'sb.barang_id = b.id')
                ->join('kategori k', 'b.kat_id = k.id')
                ->join('ruang r', 'sb.ruang_id = r.id')
                ->join('satuan s', 'sb.satuan_id = s.id')
                ->where('sb.id', $id);

            $result = $stokbrg->get()->getRow();
            echo json_encode($result);
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

    public function cekbrgdanruang()
    {
        if ($this->request->isAJAX()) {
            $barang_id = $this->request->getVar('barang_id');
            $ruang_id = $this->request->getVar('ruang_id');

            $stokbarang = $this->db->table('stok_barang sb')->select('sb.id, b.nama_brg,r.nama_ruang, sb.satuan_id, s.kd_satuan')
                ->join('ruang r', 'r.id = sb.ruang_id')
                ->join('satuan s', 's.id = sb.satuan_id')
                ->join('barang b', 'b.id = sb.barang_id')
                ->where('sb.barang_id', $barang_id)
                ->where('sb.ruang_id', $ruang_id)
                ->get()->getRow();

            echo json_encode($stokbarang);
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
                        // 'satuan' => $validation->getError('satuan_id'),
                        'jmlmasuk' => $validation->getError('jumlah_masuk'),
                    ],
                ];
            } else {
                $barang_id = $this->request->getVar('barang_id');
                $ruang_id = $this->request->getVar('ruang_id');

                $query_barang = $this->barang->find($barang_id);
                $namabrg = $query_barang['nama_brg'];
                $query_ruang = $this->ruang->find($ruang_id);
                $namaruang = $query_ruang['nama_ruang'];

                $stokbarang = $this->db->table('stok_barang sb')->select('sb.id, sb.jumlah_keluar, sb.jumlah_masuk, b.nama_brg,r.nama_ruang')
                    ->join('ruang r', 'r.id = sb.ruang_id')
                    ->join('barang b', 'b.id = sb.barang_id')
                    ->where('sb.barang_id', $barang_id)
                    ->where('sb.ruang_id', $ruang_id)
                    ->get()->getRowArray();

                $jml_masuk = '';
                $jml_keluar = '';
                $stokbrg_id = '';
                if ($stokbarang) {
                    $jml_masuk = intval($stokbarang['jumlah_masuk']) + intval($this->request->getVar('jumlah_masuk'));
                    $jml_keluar = intval($stokbarang['jumlah_keluar']);
                    $stokbrg_id = $this->request->getVar('id');
                } else {
                    $jml_keluar = 0;
                    $jml_masuk = intval($this->request->getVar('jumlah_masuk'));
                    $stokbrg_id = '';
                }
                $sisa_stok = $jml_masuk - $jml_keluar;

                $simpandata = [
                    'id' => $stokbrg_id,
                    'barang_id' => $barang_id,
                    'ruang_id' => $ruang_id,
                    'satuan_id' => $this->request->getVar('satuan_id'),
                    'jumlah_masuk' => $jml_masuk,
                    'jumlah_keluar' => $jml_keluar,
                    'sisa_stok' => $sisa_stok,
                ];

                if ($stokbarang) {
                    $ubahdata = $this->stokbarang->setUpdateData($simpandata);

                    //periksa perubahan data
                    $data_lama = $stokbarang;
                    $data_baru = $simpandata;
                    $field_update = [];
                    foreach ($data_baru as $key => $value) {
                        if (isset($data_lama[$key]) && $data_lama[$key] !== $value) {
                            $field_update[] = $key;
                        }
                    }
                    // update data ke database
                    $this->stokbarang->update($stokbrg_id, $ubahdata);
                    // Periksa apakah query terakhir adalah operasi update
                    $lastQuery = $this->db->getLastQuery();

                    // jenis transaksi : 'barang tetap masuk','barang persediaan masuk','permintaan barang','peminjaman barang','perbaikan barang rusak','penghapusan barang rusak'
                    $this->riwayattrx->inserthistori($stokbrg_id, $stokbarang, $simpandata, 'barang tetap masuk update', $lastQuery, $field_update);

                    $msg = ['sukses' => "Data barang: $namabrg di $namaruang berhasil terupdate"];
                } else {
                    // Panggil fungsi setInsertData dari model sebelum data disimpan
                    $insertdata = $this->stokbarang->setInsertData($simpandata);

                    // Simpan data ke database
                    $this->stokbarang->save($insertdata);

                    $stokbrg_id = $this->stokbarang->insertID();
                    $jenistrx = $this->request->getVar('jenis_transaksi');

                    $lastQuery = $this->db->getLastQuery();

                    $this->riwayattrx->inserthistori($stokbrg_id, null, $simpandata, $jenistrx, $lastQuery, null);

                    $msg = ['sukses' => 'Data stok barang ' . $namabrg . ' berhasil tersimpan'];
                }
            }
            echo json_encode($msg);
        } else {
            $data = [
                'message' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/html/error_404', $data);
        }
    }

    public function updatedata($id)
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
                        // 'satuan' => $validation->getError('satuan_id'),
                        'jmlmasuk' => $validation->getError('jumlah_masuk'),
                    ],
                ];
            } else {
                $stokbrglama = $this->db->table('stok_barang sb')->select('sb.*, b.nama_brg')->join('barang b', 'b.id = sb.barang_id')->where('sb.id', $id)->get()->getRowArray();
                $barang_id = $this->request->getVar('barang_id');
                $ruang_id = $this->request->getVar('ruang_id');
                $satuan_id = $this->request->getVar('satuan_id');
                $jml_masuk = $this->request->getVar('jumlah_masuk');
                $jml_keluar = $stokbrglama['jumlah_keluar'];
                $namabrg = $stokbrglama['nama_brg'];
                $sisa_stok = $jml_masuk - $jml_keluar;

                $updatedata = [
                    'barang_id' => $barang_id,
                    'ruang_id' => $ruang_id,
                    'satuan_id' => $satuan_id,
                    'jumlah_masuk' => $jml_masuk,
                    'sisa_stok' => $sisa_stok,
                ];

                $ubahdata = $this->stokbarang->setUpdateData($updatedata);

                //periksa perubahan data
                $data_lama = $stokbrglama;
                $data_baru = $updatedata;
                $field_update = [];
                foreach ($data_baru as $key => $value) {
                    if (isset($data_lama[$key]) && $data_lama[$key] !== $value) {
                        $field_update[] = $key;
                    }
                }
                // update data ke database
                $this->stokbarang->update($id, $ubahdata);
                // Periksa apakah query terakhir adalah operasi update
                $lastQuery = $this->db->getLastQuery();

                // jenis transaksi : 'barang tetap masuk','barang persediaan masuk','permintaan barang','peminjaman barang','perbaikan barang rusak','penghapusan barang rusak'
                $this->riwayattrx->inserthistori($id, $stokbrglama, $updatedata, 'barang tetap masuk update', $lastQuery, $field_update);

                $msg = ['sukses' => "Data stok barang: $namabrg berhasil terupdate"];
            }
            echo json_encode($msg);
        } else {
            $data = [
                'message' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/html/error_404', $data);
        }
    }

    public function hapusdata($id)
    {
        if ($this->request->isAJAX()) {
            $nama_brg = $this->request->getVar('nama_brg');
            $nama_ruang = $this->request->getVar('nama_ruang');
            try {
                $this->stokbarang->setSoftDelete($id);

                $msg = [
                    'sukses' => "Data barang : $nama_brg di $nama_ruang berhasil dihapus",
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

    public function restoredata($id = null)
    {
        if ($this->request->isAJAX()) {

            $restoredata = [
                'deleted_by' => null,
                'deleted_at' => null,
            ];
            $jenis = $this->request->getVar('jenis_kat');

            if ($id != null) {
                $nama_brg = $this->request->getVar('nama_brg');
                $nama_ruang = $this->request->getVar('nama_ruang');
                $this->stokbarang->update($id, $restoredata);

                $msg = [
                    'sukses' => "Data $jenis: $nama_brg di $nama_ruang berhasil dipulihkan",
                ];
            } else {
                $this->db->table('stok_barang')
                    ->set($restoredata)
                    ->where('deleted_at is NOT NULL', NULL, FALSE)
                    ->update();
                $jmldata = $this->db->affectedRows();

                if ($jmldata > 0) {
                    $msg = [
                        'sukses' => "$jmldata data $jenis berhasil dipulihkan semuanya",
                    ];
                } else {
                    $msg = [
                        'error' => 'Tidak ada data barang tetap masuk yang bisa dipulihkan'
                    ];
                }
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

    public function hapuspermanen($id = [])
    {
        if ($this->request->isAJAX()) {
            $ids = $this->request->getVar('id');
            $jenis = $this->request->getVar('jenis_kat');
            $datalama = [];
            $id = explode(",", $ids);
            if (count($id) === 1) {
                $stokbrglama = $this->stokbarang->select('*')->where('id', $id)->get()->getRowArray();
                array_push($datalama, $stokbrglama);
                $nama_brg = $this->request->getVar('nama_brg');
                $nama_ruang = $this->request->getVar('nama_ruang');

                $this->stokbarang->delete($id, true);

                $lastQuery = $this->db->getLastQuery();

                $this->riwayattrx->inserthistori($id, $datalama, null, 'hapus stok barang tetap masuk', $lastQuery, null);

                $msg = [
                    'sukses' => "Data stok $jenis: $nama_brg di $nama_ruang berhasil dihapus secara permanen",
                ];
            } else {
                $data_lama = [];
                foreach ($id as $stokbrg_id) {
                    $stokbrglama = $this->stokbarang->select('*')->where('id', $stokbrg_id)->get()->getRowArray();
                    array_push($data_lama, $stokbrglama);

                    $this->stokbarang->delete($stokbrg_id, true);
                    // $lastQuery = $this->db->getLastQuery();

                    $this->riwayattrx->deletehistorimultiple([$stokbrg_id], $data_lama, 'hapus stok barang tetap masuk');
                }

                $msg = [
                    'sukses' => count($id) . " data stok $jenis berhasil dihapus secara permanen",
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
