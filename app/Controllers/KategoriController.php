<?php

namespace App\Controllers;

use App\Models\Kategori;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;

class KategoriController extends BaseController
{
    protected $kategori;
    protected $uri;
    public function __construct()
    {
        $this->kategori = new Kategori();
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
            'nav' => 'kategori',
            'title' => 'Kategori',
            'breadcrumb' => $breadcrumb
        ];

        return view('kategori/index', $data);
    }

    public function listdatakategori()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getGet('jenis');
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);
            $builder = $this->db->table('kategori')->select('id,kd_kategori, nama_kategori, deskripsi, created_by, created_at, deleted_by, deleted_at');

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder) use ($jenis, $isRestore) { // tambahkan parameter $jenis dan $isRestore pada closure 
                    if ($isRestore) {
                        $builder->where('deleted_at IS NOT NULL');
                    } else {
                        $builder->where('deleted_at', null);
                        $builder->where('jenis', $jenis);
                    }
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('created_at', 'desc');
                })
                ->add('action', function ($row) use ($isRestore, $jenis) {
                    if ($isRestore) {
                        return '
                    <div class="btn-group mb-1">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="restore(' . $row->id . ', \'' . htmlspecialchars($row->nama_kategori) . '\')"><i class="fa fa-undo"></i> Pulihkan</a>
                        </li>
                        <li><a class="dropdown-item" onclick="hapuspermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_kategori) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a>
                        </li>
                    </ul>
                    </div>
                    ';
                    } else {
                        return '<button type="button" class="btn btn-warning btn-sm btn-editgedung" onclick="tampilform(\'' . "update" . '\',\'' . $jenis . '\',' . $row->id . ')"> <i class="fa fa-pencil-square-o"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_kategori) . '\')"><i class="fa fa-trash-o"></i></button>';
                    }
                })
                ->toJson(true);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampilformtambah()
    {
        if (!$this->request->isAJAX()) {
            exit("Maaf tidak dapat diproses");
        }

        $title = $this->request->getVar('title');
        $nav = $this->request->getVar('nav');
        $jenis = $this->request->getVar('jenis');
        $saveMethod = $this->request->getVar('saveMethod');
        $globalId = $this->request->getVar('globalId');

        $data = [
            'title' => $title,
            'nav' => $nav,
            'jenis' => $jenis,
            'saveMethod' => $saveMethod,
            'globalId' => $globalId,
        ];

        $msg = [
            'data' => view('kategori/cardform', $data),
        ];

        echo json_encode($msg);
    }

    public function restoredata($id = null)
    {
        if ($this->request->isAJAX()) {
            $restoredata = [
                'deleted_by' => null,
                'deleted_at' => null,
            ];

            if ($id != null) {
                $nama_kategori = $this->request->getVar('nama_kategori');
                $this->kategori->update($id, $restoredata);

                $msg = [
                    'sukses' => "Data kategori: " . $nama_kategori . '  berhasil dipulihkan',
                ];
            } else {
                $this->db->table('kategori')
                    ->set($restoredata)
                    ->where('deleted_at is NOT NULL', NULL, FALSE)
                    ->update();
                $jmldata = $this->db->affectedRows();

                if ($jmldata > 0) {
                    $msg = [
                        'sukses' => "$jmldata data kategori berhasil dipulihkan semuanya",
                    ];
                } else {
                    $msg = [
                        'error' => 'Tidak ada data kategori tetap yang bisa dipulihkan'
                    ];
                }
            }

            return json_encode($msg);
        } else exit("Maaf tidak dapat diproses");
    }

    public function hapuspermanen($id = null)
    {
        if ($this->request->isAJAX()) {
            if ($id != null) {
                $nama_kategori = $this->request->getVar('nama_kategori');

                $this->kategori->delete($id, true);

                $msg = [
                    'sukses' => "Data kategori: $nama_kategori berhasil dihapus secara permanen",
                ];
            } else {
                $this->kategori->purgeDeleted();
                $jmlhapus = $this->kategori->db->affectedRows();
                $msg = [
                    'sukses' => "$jmlhapus data kategori berhasil dihapus secara permanen",
                ];
            }

            return json_encode($msg);
        } else exit("Maaf tidak dapat diproses");
    }


    public function getsubkode1()
    {
        if ($this->request->isAJAX()) {
            $jenisbarang = $this->request->getVar('jenis');
            // echo $jenisbarang;
            if ($jenisbarang == 'Barang Tetap') {
                $query = $this->db->query("SELECT DISTINCT SUBSTRING(kd_kategori, 1, 1) AS subkode1 
                    FROM kategori 
                    WHERE jenis = '$jenisbarang'
                    AND deleted_at IS NULL 
                    ORDER BY subkode1");
                $result = $query->getResultArray();
            } else if ($jenisbarang == 'Barang Persediaan') {
                $query = $this->db->query("SELECT DISTINCT LEFT(SUBSTRING_INDEX(kd_kategori, '.', 1), 3) AS subkode1 
                    FROM kategori
                    WHERE jenis = '$jenisbarang'
                    AND deleted_at IS NULL
                    ORDER BY subkode1;");
                $result = $query->getResultArray();
            }

            echo json_encode($result);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getsubkode2()
    {
        if ($this->request->isAJAX()) {
            $subkode1 = $this->request->getVar('subkode1');
            $query = $this->db->table('kategori')
                ->select("DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(kd_kategori, '.', 2), '.', -1) AS subkode2")
                ->whereIn("SUBSTRING_INDEX(kd_kategori, '.', 1)", explode(',', $subkode1))
                ->whereNotIn("SUBSTRING_INDEX(kd_kategori, '.', 2)", [$subkode1])
                ->get();
            $result = $query->getResult();
            echo json_encode($result);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getsubkode3()
    {
        if ($this->request->isAJAX()) {
            $subkode1 = $this->request->getVar('subkode1');
            $subkode2 = $this->request->getVar('subkode2');
            $query = $this->db->query("SELECT DISTINCT SUBSTRING(kd_kategori, 6, 2) AS subkode3
            FROM kategori
            WHERE SUBSTRING(kd_kategori, 1, 1) = '$subkode1'
            AND SUBSTRING(kd_kategori, 3, 2) IN ('$subkode2')
            ORDER BY subkode3 ASC");
            $result = $query->getResult();
            echo json_encode($result);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getsubkode4()
    {
        if ($this->request->isAJAX()) {
            $subkode1 = $this->request->getVar('subkode1');
            $subkode2 = $this->request->getVar('subkode2');
            $subkode3 = $this->request->getVar('subkode3');
            $query = $this->db->query("SELECT DISTINCT SUBSTRING_INDEX(kd_kategori, '.', -1) AS subkode4
            FROM kategori
            WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(kd_kategori, '.', 1), '.', -1) = '$subkode1'
            AND SUBSTRING_INDEX(SUBSTRING_INDEX(kd_kategori, '.', 2), '.', -1) = '$subkode2'
            AND SUBSTRING_INDEX(SUBSTRING_INDEX(kd_kategori, '.', 3), '.', -1) = '$subkode3'
            GROUP BY subkode4
            HAVING COUNT(subkode4) >= 1;");
            $result = $query->getResult();
            echo json_encode($result);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getnamakategori()
    {
        if ($this->request->isAJAX()) {
            $subkode1 = $this->request->getPost('subkode1');
            $subkode2 = $this->request->getPost('subkode2');
            $subkode3 = $this->request->getPost('subkode3');
            $subkode4 = $this->request->getPost('subkode4');
            $jenis = $this->request->getPost('jenis');
            $kode = '';
            if ($subkode2 == '' && $subkode3 == '' && $subkode4 == '') {
                $kode = $subkode1;
            } else if ($subkode3 == '' && $subkode4 == '') {
                $kode = $subkode1 . '.' . $subkode2;
            } else if ($subkode4 == '') {
                $kode = $subkode1 . '.' . $subkode2 . '.' . $subkode3;
            } else {
                $kode = $subkode1 . '.' . $subkode2 . '.' . $subkode3 . '.' . $subkode4;
            }
            // if($jenis == 'Barang Tetap'){}
            $query = $this->db->table('kategori')
                ->where('kd_kategori', $kode)
                ->where('jenis', $jenis)
                ->get();
            $result = $query->getRow();
            echo json_encode($result);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kd_kategori' => [
                    'label' => 'Kode Kategori',
                    'rules' => 'required|is_unique[kategori.kd_kategori]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada dan tidak boleh sama',
                    ],
                ],
                'nama_kategori' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'kdkat' => $validation->getError('kd_kategori'),
                        'nama_kategori' => $validation->getError('nama_kategori'),
                    ],
                ];
            } else {
                $simpandata = [
                    'kd_kategori' => $this->request->getVar('kd_kategori'),
                    'nama_kategori' => $this->request->getVar('nama_kategori'),
                    'deskripsi' => $this->request->getVar('deskripsi'),
                    'jenis' => $this->request->getVar('jenis'),
                ];

                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertdata = $this->kategori->setInsertData($simpandata);
                // Simpan data ke database
                $this->kategori->save($insertdata);

                $msg = ['sukses' => 'Data kategori berhasil tersimpan'];
            }
            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getkategoribyid()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $builder =  $this->db->table('kategori')
                ->select('*')
                ->where('id', $id)
                ->get();

            $row = $builder->getRow();

            echo json_encode($row);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function updatedata($id)
    {
        if ($this->request->isAJAX()) {
            if ($this->request->isAJAX()) {
                $validation =  \Config\Services::validation();

                $valid = $this->validate([
                    'kd_kategori' => [
                        'label' => 'Kode Kategori',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ],
                    ],
                    'nama_kategori' => [
                        'label' => 'Nama Kategori',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ],
                ]);

                if (!$valid) {
                    $msg = [
                        'error' => [
                            'kdkat' => $validation->getError('kd_kategori'),
                            'nama_kategori' => $validation->getError('nama_kategori'),
                        ],
                    ];
                } else {
                    $updatedata = [
                        'kd_kategori' => $this->request->getVar('kd_kategori'),
                        'nama_kategori' => $this->request->getVar('nama_kategori'),
                        'deskripsi' => $this->request->getVar('deskripsi'),
                        'jenis' => $this->request->getVar('jenis'),
                    ];

                    // Panggil fungsi setInsertData dari model sebelum data diupdate
                    $ubahdata = $this->kategori->setUpdateData($updatedata);
                    // update data ke database
                    $this->kategori->update($id, $ubahdata);

                    $msg = ['sukses' => 'Data kategori: ' . $updatedata['nama_kategori'] . ' berhasil terupdate'];
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

    public function hapusdata($id)
    {
        if ($this->request->isAJAX()) {
            $nama_kategori = $this->request->getVar('nama_kategori');
            try {
                $this->kategori->setSoftDelete($id);

                $msg = [
                    'sukses' => "Data kategori : $nama_kategori berhasil dihapus",
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
}
