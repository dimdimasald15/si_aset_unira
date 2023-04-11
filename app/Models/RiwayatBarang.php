<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatBarang extends Model
{
    protected $table = "riwayat_barang";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'barang_id',    'jenis_transaksi', 'field', 'old_value', 'new_value', 'created_by', 'created_at'];
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
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['created_by'] = $username;
        }
        return $data;
    }

    public function inserthistori($id, $data_lama, $data_baru, $lastQuery, $field_update)
    {
        $datasimpan = [];
        if (strpos($lastQuery, 'INSERT') !== false) {
            $datasimpan = [
                'barang_id' => $id,
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
                'barang_id' => $id,
                'field' => json_encode(array_keys($new_value)),
                'old_value' => json_encode($old_value),
                'new_value' => json_encode($new_value),
            ];
        } else if (strpos($lastQuery, 'DELETE') !== false) {
            $datasimpan = [
                'barang_id' => $id,
                'field' => 'delete data',
                'old_value' => json_encode($data_lama),
                'new_value' => '',
            ];
        }

        // array_push($datasimpan, $data);

        $insertdatasimpan = $this->setInsertData($datasimpan);
        $this->save($insertdatasimpan);
    }
}
