<?php

namespace App\Controllers;

use App\Models\Barang;
use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;

class BarangController extends BaseController
{
    protected $barang, $uri;
    public function __construct()
    {
        $this->barang = new Barang();
        $this->uri = service('uri');
    }
    public function index()
    {
        $segments = $this->uri->getSegments();
        $breadcrumb = [];
        $link = '';

        foreach ($segments as $segment) {
            $link .= '/' . $segment;
            $breadcrumb[] = ['name' => ucfirst($segment), 'link' => $link];
        }
        $data = [
            'title' => 'Barang',
            'nav' => 'barang',
            'breadcrumb' => $breadcrumb
        ];

        return view('barang/index', $data);
    }

    public function listdatabarang()
    {
        if ($this->request->isAJAX()) {
            $builder = $this->db->table('barang b')
                ->select('b.id,b.nama_brg, b.kode_brg,b.stok,b.harga_beli,b.kondisi, b.created_at, b.created_by, b.deleted_at, k.nama_kategori, s.kd_satuan, r.nama_ruang')
                ->join('kategori k', 'b.kat_id = k.id')
                ->join('satuan s', 'b.satuan_id = s.id')
                ->join('ruang r', 'b.ruang_id = r.id');

            return DataTable::of($builder)
                ->filter(function ($builder) {
                    $builder->where('b.deleted_at', null);
                })
                ->postQuery(function ($builder) {
                    // $builder->orderBy('customerNumber', 'desc');
                    $builder->orderBy('b.id', 'desc');
                })
                //<button type="button" class="btn btn-primary btn-sm" onclick="alert(\'edit customer: '.$row->customerName.'\') ><i class="fas fa-edit"></i></button>
                ->addNumbering('no')
                ->add('action', function ($row) {
                    return '<button type="button" class="btn btn-warning btn-sm btn-editbarang" onclick="edit(' . $row->id . ')"> <i class="fa fa-pencil-square-o"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\')"><i class="fa fa-trash-o"></i></button>';
                })
                ->toJson(true);
        } else {
            exit("Maaf tidak dapat diproses");
        }
    }
}
