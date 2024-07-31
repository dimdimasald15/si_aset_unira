<?php

namespace App\Controllers;

use App\Models\Pengguna;
use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    protected $uri;
    protected $auth;
    protected $pengguna;
    public function __construct()
    {
        $this->uri = service('uri');
        $this->pengguna = new Pengguna();
        $this->auth = service('auth');
    }

    public function index()
    {
        $breadcrumb = $this->getBreadcrumb();
        $petugas = $this->pengguna->select('id, nip, username, email, foto, role')->where('username', $_SESSION['username'])->get()->getRow();
        $data = [
            'title' => 'My Profile',
            'nav' => 'profile',
            'petugas' => $petugas,
            'breadcrumb' => $breadcrumb,
        ];
        return view('profile/index', $data);
    }

    public function tampilform()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $id = $this->request->getVar('id');
        $saveMethod = $this->request->getVar('save$saveMethod');
        $view = "profile/formubahpassword";
        $data = [
            'id' => $id,
            'saveMethod' => $saveMethod,
        ];
        $msg = [
            'data' => view($view, $data),
        ];

        echo json_encode($msg);
    }

    public function ubahpassword()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $validation = \Config\Services::validation();
        $rules = [
            'password_lama' => [
                'label' => 'Password Lama',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.'
                ]
            ],
            'password_baru' => [
                'label' => 'Password Baru',
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => '{field} tidak boleh kosong.',
                    'min_length' => '{field} minimal 8 karakter.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
        }
        // check for errors
        if (!empty($errors)) {
            $msg = [
                'error' => $errors
            ];
        } else {
            // Ambil user dari session
            $id = $this->request->getVar('id');
            $user = $this->pengguna->where('id', $id)->first();
            // Cek apakah password lama sesuai dengan yang ada di database
            if (!password_verify($this->request->getVar('password_lama'), $user['password'])) {
                $msg = [
                    'error' => [
                        'password_lama' => 'Password lama tidak sesuai.',
                    ],
                ];
            } else {
                // Update password baru ke database
                $this->pengguna->update($id, [
                    'password' => password_hash($this->request->getVar('password_baru'), PASSWORD_DEFAULT),
                ]);
                $msg = [
                    'success' => 'Password berhasil diubah.',
                ];
            }
        }
        echo json_encode($msg);
    }

    public function gantifoto()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $id = $this->session->get('id');
        // cek data foto
        $cekdata = $this->pengguna->find($id);
        $fotolama = $cekdata['foto'];
        if ($fotolama != NULL || $fotolama != "") {
            unlink(FCPATH . '/uploads/' . $fotolama);
        }

        // tangkap file foto
        $filefoto = $this->request->getFile('foto');
        $filename = $filefoto->getClientName();
        if ($cekdata['foto'] !== $filename) {
            // Cek apakah terdapat perubahan pada foto
            if ($cekdata['foto'] !== $filename) {
                // Jika foto berubah, set ulang session
                $login = [
                    'isLoggedIn' => 1,
                    'username' => $cekdata['username'],
                    'role' => $cekdata['role'],
                    'foto' => $filename
                ];
                $this->session->set($login);
            }
        }
        $filefoto->move(FCPATH . '/uploads/', $filename);

        $updatefoto = [
            'foto' => $filename
        ];

        $ubahfoto = $this->pengguna->setUpdateData($updatefoto);
        $this->pengguna->update($id, $ubahfoto);

        $msg = [
            'success' => 'File foto berhasil diupload',
            'image_url' => base_url() . "/uploads/$filename"
        ];
        return $this->response->setJSON($msg);
    }

    public function getprofilebynip()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $nip = $this->request->getGet('nip');

        $query = $this->db->table('petugas')->select('*')->where('nip', $nip);
        $petugas = $query->get()->getRow();

        echo json_encode($petugas);
    }

    public function updatedata($id)
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $validation = \Config\Services::validation();
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
        $errors = [];
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
            $msg = [
                'error' => $errors
            ];
        } else {
            $this->db->transStart();
            $newusername = $this->request->getVar('username');
            $datalama = $this->pengguna->find($id);
            if ($datalama['username'] !== $newusername) {
                // Cek apakah terdapat perubahan pada username
                if ($datalama['username'] !== $newusername) {
                    // Jika username berubah, set ulang session
                    $login = [
                        'isLoggedIn' => 1,
                        'username' => $newusername,
                        'role' => $datalama['role'],
                        'foto' => $datalama['foto']
                    ];
                    $this->session->set($login);

                    // Update konten tabel yang memiliki kolom created_by, updated_by, dan deleted_by
                    $tablesToUpdate = ['gedung', 'petugas', 'anggota', 'barang', 'kategori', 'peminjaman', 'permintaan', 'riwayat_barang', 'riwayat_transaksi', 'ruang', 'satuan', 'stok_barang', 'unit', 'pelaporan_kerusakan', 'notifikasi']; // Ganti 'tabel_lain' dengan nama tabel lain yang perlu diupdate
                    foreach ($tablesToUpdate as $table) {
                        $where = "created_by='" . $datalama['username'] . "' OR updated_by='" . $datalama['username'] . "' OR deleted_by='" . $datalama['username'] . "'";
                        $namatable = $this->db->table($table)
                            ->select('*')
                            ->where($where)
                            ->get()->getResultArray();
                        foreach ($namatable as $row) {
                            $data = [];
                            if ($row['created_by'] == $datalama['username']) {
                                $data['created_by'] = $newusername;
                            }
                            if ($row['updated_by'] == $datalama['username']) {
                                $data['updated_by'] = $newusername;
                            }
                            if ($row['deleted_by'] == $datalama['username']) {
                                $data['deleted_by'] = $newusername;
                            }

                            $this->db->table($table)->where('id', $row['id'])->update($data);
                        }
                    }
                }
            }

            $updatedata = [
                'nip' => $this->request->getVar('nip'),
                'email' => $this->request->getVar('email'),
                'username' => $newusername,
                'role' => $this->request->getVar('role'),
            ];

            // Panggil fungsi setInsertData dari model sebelum data diupdate
            $ubahdata = $this->pengguna->setUpdateData($updatedata);
            // update data ke database
            $this->pengguna->update($id, $ubahdata);

            $this->db->transComplete();
            if ($this->db->transStatus() === false) {
                // Jika terjadi kesalahan pada transaction
                $msg = [
                    'error' => [
                        'transaction' => 'Gagal menyimpan perubahan profile data',
                    ]
                ];
            } else {
                $msg = ['success' => "Data pengguna: $newusername sebagai " . strtolower($updatedata['role']) . " berhasil diperbarui"];
            }
        }

        echo json_encode($msg);
    }
}
