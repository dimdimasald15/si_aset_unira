<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Gedung;
use \Hermawan\DataTables\DataTable;


class GedungController extends BaseController
{
    protected $gedung, $uri, $title;
    public function __construct()
    {
        $this->gedung = new Gedung();
        $this->uri = service('uri');
        $this->title = "Gedung";
    }
    public function index()
    {
        $breadcrumb = $this->getBreadcrumb();
        $data = [
            'title' => $this->title,
            'nav' => strtolower($this->title),
            'breadcrumb' => $breadcrumb,
        ];

        return view('gedung/index', $data);
    }

    public function listdatagedung()
    {
        if ($this->request->isAJAX()) {
            $this->db = \Config\Database::connect();

            $builder = $this->db->table('gedung')
                ->select('gedung.id, nama_gedung, prefix, gedung.created_at, gedung.created_by, gedung.deleted_at, kategori.kd_kategori, kategori.nama_kategori')
                ->join('kategori', 'gedung.kat_id=kategori.id');

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder) {
                    $builder->where('gedung.deleted_at', null);
                })
                ->add('action', function ($row) {
                    return '<div class="btn-group mb-1">
                    <button type="button" class="btn btn-success  btn-sm dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="util.getForm(\'' . htmlspecialchars("update") . '\',' . $row->id . ')"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a class="dropdown-item" onclick="gedung.hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_gedung) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a></li>
                    </ul>
                    </div>';
                })
                ->toJson(true);
        } else {
            $data = $this->errorPage404();
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
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getForm()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $saveMethod = $this->request->getGet('saveMethod');
        $id = $this->request->getGet('id');
        $gedung = '';
        if ($id) {
            $gedung = $this->getgedungbyid($id);
        }
        $data = [
            'id' => $id,
            'title' => $this->title,
            'saveMethod' => $saveMethod,
            'gedung' => $gedung,
        ];

        $msg = [
            'data' => view('gedung/form', $data),
        ];

        echo json_encode($msg);
    }

    public function getgedungbyid($id)
    {
        $builder = $this->db->table('gedung g')
            ->select('g.id, g.nama_gedung, g.prefix, g.kat_id, k.nama_kategori')
            ->join('kategori k', 'g.kat_id = k.id')
            ->where('g.id', $id)
            ->get();
        $row = $builder->getRow();

        return json_encode($row);
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
        $rules = [
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
        ];
        if (!$this->validate($rules)) {
            $msg = [
                'error' => [
                    'namagedung' => $validation->getError('nama_gedung'),
                    'prefix' => $validation->getError('prefix'),
                    'katid' => $validation->getError('kat_id'),
                ],
            ];
        } else {
            $data = [
                'nama_gedung' => $this->request->getVar('nama_gedung'),
                'prefix' => $this->request->getVar('prefix'),
                'kat_id' => $this->request->getVar('kat_id'),
            ];

            if ($id === null) {
                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertdata = $this->gedung->setInsertData($data);
                // Simpan data ke database
                $this->gedung->save($insertdata);
                $msg = ['success' => 'Data gedung berhasil tersimpan'];
            } else {
                // Panggil fungsi setUpdateData dari model sebelum data diperbarui
                $updatedata = $this->gedung->setUpdateData($data);
                // Perbarui data di database
                $this->gedung->update($id, $updatedata);
                $msg = ['success' => 'Data gedung: ' . $data['nama_gedung'] . ' berhasil terupdate'];
            }
        }
        echo json_encode($msg);
    }


    public function hapusdata($id)
    {
        if ($this->request->isAJAX()) {
            $inputData = json_decode($this->request->getBody(), true);
            $nama_gedung = $inputData["nama_gedung"];
            try {
                $this->gedung->delete($id, true);

                $msg = [
                    'success' => "Data gedung : $nama_gedung berhasil dihapus",
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
