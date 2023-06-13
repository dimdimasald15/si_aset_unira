<?php

namespace App\Models;

use CodeIgniter\Model;

class Pelaporankerusakan extends Model
{
    protected $table = "pelaporan_kerusakan";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'stokbrg_id', 'anggota_id', 'no_laporan', 'jml_barang', 'title', 'deskripsi', 'foto', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'];
    protected $useSoftDeletes   = true;
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;
    protected $deletedField  = 'deleted_at';

    protected $beforeInsert = ['setInsertData'];
    protected $beforeUpdate = ['setUpdateData'];
    protected $allowCallbacks = true;

    public function setInsertData(array $data, $username)
    {
        // $username = session()->get('username');
        if (!empty($username) && !array_key_exists('created_by', $data)) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $username;
        }
        return $data;
    }

    public function setUpdateData(array $data, $username)
    {
        // $username = session()->get('username');
        if (!empty($username) && !array_key_exists('updated_by', $data)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $username;
        }
        return $data;
    }

    public function setSoftDelete()
    {
        $session = \Config\Services::session();
        $data = [
            'deleted_by' => $session->get('username'),
            'deleted_at' => date("Y-m-d H:i:s", time())
        ];

        return $data;

        // $this->update($id, $data);
    }

    public function setRestoreData()
    {
        $username = session()->get('username');

        $username = session()->get('username');
        // if (!empty($username) && !array_key_exists('updated_by', $data)) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['updated_by'] = $username;
        $data['deleted_by'] = null;
        $data['deleted_at'] = null;
        // }
        return $data;
    }

    public function paginatePelaporan(int $nmPage, string $string)
    {
        return $this->select('pelaporan_kerusakan.*, a.nama_anggota, a.no_anggota, a.level, u.singkatan, n.viewed_by_admin')
            ->join('anggota a', 'a.id=pelaporan_kerusakan.anggota_id')
            ->join('unit u', 'u.id=a.unit_id')
            ->join('notifikasi n', 'pelaporan_kerusakan.id=n.laporan_id')
            ->where('n.deleted_at IS NULL')
            ->where('pelaporan_kerusakan.deleted_at IS NULL')
            ->orderBy('pelaporan_kerusakan.id', 'DESC')
            ->paginate($nmPage, $string);
    }
}
