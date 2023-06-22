<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    protected $db;
    protected $session;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        // Jika pengguna telah login, alihkan ke halaman dashboard
        if ($this->session->has('isLoggedIn') && $this->session->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }

        // Jika pengguna belum login, tampilkan halaman login
        $data = [
            'title' => 'Login | SI Aset UNIRA'
        ];

        return view('login/index', $data);
    }

    public function login()
    {
        if ($this->request->isAJAX()) {
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'email' => $validation->getError('email'),
                        'password' => $validation->getError('password'),
                    ],
                ];
            } else {
                //cek user dulu ke database
                $query_email = $this->db->query("SELECT * FROM petugas WHERE email = '$email'");
                //object
                $result = $query_email->getResult();

                if (count($result) > 0) {
                    //Jika username ada maka lanjutkan verifikasi password
                    $row = $query_email->getRow();
                    $password_user = $row->password;

                    if (password_verify($password, $password_user)) {
                        //Jika password benar, maka buat session
                        $login = [
                            'isLoggedIn' => 1,
                            'id' => $row->id,
                            'username' => $row->username,
                            'role' => $row->role,
                            'foto' => $row->foto
                        ];

                        $this->session->set($login);

                        $msg = [
                            'sukses' => [
                                'link' => base_url() . 'admin/dashboard',
                            ]
                        ];
                    } else {
                        $msg = [
                            'error' => [
                                'password' => 'Password anda salah, masukkan password yang benar',
                            ],
                        ];
                    }
                } else {
                    $msg = [
                        'error' => [
                            'email' => 'email anda tidak ditemukan',
                        ],
                    ];
                }
            }
            echo json_encode($msg);
        } else exit('Maaf tidak dapat diproses');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('auth');
    }
}
