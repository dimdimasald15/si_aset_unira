<?php

namespace App\Services;

class RestoreService
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function restoreData($tableName, $ids, $columnNames)
    {
        $this->db->transStart();
        foreach ($ids as $id) {
            $record = $this->db->table($tableName)->select('*')->where('id', $id)->get()->getRowArray();
            if ($record && $record['deleted_at'] !== NULL) {
                $this->db->table($tableName)->update(['deleted_by' => null, 'deleted_at' => null], ['id' => $id]);
            }
        }
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return ['error' => 'Gagal memulihkan data ' . $columnNames['nama']];
        } else {
            return ['success' => "Sukses memulihkan data " . $columnNames['nama'] . " " . $columnNames['value']];
        }
    }
}
