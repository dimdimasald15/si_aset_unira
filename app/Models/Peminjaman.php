<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class Peminjaman extends Model
{
    protected $table = "peminjaman";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'barang_id', 'anggota_id', 'jml_barang', 'jml_hari', 'keterangan', 'kondisi_pinjam', 'kondisi_kembali', 'tgl_pinjam', 'tgl_kembali', 'status', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'];
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
            'deleted_at' => Time::now('Asia/Jakarta', 'id_ID'),
        ];
        $this->update($id, $data);
    }

    public function fetchPeminjamanData($tgl_peminjaman, $m, $y, $jenis)
    {
        $builder = $this->db->table('peminjaman p')
            ->select('p.*, a.nama_anggota, b.nama_brg, u.singkatan, s.kd_satuan')
            ->join('anggota a', 'a.id = p.anggota_id')
            ->join('barang b', 'b.id = p.barang_id')
            ->join('kategori k', 'k.id = b.kat_id')
            ->join('unit u', 'u.id = a.unit_id')
            ->join('satuan s', 's.id = b.satuan_id')
            ->where('k.jenis', $jenis)
            ->where('k.deleted_at', null)
            ->where('b.deleted_at', null)
            ->where('p.deleted_at', null);

        if ($tgl_peminjaman) {
            $builder->like("p.created_at", $tgl_peminjaman . "%");
        } else {
            $builder->where('YEAR(p.created_at)', $y ? $y : date('Y'));
            if ($m) {
                $builder->where('MONTH(p.created_at)', $m);
            }
        }

        $builder->orderBy('p.id', 'ASC');
        $results = $builder->get()->getResultArray();

        $tgldibuat = array_map(function ($val) {
            return format_tanggal($val['created_at']);
        }, $results);

        foreach ($results as $key => &$result) {
            $result['tgldibuat'] = $tgldibuat[$key];
        }

        $groupedData = [];

        foreach ($results as &$item) {
            $dateString = $item["tgldibuat"];
            $haritanggal = $tgl_peminjaman ? $dateString : explode(" ", $dateString)[2] . " " . explode(" ", $dateString)[3];

            if (!isset($groupedData[$haritanggal])) {
                $groupedData[$haritanggal] = [];
            }
            $groupedData[$haritanggal][] = $item;
        }

        return $groupedData;
    }
}
