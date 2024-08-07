<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;


class StokBarang extends Model
{
    protected $table = "stok_barang";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'barang_id', 'ruang_id', 'jumlah_masuk', 'jumlah_keluar', 'sisa_stok', 'tgl_beli', 'created_at', 'created_by', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'];
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

    public function getStokSarpras($idbrg, $idsarpras)
    {
        $datasarpras = $this->db->table('stok_barang')->select('*')
            ->where('barang_id', $idbrg)
            ->where('ruang_id', $idsarpras)
            ->get()->getRowArray();

        return $datasarpras;
    }
    public function fetchLowStockItems()
    {
        return $this->db->table('stok_barang sb')
            ->select('sb.*, k.nama_kategori, b.nama_brg, b.warna, b.harga_beli, b.kode_brg, b.foto_barang, s.kd_satuan')
            ->join('barang b', 'b.id=sb.barang_id')
            ->join('kategori k', 'k.id=b.kat_id')
            ->join('ruang r', 'sb.ruang_id = r.id')
            ->join('satuan s', 'b.satuan_id = s.id')
            ->where('k.jenis', 'Barang Persediaan')
            ->where('sb.deleted_at', null)
            ->where('b.deleted_at', null)
            ->having('sb.sisa_stok <= 3')
            ->orderBy('sb.id', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
    }
}
