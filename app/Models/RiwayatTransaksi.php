<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatTransaksi extends Model
{
    protected $table = "riwayat_transaksi";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'stokbrg_id',    'jenis_transaksi', 'field', 'old_value', 'new_value', 'created_by', 'created_at'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';

    protected $beforeInsert = ['setInsertData'];
    protected $allowCallbacks = true;

    public function setInsertData(array $data)
    {
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
}
