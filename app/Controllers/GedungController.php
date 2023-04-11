<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Gedung;
use \Hermawan\DataTables\DataTable;


class GedungController extends BaseController
{
    protected $gedung, $uri;
    public function __construct()
    {
        $this->gedung = new Gedung();
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
            'title' => 'Gedung',
            'nav' => 'gedung',
            'breadcrumb' => $breadcrumb,
        ];

        return view('gedung/index', $data);
    }

    public function listdatagedung()
    {
        // return json_encode('test');
        if ($this->request->isAJAX()) {
            $this->db = \Config\Database::connect();

            $builder = $this->db->table('gedung')
                ->select('gedung.id, nama_gedung, prefix, gedung.created_at, gedung.created_by, gedung.deleted_at, kategori.kd_kategori, kategori.nama_kategori')
                ->join('kategori', 'gedung.kat_id=kategori.id');
            // var_dump($builder);

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder) {
                    $builder->where('gedung.deleted_at', null);
                })
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-warning btn-sm btn-editgedung" onclick="edit(' . $row->id . ')"> <i class="fa fa-pencil-square-o"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_gedung) . '\')"><i class="fa fa-trash-o"></i></button>';
                })
                ->toJson(true);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function pilihkategori()
    {
        if ($this->request->isAJAX()) {
            $caridata = $this->request->getGet('search');
            $datakategori = $this->db->table('kategori')
                ->like('nama_kategori', $caridata)
                ->like('kd_kategori', 'A.02.01.%')
                ->get();
            if ($datakategori->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($datakategori->getResultArray() as $row) {
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['nama_kategori'];

                    $key++;
                }
            } else {
                $list = [
                    ['id' => '', 'text' => 'Maaf keyword yang anda cari tidak ditemukan']
                ];
            }
            echo json_encode($list);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'nama_gedung' => [
                    'label' => 'Nama Gedung',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'prefix' => [
                    'label' => 'Nama Singkat (Prefix)',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kat_id' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'namagedung' => $validation->getError('nama_gedung'),
                        'prefix' => $validation->getError('prefix'),
                        'katid' => $validation->getError('kat_id'),
                    ],
                ];
            } else {
                $simpandata = [
                    'nama_gedung' => $this->request->getVar('nama_gedung'),
                    'prefix' => $this->request->getVar('prefix'),
                    'kat_id' => $this->request->getVar('kat_id'),
                ];

                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertdata = $this->gedung->setInsertData($simpandata);
                // Simpan data ke database
                $this->gedung->save($insertdata);

                $msg = ['sukses' => 'Data gedung berhasil tersimpan'];
            }
            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function get_gedung_by_id($id)
    {
        if ($this->request->isAJAX()) {
            $builder = $this->db->table('gedung g')
                ->select('g.id, g.nama_gedung, g.prefix, g.kat_id, k.nama_kategori')
                ->join('kategori k', 'g.kat_id = k.id')
                ->where('g.id', $id)
                ->get();
            $row = $builder->getRow();

            echo json_encode($row);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function updatedata($id)
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'nama_gedung' => [
                    'label' => 'Nama Gedung',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'prefix' => [
                    'label' => 'Nama Singkat (Prefix)',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kat_id' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'namagedung' => $validation->getError('nama_gedung'),
                        'prefix' => $validation->getError('prefix'),
                        'katid' => $validation->getError('kat_id'),
                    ],
                ];
            } else {
                $updatedata = [
                    'nama_gedung' => $this->request->getVar('nama_gedung'),
                    'prefix' => $this->request->getVar('prefix'),
                    'kat_id' => $this->request->getVar('kat_id'),
                ];

                // Panggil fungsi setInsertData dari model sebelum data diupdate
                $ubahdata = $this->gedung->setUpdateData($updatedata);
                // update data ke database
                $this->gedung->update($id, $ubahdata);


                $msg = ['sukses' => 'Data gedung: ' . $updatedata['nama_gedung'] . ' berhasil terupdate'];
            }
            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function hapusdata($id)
    {
        if ($this->request->isAJAX()) {
            $nama_gedung = $this->request->getVar('nama_gedung');
            try {
                $this->gedung->setSoftDelete($id);

                $msg = [
                    'sukses' => "Data gedung : $nama_gedung berhasil dihapus",
                ];
                echo json_encode($msg);
            } catch (\Exception $e) {
                $msg = [
                    'error' => $e->getMessage(),
                ];
                echo json_encode($msg);
            }
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }
}
