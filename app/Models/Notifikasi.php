<?php

namespace App\Models;

use CodeIgniter\Model;

class Notifikasi extends Model
{
    protected $table = "notifikasi";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'laporan_id', 'petugas_id', 'viewed_by_admin', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'];
    protected $useSoftDeletes   = true;
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;
    protected $deletedField  = 'deleted_at';

    protected $beforeInsert = ['setInsertData'];
    protected $beforeUpdate = ['setUpdateData'];
    protected $allowCallbacks = true;

    public function setInsertData(array $data, $nama_anggota)
    {

        $username = '';
        if ($nama_anggota) {
            $username = $nama_anggota;
        } else {
            $username = session()->get('username');
        }

        if (!empty($username) && !array_key_exists('created_by', $data)) {
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $username;
        }
        return $data;
    }

    public function setUpdateData(array $data)
    {
        $username = session()->get('username');

        $username = session()->get('username');
        if (!empty($username) && !array_key_exists('updated_by', $data)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $username;
        }
        return $data;
    }

    public function setSoftDelete($id)
    {
        $session = \Config\Services::session();
        $data = [
            'deleted_by' => $session->get('username'),
            'deleted_at' => date("Y-m-d H:i:s", time())
        ];
        $this->update($id, $data);
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
}
