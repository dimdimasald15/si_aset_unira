<?php

namespace App\Controllers;

use App\Models\Unit;
use App\Services\RestoreService;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use App\Services\DeleteTemporaryService;

class UnitController extends BaseController
{
    protected $unit, $uri, $restoreService, $deleteTemporaryService;
    public function __construct()
    {
        $this->unit = new Unit();
        $this->uri = service('uri');
        $this->restoreService = new RestoreService();
        $this->deleteTemporaryService = new DeleteTemporaryService($this->unit);
    }

    public function listdata()
    {
        if ($this->request->isAJAX()) {
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);

            $builder = $this->db->table('unit')
                ->select('id, nama_unit, singkatan, deskripsi, kategori_unit, created_at, created_by, deleted_by, deleted_at');
            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder) use ($isRestore) {
                    if ($isRestore) {
                        $builder->where('deleted_at IS NOT NULL');
                    } else {
                        $builder->where('deleted_at', null);
                    }
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('id', 'desc');
                })
                ->add('checkRowUnit', function ($row) use ($isRestore) {
                    if (!$isRestore) {
                        return '<input type="checkbox" name="id[]" class="checkRowUnit" value="' . $row->id . '">';
                    }
                })
                ->add('action', function ($row) use ($isRestore) {
                    if ($isRestore) {
                        return '
                        <div class="btn-group mb-1">
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu shadow-lg">
                            <li><a class="dropdown-item" onclick="unit.restore(' . $row->id . ', \'' . htmlspecialchars($row->nama_unit) . '\')"><i class="fa fa-undo"></i> Pulihkan</a></li>
                            <li><a class="dropdown-item" onclick="unit.hapusPermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_unit) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a></li>
                        </ul>
                        </div>
                        ';
                    } else {
                        return '
                        <div class="btn-group mb-1">
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu shadow-lg">
                            <li><a class="dropdown-item" onclick="util.getForm(\'' . htmlspecialchars("update") . '\',' . $row->id . ',\'' . htmlspecialchars("anggota/tampilformunit") . '\')"> <i class="fa fa-pencil-square-o"></i> Ubah Unit</a></li>
                            <li><a class="dropdown-item" onclick="unit.hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_unit) . '\')"><i class="fa fa-trash-o"></i> Hapus
                        ';
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
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $saveMethod = $this->request->getGet('saveMethod');
        $id = $this->request->getGet('id');
        $kategori = ["Divisi", "Fakultas", "Program Studi"];
        $title = "Unit";
        $unit = '';
        if ($id) {
            $unit = $this->getunitbyid($id);
        }
        $data = [
            'id' => $id ? $id : '',
            'saveMethod' => $saveMethod,
            'title' => $title,
            'unit' => $unit,
            'kategori' => $kategori,
        ];

        $msg = [
            'data' => view('anggota/formunit', $data),
        ];

        echo json_encode($msg);
    }

    public function getunitbyid($id)
    {
        $query = $this->unit->find($id);
        $unit = [
            "id" => $query["id"],
            "nama_unit" => $query["nama_unit"],
            "kategori_unit" => $query["kategori_unit"],
            "singkatan" => $query["singkatan"],
            "deskripsi" => $query["deskripsi"],
        ];
        return json_encode($unit);
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
        $isUpdate = $id !== null;

        $rules = [
            'nama_unit' => [
                'label' => 'Nama unit',
                'rules' => 'required' . ($isUpdate ? '' : '|is_unique[unit.nama_unit]'),
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah ada dan tidak boleh sama',
                ],
            ],
            'singkatan' => [
                'label' => 'Singkatan',
                'rules' => 'required' . ($isUpdate ? '' : '|is_unique[unit.singkatan]'),
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah ada dan tidak boleh sama',
                ],
            ],
            'kategori_unit' => [
                'label' => 'Kategori unit',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
            $msg = [
                'error' => $errors,
            ];
        } else {
            $nama_unit = $this->request->getVar('nama_unit');
            $singkatan = $this->request->getVar('singkatan');
            $kategori_unit = $this->request->getVar('kategori_unit');
            $deskripsi = $this->request->getVar('deskripsi');

            $data = [
                'nama_unit' => $nama_unit,
                'singkatan' => $singkatan,
                'kategori_unit' => $kategori_unit,
                'deskripsi' => $deskripsi,
            ];

            if ($isUpdate) {
                $updatedata = $this->unit->setUpdateData($data);
                $this->unit->update($id, $updatedata);
            } else {
                $insertdata = $this->unit->setInsertData($data);
                $this->unit->save($insertdata);
            }
            $msg = [
                'success' => $isUpdate ? "Perubahan data berhasil disimpan" : "Data $nama_unit berhasil disimpan",
            ];
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
        $nama_unit = $inputData["nama_unit"];
        $msg = $this->deleteTemporaryService->softDelete($id, 'unit', $nama_unit);
        echo json_encode($msg);
    }

    public function multipledelete()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $id_unit = $this->request->getVar('id');
        $jmldata = count($id_unit);

        foreach ($id_unit as $id) {
            $this->unit->setSoftDelete($id);
        }

        $msg = [
            'success' => "$jmldata data unit berhasil dihapus secara temporary",
        ];

        echo json_encode($msg);
    }

    public function hapuspermanen($id = null)
    {

        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        if ($id != null) {
            $nama_unit = $this->request->getVar('nama_unit');

            $this->unit->delete($id, true);

            $msg = [
                'success' => "Data unit $nama_unit berhasil dihapus secara permanen",
            ];
        } else {
            $this->unit->purgeDeleted();
            $jmlhapus = $this->unit->db->affectedRows();
            $msg = [
                'success' => "$jmlhapus data unit berhasil dihapus secara permanen",
            ];
        }

        echo json_encode($msg);
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
        $nama_unit = isset($inputData['nama_unit']) ? $inputData['nama_unit'] : "";

        $columnNames = [
            'nama' => 'unit',
            'value' => $nama_unit
        ];

        $msg = $this->restoreService->restoreData('unit', $ids, $columnNames);

        echo json_encode($msg);
    }
}
