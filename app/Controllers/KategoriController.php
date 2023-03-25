<?php

namespace App\Controllers;

use App\Models\Kategori;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;

class KategoriController extends BaseController
{
    protected $kategori, $uri;
    public function __construct()
    {
        $this->kategori = new Kategori();
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
            'nav' => 'kategori',
            'title' => 'Kategori',
            'breadcrumb' => $breadcrumb
        ];

        return view('kategori/index', $data);
    }

    public function listdataKategori()
    {
        if ($this->request->isAJAX()) {
            $this->db = \Config\Database::connect();
            $builder = $this->db->table('kategori')->select('id,kd_kategori, nama_kategori, deskripsi, created_by, created_at, deleted_at');

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder) {
                    $builder->where('deleted_at', null);
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('created_at', 'desc');
                })
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-warning btn-sm btn-editgedung" onclick="edit(' . $row->id . ')"> <i class="fa fa-pencil-square-o"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_kategori) . '\')"><i class="fa fa-trash-o"></i></button>';
                })
                ->toJson(true);
        } else {
            exit("Maaf tidak dapat diproses");
        }
    }

    public function getsubkode1()
    {
        if ($this->request->isAJAX()) {
            $query = $this->db->query('SELECT DISTINCT SUBSTRING(kd_kategori, 1, 1) AS kode FROM kategori ORDER BY kode');
            $result = $query->getResultArray();

            echo json_encode($result);
        } else {
            exit("Maaf, tidak dapat diproses.");
        }
    }

    public function getsubkode2()
    {
        if ($this->request->isAJAX()) {
            $subkode1 = $this->request->getVar('subkode1');
            $query = $this->db->table('kategori')
                ->select("DISTINCT SUBSTRING_INDEX(SUBSTRING_INDEX(kd_kategori, '.', 2), '.', -1) AS subkode2")
                ->whereIn("SUBSTRING_INDEX(kd_kategori, '.', 1)", explode(',', $subkode1))
                ->whereNotIn("SUBSTRING_INDEX(kd_kategori, '.', 2)", [$subkode1])
                ->get();
            $result = $query->getResult();
            echo json_encode($result);
        } else {
            echo "Maaf, tidak dapat diproses.";
        }
    }

    public function getsubkode3()
    {
        if ($this->request->isAJAX()) {
            $subkode1 = $this->request->getVar('subkode1');
            $subkode2 = $this->request->getVar('subkode2');
            $query = $this->db->query("SELECT DISTINCT SUBSTRING(kd_kategori, 6, 2) AS subkode3
            FROM kategori
            WHERE SUBSTRING(kd_kategori, 1, 1) = '$subkode1'
            AND SUBSTRING(kd_kategori, 3, 2) IN ('$subkode2')
            ORDER BY subkode3 ASC");
            $result = $query->getResult();
            echo json_encode($result);
        } else {
            echo "Maaf, tidak dapat diproses.";
        }
    }

    public function getsubkode4()
    {
        if ($this->request->isAJAX()) {
            $subkode1 = $this->request->getVar('subkode1');
            $subkode2 = $this->request->getVar('subkode2');
            $subkode3 = $this->request->getVar('subkode3');
            $query = $this->db->query("SELECT DISTINCT SUBSTRING_INDEX(kd_kategori, '.', -1) AS subkode4
            FROM kategori
            WHERE SUBSTRING_INDEX(SUBSTRING_INDEX(kd_kategori, '.', 1), '.', -1) = '$subkode1'
            AND SUBSTRING_INDEX(SUBSTRING_INDEX(kd_kategori, '.', 2), '.', -1) = '$subkode2'
            AND SUBSTRING_INDEX(SUBSTRING_INDEX(kd_kategori, '.', 3), '.', -1) = '$subkode3'
            GROUP BY subkode4
            HAVING COUNT(subkode4) >= 1;");
            $result = $query->getResult();
            echo json_encode($result);
        } else {
            echo "Maaf, tidak dapat diproses.";
        }
    }

    public function getnamakategori()
    {
        if ($this->request->isAJAX()) {
            $subkode1 = $this->request->getPost('subkode1');
            $subkode2 = $this->request->getPost('subkode2');
            $subkode3 = $this->request->getPost('subkode3');
            $subkode4 = $this->request->getPost('subkode4');
            $kode = '';
            if ($subkode2 == '' && $subkode3 == '' && $subkode4 == '') {
                $kode = $subkode1;
            } else if ($subkode3 == '' && $subkode4 == '') {
                $kode = $subkode1 . '.' . $subkode2;
            } else if ($subkode4 == '') {
                $kode = $subkode1 . '.' . $subkode2 . '.' . $subkode3;
            } else {
                $kode = $subkode1 . '.' . $subkode2 . '.' . $subkode3 . '.' . $subkode4;
            }

            $query = $this->db->table('kategori')
                ->where('kd_kategori', $kode)
                ->get();
            $result = $query->getRow();
            echo json_encode($result);
        } else {
            echo "Maaf, tidak dapat diproses.";
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kd_kategori' => [
                    'label' => 'Kode Kategori',
                    'rules' => 'required|is_unique[kategori.kd_kategori]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada dan tidak boleh sama',
                    ],
                ],
                'nama_kategori' => [
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
                        'kdkat' => $validation->getError('kd_kategori'),
                        'nama_kategori' => $validation->getError('nama_kategori'),
                        'deskripsi' => $validation->getError('deskripsi'),
                    ],
                ];
            } else {
                $simpandata = [
                    'kd_kategori' => $this->request->getVar('kd_kategori'),
                    'nama_kategori' => $this->request->getVar('nama_kategori'),
                    'deskripsi' => $this->request->getVar('deskripsi'),
                ];

                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertdata = $this->kategori->setInsertData($simpandata);
                // Simpan data ke database
                $this->kategori->save($insertdata);

                $msg = ['sukses' => 'Data kategori berhasil tersimpan'];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function get_kategori_by_id($id)
    {
        if ($this->request->isAJAX()) {
            $builder =  $this->db->table('kategori')
                ->select('*')
                ->where('id', $id)
                ->get();

            $row = $builder->getRow();

            echo json_encode($row);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    public function updatedata($id)
    {
        if ($this->request->isAJAX()) {
            if ($this->request->isAJAX()) {
                $validation =  \Config\Services::validation();

                $valid = $this->validate([
                    'kd_kategori' => [
                        'label' => 'Kode Kategori',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                            // 'is_unique' => '{field} sudah ada dan tidak boleh sama',
                        ],
                    ],
                    'nama_kategori' => [
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
                            'kdkat' => $validation->getError('kd_kategori'),
                            'nama_kategori' => $validation->getError('nama_kategori'),
                            'deskripsi' => $validation->getError('deskripsi'),
                        ],
                    ];
                } else {
                    $updatedata = [
                        'kd_kategori' => $this->request->getVar('kd_kategori'),
                        'nama_kategori' => $this->request->getVar('nama_kategori'),
                        'deskripsi' => $this->request->getVar('deskripsi'),
                    ];

                    // Panggil fungsi setInsertData dari model sebelum data diupdate
                    $ubahdata = $this->kategori->setUpdateData($updatedata);
                    // update data ke database
                    $this->kategori->update($id, $ubahdata);


                    $msg = ['sukses' => 'Data kategori: ' . $updatedata['nama_kategori'] . ' berhasil terupdate'];
                }
                echo json_encode($msg);
            } else {
                echo 'Maaf tidak dapat diproses';
            }
        }
    }

    public function hapusdata($id)
    {
        if ($this->request->isAJAX()) {
            $nama_kategori = $this->request->getVar('nama_kategori');
            try {
                $this->kategori->setSoftDelete($id);

                $msg = [
                    'sukses' => "Data kategori : $nama_kategori berhasil dihapus",
                ];
                echo json_encode($msg);
            } catch (\Exception $e) {
                $msg = [
                    'error' => $e->getMessage(),
                ];
                echo json_encode($msg);
            }
        } else exit('Maaf tidak dapat diproses');
    }
}
