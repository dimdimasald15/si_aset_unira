<?php

namespace App\Controllers;

use App\Models\Unit;
use App\Models\Anggota;

use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
// use CodeIgniter\Exceptions\PageNotFoundException;
// use RuntimeException;
use CodeIgniter\Database\Exceptions\DatabaseException;

class AnggotaController extends BaseController
{
    protected $anggota, $unit, $uri;
    public function __construct()
    {
        $this->anggota = new Anggota();
        $this->unit = new Unit();
        $this->uri = service('uri');
    }

    public function index()
    {
        $segments = $this->uri->getSegments();
        $breadcrumb = [];
        $link = '';

        foreach ($segments as $segment) {
            $link .= '/' . $segment;
            $name = ucwords(str_replace('-', ' ', $segment));
            $breadcrumb[] = ['name' => $name, 'link' => $link];
        }
        $data = [
            'title' => 'Unit & Anggota',
            'nav' => 'anggota',
            'breadcrumb' => $breadcrumb
        ];

        return view('anggota/index', $data);
    }

    public function listdataunit()
    {
        if ($this->request->isAJAX()) {
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);

            $builder = $this->db->table('unit')
                ->select('id, nama_unit, singkatan, deskripsi, kategori_unit, created_at, created_by, deleted_by, deleted_at');
            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder) use ($isRestore) {
                    if ($isRestore) {
                        $builder->where('deleted_at IS NOT NULL');
                    } else {
                        $builder->where('deleted_at', null);
                    }
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('id', 'desc');
                })
                ->add('checkRowUnit', function ($row) use ($isRestore) {
                    if (!$isRestore) {
                        return '<input type="checkbox" name="id[]" class="checkRowUnit" value="' . $row->id . '">';
                    }
                })
                ->add('action', function ($row) use ($isRestore) {
                    if ($isRestore) {
                        return '
                        <div class="btn-group mb-1">
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu shadow-lg">
                            <li><a class="dropdown-item" onclick="restoreunit(' . $row->id . ', \'' . htmlspecialchars($row->nama_unit) . '\')"><i class="fa fa-undo"></i> Pulihkan</a></li>
                            <li><a class="dropdown-item" onclick="hapuspermanenunit(' . $row->id . ', \'' . htmlspecialchars($row->nama_unit) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a></li>
                        </ul>
                        </div>
                        ';
                    } else {
                        return '
                        <div class="btn-group mb-1">
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu shadow-lg">
                            <li><a class="dropdown-item" onclick="editunit(' . $row->id . ')"> <i class="fa fa-pencil-square-o"></i> Ubah Unit</a></li>
                            <li><a class="dropdown-item" onclick="hapusunit(' . $row->id . ', \'' . htmlspecialchars($row->nama_unit) . '\')"><i class="fa fa-trash-o"></i> Hapus
                        ';
                    }
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

    public function listdataanggota()
    {
        if ($this->request->isAJAX()) {
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);

            $builder = $this->db->table('anggota a')->select('a.id, a.no_anggota, a.nama_anggota, a.no_hp, a.level, a.unit_id, a.created_at, a.created_by, a.deleted_by, a.deleted_at, u.nama_unit, u.singkatan')
                ->join('unit u', 'a.unit_id = u.id');

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder) use ($isRestore) {
                    if ($isRestore) {
                        $builder->where('a.deleted_at IS NOT NULL');
                    } else {
                        $builder->where('a.deleted_at', null);
                        $builder->where('u.deleted_at', null);
                    }
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('a.id', 'desc');
                })
                ->add('checkRowAnggota', function ($row) use ($isRestore) {
                    if (!$isRestore) {
                        return '<input type="checkbox" name="id[]" class="checkRowAnggota" value="' . $row->id . '">';
                    }
                })
                ->add('action', function ($row) use ($isRestore) {
                    if ($isRestore) {
                        return '
                        <div class="btn-group mb-1">
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu shadow-lg">
                            <li><a class="dropdown-item" onclick="restoreanggota(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-undo"></i> Pulihkan</a></li>
                            <li><a class="dropdown-item" onclick="hapuspermanenanggota(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a></li>
                        </ul>
                        </div>
                        ';
                    } else {
                        return '
                        <div class="btn-group mb-1">
                        <button type="button" class="btn btn-sm btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu shadow-lg">
                            <li><a class="dropdown-item" onclick="editanggota(' . $row->id . ')"> <i class="fa fa-pencil-square-o"></i> Ubah anggota</a></li>
                            <li><a class="dropdown-item" onclick="hapusanggota(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-trash-o"></i> Hapus
                        ';
                    }
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

    public function singleformanggota()
    {
        if ($this->request->isAJAX()) {
            $saveMethod = $this->request->getGet('saveMethod');
            $globalId = $this->request->getGet('globalId');
            $nav = $this->request->getGet('nav');
            $title = "Anggota";

            $data = [
                'globalId' => $globalId ? $globalId : '',
                'saveMethod' => $saveMethod,
                'title' => $title,
                'nav' => $nav,
            ];

            $msg = [
                'data' => view('anggota/singleformanggota', $data),
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

    public function singleformunit()
    {
        if ($this->request->isAJAX()) {
            $saveMethod = $this->request->getGet('saveMethod');
            $globalId = $this->request->getGet('globalId');
            $nav = $this->request->getGet('nav');
            $title = "Unit";

            $data = [
                'globalId' => $globalId ? $globalId : '',
                'saveMethod' => $saveMethod,
                'title' => $title,
                'nav' => $nav,
            ];

            $msg = [
                'data' => view('anggota/singleformunit', $data),
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

    public function getkategoriunit()
    {
        if ($this->request->isAJAX()) {
            $query = $this->db->table('unit')->select('kategori_unit')->groupBy('kategori_unit')->get();
            $msg = $query->getResultArray();

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function simpandataunit()
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
            'nama_unit' => [
                'label' => 'Nama unit',
                'rules' => 'required|is_unique[unit.nama_unit]',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                    'is_unique' => "{field} sudah ada dan tidak boleh sama",
                ],
            ],
            'singkatan' => [
                'label' => 'Singkatan',
                'rules' => 'required|is_unique[unit.singkatan]',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                    'is_unique' => "{field} sudah ada dan tidak boleh sama",
                ],
            ],
            'kategori_unit' => [
                'label' => 'Kategori unit',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
        }
        if (!empty($errors)) {
            $msg = [
                'error' => $errors,
            ];
        } else {
            $nama_unit = $this->request->getVar('nama_unit');
            $singkatan = $this->request->getVar('singkatan');
            $kategori_unit = $this->request->getVar('kategori_unit');
            $deskripsi = $this->request->getVar('deskripsi');

            $simpandata = [
                'nama_unit' => $nama_unit,
                'singkatan' => $singkatan,
                'kategori_unit' => $kategori_unit,
                'deskripsi' => $deskripsi,
            ];

            $insertdata = $this->unit->setInsertData($simpandata);
            $this->unit->save($insertdata);

            $msg = [
                'sukses' => "Data $nama_unit berhasil disimpan",
            ];
        }

        echo json_encode($msg);
    }

    public function getdataunitbyid()
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
        $id = $this->request->getVar('id');
        $builder = $this->unit->find($id);
        echo json_encode($builder);
    }

    public function updatedataunit($id)
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
            'nama_unit' => [
                'label' => 'Nama unit',
                'rules' => 'required',
                'errors' => [
                    'is_unique' => "{field} sudah ada dan tidak boleh sama",
                ],
            ],
            'singkatan' => [
                'label' => 'Singkatan',
                'rules' => 'required',
                'errors' => [
                    'is_unique' => "{field} sudah ada dan tidak boleh sama",
                ],
            ],
            'kategori_unit' => [
                'label' => 'Kategori unit',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
        }
        if (!empty($errors)) {
            $msg = [
                'error' => $errors,
            ];
        } else {
            $nama_unit = $this->request->getVar('nama_unit');
            $singkatan = $this->request->getVar('singkatan');
            $kategori_unit = $this->request->getVar('kategori_unit');
            $deskripsi = $this->request->getVar('deskripsi');

            $ubahdata = [
                'nama_unit' => $nama_unit,
                'singkatan' => $singkatan,
                'kategori_unit' => $kategori_unit,
                'deskripsi' => $deskripsi,
            ];

            $updatedata = $this->unit->setUpdateData($ubahdata);
            $this->unit->update($id, $updatedata);

            $msg = [
                'sukses' => "Data $nama_unit berhasil diubah",
            ];
        }

        echo json_encode($msg);
    }

    public function hapusdataunit($id)
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }

        $nama_unit = $this->request->getVar('nama_unit');
        try {
            $this->unit->setSoftDelete($id);

            $msg = [
                'sukses' => "Data unit $nama_unit berhasil dihapus secara sementara",
            ];
            echo json_encode($msg);
        } catch (\Exception $e) {
            $msg = [
                'error' => $e->getMessage(),
            ];
            echo json_encode($msg);
        }
    }

    public function restoredataunit($id = [])
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }

        $ids = $this->request->getVar('id');
        $id = explode(",", $ids);
        $restoredata = [
            'deleted_by' => null,
            'deleted_at' => null,
        ];
        if (count($id) === 1) {
            foreach ($id as $key => $idunit) {
                $nama_unit = $this->request->getVar('nama_unit');
                $this->unit->update($idunit, $restoredata);

                $msg = [
                    'sukses' => "Data unit $nama_unit berhasil dipulihkan",
                ];
            }
        } else {
            foreach ($id as $key => $idunit) {
                $this->unit->update($idunit, $restoredata);
            }

            $msg = [
                'sukses' => count($id) . " Data unit berhasil dipulihkan",
            ];
        }

        echo json_encode($msg);
    }

    public function simpandataanggota()
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
            'nama_anggota' => [
                'label' => 'Nama anggota',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
            'no_anggota' => [
                'label' => 'Nomor anggota',
                'rules' => 'required|is_unique[anggota.no_anggota]',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                    'is_unique' => "{field} sudah ada dan tidak boleh sama",
                ],
            ],
            'level' => [
                'label' => 'Level',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
            'unit_id' => [
                'label' => 'Unit',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
        }
        if (!empty($errors)) {
            $msg = [
                'error' => $errors,
            ];
        } else {
            $nama_anggota = $this->request->getVar('nama_anggota');
            $level = $this->request->getVar('level');
            $unit_id = $this->request->getVar('unit_id');
            $no_anggota = $this->request->getVar('no_anggota');
            $no_hp = $this->request->getVar('no_hp');

            $simpandata = [
                'nama_anggota' => $nama_anggota,
                'level' => $level,
                'unit_id' => $unit_id,
                'no_anggota' => $no_anggota,
                'no_hp' => $no_hp,
            ];

            $insertdata = $this->anggota->setInsertData($simpandata);
            $this->anggota->save($insertdata);

            $msg = [
                'sukses' => "Data $nama_anggota berhasil disimpan",
            ];
        }

        echo json_encode($msg);
    }

    public function getdataanggotabyid()
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
        $id = $this->request->getVar('id');
        $builder = $this->db->table('anggota a')->select('a.*, u.singkatan')->join('unit u', 'u.id=a.unit_id')->where('a.id', $id)->get()->getRowArray();
        echo json_encode($builder);
    }

    public function updatedataanggota($id)
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
            'nama_anggota' => [
                'label' => 'Nama anggota',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
            'no_anggota' => [
                'label' => 'Nomor anggota',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
            'level' => [
                'label' => 'Level',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
            'unit_id' => [
                'label' => 'Unit',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
        }
        if (!empty($errors)) {
            $msg = [
                'error' => $errors,
            ];
        } else {
            $nama_anggota = $this->request->getVar('nama_anggota');
            $level = $this->request->getVar('level');
            $unit_id = $this->request->getVar('unit_id');
            $no_anggota = $this->request->getVar('no_anggota');
            $no_hp = $this->request->getVar('no_hp');

            $ubahdata = [
                'nama_anggota' => $nama_anggota,
                'level' => $level,
                'unit_id' => $unit_id,
                'no_anggota' => $no_anggota,
                'no_hp' => $no_hp,
            ];

            $updatedata = $this->anggota->setUpdateData($ubahdata);
            $this->anggota->update($id, $updatedata);

            $msg = [
                'sukses' => "Data $nama_anggota berhasil diubah",
            ];
        }

        echo json_encode($msg);
    }

    public function hapusdataanggota($id)
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }

        $nama_anggota = $this->request->getVar('nama_anggota');
        try {
            $this->anggota->setSoftDelete($id);

            $msg = [
                'sukses' => "Data anggota $nama_anggota berhasil dihapus secara sementara",
            ];
            echo json_encode($msg);
        } catch (\Exception $e) {
            $msg = [
                'error' => $e->getMessage(),
            ];
            echo json_encode($msg);
        }
    }

    public function restoredataanggota($id = [])
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }

        $ids = $this->request->getVar('id');
        $id = explode(",", $ids);
        $restoredata = [
            'deleted_by' => null,
            'deleted_at' => null,
        ];
        if (count($id) === 1) {
            foreach ($id as $key => $idanggota) {
                $nama_anggota = $this->request->getVar('nama_anggota');
                $this->anggota->update($idanggota, $restoredata);

                $msg = [
                    'sukses' => "Data anggota $nama_anggota berhasil dipulihkan",
                ];
            }
        } else {
            foreach ($id as $key => $idanggota) {
                $this->anggota->update($idanggota, $restoredata);
            }

            $msg = [
                'sukses' => count($id) . " Data anggota berhasil dipulihkan",
            ];
        }

        echo json_encode($msg);
    }

    public function multipledeleteunittemporary()
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }

        $id_unit = $this->request->getVar('id');
        $jmldata = count($id_unit);

        foreach ($id_unit as $id) {
            $this->unit->setSoftDelete($id);
        }

        $msg = [
            'sukses' => "$jmldata data unit berhasil dihapus secara temporary",
        ];

        echo json_encode($msg);
    }
    public function multipledeleteanggotatemporary()
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }

        $id_anggota = $this->request->getVar('id');
        $jmldata = count($id_anggota);

        foreach ($id_anggota as $id) {
            $this->anggota->setSoftDelete($id);
        }

        $msg = [
            'sukses' => "$jmldata data anggota berhasil dihapus secara temporary",
        ];

        echo json_encode($msg);
    }

    public function hapuspermanenunit($id = [])
    {

        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
        $id = $this->request->getVar('id');
        $id_unit = explode(",", $id);

        if (count($id_unit) === 1) {
            $nama_unit = $this->request->getVar('nama_unit');
            try {
                // Lakukan operasi penghapusan data unit
                $this->unit->delete($id_unit, true);

                // Jika operasi penghapusan berhasil
                $msg = ['sukses' => "Data unit: $nama_unit berhasil dihapus secara permanen"];
            } catch (DatabaseException $e) {
                // Jika terjadi kesalahan saat penghapusan data unit
                if (strpos($e->getMessage(), 'a foreign key constraint fails') !== false) {
                    $msg = ['error' => 'Tidak dapat menghapus unit karena ada data anggota yang terkait'];
                } else {
                    $msg = ['error' => 'Hapus data unit gagal: ' . $e->getMessage()];
                }
            }
        } else {
            foreach ($id_unit as $ids) {
                try {
                    // Lakukan operasi penghapusan data unit
                    $this->unit->delete($ids, true);

                    // Jika operasi penghapusan berhasil
                } catch (DatabaseException $e) {
                    // Jika terjadi kesalahan saat penghapusan data unit
                    if (strpos($e->getMessage(), 'a foreign key constraint fails') !== false) {
                        $msg = ['error' => 'Tidak dapat menghapus unit yang masih memiliki data anggota yang terkait'];
                    } else {
                        $msg = ['error' => 'Hapus data unit gagal: ' . $e->getMessage()];
                    }
                }
            }

            $msg = [
                'sukses' => count($id_unit) . " data unit berhasil dihapus secara permanen",
            ];
        }

        echo json_encode($msg);
    }

    public function hapuspermanenanggota($id = [])
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
        $id = $this->request->getVar('id');
        $id_anggota = explode(",", $id);

        if (count($id_anggota) === 1) {
            $nama_anggota = $this->request->getVar('nama_anggota');

            try {
                // Lakukan operasi penghapusan data unit
                $this->anggota->delete($id_anggota, true);

                $msg = [
                    'sukses' => "Data anggota: $nama_anggota berhasil dihapus secara permanen",
                ];
            } catch (DatabaseException $e) {
                // Jika terjadi kesalahan saat penghapusan data unit
                if (strpos($e->getMessage(), 'a foreign key constraint fails') !== false) {
                    $msg = ['error' => 'Tidak dapat menghapus anggota karena ada masih data pelaporan kerusakan aset/ peminjaman/ permintaan yang terkait'];
                } else {
                    $msg = ['error' => 'Hapus data anggota gagal: ' . $e->getMessage()];
                }
            }
        } else {
            $jmlhapus = 0;
            foreach ($id_anggota as $ids) {
                try {
                    // Lakukan operasi penghapusan data unit
                    $this->anggota->delete($ids, true);
                    $jmlhapus += $this->anggota->affectedRows();
                } catch (DatabaseException $e) {
                    // Jika terjadi kesalahan saat penghapusan data unit
                    if (strpos($e->getMessage(), 'a foreign key constraint fails') !== false) {
                        $msg = ['error' => 'TTidak dapat menghapus anggota karena ada masih data pelaporan kerusakan aset/ peminjaman/ permintaan yang terkait'];
                    } else {
                        $msg = ['error' => 'Hapus data anggota gagal: ' . $e->getMessage()];
                    }
                }
            }

            $msg = [
                'sukses' => "$jmlhapus data anggota berhasil dihapus secara permanen",
            ];
        }

        echo json_encode($msg);
    }
}
