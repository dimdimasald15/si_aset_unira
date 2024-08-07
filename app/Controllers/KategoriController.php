<?php

namespace App\Controllers;

use App\Models\Kategori;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use App\Services\DeleteTemporaryService;
use App\Services\RestoreService;

class KategoriController extends BaseController
{
    protected $kategori, $uri, $title, $restoreService, $deleteTemporaryService;
    public function __construct()
    {
        $this->kategori = new Kategori();
        $this->uri = service('uri');
        $this->title = "Kategori";
        $this->restoreService = new RestoreService();
        $this->deleteTemporaryService = new DeleteTemporaryService($this->kategori);
    }

    public function index()
    {
        $breadcrumb = $this->getBreadcrumb();
        $tabId = ['ktetap', 'kpersediaan'];
        $categoryName = ['Barang Tetap', 'Barang Persediaan'];
        $data = [
            'nav' => 'kategori',
            'title' => $this->title,
            'breadcrumb' => $breadcrumb,
            'tabId' => $tabId,
            'categoryName' => $categoryName,
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
                        <li><a class="dropdown-item" onclick="kategori.restore(' . $row->id . ', \'' . htmlspecialchars($row->nama_kategori) . '\')"><i class="fa fa-undo"></i> Pulihkan</a>
                        </li>
                        <li><a class="dropdown-item" onclick="kategori.hapusPermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_kategori) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a>
                        </li>
                    </ul>
                    </div>
                    ';
                    } else {
                        return '
                        <div class="btn-group mb-1">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="kategori.getForm(\'' . "update" . '\',\'' . $jenis . '\',' . $row->id . ')"> <i class="fa fa-pencil-square-o"></i> Edit</a>
                        </li>
                        <li><a class="dropdown-item" onclick="kategori.hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_kategori) . '\')"><i class="fa fa-trash-o"></i> Hapus</a>
                        </li>
                    </ul>
                    </div>';
                    }
                })
                ->toJson(true);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampilform()
    {
        if (!$this->request->isAJAX()) {
            exit("Maaf tidak dapat diproses");
        }
        $jenis = $this->request->getVar('jenis');
        $saveMethod = $this->request->getVar('saveMethod');
        $id = $this->request->getVar('id');
        $kategori = '';
        if ($id) {
            $kategori = $this->getkategoribyid($id);
        }
        $data = [
            'title' => $this->title,
            'jenis' => $jenis,
            'saveMethod' => $saveMethod,
            'id' => $id,
            'kategori' => $kategori,
        ];
        $msg = [
            'data' => view('kategori/form', $data),
        ];

        echo json_encode($msg);
    }

    public function getkategoribyid($id)
    {
        $row = $this->kategori->find($id);
        return json_encode($row);
    }

    public function restoredata()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $inputData = $this->request->getHeaderLine('Content-Type') === 'application/json' ?
            json_decode($this->request->getBody(), true) :
            $this->request->getVar();

        $ids = explode(",", $inputData['id']);
        $nama_kategori = isset($inputData['nama_kategori']) ? $inputData['nama_kategori'] : "";

        $columnNames = [
            'nama' => 'kategori',
            'value' => $nama_kategori
        ];

        $msg = $this->restoreService->restoreData('kategori', $ids, $columnNames);

        echo json_encode($msg);
    }

    public function hapuspermanen($id = null)
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        if ($id != null) {
            $nama_kategori = $this->request->getVar('nama_kategori');

            $this->kategori->delete($id, true);

            $msg = [
                'success' => "Data kategori: $nama_kategori berhasil dihapus secara permanen",
            ];
        } else {
            $this->kategori->purgeDeleted();
            $jmlhapus = $this->kategori->db->affectedRows();
            $msg = [
                'success' => "$jmlhapus data kategori berhasil dihapus secara permanen",
            ];
        }
        return json_encode($msg);
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
            $kategori = [
                "kd_kategori" => $result->kd_kategori,
                "nama_kategori" => $result->nama_kategori,
                "deskripsi" => $result->deskripsi,
            ];
            echo json_encode($kategori);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function simpandata()
    {
        return $this->processData();
    }

    public function updatedata($id)
    {
        return $this->processData($id);
    }

    private function processData($id = null)
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $rules = [
                'kd_kategori' => [
                    'label' => 'Kode Kategori',
                    'rules' => $id ? 'required' : 'required|is_unique[kategori.kd_kategori]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => $id ? '' : '{field} sudah ada dan tidak boleh sama',
                    ],
                ],
                'nama_kategori' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ];

            if (!$this->validate($rules)) {
                $msg = [
                    'error' => [
                        'kd_kategori' => $validation->getError('kd_kategori'),
                        'nama_kategori' => $validation->getError('nama_kategori'),
                    ],
                ];
            } else {
                $data = [
                    'kd_kategori' => $this->request->getVar('kd_kategori'),
                    'nama_kategori' => $this->request->getVar('nama_kategori'),
                    'deskripsi' => $this->request->getVar('deskripsi'),
                    'jenis' => $this->request->getVar('jenis'),
                ];

                if ($id === null) {
                    // Panggil fungsi setInsertData dari model sebelum data disimpan
                    $insertdata = $this->kategori->setInsertData($data);
                    // Simpan data ke database
                    $this->kategori->save($insertdata);
                    $msg = ['success' => 'Data kategori berhasil tersimpan'];
                } else {
                    // Panggil fungsi setUpdateData dari model sebelum data diperbarui
                    $updatedata = $this->kategori->setUpdateData($data);
                    // Perbarui data di database
                    $this->kategori->update($id, $updatedata);
                    $msg = ['success' => 'Data kategori: ' . $data['nama_kategori'] . ' berhasil diperbarui'];
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
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $inputData = json_decode($this->request->getBody(), true);
        $nama_kategori = $inputData["nama_kategori"];
        $msg = $this->deleteTemporaryService->softDelete($id, 'kategori', $nama_kategori);
        echo json_encode($msg);
    }
}
