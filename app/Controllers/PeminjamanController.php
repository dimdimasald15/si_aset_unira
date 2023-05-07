<?php

namespace App\Controllers;

use App\Models\Barang;
use App\Models\RiwayatBarang;
use App\Models\Kategori;
use App\Models\Ruang;
use App\Models\StokBarang;
use App\Models\RiwayatTransaksi;
use App\Models\Anggota;
use App\Models\Peminjaman;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use PHPUnit\Framework\Constraint\Count;

class PeminjamanController extends BaseController
{
    protected $barang, $kategori, $uri, $stokbarang, $riwayatbarang, $ruang, $riwayattrx, $anggota, $peminjaman;
    public function __construct()
    {
        $this->barang = new Barang();
        $this->riwayatbarang = new RiwayatBarang();
        $this->kategori = new Kategori();
        $this->ruang = new Ruang();
        $this->stokbarang = new StokBarang();
        $this->riwayattrx = new RiwayatTransaksi();
        $this->anggota = new Anggota();
        $this->peminjaman = new Peminjaman();
        $this->uri = service('uri');
    }

    public function index()
    {
        $segments = $this->uri->getSegments();
        $breadcrumb = [];
        $link = '';

        foreach ($segments as $segment) {
            $link .= '/' . $segment;
            $name = ucwords(str_replace('-', ' ', $segment));
            $breadcrumb[] = ['name' => $name, 'link' => $link];
        }
        $data = [
            'title' => 'Peminjaman Barang Tetap',
            'nav' => 'peminjaman-barang-tetap',
            'jenis_kat' => 'Barang Tetap',
            'breadcrumb' => $breadcrumb
        ];

        return view('peminjaman/index', $data);
    }

    public function listdatapeminjaman()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getVar('jenis_kat');
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);
            $builder = $this->db->table('peminjaman p')->select('p.id,p.anggota_id, p.barang_id, p.jml_barang, p.kondisi_pinjam, p.kondisi_kembali, p.jml_hari, p.tgl_pinjam, p.tgl_kembali, p. created_at, p.created_by, p.deleted_at, p.deleted_by, a.unit_id, u.singkatan, a.nama_anggota,  k.nama_kategori, b.nama_brg, u.singkatan, s.kd_satuan')
                ->join('anggota a', 'a.id = p.anggota_id')
                ->join('unit u', 'u.id = a.unit_id')
                ->join('barang b', 'b.id=p.barang_id')
                ->join('kategori k', 'k.id=b.kat_id')
                ->join('stok_barang sb', 'b.id=sb.barang_id')
                ->join('satuan s', 's.id=sb.satuan_id')
                ->join('ruang r', 'r.id=sb.ruang_id')
                ->where('r.id', 54)
                ->where('k.jenis', $jenis);

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder) use ($jenis, $isRestore) {
                    if ($isRestore) {
                        $builder->where('p.deleted_at IS NOT NULL');
                        $builder->where('k.jenis', $jenis);
                    } else {
                        $builder->where('p.deleted_at', null);
                        $builder->where('k.jenis', $jenis);
                    }
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('p.id', 'desc');
                })
                ->add('checkrow', function ($row) use ($isRestore) {
                    if (!$isRestore) {
                        return '<input type="checkbox" name="id[]" class="checkrow" value="' . $row->id . '">';
                    }
                })
                ->add('action', function ($row) use ($isRestore, $jenis) {
                    if ($isRestore) {
                        return '
                    <div class="btn-group mb-1">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="restore(' . $row->id . ', ' . $row->barang_id . ',\'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_anggota) . '\')"><i class="fa fa-undo"></i> Pulihkan</a>
                        </li>
                        <li><a class="dropdown-item" onclick="hapuspermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_anggota) . '\', \'54\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a>
                        </li>
                    </ul>
                    </div>
                    ';
                    } else {
                        return '<div class="btn-group btn-group-sm mb-1">
                    <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="edit(' . $row->id . ')"><i class="fa fa-pencil-square-o"></i> Update Peminjaman</a>
                        </li>
                        <li><a class="dropdown-item" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_anggota) . '\', \'' . htmlspecialchars($row->nama_brg) . '\')"><i class="fa fa-trash-o"></i> Hapus Peminjaman</a>
                        </li>
                    </ul>
                </div>';
                    }
                })
                ->toJson(true);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }
}
