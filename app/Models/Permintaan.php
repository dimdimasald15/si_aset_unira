<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;


class Permintaan extends Model
{
    protected $table = "permintaan";
    protected $primaryKey = 'id';
    protected $allowedFields = ['id', 'barang_id', 'anggota_id', 'tgl_minta', 'keterangan', 'jml_barang', 'created_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'];
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

    public function fetchDataTableLaporanPermintaan($m, $y)
    {
        $builder = $this->db->table('permintaan p')
            ->select('u.nama_unit, COUNT(p.barang_id) AS count_brg, 
            GROUP_CONCAT(CONCAT(b.nama_brg, " (", p.jml_barang, " ", s.kd_satuan, ")") SEPARATOR ", ") AS nama_brg, 
            GROUP_CONCAT(DISTINCT a.nama_anggota SEPARATOR ", ") AS nama_anggota, 
            CONCAT(MONTH(p.tgl_minta), "/", YEAR(p.tgl_minta)) AS bulan_tahun, 
            (SELECT SUM(p2.jml_barang * b2.harga_beli) 
                FROM permintaan p2 
                JOIN barang b2 ON b2.id = p2.barang_id 
                JOIN anggota a2 ON a2.id = p2.anggota_id 
                JOIN unit u2 ON u2.id = a2.unit_id 
                WHERE a2.unit_id = a.unit_id 
                AND p2.deleted_at IS NULL 
                AND b2.deleted_at IS NULL
            ) AS total_valuasi')
            ->join('anggota a', 'a.id = p.anggota_id')
            ->join('unit u', 'a.unit_id = u.id')
            ->join('barang b', 'b.id = p.barang_id')
            ->join('satuan s', 'b.satuan_id = s.id')
            ->where('p.deleted_at', null)
            ->groupBy('a.unit_id')
            ->orderBy('bulan_tahun', 'DESC');

        // Apply date filters based on input parameters
        if (!empty($y)) {
            $builder->where('YEAR(p.tgl_minta)', $y);
            if (!empty($m)) {
                $builder->where('MONTH(p.tgl_minta)', $m);
            }
        } else {
            $builder->where('YEAR(p.tgl_minta)', date('Y'));
        }
        // Execute the query and return the result
        return $builder->get()->getResultArray();
    }

    public function fetchChartData($m, $y)
    {
        $builder = $this->db->table('permintaan p')->select('u.singkatan, CONCAT(MONTH(p.tgl_minta), "/", YEAR(p.tgl_minta)) AS bulan_tahun, 
        (SELECT SUM(p2.jml_barang * b2.harga_beli) FROM permintaan p2 
            JOIN barang b2 ON b2.id = p2.barang_id 
            JOIN anggota a2 ON a2.id = p2.anggota_id 
            JOIN unit u2 ON u2.id = a2.unit_id 
            WHERE a2.unit_id = a.unit_id 
            AND p2.deleted_at IS NULL 
            AND b2.deleted_at IS NULL) AS total_valuasi')
            ->join('anggota a', 'a.id = p.anggota_id')
            ->join('unit u', 'a.unit_id = u.id')
            ->where('p.deleted_at IS NULL')
            ->groupBy('a.unit_id')
            ->orderBy('bulan_tahun', 'ASC');

        if (empty($y) || $y == "null") {
            $builder->where('YEAR(p.tgl_minta)', date('Y'));
        } else {
            if (!empty($m)) {
                $builder->where('MONTH(p.tgl_minta)', $m);
            }
            $builder->where('YEAR(p.tgl_minta)', $y);
        }

        return $builder->get()->getResultArray();
    }

    public function initializeResultArray($data)
    {
        $resultArray = [];
        $months_in_data = [];
        $allSingkatan = [];
        // Proses data
        foreach ($data as $item) {
            list($bulan, $tahun) = explode('/', $item['bulan_tahun']);
            $bulan = (int)$bulan;
            $formattedBulan = format_bulan($bulan);
            $formattedBulanTahun = $formattedBulan . ' ' . $tahun;
            $totalVal = format_uang($item['total_valuasi']);
            // Menyimpan semua singkatan
            if (!in_array($item['singkatan'], $allSingkatan)) {
                $allSingkatan[] = $item['singkatan'];
            }
            if (!isset($resultArray[$formattedBulan])) {
                array_push($months_in_data, $formattedBulan);
                $resultArray[$formattedBulan] = [];
            }
            $resultArray[$formattedBulan][] = [
                'singkatan' => $item['singkatan'],
                'bulan_tahun' => $formattedBulanTahun,
                'total_valuasi' => $item['total_valuasi'],
                'totalval' => $totalVal
            ];
        }
        // Menambahkan data yang tidak ada di input dan menjaga urutan
        $orderedResultArray = [];
        foreach ($months_in_data as $month) {
            if (!isset($orderedResultArray[$month])) {
                $orderedResultArray[$month] = [];
            }

            foreach ($allSingkatan as $singkatan) {
                $found = false;
                foreach ($resultArray[$month] as $entry) {
                    if ($entry['singkatan'] === $singkatan) {
                        $orderedResultArray[$month][] = $entry;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $orderedResultArray[$month][] = [
                        'singkatan' => $singkatan,
                        'bulan_tahun' => $month . ' ' . date('Y'),
                        'total_valuasi' => '0',
                        'totalval' => 'Rp0,-'
                    ];
                }
            }
        }

        return $orderedResultArray;
    }
}
