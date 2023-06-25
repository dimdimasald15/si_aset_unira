<?php

namespace App\Controllers;

use App\Models\Barang;
use App\Models\RiwayatBarang;
use App\Models\Kategori;
use App\Models\Ruang;
use App\Models\StokBarang;
use App\Models\RiwayatTransaksi;
use \Hermawan\DataTables\DataTable;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\Response;
use PHPUnit\Framework\Constraint\Count;

class BarangController extends BaseController
{
    protected $barang, $kategori, $uri, $stokbarang, $riwayatbarang, $ruang, $riwayattrx;
    public function __construct()
    {
        $this->barang = new Barang();
        $this->riwayatbarang = new RiwayatBarang();
        $this->kategori = new Kategori();
        $this->ruang = new Ruang();
        $this->stokbarang = new StokBarang();
        $this->riwayattrx = new RiwayatTransaksi();
        $this->uri = service('uri');
    }

    public function indexbarangtetap()
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
            'title' => 'Barang Tetap Masuk',
            'nav' => 'barang-tetap-masuk',
            'jenis_kat' => 'Barang Tetap',
            'breadcrumb' => $breadcrumb
        ];

        return view('barang/index', $data);
    }

    public function indexbarangpersediaan()
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
            'title' => 'Barang Persediaan Masuk',
            'nav' => 'barang-persediaan-masuk',
            'jenis_kat' => 'Barang Persediaan',
            'breadcrumb' => $breadcrumb
        ];

        return view('barang/index', $data);
    }

    public function listdatabarang()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getVar('jenis_kat');

            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);
            $builder = $this->db->table('stok_barang sb')
                ->select('sb.id, sb.barang_id, k.nama_kategori, b.nama_brg,b.warna, b.harga_beli, b.kode_brg, b.foto_barang, sb.jumlah_masuk, sb.jumlah_keluar, sb.sisa_stok, b.kat_id, sb.ruang_id, sb.satuan_id, sb.created_at, sb.created_by, sb.deleted_at, sb.deleted_by, r.nama_ruang')
                ->join('barang b', 'b.id=sb.barang_id')
                ->join('kategori k', 'k.id=b.kat_id ')
                ->join('ruang r', 'sb.ruang_id = r.id')
                ->join('satuan s', 'sb.satuan_id = s.id')
                ->where('r.id', 54);

            return DataTable::of($builder)
                ->addNumbering('no')
                ->filter(function ($builder, $request) use ($jenis, $isRestore) {
                    if (isset($request->barang) || isset($request->kategori)) {
                        if ($request->barang) {
                            $builder->where('sb.barang_id', $request->barang);
                        }
                        if ($request->kategori) {
                            $builder->where('b.kat_id', $request->kategori);
                        }
                    }
                    if ($isRestore) {
                        $builder->where('sb.deleted_at IS NOT NULL');
                        $builder->where('b.deleted_at IS NOT NULL');
                        $builder->where('k.jenis', $jenis);
                    } else {
                        $builder->where('sb.deleted_at', null);
                        $builder->where('b.deleted_at', null);
                        $builder->where('k.jenis', $jenis);
                    }
                })
                ->postQuery(function ($builder) {
                    $builder->orderBy('sb.id', 'desc');
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
                        <li><a class="dropdown-item" onclick="restore(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-undo"></i> Pulihkan</a>
                        </li>
                        <li><a class="dropdown-item" onclick="hapuspermanen(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a>
                        </li>
                    </ul>
                    </div>
                    ';
                    } else {
                        $action = '<div class="btn-group btn-group-sm mb-1">
                    <button type="button" class="btn btn-success dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="detailstokbarang(\'' . htmlspecialchars($row->kode_brg) . '\',' . $row->ruang_id . ')"><i class="fa fa-info-circle"></i> Detail Stok Barang</a>
                        </li>';
                        if ($jenis == "Barang Tetap") {
                            $action .= '<li><a class="dropdown-item" onclick="cetaklabel(' . $row->id . ')"><i class="fa fa-qrcode"></i> Cetak Label Barang</a>
                        </li>';
                        }
                        $action .= '<li><a class="dropdown-item" onclick="edit(' . $row->barang_id . ')"><i class="fa fa-pencil-square-o"></i> Update Barang</a>
                        </li>
                        <li><a class="dropdown-item" onclick="upload(' . $row->barang_id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->foto_barang) . '\')"><i class="bi bi-image"></i> Update Gambar Barang</a>
                        </li>
                        <li><a class="dropdown-item" onclick="hapus(' . $row->id . ', \'' . htmlspecialchars($row->nama_brg) . '\')"><i class="fa fa-trash-o"></i> Hapus Barang</a>
                        </li>
                    </ul>
                </div>';

                        return $action;
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

    public function tampilcardupload()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $nama_brg = $this->request->getVar('nama_brg');
            $fotobrg = $this->request->getVar('foto_barang');

            $data = [
                'id' => $id,
                'nama_brg' => $nama_brg,
                'fotobrg' => $fotobrg,
                'title' => 'Barang Tetap',
            ];

            $msg = [
                'sukses' => view('barang/cardupload', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function detailbarang($url)
    {
        $kdbrg = substr($url, 0, strrpos($url, "-")); // mendapatkan string "C-02-06-01-001"
        $kode_brg = str_replace('-', '.', $kdbrg);
        $ruang_id = substr($url, strrpos($url, "-") + 1); // mendapatkan string "6"

        $query   = $this->db->table('stok_barang sb')->select('sb.*, k.nama_kategori, b.nama_brg, b.kode_brg, b.foto_barang, b.harga_beli, b.harga_jual, b.asal, b.toko, b.instansi, b.no_seri, b.no_dokumen, b.merk, b.tgl_pembelian, b.warna, sb.ruang_id, r.nama_ruang, sb.satuan_id, s.kd_satuan, b.created_at, b.created_by, b.deleted_at')
            ->join('barang b', 'sb.barang_id = b.id')
            ->join('kategori k', 'b.kat_id = k.id')
            ->join('ruang r', 'sb.ruang_id = r.id')
            ->join('satuan s', 'sb.satuan_id = s.id')
            ->where('b.kode_brg', $kode_brg)
            ->where('sb.ruang_id', $ruang_id)
            ->groupBy('b.id')
            ->get();
        // dd($query->getRow());

        $result = $query->getRow();
        if ($result) {
            $title = 'Detail Barang ' . $result->nama_brg . ' di ' . $result->nama_ruang;
        } else {
            $title = 'Detail Barang';
        }

        $data = [
            'title' => $title,
            'barang' => $result,
        ];

        return view('barang/detailstokbarang', $data);
    }

    public function tampillabelbarang()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $jenis = $this->request->getVar('jenis_kat');

            $data = [
                'id' => $id,
                'title' => $jenis,
            ];
            $msg = [
                'sukses' => view('barang/modallabel', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getdatabarangbyid()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $barang = $this->db->table('barang b')
                ->select('b.id, b.kat_id, b.kode_brg, b.nama_brg, b.merk, b.warna, b.asal, b.harga_beli, b.harga_jual, b.toko, b.instansi, b.no_seri, b.no_dokumen, b.foto_barang, b.tgl_pembelian')
                ->where('id', $id);

            $result = $barang->get()->getRow();
            echo json_encode($result);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getdatastokbarangbyid()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $stokbrg = $this->db->table('stok_barang sb')->select('sb.*, k.nama_kategori, b.nama_brg, b.kode_brg, b.foto_barang, b.harga_beli, b.harga_jual, b.asal, b.toko, b.instansi, b.no_seri, b.no_dokumen, b.merk, b.tgl_pembelian, b.warna, r.nama_ruang, satuan_id, s.kd_satuan, b.created_at, b.created_by, b.deleted_at')
                ->join('barang b', 'sb.barang_id = b.id')
                ->join('kategori k', 'b.kat_id = k.id')
                ->join('ruang r', 'sb.ruang_id = r.id')
                ->join('satuan s', 'sb.satuan_id = s.id')
                ->where('sb.id', $id);

            $result = $stokbrg->get()->getRow();
            echo json_encode($result);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getbarangbyany()
    {
        if ($this->request->isAJAX()) {
            $kode_brg = $this->request->getVar('kode_brg');
            $id = $this->request->getVar('id');
            $getbarang = '';
            if (!empty($id)) {
                $getbarang = $this->db->table('stok_barang sb')
                    ->select('b.*, k.nama_kategori, k.kd_kategori, sb.jumlah_masuk, sb.satuan_id, sb.ruang_id, r.nama_ruang, s.kd_satuan')
                    ->join('barang b', 'sb.barang_id = b.id')
                    ->join('kategori k', 'b.kat_id = k.id')
                    ->join('ruang r', 'sb.ruang_id = r.id')
                    ->join('satuan s', 'sb.satuan_id = s.id')
                    ->where('b.id', $id)
                    ->get();
            } else if (!empty($kode_brg)) {
                $getbarang = $this->db->table('barang b')
                    ->select('b.id, b.kat_id, b.kode_brg, b.nama_brg, b.merk, b.warna, b.asal, b.harga_beli, b.harga_jual, b.toko, b.instansi, b.no_seri, b.no_dokumen, b.foto_barang, b.tgl_pembelian')
                    ->where('kode_brg', $kode_brg)
                    ->get();
            }

            if ($getbarang->getNumRows() > 0) {
                $data = $getbarang->getRow();
            } else {
                $data = 'data kosong';
            }
            echo json_encode($data);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function pilihbarang()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet('search');
            $jenis = $this->request->getGet('jenis_kat');

            if ($jenis == 'Barang Tetap') {
                if (!empty($search)) {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')
                        ->like('b.nama_brg', $search)->get();
                } else {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')->get();
                }
            } else if ($jenis == 'Barang Persediaan') {
                if (!empty($search)) {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')
                        ->like('b.nama_brg', $search)->get();
                } else {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')->get();
                }
            }
            // var_dump($databarang);
            if ($databarang->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($databarang->getResultArray() as $row) {
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['nama_brg'];

                    $key++;
                }
            } else {
                $list = [
                    ['id' => '', 'text' => 'Maaf keyword yang anda cari tidak ditemukan'],
                ];
            }
            echo json_encode($list);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function pilihkategori()
    {
        if ($this->request->isAJAX()) {
            $caridata = $this->request->getGet('search');
            $jenis = $this->request->getGet('jenis_kat');
            $datakategori = '';
            if ($jenis == 'Barang Tetap') {
                if (!empty($caridata)) {
                    $datakategori = $this->db->table('kategori')
                        ->like('nama_kategori', $caridata)
                        ->where('jenis', $jenis)
                        ->where('SUBSTRING(kd_kategori, 1, 1) !=', 'A')
                        ->where('LENGTH(kd_kategori) >=', 7)
                        ->where('deleted_at', null)
                        ->orderBy('nama_kategori', 'ASC')
                        ->get();
                } else {
                    $datakategori = $this->db->table('kategori')
                        ->where('jenis', $jenis)
                        ->where('SUBSTRING(kd_kategori, 1, 1) !=', 'A')
                        ->where('LENGTH(kd_kategori) >=', 7)
                        ->where('deleted_at', null)
                        ->orderBy('nama_kategori', 'ASC')
                        ->get();
                }
            } else if ($jenis == 'Barang Persediaan') {
                if (!empty($caridata)) {
                    $datakategori = $this->db->table('kategori')
                        ->like('nama_kategori', $caridata)
                        ->where('jenis', $jenis)
                        ->where('LENGTH(kd_kategori) >=', 4)
                        ->where('deleted_at', null)
                        ->orderBy('nama_kategori', 'ASC')
                        ->get();
                } else {
                    $datakategori = $this->db->table('kategori')
                        ->where('jenis', $jenis)
                        ->where('LENGTH(kd_kategori) >=', 4)
                        ->where('deleted_at', null)
                        ->orderBy('nama_kategori', 'ASC')
                        ->get();
                }
            }

            if ($datakategori->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($datakategori->getResultArray() as $row) {
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['nama_kategori'];

                    $key++;
                }
            } else {
                $list = [
                    ['id' => '', 'text' => 'Maaf keyword yang anda cari tidak ditemukan'],
                ];
            }
            echo json_encode($list);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function pilihlokasi()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet('search');
            if (!empty($search)) {
                $datalokasi = $this->db->table('ruang')->where('deleted_at', null)->orderBy('nama_ruang', 'ASC')
                    ->like('nama_ruang', $search)->get();
            } else {
                $datalokasi = $this->db->table('ruang')->where('deleted_at', null)->orderBy('nama_ruang', 'ASC')->get();
            }
            // var_dump($datalokasi);
            if ($datalokasi->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($datalokasi->getResultArray() as $row) {
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['nama_ruang'];

                    $key++;
                }
            } else {
                $list = [
                    ['id' => '', 'text' => 'Maaf keyword yang anda cari tidak ditemukan'],
                ];
            }
            echo json_encode($list);
        } else {
            $data = [
                'message' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/html/error_404', $data);
        }
    }

    public function pilihsatuan()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet('search');
            $datasatuan = $this->db->table('satuan')
                ->like('kd_satuan', $search)->get();
            // var_dump($datasatuan);
            if ($datasatuan->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($datasatuan->getResultArray() as $row) {
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['kd_satuan'];

                    $key++;
                }
            } else {
                $list = [
                    ['id' => '', 'text' => 'Maaf keyword yang anda cari tidak ditemukan'],
                ];
            }
            echo json_encode($list);
        } else {
            $data = [
                'message' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/html/error_404', $data);
        }
    }

    public function pilihwarna()
    {
        if ($this->request->isAJAX()) {
            $search = $this->request->getGet('search');
            if (!is_string($search)) {
                // Handle invalid search parameter
                return $this->response->setJSON([]);
            }
            $datawarna = [
                'aliceblue' => '#F0F8FF',
                'antiquewhite' => '# FAEBD7',
                'aqua' => '#00FFFF',
                'aquamarine' => '#7FFFD4',
                'azure' => '#F0FFFF',
                'krem' => '#F5F5DC',
                'bisque' => '#FFE4C4',
                'hitam' => '#000000',
                'blanchedalmond' => '#FFEBCD',
                'biru' => '#0000FF',
                'blueviolet' => '#8A2BE2',
                'brown' => '#A52A2A',
                'burlywood' => '# DEB887',
                'cadetblue' => '#5F9EA0',
                'chartreuse' => '#7FFF00',
                'coklat' => '#D2691E',
                'koral' => '# FF7F50',
                'cornflowerblue' => '#6495ED',
                'cornsilk' => '#FFF8DC',
                'crimson' => '# DC143C',
                'cyan' => '#00FFFF',
                'darkblue' => '#00008B',
                'darkcyan' => '#008B8B',
                'darkgoldenrod' => '#B8860B',
                'darkgray' => '#A9A9A9',
                'darkgreen' => '#006400',
                'darkgrey' => '#A9A9A9',
                'darkkhaki' => '# BDB76B',
                'darkmagenta' => '#8B008B',
                'darkolivegreen' => '#556B2F',
                'darkorange' => '# FF8C00',
                'darkorchid' => '#9932CC',
                'darkred' => '#8B0000',
                'darksalmon' => '#E9967A',
                'darkseagreen' => '#8FBC8F',
                'darkslateblue' => '#483D8B',
                'darkslategray' => '#2F4F4F',
                'darkslategrey' => '#2F4F4F',
                'darkturquoise' => '#00CED1',
                'darkviolet' => '#9400D3',
                'deeppink' => '# FF1493',
                'deepskyblue' => '#00BFFF',
                'dimgray' => '#696969',
                'dimgrey' => '#696969',
                'dodgerblue' => '#1E90FF',
                'firebrick' => '#B22222',
                'floralwhite' => '#FFFAF0',
                'forestgreen' => '#228B22',
                'fuchsia' => '# FF00FF',
                'gainsboro' => '#DCDCDC',
                'ghostwhite' => '#F8F8FF',
                'gold' => '# FFD700',
                'goldenrod' => '# DAA520',
                'abu-abu' => '#808080',
                'hijau' => '#008000',
                'greenyellow' => '# ADFF2F',
                'abu-abu' => '#808080',
                'honeydew' => '#F0FFF0',
                'hotpink' => '# FF69B4',
                'indianred' => '# CD5C5C',
                'indigo' => '#4B0082',
                'ivory' => '#FFFFF0',
                'khaki' => '#F0E68C',
                'lavender' => '#E6E6FA',
                'lavenderblush' => '#FFF0F5',
                'lawngreen' => '#7CFC00',
                'lemonchiffon' => '#FFFACD',
                'lightblue' => '#ADD8E6',
                'lightcoral' => '#F08080',
                'lightcyan' => '#E0FFFF',
                'lightgoldenrodyellow' => '#FAFAD2',
                'lightgray' => '#D3D3D3',
                'lightgreen' => '#90EE90',
                'lightgrey' => '#D3D3D3',
                'lightpink' => '# FFB6C1',
                'lightsalmon' => '#FFA07A',
                'lightseagreen' => '#20B2AA',
                'lightskyblue' => '#87CEFA',
                'lightslategray' => '#778899',
                'lightslategrey' => '#778899',
                'lightsteelblue' => '#B0C4DE',
                'lightyellow' => '#FFFFE0',
                'lime' => '#00FF00',
                'limegreen' => '#32CD32',
                'linen' => '#FAF0E6',
                'magenta' => '# FF00FF',
                'maroon' => '#800000',
                'mediumaquamarine' => '#66CDAA',
                'mediumblue' => '#0000CD',
                'mediumorchid' => '# BA55D3',
                'mediumpurple' => '#9370D0',
                'mediumseagreen' => '#3CB371',
                'mediumslateblue' => '#7B68EE',
                'mediumspringgreen' => '#00FA9A',
                'mediumturquoise' => '#48D1CC',
                'mediumvioletred' => '#C71585',
                'midnightblue' => '#191970',
                'mintcream' => '#F5FFFA',
                'mistyrose' => '#FFE4E1',
                'moccasin' => '#FFE4B5',
                'navajowhite' => '#FFDEAD',
                'navy' => '#000080',
                'oldlace' => '#FDF5E6',
                'olive' => '#808000',
                'olivedrab' => '#6B8E23',
                'orange' => '#FFA500',
                'orangered' => '#FF4500',
                'anggrek' => '# DA70D6',
                'palegoldenrod' => '#EEE8AA',
                'palegreen' => '#98FB98',
                'paleturquoise' => '# AFEEEE',
                'palevioletred' => '# DB7093',
                'papayawhip' => '#FFEFD5',
                'peachpuff' => '# FFDAB9',
                'peru' => '# CD853F',
                'pink' => '# FFC0CB',
                'prem' => '#DDA0DD',
                'powderblue' => '#B0E0E6',
                'ungu' => '#800080',
                'merah' => '#FF0000',
                'rosybrown' => '# BC8F8F',
                'royalblue' => '#4169E1',
                'saddlebrown' => '#8B4513',
                'salmon' => '# FA8072',
                'sandybrown' => '#F4A460',
                'seagreen' => '#2E8B57',
                'seashell' => '#FFF5EE',
                'sienna' => '#A0522D',
                'silver' => '#C0C0C0',
                'skyblue' => '#87CEEB',
                'slateblue' => '#6A5ACD',
                'slategray' => '#708090',
                'slategrey' => '#708090',
                'snow' => '#FFFAFA',
                'springgreen' => '#00FF7F',
                'steelblue' => '#4682B4',
                'tan' => '#D2B48C',
                'teal' => '#008080',
                'thistle' => '#D8BFD8',
                'tomato' => '#FF6347',
                'turquoise' => '#40E0D0',
                'violet' => '#EE82EE',
                'wheat' => '#F5DEB3',
                'putih' => '#FFFFFF',
                'whitesmoke' => '#F5F5F5',
                'kuning' => '#FFFF00',
                'yellowgreen' => '#9ACD32'
            ];

            $results = [];
            foreach ($datawarna as $warna => $kode) {
                if (stripos($warna, $search) !== false) {
                    $results[] = [
                        'id' => $warna,
                        'text' => $warna,
                        'kode' => $kode,
                    ];
                }
            }

            return $this->response->setJSON($results);
        } else {
            $data = [
                'message' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/html/error_404', $data);
        }
    }

    public function cekbrgdanruang()
    {
        if ($this->request->isAJAX()) {
            $barang_id = $this->request->getVar('barang_id');
            $ruang_id = $this->request->getVar('ruang_id');

            $stokbarang = $this->db->table('stok_barang sb')->select('sb.id, sb.sisa_stok, sb.tgl_beli, b.nama_brg,r.nama_ruang, sb.satuan_id, s.kd_satuan')
                ->join('ruang r', 'r.id = sb.ruang_id')
                ->join('satuan s', 's.id = sb.satuan_id')
                ->join('barang b', 'b.id = sb.barang_id')
                ->where('sb.barang_id', $barang_id)
                ->where('sb.ruang_id', $ruang_id)
                ->get()->getRow();

            echo json_encode($stokbarang);
        } else {
            $data = [
                'message' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/html/error_404', $data);
        }
    }

    public function getsubkdbarang()
    {
        if ($this->request->isAJAX()) {
            $katid = $this->request->getVar('katid');
            $cekkatid = $this->barang->select('*')->where('kat_id', $katid)->get()->getRow();
            if ($cekkatid !== null) {
                $subkdbarang = $this->db->query("SELECT SUBSTR(b.kode_brg, -3) AS subkdbarang, k.kd_kategori FROM barang b JOIN kategori k ON b.kat_id = k.id WHERE b.kat_id = $katid ORDER BY b.id DESC");

                $result = $subkdbarang->getResultArray();
            } else {
                $subkdbarang = $this->db->table('kategori')->select('kd_kategori')->where('id', $katid)->get();
                if ($subkdbarang) {
                    $result = $subkdbarang->getResultArray();
                } else {
                    $result = [];
                }
            }

            echo json_encode($result);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function getkdbrgbykdkat()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('katid');
            $getkdbarang = $this->db->table('barang b')
                ->select('SUBSTR(b.kode_brg, -3) AS subkdbarang, k.kd_kategori')
                ->join('kategori k', 'b.kat_id = k.id')
                ->where('b.kat_id', $id)
                ->orderBy('b.id', 'DESC')
                ->limit(1)
                ->get()
                ->getRow();
            if (empty($getkdbarang)) {
                $kd_kat = $this->kategori->find($id);

                $msg = [
                    'subkdkat' => $kd_kat['kd_kategori'],
                    'subkdbrgother' => '001',
                ];
            } else {
                // mengambil angka dari string lalu menambahkannya dengan 1
                $subkdbarang = (int)($getkdbarang->subkdbarang) + 1;
                // mengubah angka menjadi string dengan 3 karakter dan diisi dengan "0" jika kurang dari 3 karakter
                $sbkdbrgbaru = str_pad((string)$subkdbarang, 3, "0", STR_PAD_LEFT);

                $msg = [
                    'subkdkat' => $getkdbarang->kd_kategori,
                    'subkdbrgother' => $sbkdbrgbaru,
                ];
            }

            echo json_encode($msg);
        }
    }

    public function getmodalpangkasgambar()
    {
        if ($this->request->isAJAX()) {

            $msg = [
                'data' => view('barang/modalpangkasgambar'),
            ];

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampiltambahstok()
    {
        if ($this->request->isAJAX()) {
            $title = $this->request->getVar('title');
            $jenis_kat = $this->request->getVar('jenis_kat');
            $jenistrx = $this->request->getVar('jenistrx');
            $nav = $this->request->getVar('nav');
            $saveMethod = $this->request->getVar('saveMethod');

            $data = [
                'title' => $title,
                'jenis_kat' => $jenis_kat,
                'jenistrx' => $jenistrx,
                'nav' => $nav,
                'saveMethod' => $saveMethod,
            ];

            $msg = [
                'data' => view('barang/formtambahstok', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampiltambahbarangmultiple()
    {
        if ($this->request->isAJAX()) {
            $title = $this->request->getVar('title');
            $jenis_kat = $this->request->getVar('jenis_kat');
            $jenistrx = $this->request->getVar('jenistrx');
            $nav = $this->request->getVar('nav');
            $saveMethod = $this->request->getVar('saveMethod');

            $data = [
                'title' => $title,
                'jenis_kat' => $jenis_kat,
                'jenistrx' => $jenistrx,
                'nav' => $nav,
                'saveMethod' => $saveMethod,
            ];

            $msg = [
                'data' => view('barang/formmultipleinsert', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampiltambahstokmultiple()
    {
        if ($this->request->isAJAX()) {
            $title = $this->request->getVar('title');
            $jenis_kat = $this->request->getVar('jenis_kat');
            $jenistrx = $this->request->getVar('jenistrx');
            $nav = $this->request->getVar('nav');
            $saveMethod = $this->request->getVar('saveMethod');

            $data = [
                'title' => $title,
                'jenis_kat' => $jenis_kat,
                'jenistrx' => $jenistrx,
                'nav' => $nav,
                'saveMethod' => $saveMethod,
            ];

            $msg = [
                'data' => view('barang/formtambahstokmultiple', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampilsingleform()
    {
        if ($this->request->isAJAX()) {
            $jenis_kat = $this->request->getVar('jenis_kat');
            $nav = $this->request->getVar('nav');
            $jenistrx = $this->request->getVar('jenistrx');
            $saveMethod = $this->request->getVar('saveMethod');
            $data = [
                'jenis_kat' => $jenis_kat,
                'nav' => $nav,
                'jenistrx' => $jenistrx,
                'saveMethod' => $saveMethod,
            ];
            $msg = [
                'data' => view('barang/formsingleinsert', $data)
            ];
            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampileditform()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $title = $this->request->getVar('jenis_kat');
            $nav = $this->request->getVar('nav');
            $jenistrx = "Update " . $this->request->getVar('jenistrx');
            $saveMethod = $this->request->getVar('saveMethod');

            $data = [
                'id' => $id,
                'title' => $title,
                'nav' => $nav,
                'jenistrx' => $jenistrx,
                'saveMethod' => $saveMethod,
            ];
            $msg = [
                'data' => view('barang/formsingleedit', $data)
            ];
            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }



    public function simpandatabarang()
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kat_id' => [
                    'label' => 'Kode Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'kode_brg' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required|is_unique[barang.kode_brg]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada dan tidak boleh sama',
                    ],
                ],
                'nama_brg' => [
                    'label' => 'Nama Barang',
                    'rules' => 'required|is_unique[barang.nama_brg]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} sudah ada dan tidak boleh sama',
                    ]
                ],
                'merk' => [
                    'label' => 'Merk barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'asal' => [
                    'label' => 'Asal barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'harga_beli' => [
                    'label' => 'Harga beli barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} tidak boleh kosong",
                    ]
                ],
                'harga_jual' => [
                    'label' => 'Harga jual barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} tidak boleh kosong",
                    ]
                ],
                'ruang_id' => [
                    'label' => 'Nama ruang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jumlah_masuk' => [
                    'label' => 'Jumlah masuk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'satuan_id' => [
                    'label' => 'Nama satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'katid' => $validation->getError('kat_id'),
                        'kodebrg' => $validation->getError('kode_brg'),
                        'namabarang' => $validation->getError('nama_brg'),
                        'merk' => $validation->getError('merk'),
                        'asal' => $validation->getError('asal'),
                        'hargabeli' => $validation->getError('harga_beli'),
                        'hargajual' => $validation->getError('harga_jual'),
                        'jmlmasuk' => $validation->getError('jumlah_masuk'),
                        'lokasi' => $validation->getError('ruang_id'),
                        'satuan' => $validation->getError('satuan_id'),
                    ],
                ];
            } else {
                $namabrg = $this->request->getVar('nama_brg');
                $tgl_pembelian = $this->request->getVar('tgl_pembelian');

                $simpanbrg = [
                    'kat_id' => $this->request->getVar('kat_id'),
                    'kode_brg' => $this->request->getVar('kode_brg'),
                    'nama_brg' => $namabrg,
                    'merk' => $this->request->getVar('merk'),
                    'warna' => $this->request->getVar('warna'),
                    'asal' => $this->request->getVar('asal'),
                    'toko' => $this->request->getVar('toko'),
                    'instansi' => $this->request->getVar('instansi'),
                    'no_seri' => $this->request->getVar('no_seri'),
                    'no_dokumen' => $this->request->getVar('no_dokumen'),
                    'harga_beli' => $this->request->getVar('harga_beli'),
                    'harga_jual' => $this->request->getVar('harga_jual'),
                    'tgl_pembelian' => $tgl_pembelian,
                ];

                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertbrg = $this->barang->setInsertData($simpanbrg);
                // Simpan data ke database
                $this->barang->save($insertbrg);

                $barang_id = $this->barang->insertID();

                $jenistrx = $this->request->getVar('jenistrx');
                $jml_keluar = 0;
                $jml_masuk = intval($this->request->getVar('jumlah_masuk'));
                $sisa_stok = $jml_masuk - $jml_keluar;

                $simpanstok = [
                    'barang_id' => $barang_id,
                    'ruang_id' => $this->request->getVar('ruang_id'),
                    'satuan_id' => $this->request->getVar('satuan_id'),
                    'jumlah_masuk' => $this->request->getVar('jumlah_masuk'),
                    'jumlah_keluar' => $jml_keluar,
                    'sisa_stok' => $sisa_stok,
                    'tgl_beli' => $tgl_pembelian,
                ];

                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertstok = $this->stokbarang->setInsertData($simpanstok);

                // Simpan data ke database
                $this->stokbarang->save($insertstok);

                $stokbrg_id = $this->stokbarang->insertID();

                $lastQuery = $this->db->getLastQuery();

                $this->riwayatbarang->inserthistori($barang_id, null, $simpanbrg, $lastQuery, null);

                $this->riwayattrx->inserthistori($stokbrg_id, null, $simpanstok, $jenistrx, $lastQuery, null);

                $msg = ['sukses' => 'Data barang berhasil tersimpan'];
            }
            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function updatedatastok($id)
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'barang_id' => [
                    'label' => 'Nama barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'jumlah_masuk' => [
                    'label' => 'Jumlah masuk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgl_pembelian' => [
                    'label' => 'Tanggal Pembelian',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'idbrg' => $validation->getError('barang_id'),
                        'jmlmasuk' => $validation->getError('jumlah_masuk'),
                        'tglbeli' => $validation->getError('tgl_pembelian'),
                    ],
                ];
            } else {
                $stokbrglama = $this->db->table('stok_barang sb')->select('sb.*, b.nama_brg')->join('barang b', 'b.id = sb.barang_id')->where('sb.id', $id)->get()->getRowArray();

                $jml_masuk = intval($stokbrglama['jumlah_masuk']) + intval($this->request->getVar('jumlah_masuk'));
                $jml_keluar = $stokbrglama['jumlah_keluar'];
                $namabrg = $stokbrglama['nama_brg'];
                $sisa_stok = $jml_masuk - $jml_keluar;
                $jenistrx = $this->request->getVar('jenis_transaksi');
                $tglbeli = $this->request->getVar('tgl_pembelian');
                if ($tglbeli) {
                    $tgl_beli = $tglbeli;
                } else
                    $tgl_beli = '';

                $updatedata = [
                    'jumlah_masuk' => $jml_masuk,
                    'sisa_stok' => $sisa_stok,
                    'tgl_beli' => $tgl_beli,
                ];

                $ubahdata = $this->stokbarang->setUpdateData($updatedata);

                //periksa perubahan data
                $data_lama = $stokbrglama;
                $data_baru = $updatedata;
                $field_update = [];
                foreach ($data_baru as $key => $value) {
                    if (isset($data_lama[$key]) && $data_lama[$key] !== $value) {
                        $field_update[] = $key;
                    }
                }
                // update data ke database
                $this->stokbarang->update($id, $ubahdata);
                // Periksa apakah query terakhir adalah operasi update
                $lastQuery = $this->db->getLastQuery();

                // jenis transaksi : 'barang tetap masuk','barang persediaan masuk','permintaan barang','peminjaman barang','perbaikan barang rusak','penghapusan barang rusak'
                $this->riwayattrx->inserthistori($id, $stokbrglama, $updatedata, "$jenistrx", $lastQuery, $field_update);

                $msg = ['sukses' => "Data stok barang: $namabrg berhasil terupdate"];
            }

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function updatedatastokmultiple()
    {
        if ($this->request->isAJAX()) {
            $jenistrx = $this->request->getVar('jenistrx');
            $jmldata = $this->request->getVar('jmldata');

            $validation =  \Config\Services::validation();
            $errors = array();
            for ($a = 1; $a <= $jmldata; $a++) {
                $rules = [
                    'barang_id' . $a => [
                        'label' => 'Nama Barang',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ]
                    ],
                    'ruang_id_' . $a => [
                        'label' => 'Nama ruang',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ]
                    ],
                    'jumlah_masuk_' . $a => [
                        'label' => 'Jumlah masuk',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ]
                    ],
                    'tgl_pembelian_' . $a => [
                        'label' => 'Tanggal pembelian baru',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ],
                    ],
                ];
                if (!$this->validate($rules)) {
                    $errors = $validation->getErrors();
                }
            }

            // check for errors
            if (!empty($errors)) {
                $msg = [
                    'jmldata' => $jmldata,
                    'error' => $errors
                ];
            } else {
                $id = array();
                // $barang_id = array();
                $ruang_id = array();
                $satuan_id = array();
                $jmlmskbaru = array();
                $jmlkeluarbaru = array();
                $tglbelibaru = array();

                $jmldata = intval($this->request->getVar('jmldata'));
                for ($x = 1; $x <= $jmldata; $x++) {
                    array_push($id, $this->request->getVar("id_$x"));
                    array_push($tglbelibaru, $this->request->getVar("tgl_pembelian_$x"));
                    array_push($jmlmskbaru, $this->request->getVar("jumlah_masuk_$x"));
                    array_push($satuan_id, $this->request->getVar("satuan_id$x"));
                }

                $stoklama = array();
                for ($y = 0; $y < $jmldata; $y++) {
                    $stoklama[] = $this->db->table('stok_barang')->select('*')->where('id', $id[$y])->get()->getRowArray();
                }

                $jumlah_masuk = array();
                $jumlah_keluar = array();
                $sisa_stok = array();
                for ($z = 0; $z < $jmldata; $z++) {
                    array_push($jumlah_masuk, (intval($jmlmskbaru[$z]) + $stoklama[$z]["jumlah_masuk"]));
                    array_push($sisa_stok, (intval($jmlmskbaru[$z]) + $stoklama[$z]["jumlah_masuk"] - $stoklama[$z]["jumlah_keluar"]));
                }

                $this->db->transStart();

                for ($i = 0; $i < $jmldata; $i++) {
                    $updatedata = [
                        'jumlah_masuk' => $jumlah_masuk[$i],
                        'sisa_stok' => $sisa_stok[$i],
                        'tgl_beli' => $tglbelibaru[$i],
                    ];
                    $ubahdata = $this->stokbarang->setUpdateData($updatedata);

                    //periksa perubahan data
                    $data_lama = $stoklama[$i];
                    $data_baru = $updatedata;
                    $field_update = [];
                    foreach ($data_baru as $key => $value) {
                        if (isset($data_lama[$key]) && $data_lama[$key] !== $value) {
                            $field_update[] = $key;
                        }
                    }
                    // update data ke database
                    $this->stokbarang->update($id[$i], $ubahdata);

                    // Periksa apakah query terakhir adalah operasi update
                    $lastQuery = $this->db->getLastQuery();

                    // jenis transaksi : 'barang tetap masuk','barang persediaan masuk','permintaan barang','peminjaman barang','perbaikan barang rusak','penghapusan barang rusak'
                    $this->riwayattrx->inserthistori($id[$i], $stoklama[$i], $updatedata, $jenistrx, $lastQuery, $field_update);
                }

                $this->db->transComplete();
                if ($this->db->transStatus() === false) {
                    // Jika terjadi kesalahan pada transaction
                    $msg = ['error' => 'Gagal menyimpan data stok barang'];
                } else {
                    // Jika berhasil disimpan
                    $msg = ['sukses' => "Sukses $jmldata data stok barang berhasil di update"];
                }
            }
            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function transfermultiplebarang()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getVar('jenis');
            $jenistrx = $this->request->getVar('jenistrx');
            $jmldata = $this->request->getVar('jmldata');
            // echo $jmldata;

            $validation =  \Config\Services::validation();
            $errors = array();
            for ($a = 1; $a <= $jmldata; $a++) {
                $rules = [
                    'ruang_id' . $a => [
                        'label' => 'Nama ruang',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ]
                    ],
                    'jumlah_keluar' . $a => [
                        'label' => 'Jumlah keluar',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ]
                    ],
                ];
                if (!$this->validate($rules)) {
                    $errors = $validation->getErrors();
                }
            }
            // check for errors
            if (!empty($errors)) {
                $msg = [
                    'jmldata' => $jmldata,
                    'error' => $errors
                ];
            } else {
                $id = array();
                $barang_id = array();
                $ruang_id = array();
                $satuan_id = array();
                $jumlah_keluar_sarpras = array();
                $sisa_stok_sarpras = array();
                $stoksarpras = array();
                $jumlah_masuk = array();
                $jumlah_keluar = array();
                $sisa_stok = array();
                $tgl_beli = array();

                // persiapan update stok barang dengan sisa stok baru
                for ($x = 1; $x <= $jmldata; $x++) {
                    array_push($id, $this->request->getVar("id_$x"));
                    $stoksarpras[] = $this->db->table('stok_barang')->select('*')->where('id', $this->request->getVar("id_$x"))->get()->getRowArray();
                    array_push($jumlah_keluar_sarpras, (intval($this->request->getVar("jumlah_keluar$x")) + $stoksarpras[$x - 1]['jumlah_keluar']));
                    array_push($sisa_stok_sarpras, $this->request->getVar("sisa_stok$x"));
                }

                // persiapan tambah stok barang dengan data baru
                for ($y = 1; $y <= $jmldata; $y++) {
                    array_push($barang_id, $stoksarpras[$y - 1]['barang_id']);
                    array_push($ruang_id, $this->request->getVar("ruang_id$y"));
                    array_push($jumlah_masuk, $this->request->getVar("jumlah_keluar$y"));
                    array_push($jumlah_keluar, 0);
                    array_push($sisa_stok, $this->request->getVar("jumlah_keluar$y") - 0);
                    array_push($satuan_id, $stoksarpras[$y - 1]['satuan_id']);
                    array_push($tgl_beli, $this->request->getVar("tgl_belilama$y"));
                }

                $stokbrgall = $this->stokbarang->select('*')->get()->getResultArray();

                $this->db->transStart();
                $datalamastokbrg = array();
                for ($i = 0; $i < $jmldata; $i++) {
                    //pengubahan data di stok barang sarana dan prasarana
                    $updatedata1 = [
                        'jumlah_keluar' => $jumlah_keluar_sarpras[$i],
                        'sisa_stok' => $sisa_stok_sarpras[$i],
                    ];

                    $ubahdata1 = $this->stokbarang->setUpdateData($updatedata1);

                    //periksa perubahan data
                    $data_lama1 = $stoksarpras[$i];
                    $data_baru1 = $updatedata1;
                    $field_update1 = [];
                    foreach ($data_baru1 as $key => $value) {
                        if (isset($data_lama1[$key]) && $data_lama1[$key] !== $value) {
                            $field_update1[] = $key;
                        }
                    }
                    // update data ke database
                    $this->stokbarang->update($id[$i], $ubahdata1);

                    // Periksa apakah query terakhir adalah operasi update
                    $lastQuery1 = $this->db->getLastQuery();

                    $this->riwayattrx->inserthistori($id[$i], $stoksarpras[$i], $updatedata1, "update $jenis masuk", $lastQuery1, $field_update1);

                    $data_ditemukan = false;
                    $isDeleted = false;
                    $isSameLocation = false;
                    for ($j = 0; $j < count($stokbrgall); $j++) {
                        if ($barang_id[$i] == $stokbrgall[$j]['barang_id'] && $ruang_id[$i] == $stoksarpras[$i]['ruang_id'] && $stokbrgall[$j]['deleted_at'] == null) {
                            $data_ditemukan = true;
                            $isSameLocation = true;
                            $isDeleted = false;
                        } else if ($barang_id[$i] == $stokbrgall[$j]['barang_id'] && $ruang_id[$i] == $stokbrgall[$j]['ruang_id'] && $stokbrgall[$j]['deleted_at'] == null) {
                            $data_ditemukan = true;
                            $isSameLocation = false;
                            $isDeleted = false;
                            array_push($datalamastokbrg, $stokbrgall[$j]);
                        } else if ($barang_id[$i] == $stokbrgall[$j]['barang_id'] && $ruang_id[$i] == $stokbrgall[$j]['ruang_id'] && $stokbrgall[$j]['deleted_at'] !== null) {
                            $data_ditemukan = true;
                            $isDeleted = true;
                            $isSameLocation = false;
                            array_push($datalamastokbrg, $stokbrgall[$j]);
                        }
                    }

                    if (!$data_ditemukan) {
                        // echo "data tidak ditemukan";
                        //Inset stok barang di ruang yang baru
                        $simpandata = [
                            'barang_id' => $barang_id[$i],
                            'ruang_id' => $ruang_id[$i],
                            'satuan_id' => $satuan_id[$i],
                            'jumlah_masuk' => $jumlah_masuk[$i],
                            'jumlah_keluar' => $jumlah_keluar[$i],
                            'sisa_stok' => $sisa_stok[$i],
                            'tgl_beli' => $tgl_beli[$i],
                        ];
                        // Panggil fungsi setInsertData dari model sebelum data disimpan
                        $insertdata = $this->stokbarang->setInsertData($simpandata);
                        // Simpan data ke database
                        $this->stokbarang->save($insertdata);

                        $stokbrg_id = $this->stokbarang->insertID();

                        //Simpan ke dalam table riwayat_transaksi
                        $data_riwayat = $insertdata;
                        $data_riwayat['stokbrg_id'] = $stokbrg_id;
                        $data_riwayat['jenis_transaksi'] = $jenistrx;
                        $data_riwayat['field'] = 'Semua field';
                        $data_riwayat['old_value'] = '';
                        $data_riwayat['new_value'] = json_encode($insertdata);
                        $setdatariwayat = $this->riwayattrx->setInsertData($data_riwayat);
                        $this->riwayattrx->save($setdatariwayat);
                    } else if ($data_ditemukan && !$isSameLocation && !$isDeleted) {
                        $updatedata2 = [
                            'jumlah_masuk' => ($datalamastokbrg[$i]['jumlah_masuk'] + intval($jumlah_masuk[$i])),
                            'jumlah_keluar' => 0,
                            'sisa_stok' => (intval($datalamastokbrg[$i]['sisa_stok']) + intval($jumlah_masuk[$i])),
                        ];
                        $ubahdata2 = $this->stokbarang->setUpdateData($updatedata2);

                        //periksa perubahan data
                        $data_lama2 = $datalamastokbrg[$i];
                        $data_baru2 = $updatedata2;
                        $field_update2 = [];
                        foreach ($data_baru2 as $key => $value) {
                            if (isset($data_lama2[$key]) && $data_lama2[$key] !== $value) {
                                $field_update2[] = $key;
                            }
                        }
                        // update data ke database
                        $this->stokbarang->update($datalamastokbrg[$i]['id'], $ubahdata2);

                        // Periksa apakah query terakhir adalah operasi update
                        $lastQuery2 = $this->db->getLastQuery();

                        $this->riwayattrx->inserthistori($datalamastokbrg[$i]['id'], $datalamastokbrg[$i], $updatedata2, "update $jenistrx", $lastQuery2, $field_update2);
                    } else if ($data_ditemukan && !$isSameLocation && $isDeleted) {
                        // echo "data ditemukan, lokasi tidak sama dan namun data terhapus";
                        $updatedata2 = [
                            'jumlah_masuk' => ($datalamastokbrg[$i]['jumlah_masuk'] + intval($jumlah_masuk[$i])),
                            'jumlah_keluar' => 0,
                            'sisa_stok' => (intval($datalamastokbrg[$i]['sisa_stok']) + intval($jumlah_masuk[$i])),
                            'deleted_by' => null,
                            'deleted_at' => null,
                        ];
                        $ubahdata2 = $this->stokbarang->setUpdateData($updatedata2);

                        //periksa perubahan data
                        $data_lama2 = $datalamastokbrg[$i];
                        $data_baru2 = $updatedata2;
                        $field_update2 = [];
                        foreach ($data_baru2 as $key => $value) {
                            if (isset($data_lama2[$key]) && $data_lama2[$key] !== $value) {
                                $field_update2[] = $key;
                            }
                        }
                        // update data ke database
                        $this->stokbarang->update($datalamastokbrg[$i]['id'], $ubahdata2);

                        // Periksa apakah query terakhir adalah operasi update
                        $lastQuery2 = $this->db->getLastQuery();

                        $this->riwayattrx->inserthistori($datalamastokbrg[$i]['id'], $datalamastokbrg[$i], $updatedata2, "update $jenistrx", $lastQuery2, $field_update2);
                    }
                }

                if ($data_ditemukan && $isSameLocation && !$isDeleted) {
                    // echo "data ditemukan, lokasi sama dan namun data tidak terhapus";

                    $msg = [
                        'error' =>
                        [
                            'isSarpras' => 'Tidak boleh memasukkan ruang yang sama!',
                        ]
                    ];
                } else {
                    $this->db->transComplete();
                    if ($this->db->transStatus() === false) {
                        // Jika terjadi kesalahan pada transaction
                        $msg = [
                            'error' =>
                            [
                                'transStatus' => 'Gagal menyimpan data stok barang',
                            ]
                        ];
                    } else {
                        // Jika berhasil disimpan
                        $msg = ['sukses' => "Sukses $jmldata data stok barang berhasil di pindahkan dari ruangan sebelumnya"];
                    }
                }
            }

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function updatedatabarang($id)
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kat_id' => [
                    'label' => 'Kode Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'kode_brg' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'nama_brg' => [
                    'label' => 'Nama Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'merk' => [
                    'label' => 'Merk barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'asal' => [
                    'label' => 'Asal barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'harga_beli' => [
                    'label' => 'Harga beli barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} tidak boleh kosong",
                    ]
                ],
                'harga_jual' => [
                    'label' => 'Harga jual barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} tidak boleh kosong",
                    ]
                ],
                'ruang_id' => [
                    'label' => 'Nama ruang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jumlah_masuk' => [
                    'label' => 'Jumlah masuk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'satuan_id' => [
                    'label' => 'Nama satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'katid' => $validation->getError('kat_id'),
                        'kodebrg' => $validation->getError('kode_brg'),
                        'namabarang' => $validation->getError('nama_brg'),
                        'merk' => $validation->getError('merk'),
                        'asal' => $validation->getError('asal'),
                        'hargabeli' => $validation->getError('harga_beli'),
                        'hargajual' => $validation->getError('harga_jual'),
                        'jmlmasuk' => $validation->getError('jumlah_masuk'),
                        'lokasi' => $validation->getError('ruang_id'),
                        'satuan' => $validation->getError('satuan_id'),
                    ],
                ];
            } else {
                //update data barang
                $barang_lama = $this->barang->find($id);
                $ruang_id = $this->request->getVar('ruang_id');
                $namabrg = $this->request->getVar('nama_brg');

                $updatebarang = [
                    'kat_id' => $this->request->getVar('kat_id'),
                    'kode_brg' => $this->request->getVar('kode_brg'),
                    'nama_brg' => $namabrg,
                    'merk' => $this->request->getVar('merk'),
                    'warna' => $this->request->getVar('warna'),
                    'tipe' => $this->request->getVar('tipe'),
                    'asal' => $this->request->getVar('asal'),
                    'toko' => $this->request->getVar('toko'),
                    'instansi' => $this->request->getVar('instansi'),
                    'no_seri' => $this->request->getVar('no_seri'),
                    'no_dokumen' => $this->request->getVar('no_dokumen'),
                    'harga_beli' => $this->request->getVar('harga_beli'),
                    'harga_jual' => $this->request->getVar('harga_jual'),
                    'tgl_pembelian' => $this->request->getVar('tgl_pembelian'),
                ];

                // Panggil fungsi setInsertData dari model sebelum data diupdate
                $ubahbarang = $this->barang->setUpdateData($updatebarang);

                //periksa perubahan data
                $databrg_lama = $barang_lama;
                $databrg_baru = $updatebarang;
                $fieldbrg_update = [];
                foreach ($databrg_baru as $key => $value) {
                    if (isset($databrg_lama[$key]) && $databrg_lama[$key] !== $value) {
                        $fieldbrg_update[] = $key;
                    }
                }
                // update data ke database
                $this->barang->update($id, $ubahbarang);
                // Periksa apakah query terakhir adalah operasi update
                $lastQuery = $this->db->getLastQuery();

                $this->riwayatbarang->inserthistori($id, $barang_lama, $updatebarang, $lastQuery, $fieldbrg_update);

                //update stok barang
                $stokbrglama = $this->db->table('stok_barang sb')->select('sb.*, b.nama_brg, r.nama_ruang')->join('barang b', 'b.id = sb.barang_id')->join('ruang r', 'r.id=sb.ruang_id')->where('sb.barang_id', $id)->where('sb.ruang_id', $ruang_id)->get()->getRowArray();
                $sb_id = $stokbrglama['id'];
                $nama_ruang = $stokbrglama['nama_ruang'];
                $barang_id = $id;
                $ruang_id = $this->request->getVar('ruang_id');
                $satuan_id = $this->request->getVar('satuan_id');
                $jml_masuk = intval($this->request->getVar('jumlah_masuk'));
                $jml_keluar = $stokbrglama['jumlah_keluar'];
                $namabrg = $stokbrglama['nama_brg'];
                $sisa_stok = $jml_masuk - $jml_keluar;
                $jenistrx = $this->request->getVar('jenistrx');
                $tglbeli = $this->request->getVar('tgl_pembelian');
                if ($tglbeli) {
                    $tgl_beli = $tglbeli;
                } else
                    $tgl_beli = '';

                $updatestok = [
                    'barang_id' => $barang_id,
                    'ruang_id' => $ruang_id,
                    'satuan_id' => $satuan_id,
                    'jumlah_masuk' => $jml_masuk,
                    'sisa_stok' => $sisa_stok,
                    'tgl_beli' => $tgl_beli,
                ];

                $ubahstok = $this->stokbarang->setUpdateData($updatestok);

                //periksa perubahan data
                $datastok_lama = $stokbrglama;
                $datastok_baru = $updatestok;
                $field_update = [];
                foreach ($datastok_baru as $key => $value) {
                    if (isset($datastok_lama[$key]) && $datastok_lama[$key] !== $value) {
                        $field_update[] = $key;
                    }
                }
                // update data ke database
                $this->stokbarang->update($sb_id, $ubahstok);
                // Periksa apakah query terakhir adalah operasi update
                $lastQuery = $this->db->getLastQuery();

                // jenis transaksi : 'barang tetap masuk','barang persediaan masuk','permintaan barang','peminjaman barang','perbaikan barang rusak','penghapusan barang rusak'
                $this->riwayattrx->inserthistori($sb_id, $stokbrglama, $updatestok, $jenistrx, $lastQuery, $field_update);

                $msg = ['sukses' => "Data barang: $namabrg di $nama_ruang berhasil terupdate"];
            }
            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function simpanupload()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'foto_barang' => [
                    'label' => 'Upload Foto',
                    'rules' => 'uploaded[foto_barang]|mime_in[foto_barang,image/png,image/jpeg,image/jpg]|is_image[foto_barang]',
                    'errors' => [
                        'uploaded' => '{field} wajib diisi',
                        'mime_in' => 'Harus dalam bentuk gambar, jangan file lain',
                        'is_image' => 'Harus dalam bentuk gambar, jangan file lain',
                        'max_size' => 'Ukuran file terlalu besar. Maksimal 1024KB',
                    ],
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'fotobrg' => $validation->getError('foto_barang'),
                    ]
                ];
            } else {
                $cekdata = $this->barang->find($id);

                $fotolama = $cekdata['foto_barang'];

                if ($fotolama != NULL || $fotolama != "") {
                    unlink(FCPATH . '/assets/images/foto_barang/' . $fotolama);
                }
                // tangkap file foto
                $filefoto = $this->request->getFile('foto_barang');
                $filename = $filefoto->getRandomName();
                // simpan file yang di-cropped saja
                $gambar = $this->request->getVar('cropped_image');
                // $namabrg = $cekdata['nama_brg'];
                list($type, $gambar) = explode(';', $gambar);
                list(, $gambar) = explode(',', $gambar);
                $gambar = base64_decode($gambar);
                $namafile = str_replace(' ', '_', strtolower($filename)) . '.png';
                // hapus ekstensi .jpg pada nama file
                $namafile = str_replace('.jpg', '', $namafile);

                file_put_contents(FCPATH . '/assets/images/foto_barang/' . $namafile, $gambar);

                $updatefoto = [
                    'foto_barang' => $namafile
                ];

                // Panggil fungsi setInsertData dari model sebelum data diupdate
                $ubahfoto = $this->barang->setUpdateData($updatefoto);

                //periksa perubahan data
                $data_lama = $cekdata;
                $data_baru = $updatefoto;
                $field_update = [];
                foreach ($data_baru as $key => $value) {
                    if (array_key_exists($key, $data_lama) && ($data_lama[$key] ?? null) !== $value) {
                        $field_update[] = $key;
                    }
                }

                $this->barang->update($id, $ubahfoto);

                // Periksa apakah query terakhir adalah operasi update
                $lastQuery = $this->db->getLastQuery();

                $this->riwayatbarang->inserthistori($id, $cekdata, $updatefoto, $lastQuery, $field_update);

                $msg = [
                    'sukses' => 'File foto berhasil diupload'
                ];
            }

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function hapusdata($id)
    {
        if ($this->request->isAJAX()) {
            $nama_brg = $this->request->getVar('nama_brg');
            $query = $this->stokbarang->find($id);
            try {
                $this->stokbarang->setSoftDelete($id);
                $this->barang->setSoftDelete($query['barang_id']);

                $msg = [
                    'sukses' => "Data barang : $nama_brg berhasil dihapus",
                ];
                echo json_encode($msg);
            } catch (\Exception $e) {
                $msg = [
                    'error' => $e->getMessage(),
                ];
                echo json_encode($msg);
            }
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function multipledeletetemporary()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $jenis = strtolower($this->request->getVar('jenis_kat'));
            $jmldata = count($id);

            $query = array();
            $idbrg = array();
            for ($i = 0; $i < $jmldata; $i++) {
                $query[] = $this->stokbarang->find($id[$i]);
                $idbrg[] = $query[$i]['barang_id'];
            }

            for ($j = 0; $j < $jmldata; $j++) {
                $this->stokbarang->setSoftDelete($id[$j]);
                $this->barang->setSoftDelete($idbrg[$j]);
            }
            $msg = [
                'sukses' => "$jmldata data $jenis berhasil dihapus secara temporary",
            ];

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function restoredata($id = null)
    {
        if ($this->request->isAJAX()) {

            $restoredata = [
                'deleted_by' => null,
                'deleted_at' => null,
            ];
            $jenis = $this->request->getVar('jenis_kat');
            if ($id != null) {
                $nama_brg = $this->request->getVar('nama_brg');
                $query = $this->db->table('stok_barang')->select('*')->where('id', $id)->get()->getRowArray();

                $this->stokbarang->update($id, $restoredata);
                $this->barang->update($query['barang_id'], $restoredata);

                $msg = [
                    'sukses' => "Data $jenis: $nama_brg berhasil dipulihkan",
                ];
            } else {
                $this->db->query("UPDATE stok_barang sb JOIN barang b ON b.id = sb.barang_id JOIN kategori k ON b.kat_id = k.id SET sb.deleted_by = NULL, sb.deleted_at = NULL, b.deleted_by = NULL, b.deleted_at = NULL WHERE b.deleted_at IS NOT NULL AND k.jenis = '$jenis'");

                $jmldata = intval($this->db->affectedRows()) / 2;

                if ($jmldata > 0) {
                    $msg = [
                        'sukses' => "$jmldata data $jenis berhasil dipulihkan semuanya",
                    ];
                } else {
                    $msg = [
                        'error' => "Tidak ada data $jenis yang bisa dipulihkan"
                    ];
                }
            }

            return json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function hapuspermanen($id = [])
    {
        if ($this->request->isAJAX()) {
            $ids = $this->request->getVar('id');
            $jenis = $this->request->getVar('jenis_kat');
            $datastoklama = [];
            $databrglama = [];
            $id = explode(",", $ids);
            if (count($id) === 1) {
                $stoklama = $this->stokbarang->select('*')->where('id', $id)->get()->getRowArray();
                $baranglama = $this->barang->select('*')->where('id', $stoklama['barang_id'])->get()->getRowArray();
                array_push($datastoklama, $stoklama);
                array_push($databrglama, $baranglama);

                $nama_brg = $this->request->getVar('nama_brg');

                $this->stokbarang->delete($id, true);
                $this->barang->delete($stoklama['barang_id'], true);

                if ($baranglama['foto_barang'] != NULL) {
                    unlink(FCPATH . 'assets/images/foto_barang/' . $baranglama['foto_barang']);
                }

                $lastQuery = $this->db->getLastQuery();

                $this->riwayattrx->inserthistori($id, $datastoklama, null, "penghapusan permanen " . strtolower($jenis), $lastQuery, null);
                $this->riwayatbarang->inserthistori($id, $databrglama, null, $lastQuery, null);

                $msg = [
                    'sukses' => "Data $jenis: $nama_brg berhasil dihapus secara permanen",
                ];
            } else {
                $datastok_lama = [];
                $databrg_lama = [];
                foreach ($id as $stokbrg_id) {
                    $stoklama = $this->stokbarang->select('*')->where('id', $stokbrg_id)->get()->getRowArray();
                    $baranglama = $this->barang->select('*')->where('id', $stoklama['barang_id'])->get()->getRowArray();
                    array_push($datastok_lama, $stoklama);
                    array_push($databrg_lama, $baranglama);

                    $this->stokbarang->delete($stokbrg_id, true);
                    $this->barang->delete($stoklama['barang_id'], true);

                    if ($baranglama['foto_barang'] != NULL) {
                        unlink(FCPATH . 'assets/images/foto_barang/' . $baranglama['foto_barang']);
                    }

                    $this->riwayattrx->deletehistorimultiple([$stokbrg_id], $datastok_lama, "penghapusan permanen " . strtolower($jenis));
                    $this->riwayatbarang->deletehistorimultiple([$stoklama['barang_id']], $databrg_lama);
                }

                $msg = [
                    'sukses' => count($id) . " data $jenis berhasil dihapus secara permanen",
                ];
            }

            return json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function insertmultiplebarang()
    {
        if ($this->request->isAJAX()) {
            $kat_id = array();
            $kode_brg = array();
            $nama_brg = array();
            $merk = array();
            $warna = array();
            $tipe = array();
            $toko = array();
            $instansi = array();
            $no_seri = array();
            $no_dokumen = array();
            $harga_beli = array();
            $harga_jual = array();
            $tgl_pembelian = array();
            $asal = array();
            $ruang_id = array();
            $satuan_id = array();
            $jenistrx = $this->request->getVar('jenistrx');
            $jml_keluar = 0;
            $jml_masuk = array();
            $sisa_stok = array();
            $jmldata = $this->request->getVar('jmldata');

            $jmldata = intval($this->request->getVar('jmldata'));
            for ($j = 1; $j <= $jmldata; $j++) {
                $val = $this->request->getVar("kat_id$j") ?? '';
                array_push($kat_id, $val);
                array_push($kode_brg, $this->request->getVar("kode_brg$j"));
                array_push($nama_brg, $this->request->getVar("nama_brg$j"));
                array_push($merk, $this->request->getVar("merk$j"));
                array_push($warna, $this->request->getVar("warna$j"));
                array_push($tipe, $this->request->getVar("tipe$j"));
                array_push($toko, $this->request->getVar("toko$j"));
                array_push($instansi, $this->request->getVar("instansi$j"));
                array_push($no_seri, $this->request->getVar("no_seri$j"));
                array_push($no_dokumen, $this->request->getVar("no_dokumen$j"));
                array_push($harga_beli, $this->request->getVar("harga_beli$j"));
                array_push($harga_jual, $this->request->getVar("harga_jual$j"));
                array_push($tgl_pembelian, $this->request->getVar("tgl_pembelian$j"));
                array_push($asal, $this->request->getVar("asal_$j"));
                array_push($ruang_id, $this->request->getVar("ruang_id$j"));
                array_push($jml_masuk, $this->request->getVar("jumlah_masuk$j"));
                array_push($sisa_stok, (intval($this->request->getVar("jumlah_masuk$j")) - $jml_keluar));
                array_push($satuan_id, $this->request->getVar("satuan_id$j"));
            }

            $validation =  \Config\Services::validation();
            $errors = array();
            for ($a = 1; $a <= $jmldata; $a++) {
                $rules = [
                    'kat_id' . $a => [
                        'label' => 'Kode Kategori',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ],
                    ],
                    'kode_brg' . $a => [
                        'label' => 'Kode Barang',
                        'rules' => 'required|is_unique[barang.kode_brg]',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                            'is_unique' => "{field} form $a sudah ada dan tidak boleh sama",
                        ],
                    ],
                    'nama_brg' . $a => [
                        'label' => 'Nama Barang',
                        'rules' => 'required|is_unique[barang.nama_brg]',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                            'is_unique' => "{field} form $a sudah ada dan tidak boleh sama",
                        ]
                    ],
                    'merk' . $a => [
                        'label' => 'Merk barang',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ]
                    ],
                    'harga_beli' . $a => [
                        'label' => 'Harga beli barang',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ]
                    ],
                    'harga_jual' . $a => [
                        'label' => 'Harga jual barang',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ]
                    ],
                    'asal_' . $a => [
                        'label' => 'Asal barang',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ]
                    ],
                    'ruang_id' . $a => [
                        'label' => 'Nama ruang',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ]
                    ],
                    'jumlah_masuk' . $a => [
                        'label' => 'Jumlah masuk',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ]
                    ],
                    'satuan_id' . $a => [
                        'label' => 'Nama Satuan',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form $a tidak boleh kosong",
                        ],
                    ],
                ];
                if (!$this->validate($rules)) {
                    $errors = $validation->getErrors();
                }
            }

            // check for errors
            if (!empty($errors)) {
                $msg = [
                    'jmldata' => $jmldata,
                    'error' => $errors
                ];
            } else {

                $kd_kategori = $this->request->getVar('kd_kategori');
                $skbrg_lain = $this->request->getVar('skbrg_lain');
                $this->db->transStart();

                for ($i = 0; $i < $jmldata; $i++) {
                    // echo "sukses";
                    $simpanbrgmt = [
                        'kat_id' => $kat_id[$i],
                        'kode_brg' => $kd_kategori[$i] . '.' . $skbrg_lain[$i],
                        'nama_brg' => $nama_brg[$i],
                        'merk' => $merk[$i],
                        'warna' => $warna[$i],
                        'tipe' => $tipe[$i],
                        'asal' => $asal[$i],
                        'toko' => $toko[$i],
                        'instansi' => $instansi[$i],
                        'no_seri' => $no_seri[$i],
                        'no_dokumen' => $no_dokumen[$i],
                        'harga_beli' => $harga_beli[$i],
                        'harga_jual' => $harga_jual[$i],
                        'tgl_pembelian' => $tgl_pembelian[$i],
                    ];

                    // Panggil fungsi setInsertData dari model sebelum data disimpan
                    $insertbrg = $this->barang->setInsertData($simpanbrgmt);
                    // Simpan data ke database
                    $this->barang->save($insertbrg);

                    $barang_id = $this->barang->insertID();
                    // Simpan ke dalam tabel riwayat_barang
                    $data_riwayat = $insertbrg;
                    $data_riwayat['barang_id'] = $barang_id;
                    $data_riwayat['field'] = 'Semua field';
                    $data_riwayat['old_value'] = '';
                    $data_riwayat['new_value'] = json_encode($insertbrg);
                    $setdatariwayat = $this->riwayatbarang->setInsertData($data_riwayat);
                    $this->riwayatbarang->save($setdatariwayat);

                    // Insert stok barang
                    $simpanstok = [
                        'barang_id' => $barang_id,
                        'ruang_id' => $ruang_id[$i],
                        'satuan_id' => $satuan_id[$i],
                        'jumlah_masuk' => $jml_masuk[$i],
                        'jumlah_keluar' => $jml_keluar,
                        'sisa_stok' => $sisa_stok[$i],
                        'tgl_beli' => $tgl_pembelian[$i],
                    ];
                    // Panggil fungsi setInsertData dari model sebelum data disimpan
                    $insertstok = $this->stokbarang->setInsertData($simpanstok);

                    // Simpan data ke database
                    $this->stokbarang->save($insertstok);

                    $stokbrg_id = $this->stokbarang->insertID();
                    $data_riwayat = $insertstok;
                    $data_riwayat['stokbrg_id'] = $stokbrg_id;
                    $data_riwayat['jenis_transaksi'] = $jenistrx;
                    $data_riwayat['field'] = 'Semua field';
                    $data_riwayat['old_value'] = '';
                    $data_riwayat['new_value'] = json_encode($insertstok);
                    $setdatariwayat = $this->riwayattrx->setInsertData($data_riwayat);
                    $this->riwayattrx->save($setdatariwayat);
                }
                // Commit transaction
                $this->db->transComplete();

                if ($this->db->transStatus() === false) {
                    // Jika terjadi kesalahan pada transaction
                    $msg = ['error' => 'Gagal menyimpan data barang'];
                } else {
                    // Jika berhasil disimpan
                    $msg = ['sukses' => "Sukses $jmldata data barang berhasil tersimpan"];
                }
            }
            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampiltransferform()
    {
        if ($this->request->isAJAX()) {
            $ids = $this->request->getVar('ids');
            $id = explode(",", $ids);
            $title = $this->request->getVar('title');
            $jenis_kat = $this->request->getVar('jenis_kat');
            $jmldata = $this->request->getVar('jmldata');
            $saveMethod = $this->request->getVar('saveMethod');
            $nav = $this->request->getVar('nav');
            $stoklama = [];
            foreach ($id as $idstokbrg) {
                $query = $this->db->table('stok_barang sb')->select('sb.*, b.nama_brg, r.nama_ruang, s.kd_satuan')
                    ->join('barang b', 'b.id=sb.barang_id')
                    ->join('ruang r', 'r.id=sb.ruang_id')
                    ->join('satuan s', 's.id=sb.satuan_id')
                    ->where('sb.id', $idstokbrg)
                    ->get()
                    ->getRowArray();
                $stoklama[] = $query;
            }

            $data = [
                'stoklama' => json_encode($stoklama),
                'title' => $title,
                'jenis_kat' => $jenis_kat,
                'jmldata' => $jmldata,
                'saveMethod' => $saveMethod,
                'nav' => $nav,
            ];

            $msg = [
                'data' => view('barang/formtransferbarang', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
    }

    public function notifikasipersediaan()
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
        // $view = $this->request->getVar('view');
        $query = $this->db->table('stok_barang sb')
            ->select('sb.*, k.nama_kategori, b.nama_brg,b.warna, b.harga_beli, b.kode_brg, b.foto_barang, s.kd_satuan')
            ->join('barang b', 'b.id=sb.barang_id')
            ->join('kategori k', 'k.id=b.kat_id ')
            ->join('ruang r', 'sb.ruang_id = r.id')
            ->join('satuan s', 'sb.satuan_id = s.id')
            ->where('k.jenis', 'Barang Persediaan')
            ->where('sb.deleted_at', null)
            ->where('b.deleted_at', null)
            ->having('sb.sisa_stok <= 3');

        $result = $query->orderBy('sb.id', 'DESC')->limit(5)->get()->getResultArray();


        $output = '';
        if (count($result) > 0) {
            $output .= '<li>
                                <h5 class="dropdown-header">Notifikasi Barang Persediaan</h5>
                                <hr class="dropdown-divider">
                            </li>';
            foreach ($result as $row) {
                $output .= '
                    <li style="background-color:rgb(25, 135, 84, 0.1);">
                        <a href="#" class="dropdown-item" style="padding: 0.3rem 1.5rem;">
                          <div class="d-flex w-100 justify-content-between align-items-center">
                          <div>
                          <h6 class="mb-1"> ' . $row["nama_brg"] . '</h6>';
                if ($row['sisa_stok'] == 0) {
                    $output .= '<p class="mb-1">Stok barang sudah habis, sisa stok saat ini ' . $row["sisa_stok"] . ' ' . $row['kd_satuan'] . '</p>';
                } else {
                    $output .= '  <p class="mb-1">Stok barang hampir habis, sisa stok saat ini ' . $row["sisa_stok"] . ' ' . $row['kd_satuan'] . '</p>';
                }
                $output .= '<small>' . ubahTanggal($row["updated_at"] ? $row["updated_at"] : $row["created_at"]) . '</small>     
                          </div>
                          <small style="margin-left:15px;"><i class="bi bi-circle-fill text-danger"></i></small>
                          </div>
                        </a>
                      </li>
                        ';
            }
        } else {
            $output .= '<li><a href="#" class="dropdown-item" class="text-bold text-italic">Tidak ada notifikasi baru ditemukan</a></li>';
        }

        $data = [
            'notification' => $output,
            'unseen_notification' => count($result),
        ];

        echo json_encode($data);
    }
}
