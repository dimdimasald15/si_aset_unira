<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pengguna;

class Auth extends BaseController
{
    protected $db, $session, $users;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->users = new Pengguna();
    }
    public function hash()
    {
        return password_hash("petugas", PASSWORD_BCRYPT);
    }
    public function index()
    {
        // Jika pengguna telah login, alihkan ke halaman dashboard
        if ($this->session->has('isLoggedIn') && $this->session->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }

        // Jika pengguna belum login, tampilkan halaman login
        $data = [
            'title' => 'Login'
        ];

        return view('login/index', $data);
    }

    public function login()
    {
        // if (!$this->request->isAJAX()) {
        //     exit('Maaf tidak dapat diproses'); 
        // } 
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
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            $user = $this->users->where('email', $email)->first();
            if ($user === NULL) {
                $msg = [
                    'error' => [
                        'email' => 'email anda tidak ditemukan',
                    ],
                ];
            } else {
                $password_user = $user['password'];
                if (password_verify($password, $password_user)) {
                    $payload = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => $user['role'],
                        'email' => $user['email'],
                        'foto' => $user['foto'],
                        'iat' => time(),
                        'exp' => time() + (2 * 60 * 60), // 1 jam
                    ];

                    $token = generateJWT($payload);
                    $this->db->query("UPDATE petugas SET api_token = '$token' WHERE id = '{$user['id']}'");
                    //Jika password benar, maka buat session
                    $login = [
                        'isLoggedIn' => 1,
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => $user['role'],
                        'foto' => $user['foto'],
                        'token' => $token,
                    ];

                    $this->session->set($login);

                    $msg = [
                        'success' => [
                            'token' => $token,
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
            }
        }
        echo json_encode($msg);
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('auth');
    }
}
