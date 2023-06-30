<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pengguna;
use \Hermawan\DataTables\DataTable;

class PenggunaController extends BaseController
{
    protected $pengguna;
    protected $uri;
    public function __construct()
    {
        $this->pengguna = new Pengguna();
        $this->uri = service('uri');
    }
    public function index()
    {
        $segments = $this->uri->getSegments();
        $breadcrumb = [];
        $link = '';

        foreach ($segments as $segment) {
            $link .= '/' . $segment;
            $breadcrumb[] = ['name' => ucfirst($segment), 'link' => $link];
        }
        $data = [
            'title' => 'Pengguna',
            'nav' => 'pengguna',
            'breadcrumb' => $breadcrumb,
        ];

        return view('pengguna/index', $data);
    }

    public function listdatapengguna()
    {
        if ($this->request->isAJAX()) {
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
                    return '<button type="button" class="btn btn-warning btn-sm btn-editpengguna" onclick="edit(' . $row->id . ')"> <i class="fa fa-pencil-square-o"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->email) . '\')"><i class="fa fa-trash-o"></i></button>';
                })
                ->toJson(true);
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
                'password' => [
                    'label' => 'Password',
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
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'nip' => $validation->getError('nip'),
                        'email' => $validation->getError('email'),
                        'username' => $validation->getError('username'),
                        'password' => $validation->getError('password'),
                        'role' => $validation->getError('role'),
                    ],
                ];
            } else {
                $simpandata = [
                    'nip' => $this->request->getVar('nip'),
                    'email' => $this->request->getVar('email'),
                    'username' => $this->request->getVar('username'),
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'role' => $this->request->getVar('role'),
                ];

                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertdata = $this->pengguna->setInsertData($simpandata);
                // Simpan data ke database
                $this->pengguna->save($insertdata);

                $msg = ['sukses' => 'Data pengguna berhasil tersimpan'];
            }
            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function updatedata($id)
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
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
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'nip' => $validation->getError('nip'),
                        'email' => $validation->getError('email'),
                        'username' => $validation->getError('username'),
                        'role' => $validation->getError('role'),
                    ],
                ];
            } else {
                $updatedata = [
                    'nip' => $this->request->getVar('nip'),
                    'email' => $this->request->getVar('email'),
                    'username' => $this->request->getVar('username'),
                    'role' => $this->request->getVar('role'),
                ];

                // Panggil fungsi setInsertData dari model sebelum data diupdate
                $ubahdata = $this->pengguna->setUpdateData($updatedata);
                // update data ke database
                $this->pengguna->update($id, $ubahdata);


                $msg = ['sukses' => 'Data pengguna: ' . $updatedata['role'] . ' berhasil terupdate'];
            }
            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getpenggunabyid()
    {
        // var_dump($id);
        if ($this->request->isAJAX()) {
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
            // var_dump($row->password);

            echo json_encode($data);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function hapusdata($id)
    {
        if ($this->request->isAJAX()) {
            $email = $this->request->getVar('email');
            try {
                $this->pengguna->setSoftDelete($id);

                $msg = [
                    'sukses' => "Data pengguna : $email berhasil dihapus",
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
