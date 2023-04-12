<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pengguna;


class ProfileController extends BaseController
{
    protected $uri, $auth, $pengguna;
    public function __construct()
    {

        $this->uri = service('uri');
        $this->pengguna = new Pengguna();
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

        $petugas = $this->pengguna->select('id, foto')->where('username', $_SESSION['username'])->get()->getRow();

        // var_dump($petugas);

        $data = [
            'title' => 'My Profile',
            'nav' => 'profile',
            'id' => $petugas->id,
            'foto' => $petugas->foto,
            'breadcrumb' => $breadcrumb,
        ];
        return view('profile/index', $data);
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
            exit('Maaf tidak dapat diproses');
        }
    }
}
