<?php

namespace App\Controllers;

use App\Models\Ruang;
use App\Controllers\BaseController;
use App\Services\DeleteTemporaryService;
use App\Services\RestoreService;
use \Hermawan\DataTables\DataTable;

class RuangController extends BaseController
{
    protected $ruang, $uri, $title, $restoreService, $deleteTemporaryService;

    public function __construct()
    {
        $this->ruang = new Ruang();
        $this->uri = service('uri');
        $this->title = "Ruang";
        $this->restoreService = new RestoreService();
        $this->deleteTemporaryService = new DeleteTemporaryService($this->ruang);
    }

    public function index()
    {
        $breadcrumb = $this->getBreadcrumb();
        $data = [
            'title' => 'Ruang',
            'nav' => 'ruang',
            'breadcrumb' => $breadcrumb
        ];

        return view('ruang/index', $data);
    }

    public function listdataruang()
    {
        if ($this->request->isAJAX()) {
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);

            $builder = $this->db->table('ruang')
                ->select('ruang.id,nama_ruang, nama_lantai, ruang.created_at, ruang.created_by, ruang.deleted_by, ruang.deleted_at, gedung.prefix, gedung.nama_gedung')
                ->join('gedung', 'ruang.gedung_id = gedung.id');

            return DataTable::of($builder)
                ->filter(function ($builder) use ($isRestore) {
                    if ($isRestore) {
                        $builder->where('ruang.deleted_at IS NOT NULL');
                    } else {
                        $builder->where('ruang.deleted_at', null);
                    }
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('ruang.id', 'desc');
                })
                ->addNumbering('no')
                ->add('action', function ($row) use ($isRestore) {
                    if ($isRestore) {
                        return '<div class="btn-group mb-1">
                    <button type="button" class="btn btn-success  btn-sm dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="ruang.restore(' . $row->id . ', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-undo"></i> Pulihkan</a></li>
                        <li><a class="dropdown-item" onclick="ruang.hapusPermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a></li>
                    </ul>
                    </div>';
                    } else {
                        return '<div class="btn-group btn-group-sm mb-1">
                    <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                        <ul class="dropdown-menu shadow-lg">
                            <li><a class="dropdown-item" onclick="util.getForm(\'' . htmlspecialchars("update") . '\',' . $row->id . ')"> <i class="fa fa-pencil-square-o"></i> Edit</a></li>
                            <li><a class="dropdown-item" onclick="ruang.hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-trash-o"></i> Hapus</a></li>
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
        $nama_ruang = isset($inputData['nama_ruang']) ? $inputData['nama_ruang'] : "";

        $columnNames = [
            'nama' => 'ruang',
            'value' => $nama_ruang
        ];

        $msg = $this->restoreService->restoreData('ruang', $ids, $columnNames);

        echo json_encode($msg);
    }

    public function hapuspermanen($id = null)
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        if ($id != null) {
            $nama_ruang = $this->request->getVar('nama_ruang');

            $this->ruang->delete($id, true);

            $msg = [
                'success' => "Data ruangan $nama_ruang berhasil dihapus secara permanen",
            ];
        } else {
            $this->ruang->purgeDeleted();
            $jmlhapus = $this->ruang->db->affectedRows();
            $msg = [
                'success' => "$jmlhapus data ruangan berhasil dihapus secara permanen",
            ];
        }
        return json_encode($msg);
    }

    public function getgedung()
    {
        $builder = $this->db->table('gedung g')
            ->select('g.id, g.nama_gedung, g.prefix')
            ->get();
        $row = $builder->getResult();

        return json_encode($row);
    }

    public function getForm()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $saveMethod = $this->request->getGet('saveMethod');
        $id = $this->request->getGet('id');
        $gedung = $this->getgedung();
        $ruang = '';
        if ($id) {
            $ruang = $this->getruangbyid($id);
        }
        $data = [
            'id' => $id,
            'title' => $this->title,
            'saveMethod' => $saveMethod,
            'gedung' => $gedung,
            'ruang' => $ruang,
        ];

        $msg = [
            'data' => view('ruang/form', $data),
        ];

        echo json_encode($msg);
    }

    private function getruangbyid($id)
    {
        $row = $this->ruang->find($id);
        return json_encode($row);
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
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $validation = \Config\Services::validation();
        $rules = [
            'nama_ruang' => [
                'label' => 'Nama Ruang',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'nama_lantai' => [
                'label' => 'Nama Lantai',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'gedung_id' => [
                'label' => 'Nama Gedung',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $msg = [
                'error' => [
                    'namaruang' => $validation->getError('nama_ruang'),
                    'namalantai' => $validation->getError('nama_lantai'),
                    'namagedung' => $validation->getError('gedung_id'),
                ],
            ];
        } else {
            $data = [
                'nama_ruang' => $this->request->getVar('nama_ruang'),
                'nama_lantai' => $this->request->getVar('nama_lantai'),
                'gedung_id' => $this->request->getVar('gedung_id'),
            ];

            if ($id === null) {
                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertdata = $this->ruang->setInsertData($data);
                // Simpan data ke database
                $this->ruang->save($insertdata);
                $msg = ['success' => 'Data Ruang berhasil tersimpan'];
            } else {
                // Panggil fungsi setUpdateData dari model sebelum data diperbarui
                $updatedata = $this->ruang->setUpdateData($data);
                // Perbarui data di database
                $this->ruang->update($id, $updatedata);
                $msg = ['success' => 'Data ruangan: ' . $data['nama_ruang'] . ' berhasil diperbarui'];
            }
        }

        echo json_encode($msg);
    }

    public function hapusdata($id)
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $inputData = json_decode($this->request->getBody(), true);
        $nama_ruang = $inputData["nama_ruang"];
        $msg = $this->deleteTemporaryService->softDelete($id, 'ruang', $nama_ruang);
        echo json_encode($msg);
    }
}
