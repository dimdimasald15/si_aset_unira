<?php

namespace App\Controllers;

use App\Models\Gedung;
use App\Models\Pengguna;
use CodeIgniter\Database\Config;
use App\Controllers\BaseController;

class ProfileController extends BaseController
{
    protected $uri, $auth, $pengguna, $gedung;
    public function __construct()
    {

        $this->uri = service('uri');
        $this->pengguna = new Pengguna();
        $this->gedung = new Gedung();
        $this->auth = service('auth');
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

        $petugas = $this->pengguna->select('id, nip, username, email, foto, role')->where('username', $_SESSION['username'])->get()->getRow();

        // var_dump($petugas);

        $data = [
            'title' => 'My Profile',
            'petugas' => $petugas,
            'breadcrumb' => $breadcrumb,
        ];
        return view('profile/index', $data);
    }

    public function getfotobyusername()
    {
        if ($this->request->isAJAX()) {
            $username = $this->request->getVar('username');

            $profil = $this->db->table('petugas')->select('foto')->where('username', $username)->get()->getRow();

            $msg = [
                'foto' => $profil->foto,
            ];

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function ubahpassword()
    {
        if ($this->request->isAJAX()) {
            $model = new Pengguna();

            // Validasi inputan form
            $rules = [
                'password_lama' => [
                    'label' => 'Password Lama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password Lama harus diisi.'
                    ]
                ],
                'password_baru' => [
                    'label' => 'Password Baru',
                    'rules' => 'required|min_length[8]',
                    'errors' => [
                        'required' => 'Password Baru harus diisi.',
                        'min_length' => 'Password Baru minimal 8 karakter.'
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                // Jika ada kesalahan validasi, kembalikan error dalam bentuk JSON
                $errors = [
                    'password_lama' => $this->validator->getError('password_lama'),
                    'password_baru' => $this->validator->getError('password_baru'),
                ];

                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $errors,
                ]);
            }

            // Ambil user dari session
            $username = session('username');
            $user = $model->where('username', $username)->first();

            // Cek apakah password lama sesuai dengan yang ada di database
            if (!password_verify($this->request->getVar('password_lama'), $user['password'])) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => [
                        'password_lama' => 'Password Lama tidak sesuai.',
                    ],
                ]);
            }

            // Update password baru ke database
            $model->update($user['id'], [
                'password' => password_hash($this->request->getVar('password_baru'), PASSWORD_DEFAULT),
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Password berhasil diubah.',
            ]);
        }
    }

    public function gantifoto()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            // var_dump($id);
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'foto' => [
                    'label' => 'Foto',
                    'rules' => 'uploaded[foto]|mime_in[foto,image/png,image/jpeg,image/jpg]|is_image[foto]',
                    'errors' => [
                        'uploaded' => '{field} harus diunggah',
                        'mime_in' => 'Harus dalam bentuk gambar',

                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'foto' => $validation->getError('foto'),
                    ]
                ];
            } else {
                // cek data foto
                $cekdata = $this->pengguna->find($id);

                $fotolama = $cekdata['foto'];
                if ($fotolama != NULL || $fotolama != "") {
                    unlink(FCPATH . '/uploads/' . $fotolama);
                }

                // tangkap file foto
                $filefoto = $this->request->getFile('foto');
                $filename = $filefoto->getName();


                // $namafile = str_replace('.jpg', '', $namafile);

                $filefoto->move(FCPATH . '/uploads/', $filename);

                $updatefoto = [
                    'foto' => $filename
                ];

                $ubahfoto = $this->pengguna->setUpdateData($updatefoto);
                $this->pengguna->update($id, $ubahfoto);

                $msg = [
                    'sukses' => 'File foto berhasil diupload'
                ];
            }

            return $this->response->setJSON($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampilformeditprofil()
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }

        $nip = $this->request->getVar('nip');

        $data = [
            'nip' => $nip,
            'nav' => 'profile',
            'title' => 'Profile',
            'saveMethod' => 'update',
        ];

        $msg = [
            'data' => view('profile/formeditpetugas', $data)
        ];

        echo json_encode($msg);
    }

    public function getprofilebynip()
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
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
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
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
                $msg = ['sukses' => 'Data pengguna: ' . $updatedata['role'] . ' berhasil terupdate'];
            }
        }

        echo json_encode($msg);
    }
}
