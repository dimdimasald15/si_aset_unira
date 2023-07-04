<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;


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
        if (!empty($username) && !array_key_exists('created_by', $data)) {
            $data['created_at'] = Time::now('Asia/Jakarta', 'id_ID');
            $data['created_by'] = $username;
        }
        return $data;
    }

    public function setUpdateData(array $data, $username)
    {
        if (!empty($username) && !array_key_exists('updated_by', $data)) {
            $data['updated_at'] = Time::now('Asia/Jakarta', 'id_ID');
            $data['updated_by'] = $username;
        }
        return $data;
    }

    public function setSoftDelete()
    {
        $session = \Config\Services::session();
        $data = [
            'deleted_by' => $session->get('username'),
            'deleted_at' => Time::now('Asia/Jakarta', 'id_ID')
        ];

        return $data;

        // $this->update($id, $data);
    }

    public function setRestoreData()
    {
        $username = session()->get('username');

        $username = session()->get('username');
        $data['updated_at'] = Time::now('Asia/Jakarta', 'id_ID');
        $data['updated_by'] = $username;
        $data['deleted_by'] = null;
        $data['deleted_at'] = null;
        return $data;
    }

    public function paginatePelaporan(int $nmPage, string $string)
    {
        return $this->select('pelaporan_kerusakan.*, a.nama_anggota, a.no_anggota, a.level, u.singkatan, n.viewed_by_admin')
            ->join('anggota a', 'a.id=pelaporan_kerusakan.anggota_id')
            ->join('unit u', 'u.id=a.unit_id')
            ->join('notifikasi n', 'pelaporan_kerusakan.id=n.laporan_id')
            ->where('n.deleted_at IS NULL')
            ->where('a.deleted_at IS NULL')
            ->where('pelaporan_kerusakan.deleted_at IS NULL')
            ->orderBy('n.viewed_by_admin', 'ASC')
            ->orderBy('pelaporan_kerusakan.id', 'DESC')
            ->paginate($nmPage, $string);
    }
}
