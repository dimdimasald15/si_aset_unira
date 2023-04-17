<?php

namespace App\Controllers;

use App\Models\Barang;
use App\Models\RiwayatBarang;
use App\Models\Kategori;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;

class BarangController extends BaseController
{
    protected $barang, $kategori, $uri, $stokbarang, $riwayatbarang;
    public function __construct()
    {
        $this->barang = new Barang();
        $this->riwayatbarang = new RiwayatBarang();
        $this->kategori = new Kategori();
        $this->uri = service('uri');
    }
    public function indexbarangtetap()
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
            'title' => 'Barang Tetap',
            'nav' => 'barang-tetap',
            'breadcrumb' => $breadcrumb
        ];

        return view('barang/indexbarangtetap', $data);
    }

    public function indexbarangpersediaan()
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
            'title' => 'Barang Persediaan',
            'nav' => 'barang-persediaan',
            'breadcrumb' => $breadcrumb
        ];

        return view('barang/indexbarangpersediaan', $data);
    }

    public function listdatabarang()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getGet('jenis_kat');
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);
            $builder = $this->db->table('barang b')
                ->select('b.id, k.nama_kategori,k.jenis, b.nama_brg, b.harga_beli, b.kode_brg, b.kat_id, b.created_at, b.created_by, b.deleted_at, b.deleted_by')
                ->join('kategori k', 'b.kat_id = k.id')
                ->where('k.jenis', $jenis);

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder, $request) use ($jenis, $isRestore) {
                    if ($request->kategori) {
                        $builder->where('b.kat_id', $request->kategori);
                    }
                    if ($isRestore) {
                        $builder->where('b.deleted_at IS NOT NULL');
                        $builder->where('k.jenis', $jenis);
                    } else {
                        $builder->where('b.deleted_at', null);
                        $builder->where('k.jenis', $jenis);
                    }
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('b.id', 'desc');
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
                            <li><a class="dropdown-item" onclick="detailbarang(' . $row->id . ')"><i class="fa fa-info-circle"></i> Detail Barang</a>
                            </li>
                            <li><a class="dropdown-item" onclick="edit(' . $row->id . ')"><i class="fa fa-pencil-square-o"></i> Update Barang</a>
                            </li>
                            <li><a class="dropdown-item" onclick="upload(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\')"><i class="bi bi-image"></i> Update Gambar Barang</a>
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

    public function tampilcardupload()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $nama_brg = $this->request->getVar('nama_brg');
            $data = [
                'id' => $id,
                'nama_brg' => $nama_brg,
                'title' => 'Barang Tetap',
            ];

            $msg = [
                'sukses' => view('barang/cardupload', $data),
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

    // public function detailbarang($kdbrg)
    // {
    //     $kode_brg = str_replace('-', '.', $kdbrg);
    //     $query   = $this->db->table('barang b')->select('SUM(sb.jumlah_masuk) as total_jumlah_masuk, SUM(sb.sisa_stok) as jumlah_sisa_stok, b.*, k.nama_kategori, sb.jumlah_masuk, sb.sisa_stok, GROUP_CONCAT(DISTINCT r.nama_ruang SEPARATOR ", ") as nama_ruang, s.kd_satuan')
    //         ->join('stok_barang sb', 'sb.barang_id = b.id')
    //         ->join('kategori k', 'b.kat_id=k.id')
    //         ->join('ruang r', 'sb.ruang_id = r.id')
    //         ->join('satuan s', 'sb.satuan_id = s.id')
    //         ->where('b.kode_brg', $kode_brg)
    //         ->groupBy('b.id')
    //         ->get();
    //     // dd($query->getRow);

    //     $result = $query->getRow();
    //     if ($result) {
    //         $title = 'Detail Barang ' . $result->nama_brg;
    //     } else {
    //         $title = 'Detail Barang';
    //     }

    //     $data = [
    //         'title' => $title,
    //         'barang' => $result,
    //     ];

    //     return view('barang/detailbarang', $data);
    // }

    public function tampildetailbarang()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getGet('id');
            $data = [
                'id' => $id,
                'data' => view('barang/modaldetail'),
            ];
            echo json_encode($data);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampillabelbarang()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $jenis = $this->request->getVar('jenis_kat');

            $data = [
                'id' => $id,
                'title' => $jenis,
            ];
            $msg = [
                'sukses' => view('barang/modallabel', $data),
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

    public function getdatabarangbyid()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $barang = $this->db->table('barang b')
                ->select('b.id, b.kat_id, b.kode_brg, b.nama_brg, b.merk, b.warna, b.asal, b.harga_beli, b.harga_jual, b.toko, b.instansi, b.no_seri, b.no_dokumen, b.foto_barang, b.tgl_pembelian')
                ->where('id', $id);

            $result = $barang->get()->getRow();
            echo json_encode($result);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getbarangbyany()
    {
        if ($this->request->isAJAX()) {
            $kode_brg = $this->request->getVar('kode_brg');
            $id = $this->request->getVar('id');
            $getbarang = '';
            if (!empty($id)) {
                $getbarang = $this->db->table('barang b')->select('b.id, b.foto_barang, b.nama_brg, b.kat_id, b.kode_brg,k.kd_kategori, k.nama_kategori, b.warna, b.merk, b.toko, b.instansi, b.asal, b.no_dokumen, b.no_seri, b.harga_beli, b.harga_jual, b.tgl_pembelian, b.created_at, b.created_by, b.updated_at,b.updated_by')
                    ->join('kategori k', 'k.id = b.kat_id')
                    ->where('b.id', $id)
                    ->get();
            } else if (!empty($kode_brg)) {
                $getbarang = $this->db->table('barang b')
                    ->select('b.id, b.kat_id, b.kode_brg, b.nama_brg, b.merk, b.warna, b.asal, b.harga_beli, b.harga_jual, b.toko, b.instansi, b.no_seri, b.no_dokumen, b.foto_barang, b.tgl_pembelian')
                    ->where('kode_brg', $kode_brg)
                    ->get();
            }

            if ($getbarang->getNumRows() > 0) {
                $data = $getbarang->getRow();
            } else {
                $data = 'data kosong';
            }

            echo json_encode($data);
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

    public function getsubkdbarang()
    {
        if ($this->request->isAJAX()) {
            $katid = $this->request->getVar('katid');
            $cekkatid = $this->barang->select('*')->where('kat_id', $katid)->get()->getRow();
            if ($cekkatid !== null) {
                $subkdbarang = $this->db->query("SELECT SUBSTR(b.kode_brg, -3) AS subkdbarang, k.kd_kategori FROM barang b JOIN kategori k ON b.kat_id = k.id WHERE b.kat_id = $katid ORDER BY b.id DESC");

                $result = $subkdbarang->getResultArray();
            } else {
                $subkdbarang = $this->db->table('kategori')->select('kd_kategori')->where('id', $katid)->get();
                if ($subkdbarang) {
                    $result = $subkdbarang->getResultArray();
                } else {
                    $result = [];
                }
            }

            echo json_encode($result);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getkdbrgbykdkat()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('katid');
            $getkdbarang = $this->db->table('barang b')
                ->select('SUBSTR(b.kode_brg, -3) AS subkdbarang, k.kd_kategori')
                ->join('kategori k', 'b.kat_id = k.id')
                ->where('b.kat_id', $id)
                ->orderBy('b.id', 'DESC')
                ->limit(1)
                ->get()
                ->getRow();
            if (empty($getkdbarang)) {
                $kd_kat = $this->kategori->find($id);

                $msg = [
                    'subkdkat' => $kd_kat['kd_kategori'],
                    'subkdbrg' => '001',
                ];
            } else {
                // mengambil angka dari string lalu menambahkannya dengan 1
                // var_dump($getkdbarang);
                $subkdbarang = (int)($getkdbarang->subkdbarang) + 1;
                // mengubah angka menjadi string dengan 3 karakter dan diisi dengan "0" jika kurang dari 3 karakter
                $sbkdbrgbaru = str_pad((string)$subkdbarang, 3, "0", STR_PAD_LEFT);

                $msg = [
                    'subkdkat' => $getkdbarang->kd_kategori,
                    'subkdbrg' => $sbkdbrgbaru,
                ];
            }

            echo json_encode($msg);
        }
    }

    public function getmodalpangkasgambar()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'data' => view('barang/modalpangkasgambar'),
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
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kat_id' => [
                    'label' => 'Kode Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'kode_brg' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required|is_unique[barang.kode_brg]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada dan tidak boleh sama',
                    ],
                ],
                'nama_brg' => [
                    'label' => 'Nama Barang',
                    'rules' => 'required|is_unique[barang.nama_brg]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada dan tidak boleh sama',
                    ]
                ],
                'merk' => [
                    'label' => 'Merk barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'warna' => [
                    'label' => 'Warna barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'asal' => [
                    'label' => 'Asal barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'katid' => $validation->getError('kat_id'),
                        'skbarang' => $validation->getError('kode_brg'),
                        'namabarang' => $validation->getError('nama_brg'),
                        'merk' => $validation->getError('merk'),
                        'warna' => $validation->getError('warna'),
                        'asal' => $validation->getError('asal'),
                    ],
                ];
            } else {
                $namabrg = $this->request->getVar('nama_brg');

                $simpandata = [
                    'kat_id' => $this->request->getVar('kat_id'),
                    'kode_brg' => $this->request->getVar('kode_brg'),
                    'nama_brg' => $namabrg,
                    'merk' => $this->request->getVar('merk'),
                    'warna' => $this->request->getVar('warna'),
                    'asal' => $this->request->getVar('asal'),
                    'toko' => $this->request->getVar('toko'),
                    'instansi' => $this->request->getVar('instansi'),
                    'no_seri' => $this->request->getVar('no_seri'),
                    'no_dokumen' => $this->request->getVar('no_dokumen'),
                    'harga_beli' => $this->request->getVar('harga_beli'),
                    'harga_jual' => $this->request->getVar('harga_jual'),
                    'tgl_pembelian' => $this->request->getVar('tgl_pembelian'),
                ];

                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertdata = $this->barang->setInsertData($simpandata);
                // Simpan data ke database
                $this->barang->save($insertdata);

                $barang_id = $this->barang->insertID();

                $lastQuery = $this->db->getLastQuery();

                $this->riwayatbarang->inserthistori($barang_id, null, $simpandata, $lastQuery, null);

                $msg = ['sukses' => 'Data barang berhasil tersimpan'];
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

    public function updatedata($id)
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kat_id' => [
                    'label' => 'Kode Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'kode_brg' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'nama_brg' => [
                    'label' => 'Nama Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'merk' => [
                    'label' => 'Merk barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'warna' => [
                    'label' => 'Warna barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'asal' => [
                    'label' => 'Asal barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'katid' => $validation->getError('kat_id'),
                        'skbarang' => $validation->getError('kode_brg'),
                        'namabarang' => $validation->getError('nama_brg'),
                        'merk' => $validation->getError('merk'),
                        'warna' => $validation->getError('warna'),
                        'asal' => $validation->getError('asal'),
                    ],
                ];
            } else {
                // $barang_lama = $this->db->table('barang')->where('id', $id)->get()->getRowArray();
                $barang_lama = $this->barang->find($id);
                $namabrg = $this->request->getVar('nama_brg');

                $updatedata = [
                    'kat_id' => $this->request->getVar('kat_id'),
                    'kode_brg' => $this->request->getVar('kode_brg'),
                    'nama_brg' => $namabrg,
                    'merk' => $this->request->getVar('merk'),
                    'warna' => $this->request->getVar('warna'),
                    'asal' => $this->request->getVar('asal'),
                    'toko' => $this->request->getVar('toko'),
                    'instansi' => $this->request->getVar('instansi'),
                    'no_seri' => $this->request->getVar('no_seri'),
                    'no_dokumen' => $this->request->getVar('no_dokumen'),
                    'harga_beli' => $this->request->getVar('harga_beli'),
                    'harga_jual' => $this->request->getVar('harga_jual'),
                    'tgl_pembelian' => $this->request->getVar('tgl_pembelian'),
                ];

                // Panggil fungsi setInsertData dari model sebelum data diupdate
                $ubahdata = $this->barang->setUpdateData($updatedata);

                //periksa perubahan data
                $data_lama = $barang_lama;
                $data_baru = $updatedata;
                $field_update = [];
                foreach ($data_baru as $key => $value) {
                    if (isset($data_lama[$key]) && $data_lama[$key] !== $value) {
                        $field_update[] = $key;
                    }
                }
                // update data ke database
                $this->barang->update($id, $ubahdata);
                // Periksa apakah query terakhir adalah operasi update
                $lastQuery = $this->db->getLastQuery();

                $this->riwayatbarang->inserthistori($id, $barang_lama, $updatedata, $lastQuery, $field_update);

                $msg = ['sukses' => 'Data barang: ' . $namabrg . ' berhasil terupdate'];
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

    public function simpanupload()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'foto_barang' => [
                    'label' => 'Upload Foto',
                    'rules' => 'uploaded[foto_barang]|mime_in[foto_barang,image/png,image/jpeg,image/jpg]|is_image[foto_barang]',
                    'errors' => [
                        'uploaded' => '{field} wajib diisi',
                        'mime_in' => 'Harus dalam bentuk gambar, jangan file lain',
                        'is_image' => 'Harus dalam bentuk gambar, jangan file lain',
                        'max_size' => 'Ukuran file terlalu besar. Maksimal 1024KB',
                    ],
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'fotobrg' => $validation->getError('foto_barang'),
                    ]
                ];
            } else {
                $cekdata = $this->barang->find($id);

                $fotolama = $cekdata['foto_barang'];
                if ($fotolama != NULL || $fotolama != "") {
                    unlink(FCPATH . '/assets/images/foto_barang/' . $fotolama);
                }

                // tangkap file foto
                $filefoto = $this->request->getFile('foto_barang');
                $filename = $filefoto->getRandomName();
                // simpan file yang di-cropped saja
                $gambar = $this->request->getVar('cropped_image');
                // $namabrg = $cekdata['nama_brg'];
                list($type, $gambar) = explode(';', $gambar);
                list(, $gambar) = explode(',', $gambar);
                $gambar = base64_decode($gambar);
                $namafile = str_replace(' ', '_', strtolower($filename)) . '.png';
                // hapus ekstensi .jpg pada nama file
                $namafile = str_replace('.jpg', '', $namafile);

                file_put_contents(FCPATH . '/assets/images/foto_barang/' . $namafile, $gambar);

                $updatefoto = [
                    'foto_barang' => $namafile
                ];

                // Panggil fungsi setInsertData dari model sebelum data diupdate
                $ubahfoto = $this->barang->setUpdateData($updatefoto);

                //periksa perubahan data
                $data_lama = $cekdata;
                $data_baru = $updatefoto;
                $field_update = [];
                foreach ($data_baru as $key => $value) {
                    if (array_key_exists($key, $data_lama) && ($data_lama[$key] ?? null) !== $value) {
                        $field_update[] = $key;
                    }
                }

                $this->barang->update($id, $ubahfoto);

                // Periksa apakah query terakhir adalah operasi update
                $lastQuery = $this->db->getLastQuery();

                $this->riwayatbarang->inserthistori($id, $cekdata, $updatefoto, $lastQuery, $field_update);

                $msg = [
                    'sukses' => 'File foto berhasil diupload'
                ];
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
            try {
                $this->barang->setSoftDelete($id);

                $msg = [
                    'sukses' => "Data barang : $nama_brg berhasil dihapus",
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
                $this->barang->update($id, $restoredata);

                $msg = [
                    'sukses' => "Data $jenis: $nama_brg berhasil dipulihkan",
                ];
            } else {
                $this->db->table('barang')
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
                        'error' => 'Tidak ada data barang tetap yang bisa dipulihkan'
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
                $baranglama = $this->barang->select('*')->where('id', $id)->get()->getRowArray();
                array_push($datalama, $baranglama);
                $nama_brg = $this->request->getVar('nama_brg');

                $this->barang->delete($id, true);

                if ($baranglama['foto_barang'] != NULL) {
                    unlink(FCPATH . 'assets/images/foto_barang/' . $baranglama['foto_barang']);
                }

                $lastQuery = $this->db->getLastQuery();

                $this->riwayatbarang->inserthistori($id, $datalama, null, $lastQuery, null);

                $msg = [
                    'sukses' => "Data $jenis: $nama_brg berhasil dihapus secara permanen",
                ];
            } else {
                $data_lama = [];
                foreach ($id as $brg_id) {
                    $baranglama = $this->barang->select('*')->where('id', $brg_id)->get()->getRowArray();
                    array_push($data_lama, $baranglama);

                    // echo "data_lama : ";
                    // var_dump($data_lama);

                    $this->barang->delete($brg_id, true);

                    if ($baranglama['foto_barang'] != NULL) {
                        unlink(FCPATH . 'assets/images/foto_barang/' . $baranglama['foto_barang']);
                    }

                    // $lastQuery = $this->db->getLastQuery();

                    $this->riwayatbarang->deletehistorimultiple([$brg_id], $data_lama);
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
