<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;


class RiwayatBarang extends Model
{
    protected $table = "riwayat_barang";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'barang_id', 'field', 'old_value', 'new_value', 'created_by', 'created_at', 'updated_by', 'deleted_by', 'deleted_at'];
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
            $data['created_at'] = Time::now('Asia/Jakarta', 'id_ID');
            $data['created_by'] = $username;
        }
        return $data;
    }

    public function setUpdateData(array $data)
    {
        $username = session()->get('username');
        if (!empty($username) && !array_key_exists('updated_by', $data)) {
            $data['updated_at'] = Time::now('Asia/Jakarta', 'id_ID');
            $data['updated_by'] = $username;
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

    public function inserthistori($id, $data_lama, $data_baru, $lastQuery, $field_update)
    {
        // $id = (int) $id; // casting $id menjadi integer
        $datasimpan = [];
        // echo strpos($lastQuery, 'DELETE');

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
            // var_dump($datasimpan);
        }

        $insertdatasimpan = $this->setInsertData($datasimpan);
        $this->save($insertdatasimpan);
    }

    public function deletehistorimultiple($id, $data_lama)
    {
        foreach ($id as $id_brg) {
            $data_lama_filtered = array_filter($data_lama, function ($data) use ($id_brg) {
                return $data['id'] == $id_brg;
            });
            $datasimpan = [
                'barang_id' => $id_brg,
                'field' => 'delete data',
                'old_value' => json_encode(array_values($data_lama_filtered)),
                'new_value' => '',
            ];
            $insertdatasimpan = $this->setInsertData($datasimpan);
            $this->save($insertdatasimpan);
        }
    }
}
