<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;


class RiwayatTransaksi extends Model
{
    protected $table = "riwayat_transaksi";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'stokbrg_id',    'jenis_transaksi', 'field', 'old_value', 'new_value', 'created_by', 'created_at', 'updated_by', 'deleted_by', 'deleted_at'];
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
            'deleted_at' => Time::now('Asia/Jakarta', 'id_ID')
        ];
        $this->update($id, $data);
    }

    public function inserthistori($stokbrg_id, $data_lama, $data_baru, $jenistrx, $lastQuery, $field_update)
    {
        $datasimpan = [];

        if (strpos($lastQuery, 'INSERT') !== false) {
            $datasimpan = [
                'stokbrg_id' => $stokbrg_id,
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
                'stokbrg_id' => $stokbrg_id,
                'jenis_transaksi' => $jenistrx,
                'field' => json_encode(array_keys($new_value)),
                'old_value' => json_encode($old_value),
                'new_value' => json_encode($new_value),
            ];
        } else if (strpos($lastQuery, 'DELETE') !== false) {
            $datasimpan = [
                'stokbrg_id' => $stokbrg_id,
                'jenis_transaksi' => $jenistrx,
                'field' => 'delete data',
                'old_value' => json_encode($data_lama),
                'new_value' => '',
            ];
        }

        $insertdatasimpan = $this->setInsertData($datasimpan);
        $this->save($insertdatasimpan);
    }

    public function deletehistorimultiple($id, $data_lama, $jenistrx)
    {
        foreach ($id as $stokbrg_id) {
            $data_lama_filtered = array_filter($data_lama, function ($data) use ($stokbrg_id) {
                return $data['id'] == $stokbrg_id;
            });
            $datasimpan = [
                'stokbrg_id' => $stokbrg_id,
                'jenis_transaksi' => $jenistrx,
                'field' => 'delete data',
                'old_value' => json_encode(array_values($data_lama_filtered)),
                'new_value' => '',
            ];
            $insertdatasimpan = $this->setInsertData($datasimpan);
            $this->save($insertdatasimpan);
        }
    }
}
