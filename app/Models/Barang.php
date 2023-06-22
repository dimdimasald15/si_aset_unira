<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Barang extends Model
{
    protected $table = "barang";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'kat_id', 'kode_brg', 'nama_brg', 'merk', 'warna', 'tipe', 'asal', 'harga_beli', 'harga_jual', 'kondisi', 'tindakan_kerusakan', 'toko', 'instansi', 'no_seri', 'no_dokumen', 'foto_barang', 'tgl_pembelian', 'created_at', 'created_by', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'];
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
        // echo "Model Barang : ";
        // echo "<pre>";
        // var_dump($data);
        // echo "</pre>";
        $username = session()->get('username');
        if (
            !empty($username) &&
            !array_key_exists('created_by', $data)
        ) {
            $data['data']['created_at'] = Time::now('Asia/Jakarta', 'id_ID');
            $data['data']['created_by'] = $username;
        }
        return $data;
    }

    public function setUpdateData(array $data)
    {
        $username = session()->get('username');
        if (!empty($username) && !array_key_exists('updated_by', $data)) {
            $data['data']['updated_at'] = Time::now('Asia/Jakarta', 'id_ID');
            $data['data']['updated_by'] = $username;
        }
        return $data;
    }

    public function setSoftDelete($id)
    {
        $session = \Config\Services::session();
        $data = [
            'deleted_by' => $session->get('username'),
            'deleted_at' => Time::now('Asia/Jakarta', 'id_ID'),
        ];
        $this->update($id, $data);
    }
}
