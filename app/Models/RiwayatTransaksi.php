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

    public function inserthistori($id, $data_lama, $data_baru, $jenistrx, $lastQuery, $field_update)
    {
        // $id = (int) $id; // casting $id menjadi integer
        $datasimpan = [];
        // echo strpos($lastQuery, 'DELETE');

        if (strpos($lastQuery, 'INSERT') !== false) {
            $datasimpan = [
                'stokbrg_id' => $id,
                'jenis_transaksi' => $jenistrx,
                'field' => 'Semua field',
                'old_value' => '',
                'new_value' => json_encode($data_baru),
            ];
        } else if (strpos($lastQuery, 'UPDATE') !== false) {
            //Tambahkan data pada table riwayat_barang
            $old_value = [];
            $new_value = [];

            foreach ($field_update as $field) {
                if (array_key_exists($field, $data_lama)) {
                    $old_value[$field] = $data_lama[$field];
                }
                if (array_key_exists($field, $data_baru)) {
                    $new_value[$field] = $data_baru[$field];
                }
            }
            $datasimpan = [
                'stokbrg_id' => $id,
                'jenis_transaksi' => $jenistrx,
                'field' => json_encode(array_keys($new_value)),
                'old_value' => json_encode($old_value),
                'new_value' => json_encode($new_value),
            ];
        } else if (strpos($lastQuery, 'DELETE') !== false) {
            $datasimpan = [
                'stokbrg_id' => $id,
                'jenis_transaksi' => $jenistrx,
                'field' => 'delete data',
                'old_value' => json_encode($data_lama),
                'new_value' => '',
            ];
        }

        $insertdatasimpan = $this->setInsertData($datasimpan);
        $this->save($insertdatasimpan);
    }
}
