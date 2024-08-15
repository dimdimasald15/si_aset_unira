<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;


class RiwayatTransaksi extends Model
{
    protected $table = "riwayat_transaksi";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'stokbrg_id',    'jenis_transaksi', 'field', 'old_value', 'new_value', 'created_by', 'created_at', 'updated_at', 'updated_by', 'deleted_by', 'deleted_at'];
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

    public function initializeBuilderPembelianBrgTetap()
    {
        return $this->db->table('riwayat_transaksi rt')
            ->select('rt.id, b.kode_brg, b.nama_brg, b.warna, rb.field AS field_rb,
                CASE 
                    WHEN rb.field = "Semua Field" THEN CAST(REPLACE(JSON_UNQUOTE(JSON_EXTRACT(rb.new_value, \'$.harga_beli\')), \'"\', \'\') AS UNSIGNED)
                    ELSE CAST(REPLACE(JSON_UNQUOTE(JSON_EXTRACT(rb.new_value, \'$.harga_beli\')), \'"\', \'\') AS UNSIGNED)
                END AS hrg_beli_brg, rt.jenis_transaksi, rt.field AS field_rt, 
                CASE 
                    WHEN rt.jenis_transaksi = "Tambah Stok Barang Tetap Masuk di Sarpras" 
                    THEN CAST(REPLACE(JSON_UNQUOTE(JSON_EXTRACT(rt.new_value, \'$.jumlah_masuk\')), \'"\', \'\') AS SIGNED) - CAST(REPLACE(JSON_UNQUOTE(JSON_EXTRACT(rt.old_value, \'$.jumlah_masuk\')), \'"\', \'\') AS SIGNED)
                    ELSE CAST(REPLACE(JSON_UNQUOTE(JSON_EXTRACT(rt.new_value, \'$.jumlah_masuk\')), \'"\', \'\') AS UNSIGNED)
                END AS jml_msk, s.kd_satuan, rt.created_at')
            ->join('stok_barang sb', 'sb.id = rt.stokbrg_id')
            ->join('barang b', 'b.id = sb.barang_id')
            ->join('satuan s', 's.id = b.satuan_id')
            ->join('riwayat_barang rb', 'b.id = rb.barang_id')
            ->join('kategori k', 'k.id = b.kat_id')
            ->where('(rt.field LIKE "%jumlah_masuk%" OR rt.field = "Semua Field")')
            ->where('(rt.jenis_transaksi LIKE "%Barang tetap masuk%")')
            ->where($this->generateCaseStatement());
    }

    private function generateCaseStatement()
    {
        return '( CASE
            WHEN b.nama_brg IN (
                SELECT b.nama_brg 
                FROM riwayat_transaksi rt
                JOIN stok_barang sb ON sb.id = rt.stokbrg_id
                JOIN barang b ON b.id = sb.barang_id
                WHERE rt.jenis_transaksi IN ("barang tetap masuk", "Tambah Stok Barang Tetap Masuk di Sarpras", "Update barang tetap masuk")
                GROUP BY b.nama_brg
                HAVING COUNT(DISTINCT rt.jenis_transaksi) = 3
            ) THEN (rt.jenis_transaksi <> "barang tetap masuk" OR rt.field <> "Semua Field")
            WHEN b.nama_brg IN (
                SELECT b.nama_brg
                FROM riwayat_transaksi rt
                JOIN stok_barang sb ON sb.id = rt.stokbrg_id
                JOIN barang b ON b.id = sb.barang_id
                WHERE rt.jenis_transaksi IN ("barang tetap masuk", "Update barang tetap masuk")
                GROUP BY b.nama_brg
                HAVING COUNT(DISTINCT rt.jenis_transaksi) = 2
            ) THEN (rt.jenis_transaksi <> "barang tetap masuk" OR rt.field <> "Semua Field")
            WHEN b.nama_brg IN (
                SELECT b.nama_brg 
                FROM riwayat_transaksi rt
                JOIN stok_barang sb ON sb.id = rt.stokbrg_id
                JOIN barang b ON b.id = sb.barang_id
                WHERE rt.jenis_transaksi IN ("barang tetap masuk", "Tambah Stok Barang Tetap Masuk di Sarpras")
                GROUP BY b.nama_brg
                HAVING COUNT(DISTINCT rt.jenis_transaksi) = 2
            ) THEN 1
            WHEN b.nama_brg IN (
                SELECT b.nama_brg 
                FROM riwayat_transaksi rt
                JOIN stok_barang sb ON sb.id = rt.stokbrg_id
                JOIN barang b ON b.id = sb.barang_id
                WHERE rt.jenis_transaksi = "barang tetap masuk"
                GROUP BY b.nama_brg
                HAVING COUNT(DISTINCT rt.jenis_transaksi) = 1
            ) THEN (rt.jenis_transaksi = "barang tetap masuk" OR rt.field = "Semua Field")
        END)';
    }
}
