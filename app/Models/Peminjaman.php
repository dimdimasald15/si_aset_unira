<?php

namespace App\Models;

use CodeIgniter\Model;

class Peminjaman extends Model
{
    protected $table = "peminjaman";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'barang_id', 'anggota_id', 'jml_barang', 'jml_hari', 'kondisi_pinjam', 'kondisi_kembali', 'tgl_pinjam', 'tgl_kembali', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];
    protected $useSoftDeletes   = true;
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;
    protected $deletedField  = 'deleted_at';

    protected $beforeInsert = ['setInsertData'];
    protected $beforeUpdate = ['setUpdateData'];
    protected $allowCallbacks = true;

    public function setInsertData(array $data)
    {
        // dd($data);
        $username = session()->get('username');
        if (
            !empty($username) &&
            !array_key_exists('created_by', $data)
        ) {
            $data['data']['created_at'] = date('Y-m-d H:i:s');
            $data['data']['created_by'] = $username;
        }
        return $data;
    }

    public function setUpdateData(array $data)
    {
        $username = session()->get('username');
        if (!empty($username) && !array_key_exists('updated_by', $data)) {
            $data['data']['updated_at'] = date('Y-m-d H:i:s');
            $data['data']['updated_by'] = $username;
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
}
