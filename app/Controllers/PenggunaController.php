<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pengguna;
use \Hermawan\DataTables\DataTable;

class PenggunaController extends BaseController
{
    protected $pengguna, $uri, $title;
    public function __construct()
    {
        $this->pengguna = new Pengguna();
        $this->uri = service('uri');
        $this->title = "Pengguna";
    }

    public function index()
    {
        $breadcrumb = $this->getBreadcrumb();
        $data = [
            'title' => $this->title,
            'nav' => 'pengguna',
            'breadcrumb' => $breadcrumb,
        ];
        return view('pengguna/index', $data);
    }

    public function listdata()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $id = session()->get('id');
        $builder = $this->db->table('petugas')
            ->select('id, nip, email, username, password, role, created_by, created_at, deleted_at')
            ->where("id !=", $id);
        return DataTable::of($builder)
            ->addNumbering('no')
            ->filter(function ($builder) {
                $builder->where('deleted_at', null);
            })
            ->add('action', function ($row) {
                return '<div class="btn-group mb-1">
                    <button type="button" class="btn btn-success  btn-sm dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="util.getForm(\'' . htmlspecialchars("update") . '\',' . $row->id . ')"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="dropdown-item" onclick="users.hapus(' . $row->id . ', \'' . htmlspecialchars($row->email) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a></li>
                    </ul>
                    </div>';
            })
            ->toJson(true);
    }

    public function getForm()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $saveMethod = $this->request->getGet('saveMethod');
        $id = $this->request->getGet('id');
        $pengguna = '';
        if ($id) {
            $pengguna = $this->getpenggunabyid($id);
        }
        $data = [
            'id' => $id,
            'title' => $this->title,
            'saveMethod' => $saveMethod,
            'pengguna' => $pengguna,
        ];
        $msg = [
            'data' => view('pengguna/form', $data),
        ];
        echo json_encode($msg);
    }

    public function getpenggunabyid($id)
    {
        $id = $this->request->getVar('id');
        $builder = $this->db->table('petugas')
            ->select('*')
            ->where('petugas.id', $id)
            ->get();
        $row = $builder->getRow();
        $data = [
            'nip' => $row->nip,
            'email' => $row->email,
            'username' => $row->username,
            'role' => $row->role,
        ];
        return json_encode($data);
    }

    private function validasiData($isUpdate = false)
    {
        $rules = [
            'nip' => [
                'label' => 'NIP',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'valid_email' => '{field} tidak valid'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih {field} pengguna',
                ]
            ],
        ];

        if (!$isUpdate) {
            $rules['password'] = [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ]
            ];
        }

        return $this->validate($rules);
    }

    public function simpandata()
    {
        if (!$this->request->isAJAX()) {
            return $this->responseError404();
        }

        if (!$this->validasiData()) {
            return $this->responseValidationError();
        }

        $simpandata = [
            'nip' => $this->request->getVar('nip'),
            'email' => $this->request->getVar('email'),
            'username' => $this->request->getVar('username'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getVar('role'),
        ];

        $this->pengguna->save($simpandata);

        return $this->response->setJSON(['success' => 'Data pengguna berhasil tersimpan']);
    }

    public function updatedata($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->responseError404();
        }

        if (!$this->validasiData(true)) {
            return $this->responseValidationError();
        }

        $updatedata = [
            'nip' => $this->request->getVar('nip'),
            'email' => $this->request->getVar('email'),
            'username' => $this->request->getVar('username'),
            'role' => $this->request->getVar('role'),
        ];

        $this->pengguna->update($id, $updatedata);

        return $this->response->setJSON(['success' => 'Data pengguna berhasil diperbarui']);
    }

    private function responseValidationError()
    {
        $validation = \Config\Services::validation();
        $errors = [
            'nip' => $validation->getError('nip'),
            'email' => $validation->getError('email'),
            'username' => $validation->getError('username'),
            'password' => $validation->getError('password'),
            'role' => $validation->getError('role'),
        ];

        return $this->response->setJSON(['error' => $errors]);
    }

    private function responseError404()
    {
        $data = $this->errorPage404();
        return view('errors/mazer/error-404', $data);
    }




    public function hapusdata($id)
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $inputData = json_decode($this->request->getBody(), true);
        $email = $inputData["email"];
        try {
            $this->pengguna->delete($id, true);
            $msg = [
                'success' => "Data pengguna : $email berhasil dihapus",
            ];
            echo json_encode($msg);
        } catch (\Exception $e) {
            $msg = [
                'error' => $e->getMessage(),
            ];
            echo json_encode($msg);
        }
    }
}
