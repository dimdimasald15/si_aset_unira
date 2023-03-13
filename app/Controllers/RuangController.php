<?php

namespace App\Controllers;
// namespace App\Controllers\Admin;

use App\Models\Ruang;
use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;

class RuangController extends BaseController
{
    protected $ruang;

    public function __construct()
    {
        $this->ruang = new Ruang();
    }

    public function index()
    {
        $data = [
            'title' => 'Ruang',
            'nav' => 'ruang',
        ];

        return view('ruang/index', $data);
    }

    public function listdataruang()
    {
        if ($this->request->isAJAX()) {

            $builder = $this->db->table('ruang')
                ->select('ruang.id,nama_ruang, nama_lantai, ruang.created_at, ruang.created_by, ruang.deleted_at, gedung.prefix, gedung.nama_gedung')
                ->join('gedung', 'ruang.gedung_id = gedung.id');

            return DataTable::of($builder)
                ->filter(function ($builder) {
                    $builder->where('ruang.deleted_at', null);
                })
                ->postQuery(function ($builder) {
                    // $builder->orderBy('customerNumber', 'desc');
                    $builder->orderBy('ruang.id', 'desc');
                })
                //<button type="button" class="btn btn-primary btn-sm" onclick="alert(\'edit customer: '.$row->customerName.'\') ><i class="fas fa-edit"></i></button>
                ->addNumbering('no')
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-warning btn-sm btn-editruang" onclick="edit(' . $row->id . ')"> <i class="fa fa-pencil-square-o"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-trash-o"></i></button>';
                })
                ->toJson(true);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }
    // public function ceknamaruang()
    // {
    //     $nama_ruang = $this->request->getPost("nama_ruang");
    //     $isNamaruangtersedia = $this->modelruang->ceknamaruang($nama_ruang);
    //     if ($isNamaruangtersedia) {
    //         $response = [
    //             'status' => 'success',
    //             'msg' => 'nama ruang belum ada',
    //         ];
    //     } else {
    //         $response = [
    //             'status' => 'error',
    //             'msg' => "nama ruang sudah ada",
    //         ];
    //     }
    //     return $this->response->setJSON($response);
    // }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'nama_ruang' => [
                    'label' => 'Nama Ruang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'nama_lantai' => [
                    'label' => 'Nama Lantai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'gedung_id' => [
                    'label' => 'Nama Gedung',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'namaruang' => $validation->getError('nama_ruang'),
                        'namalantai' => $validation->getError('nama_lantai'),
                        'gedungid' => $validation->getError('gedung_id'),
                    ],
                ];
            } else {
                $simpandata = [
                    'nama_ruang' => $this->request->getVar('nama_ruang'),
                    'nama_lantai' => $this->request->getVar('nama_lantai'),
                    'gedung_id' => $this->request->getVar('gedung_id'),
                ];

                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertdata = $this->ruang->setInsertData($simpandata);
                // Simpan data ke database
                $this->ruang->save($insertdata);

                $msg = ['sukses' => 'Data Ruang berhasil tersimpan'];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function get_ruang_by_id($id)
    {
        if ($this->request->isAJAX()) {
            // $id = $this->request->getVar('id');
            $row = $this->ruang->find($id);
            echo json_encode($row);
        } else exit('Maaf tidak dapat diproses');
    }

    public function updatedata($id)
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'nama_ruang' => [
                    'label' => 'Nama Ruang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'nama_lantai' => [
                    'label' => 'Nama Lantai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'gedung_id' => [
                    'label' => 'Nama Gedung',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'namaruang' => $validation->getError('nama_ruang'),
                        'namalantai' => $validation->getError('nama_lantai'),
                        'gedungid' => $validation->getError('gedung_id'),
                    ],
                ];
            } else {
                $updatedata = [
                    'nama_ruang' => $this->request->getVar('nama_ruang'),
                    'nama_lantai' => $this->request->getVar('nama_lantai'),
                    'gedung_id' => $this->request->getVar('gedung_id'),
                ];
                // var_dump($this->ruang);
                $ubahdata = $this->ruang->setUpdateData($updatedata);

                $msg = [
                    'sukses' => 'Data ruangan: ' . $updatedata['nama_ruang'] . '  berhasil terupdate',
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat diproses');
        }
    }

    public function hapusdata($id)
    {
        if ($this->request->isAJAX()) {
            $nama_ruang = $this->request->getVar('nama_ruang');
            try {
                $this->ruang->setSoftDelete($id);

                $msg = [
                    'sukses' => "Data ruangan $nama_ruang berhasil dihapus",
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
