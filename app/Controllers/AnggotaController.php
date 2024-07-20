<?php

namespace App\Controllers;

use App\Models\Anggota;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;

class AnggotaController extends BaseController
{
    protected $anggota;
    protected $uri;
    public function __construct()
    {
        $this->anggota = new Anggota();
        $this->uri = service('uri');
    }

    public function index()
    {
        $breadcrumb = $this->getBreadcrumb();
        $data = [
            'title' => 'Unit & Anggota',
            'nav' => 'anggota',
            'breadcrumb' => $breadcrumb
        ];

        return view('anggota/index', $data);
    }

    public function listdata()
    {
        if ($this->request->isAJAX()) {
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);

            $builder = $this->db->table('anggota a')->select('a.id, a.no_anggota, a.nama_anggota, a.no_hp, a.level, a.unit_id, a.created_at, a.created_by, a.deleted_by, a.deleted_at, u.nama_unit, u.singkatan')
                ->join('unit u', 'a.unit_id = u.id');

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder) use ($isRestore) {
                    if ($isRestore) {
                        $builder->where('a.deleted_at IS NOT NULL');
                    } else {
                        $builder->where('a.deleted_at', null);
                        $builder->where('u.deleted_at', null);
                    }
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('a.id', 'desc');
                })
                ->add('checkRowAnggota', function ($row) use ($isRestore) {
                    if (!$isRestore) {
                        return '<input type="checkbox" name="id[]" class="checkRowAnggota" value="' . $row->id . '">';
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
                            <li><a class="dropdown-item" onclick="anggota.restore(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-undo"></i> Pulihkan</a></li>
                            <li><a class="dropdown-item" onclick="anggota.hapusPermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a></li>
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
                            <li><a class="dropdown-item" onclick="util.getForm(\'' . htmlspecialchars("update") . '\',' . $row->id . ',\'' . htmlspecialchars("anggota/tampilformanggota") . '\')"> <i class="fa fa-pencil-square-o"></i> Ubah anggota</a></li>
                            <li><a class="dropdown-item" onclick="anggota.hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-trash-o"></i> Hapus
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
        $title = "Anggota";
        $anggota = '';
        if ($id) {
            $anggota = $this->getanggotabyid($id);
        }
        $data = [
            'id' => $id ? $id : '',
            'saveMethod' => $saveMethod,
            'title' => $title,
            'anggota' => $anggota,
        ];

        $msg = [
            'data' => view('anggota/formanggota', $data),
        ];

        echo json_encode($msg);
    }

    public function getanggotabyid($id)
    {
        $builder = $this->db->table('anggota a')->select('a.id, a.nama_anggota, a.no_anggota, a.unit_id, a.level, a.no_hp, u.singkatan')
            ->join('unit u', 'u.id=a.unit_id')->where('a.id', $id)->get()->getRowArray();
        return json_encode($builder);
    }

    public function simpandata()
    {
        if (!$this->request->isAJAX()) {
            return view('errors/mazer/error-404', $this->errorPage404());
        }

        $msg = $this->processData();
        echo json_encode($msg);
    }

    public function updatedata($id)
    {
        if (!$this->request->isAJAX()) {
            return view('errors/mazer/error-404', $this->errorPage404());
        }

        $msg = $this->processData($id);
        echo json_encode($msg);
    }

    private function processData($id = null)
    {
        $validation = \Config\Services::validation();
        $rules = [
            'nama_anggota' => [
                'label' => 'Nama anggota',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
            'no_anggota' => [
                'label' => 'Nomor anggota',
                'rules' => 'required' . ($id ? '' : '|is_unique[anggota.no_anggota]'),
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                    'is_unique' => "{field} sudah ada dan tidak boleh sama",
                ],
            ],
            'level' => [
                'label' => 'Level',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
            'unit_id' => [
                'label' => 'Unit',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return [
                'error' => $validation->getErrors(),
            ];
        }

        $data = [
            'nama_anggota' => $this->request->getVar('nama_anggota'),
            'level' => $this->request->getVar('level'),
            'unit_id' => $this->request->getVar('unit_id'),
            'no_anggota' => $this->request->getVar('no_anggota'),
            'no_hp' => $this->request->getVar('no_hp'),
        ];

        if ($id) {
            $updateData = $this->anggota->setUpdateData($data);
            $this->anggota->update($id, $updateData);
            return [
                'success' => "Data {$data['nama_anggota']} berhasil diubah",
            ];
        } else {
            $insertData = $this->anggota->setInsertData($data);
            $this->anggota->save($insertData);
            return [
                'success' => "Data {$data['nama_anggota']} berhasil disimpan",
            ];
        }
    }

    public function hapusdata($id)
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $inputData = json_decode($this->request->getBody(), true);
        $nama_anggota = $inputData["nama_anggota"];
        try {
            $this->anggota->setSoftDelete($id);

            $msg = [
                'success' => "Data anggota $nama_anggota berhasil dihapus secara sementara",
            ];
            echo json_encode($msg);
        } catch (\Exception $e) {
            $msg = [
                'error' => $e->getMessage(),
            ];
            echo json_encode($msg);
        }
    }

    public function restoredata($id = [])
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $ids = $this->request->getVar('id');
        $id = explode(",", $ids);
        $restoredata = [
            'deleted_by' => null,
            'deleted_at' => null,
        ];
        if (count($id) === 1) {
            foreach ($id as $key => $idanggota) {
                $nama_anggota = $this->request->getVar('nama_anggota');
                $this->anggota->update($idanggota, $restoredata);

                $msg = [
                    'success' => "Data anggota $nama_anggota berhasil dipulihkan",
                ];
            }
        } else {
            foreach ($id as $key => $idanggota) {
                $this->anggota->update($idanggota, $restoredata);
            }

            $msg = [
                'success' => count($id) . " Data anggota berhasil dipulihkan",
            ];
        }

        echo json_encode($msg);
    }

    public function multipledelete()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $id_anggota = $this->request->getVar('id');
        $jmldata = count($id_anggota);

        foreach ($id_anggota as $id) {
            $this->anggota->setSoftDelete($id);
        }

        $msg = [
            'success' => "$jmldata data anggota berhasil dihapus secara temporary",
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
            $nama_anggota = $this->request->getVar('nama_anggota');

            $this->anggota->delete($id, true);

            $msg = [
                'success' => "Data anggota $nama_anggota berhasil dihapus secara permanen",
            ];
        } else {
            $this->anggota->purgeDeleted();
            $jmlhapus = $this->anggota->db->affectedRows();
            $msg = [
                'success' => "$jmlhapus data anggota berhasil dihapus secara permanen",
            ];
        }

        echo json_encode($msg);
    }
}
