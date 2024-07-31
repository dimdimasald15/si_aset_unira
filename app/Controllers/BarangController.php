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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BarangController extends BaseController
{
    protected $barang, $kategori, $stokbarang, $riwayatbarang, $ruang, $riwayattrx, $uri;
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

    public function index()
    {
        $breadcrumb = $this->getBreadcrumb();
        $tabId = ['brgtetap', 'alokasibrg', 'brgpersediaan'];
        $tabName = ['Barang Tetap', 'Pengalokasian Barang Tetap', 'Barang Persediaan'];
        $checkall = ['checkall1', 'checkall2', 'checkall3'];

        $data = [
            'title' => 'Barang',
            'nav' => 'kelola-barang',
            'jenis_kat' => 'Barang Tetap',
            'tabId' => $tabId,
            'tabName' => $tabName,
            'checkall' => $checkall,
            'breadcrumb' => $breadcrumb
        ];

        return view('barang/index', $data);
    }

    public function listdatabarang()
    {
        if ($this->request->isAJAX()) {
            $jenis = $this->request->getVar('jenis_kat');
            $hal = array_key_exists('hal', $this->request->getVar()) ? $this->request->getVar('hal') : '';
            $isRestore = filter_var($this->request->getGet('isRestore'), FILTER_VALIDATE_BOOLEAN);
            $builder = $this->db->table('stok_barang sb')
                ->select('sb.id, sb.barang_id, k.nama_kategori, b.nama_brg, b.warna, b.harga_beli, b.kode_brg, b.path_foto, b.foto_barang, b.asal, b.toko, b.instansi, sb.jumlah_masuk, sb.jumlah_keluar, sb.sisa_stok, b.kat_id, sb.ruang_id, b.satuan_id, sb.created_at, sb.created_by, sb.deleted_at, sb.deleted_by, r.nama_ruang, s.kd_satuan')
                ->join('barang b', 'b.id=sb.barang_id')
                ->join('kategori k', 'k.id=b.kat_id ')
                ->join('ruang r', 'sb.ruang_id = r.id')
                ->join('satuan s', 'b.satuan_id = s.id');

            if (!$isRestore) {
                if ($hal) {
                    $builder->where('r.id !=', 54);
                } else {
                    $builder->where('r.id', 54);
                }
            }

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
                        $builder->orWhere('b.deleted_at IS NOT NULL');
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
                        return '<input type="checkbox" name="id[]" value="' . $row->id . '">';
                    }
                })
                ->add('action', function ($row) use ($isRestore, $jenis, $hal) {
                    if ($isRestore) {
                        return '
                    <div class="btn-group mb-1">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle me-1" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu shadow-lg">
                        <li><a class="dropdown-item" onclick="barang.restore(' . $row->id . ', ' . $row->ruang_id . ',' . $row->barang_id . ',  \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-undo"></i> Pulihkan</a>
                        </li>
                        <li><a class="dropdown-item" onclick="barang.hapusPermanen(' . $row->id . ',' . $row->ruang_id . ',' . $row->barang_id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-trash-o"></i> Hapus Permanen</a>
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
                        <li><a class="dropdown-item" onclick="barang.detail(\'' . htmlspecialchars($row->kode_brg) . '\',' . $row->ruang_id . ')"><i class="fa fa-info-circle"></i> Detail Stok Barang</a>
                        </li>';
                        if ($jenis == "Barang Tetap" || $hal) {
                            $action .= '<li><a class="dropdown-item" onclick="barang.cetakLabel(' . $row->id . ')"><i class="fa fa-qrcode"></i> Cetak Label Barang</a>
                        </li>';
                        }
                        if (!$hal) {
                            $action .= '<li><a class="dropdown-item" onclick="barang.edit(' . $row->barang_id . ')"><i class="fa fa-pencil-square-o"></i> Update Barang</a>
                            </li>
                            <li><a class="dropdown-item" onclick="barang.upload(' . $row->barang_id . ', \'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->path_foto) . '\', \'' . htmlspecialchars($row->foto_barang) . '\')"><i class="bi bi-image"></i> Update Gambar Barang</a>
                            </li>';
                        }

                        $action .= '<li><a class="dropdown-item" onclick="barang.hapus(' . $row->id . ', \'' . $jenis . '\',\'' . htmlspecialchars($row->nama_brg) . '\', \'' . htmlspecialchars($row->nama_ruang) . '\')"><i class="fa fa-trash-o"></i> Hapus Barang</a>
                        </li>
                    </ul>
                </div>';

                        return $action;
                    }
                })
                ->toJson(true);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampilcardupload()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $nama_brg = $this->request->getVar('nama_brg');
            $foto_barang = $this->request->getVar('foto_barang');
            $path_foto = $this->request->getVar('path_foto');
            $imagesToLoad = convert_string_to_array_photos($path_foto, $foto_barang);

            $data = [
                'id' => $id,
                'nama_brg' => $nama_brg,
                'photos' => json_encode($imagesToLoad),
            ];

            $msg = [
                'data' => view('barang/cardupload', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function detailbarang($url)
    {
        $result = $this->barang->getDataByKodeBarang($url);
        if ($result) {
            $title = 'Detail Barang ' . $result->nama_brg . ' di ' . $result->nama_ruang;
        } else {
            $title = 'Detail Barang';
        }

        $data = [
            'title' => $title,
            'barang' => $result,
            'nav' => 'detail-barang'
        ];

        return view('barang/detailstokbarang', $data);
    }

    public function tampillabelbarang()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $nav = $this->request->getVar('nav');

            $data = [
                'id' => $id,
                'nav' => $nav,
            ];
            $msg = [
                'data' => view('barang/modallabel', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampilexportexcel()
    {
        if ($this->request->isAJAX()) {
            $nav = $this->request->getVar('nav');
            $title = $this->request->getVar('title');

            $data = [
                'title' => $title,
                'nav' => $nav,
            ];
            $msg = [
                'data' => view('barang/cardexportexcel', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampilimportexcel()
    {
        if ($this->request->isAJAX()) {
            $nav = $this->request->getVar('nav');
            $title = $this->request->getVar('title');

            $data = [
                'title' => $title,
                'nav' => $nav,
            ];
            $msg = [
                'data' => view('barang/modalimportexcel', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function templateinputbarang()
    {
        $jenis_kat = $this->request->getPost('jenis_kat');
        $katid = $this->request->getPost('kat_id');
        $kategori = $this->kategori->select('id, kd_kategori, nama_kategori')->whereIn('id', $katid)->findAll();
        $units = [];
        foreach ($kategori as $item) {
            if ($jenis_kat === "Barang Tetap") {
                if (strpos(strtolower($item['nama_kategori']), 'meja') !== false || strpos(strtolower($item['nama_kategori']), 'kursi') !== false) {
                    $item['satuan'] = 'buah';
                } else {
                    $item['satuan'] = 'unit';
                }
            } else {
                if (strpos(strtolower($item['nama_kategori']), 'kertas') !== false) {
                    $item['satuan'] = 'rim';
                } else if (strpos(strtolower($item['kd_kategori']), 'ELK') !== false) {
                    $item['satuan'] = 'unit';
                } else {
                    $item['satuan'] = 'pcs';
                }
            }
            $units[] = $item;
        }

        $filename = "template_input_$jenis_kat.xls";
        // Atur header untuk konten
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        // header('Cache-Control: max-age=0');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($jenis_kat);

        // Mengatur data header
        $headers = [
            'A1' => 'Kategori id',
            'B1' => 'Kode Kategori',
            'C1' => 'Nama Barang',
            'D1' => 'Merk',
            'E1' => 'Warna',
            'F1' => 'Tipe',
            'G1' => 'Asal (Beli baru/bekas/hibah',
            'H1' => 'Toko (Beli baru/bekas)',
            'I1' => 'Instansi (Beli bekas/hibah)',
            'J1' => 'Harga Beli',
            'K1' => 'Harga Jual',
            'L1' => 'No Seri',
            'M1' => 'No Dokumen',
            'N1' => 'Tanggal pembelian',
            'O1' => 'Jumlah masuk',
            'P1' => 'Unit satuan'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        // Menetapkan gaya untuk header
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
            ],
        ];

        $sheet->getStyle('A1:P1')->applyFromArray($headerStyle);

        // Rentang sel dari A2 hingga A6
        $rowIndex = 2; // Mulai penulisan dari baris kedua
        foreach ($units as $entry) {
            for ($j = 0; $j < 2; $j++) {
                $sheet->setCellValue('A' . $rowIndex, $entry['id']);
                $sheet->setCellValue('B' . $rowIndex, $entry['kd_kategori']);
                $sheet->setCellValue('C' . $rowIndex, rtrim($entry['nama_kategori']));
                $sheet->setCellValue('N' . $rowIndex, "Format: dd/mm/YYYY");
                $sheet->setCellValue('P' . $rowIndex, $entry['satuan']);
                $rowIndex++;
            }
        }

        // Atur format kolom M sebagai tanggal
        $sheet->getStyle('N2:N' . $rowIndex)->getNumberFormat()
            ->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);

        // Auto-width column
        for ($i = 'A'; $i !=  $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
        }

        // Simpan spreadsheet ke output
        $writer = new Xlsx($spreadsheet);
        $writer->save("php://output");

        // Hentikan eksekusi skrip untuk memastikan tidak ada konten tambahan yang ditambahkan ke output
        exit();
    }

    public function simpandataexcel()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'file' => [
                    'label' => 'Input file',
                    'rules' => 'uploaded[file]|ext_in[file,xls,xlsx]|max_size[file,10240]',
                    'errors' => [
                        'uploaded' => '{field} wajib diisi',
                        'ext_in' => '{field} harus dalam format .xls atau .xlsx',
                        'max_size' => 'Ukuran file terlalu besar. Maksimal 10MB',
                    ],
                ],
            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'file' => $validation->getError('file'),
                    ]
                ];
            } else {
                $file = $this->request->getFile('file');
                // Mengambil nama worksheet pertama
                $path = FCPATH . '/assets/file/data_barang/';
                if ($file->isValid() && !$file->hasMoved()) {
                    $file_name = $this->uploadFile($path, $file);
                    $arr_file = explode('.', $file_name);
                    $extension = end($arr_file);
                }
                if ($extension == "xlsx") {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                } elseif ($extension == "xls") {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                }

                $spreadsheet     = $reader->load($file_name);
                $sheet_data     = $spreadsheet->getActiveSheet()->toArray();
                $worksheetNames = $spreadsheet->getSheetNames();
                $jenis_kat = $worksheetNames[0];
                $sheetcount = count($sheet_data);
                if ($sheetcount > 1) {
                    $data = [];
                    $this->db->transStart();
                    for ($i = 1; $i < $sheetcount; $i++) {
                        $katid = $sheet_data[$i][0];
                        $namaKategori = $sheet_data[$i][2];
                        if ($katid && $namaKategori) {
                            $getNewkdbrg = $this->queryGetkdbrgbykdkat($katid);
                            $kdKategori = $sheet_data[$i][1];
                            $subKdBarang = $getNewkdbrg["subkdbrgother"];
                            $merk = $sheet_data[$i][3];
                            $warna = $sheet_data[$i][4];
                            $tipe = $sheet_data[$i][5];
                            $unit = $sheet_data[$i][15];
                            $satuan = $this->db->table('satuan')->select('id')->where('kd_satuan', $unit)->get()->getRow();
                            // Konversi ke objek DateTime
                            $datetime = $sheet_data[$i][13];
                            $tglbeli = ubah_format_tanggal($datetime);

                            $simpanbarang = [
                                'kat_id' => $katid,
                                'satuan_id' => $satuan->id,
                                'kode_brg' => $kdKategori . '.' . $subKdBarang,
                                'nama_brg' => $tipe ? "$namaKategori $merk $tipe - $warna" : "$namaKategori $merk - $warna",
                                'merk' => $merk,
                                'warna' => $warna,
                                'tipe' => $tipe,
                                'asal' => $sheet_data[$i][6],
                                'toko' => $sheet_data[$i][7],
                                'instansi' => $sheet_data[$i][8],
                                'harga_beli' => $sheet_data[$i][9],
                                'harga_jual' => $sheet_data[$i][10],
                                'no_seri' => $sheet_data[$i][11],
                                'no_dokumen' => $sheet_data[$i][12],
                                'tgl_pembelian' => $tglbeli,
                            ];
                            // Panggil fungsi setInsertData dari model sebelum data disimpan
                            $insertbrg = $this->barang->setInsertData($simpanbarang);

                            // Simpan data ke database
                            $this->barang->save($insertbrg);

                            $barang_id = $this->barang->insertID();
                            // Simpan ke dalam tabel riwayat_barang
                            $data_riwayat1['barang_id'] = $barang_id;
                            $data_riwayat1['field'] = 'Semua field';
                            $data_riwayat1['old_value'] = '';
                            $data_riwayat1['new_value'] = json_encode($insertbrg);
                            $setdatariwayat1 = $this->riwayatbarang->setInsertData($data_riwayat1);
                            $this->riwayatbarang->save($setdatariwayat1);

                            $jml_masuk = $sheet_data[$i][14];
                            // Insert stok barang
                            $simpanstok = [
                                'barang_id' => $barang_id,
                                'ruang_id' => 54,
                                'jumlah_masuk' => $jml_masuk,
                                'jumlah_keluar' => 0,
                                'sisa_stok' => $jml_masuk,
                                'tgl_beli' => $tglbeli,
                            ];
                            // Panggil fungsi setInsertData dari model sebelum data disimpan
                            $insertstok = $this->stokbarang->setInsertData($simpanstok);
                            // Simpan data ke database
                            $this->stokbarang->save($insertstok);

                            $stokbrg_id = $this->stokbarang->insertID();
                            $data_riwayat2['stokbrg_id'] = $stokbrg_id;
                            $data_riwayat2['jenis_transaksi'] = "$jenis_kat Masuk";
                            $data_riwayat2['field'] = 'Semua field';
                            $data_riwayat2['old_value'] = '';
                            $data_riwayat2['new_value'] = json_encode($insertstok);

                            $setdatariwayat2 = $this->riwayattrx->setInsertData($data_riwayat2);

                            $this->riwayattrx->save($setdatariwayat2);
                        }
                    }
                }

                $this->db->transComplete();
                if ($this->db->transStatus() === false) {
                    // Jika terjadi kesalahan pada transaction
                    $msg = ['error' => 'Gagal menyimpan data barang'];
                } else {
                    // Jika berhasil disimpan
                    $msg = ['success' => "Import data barang melalui microsoft excel berhasil tersimpan"];
                }
            }
            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
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
            $data = $this->errorPage404();
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
                ->join('satuan s', 'b.satuan_id = s.id')
                ->where('sb.id', $id);

            $result = $stokbrg->get()->getRow();
            echo json_encode($result);
        } else {
            $data = $this->errorPage404();
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
                    ->select('b.*, k.nama_kategori, k.kd_kategori, k.jenis, sb.jumlah_masuk, b.satuan_id, sb.ruang_id, r.nama_ruang, s.kd_satuan')
                    ->join('barang b', 'sb.barang_id = b.id')
                    ->join('kategori k', 'b.kat_id = k.id')
                    ->join('ruang r', 'sb.ruang_id = r.id')
                    ->join('satuan s', 'b.satuan_id = s.id')
                    ->where('b.id', $id)
                    ->get();
            }
            if (!empty($kode_brg)) {
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
            $data = $this->errorPage404();
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
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg, b.asal')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')
                        ->like('b.nama_brg', $search)->get();
                } else {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg, b.asal')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')->get();
                }
            } else if ($jenis == 'Barang Persediaan') {
                if (!empty($search)) {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg, b.asal')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')
                        ->like('b.nama_brg', $search)->get();
                } else {
                    $databarang = $this->db->table('barang b')->select('b.id, b.nama_brg, , b.asal')->join('kategori k', 'k.id = b.kat_id')->where('b.deleted_at', null)->where('k.jenis', $jenis)
                        ->orderBy('nama_brg', 'ASC')->get();
                }
            }

            if ($databarang->getNumRows() > 0) {
                $list = [];
                $key = 0;
                foreach ($databarang->getResultArray() as $row) {
                    $list[$key]['id'] = $row['id'];
                    $list[$key]['text'] = $row['nama_brg'];
                    $list[$key]['asal'] = $row['asal'];

                    $key++;
                }
            } else {
                $list = [
                    ['id' => '', 'text' => 'Maaf keyword yang anda cari tidak ditemukan'],
                ];
            }
            echo json_encode($list);
        } else {
            $data = $this->errorPage404();
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
            $data = $this->errorPage404();
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

            $stokbarang = $this->db->table('stok_barang sb')->select('sb.id, sb.sisa_stok, sb.tgl_beli, b.nama_brg,r.nama_ruang, b.satuan_id, s.kd_satuan')
                ->join('ruang r', 'r.id = sb.ruang_id')
                ->join('barang b', 'b.id = sb.barang_id')
                ->join('satuan s', 's.id = b.satuan_id')
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
                $subkdbarang = $this->db->query("SELECT SUBSTR(b.kode_brg, -4) AS subkdbarang, k.kd_kategori FROM barang b JOIN kategori k ON b.kat_id = k.id WHERE b.kat_id = $katid ORDER BY b.id DESC");

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
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function queryGetkdbrgbykdkat($id)
    {
        $getkdbarang = $this->db->table('barang b')
            ->select('SUBSTR(b.kode_brg, -4) AS subkdbarang, k.kd_kategori')
            ->join('kategori k', 'b.kat_id = k.id')
            ->where('b.kat_id', $id)
            ->orderBy('b.id', 'DESC')
            ->get()
            ->getRow();
        if (empty($getkdbarang)) {
            $kd_kat = $this->kategori->find($id);

            $msg = [
                'subkdkat' => $kd_kat['kd_kategori'],
                'subkdbrgother' => '0001',
            ];
        } else {
            // mengambil angka dari string lalu menambahkannya dengan 1
            $subkdbarang = (int)($getkdbarang->subkdbarang) + 1;
            // mengubah angka menjadi string dengan 3 karakter dan diisi dengan "0" jika kurang dari 3 karakter
            $sbkdbrgbaru = str_pad((string)$subkdbarang, 4, "0", STR_PAD_LEFT);

            $msg = [
                'subkdkat' => $getkdbarang->kd_kategori,
                'subkdbrgother' => $sbkdbrgbaru,
            ];
        }

        return $msg;
    }

    public function getkdbrgbykdkat()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getGet('katid');
            $msg = $this->queryGetkdbrgbykdkat($id);
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
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampiltambahbarang()
    {
        if ($this->request->isAJAX()) {
            $title = $this->request->getVar('title');
            $nav = $this->request->getVar('nav');
            $saveMethod = $this->request->getVar('saveMethod');
            $data = [
                'title' => $title,
                'nav' => $nav,
                'saveMethod' => $saveMethod,
            ];

            $msg = [
                'data' => view('barang/formmultipleinsert', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampiltambahstok()
    {
        if ($this->request->isAJAX()) {
            $title = $this->request->getVar('title');
            $nav = $this->request->getVar('nav');

            $data = [
                'title' => $title,
                'nav' => $nav,
            ];

            $msg = [
                'data' => view('barang/formtambahstokmultiple', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function tampileditform()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $title = $this->request->getVar('title');
            $nav = $this->request->getVar('nav');
            $saveMethod = $this->request->getVar('saveMethod');

            $data = [
                'id' => $id,
                'title' => $title,
                'nav' => $nav,
                'saveMethod' => $saveMethod,
            ];
            $msg = [
                'data' => view('barang/formsingleedit', $data)
            ];
            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function updatedatastokmultiple()
    {
        if ($this->request->isAJAX()) {
            $jmldata = $this->request->getVar('jmldata');

            $validation =  \Config\Services::validation();
            $errors = array();
            for ($a = 0; $a < $jmldata; $a++) {
                $rules = [
                    "jenis_kat.{$a}" => [
                        'label' => 'Jenis Kategori',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                        ],
                    ],
                    "barang_id.{$a}" => [
                        'label' => 'Nama Barang',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                        ]
                    ],
                    "jumlah_masuk.{$a}" => [
                        'label' => 'Jumlah masuk',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                        ]
                    ],
                    "tgl_pembelian.{$a}" => [
                        'label' => 'Tanggal pembelian baru',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
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
                $id = $this->request->getVar('id');
                $jenis_kat = $this->request->getVar('jenis_kat');
                $jmlmskbaru = $this->request->getVar('jumlah_masuk');
                $tglbelibaru = $this->request->getVar('tgl_pembelian');

                $this->db->transStart();
                for ($i = 0; $i < $jmldata; $i++) {
                    $stoklama = $this->db->table('stok_barang')->select('*')->where('id', $id[$i])->get()->getRowArray();
                    $jumlah_masuk = intval($jmlmskbaru[$i]) + $stoklama['jumlah_masuk'];
                    $sisa_stok = intval($jmlmskbaru[$i]) + $stoklama['jumlah_masuk'] - $stoklama['jumlah_keluar'];
                    $jenistrx = "tambah stok " . strtolower($jenis_kat[$i]) . " di sarpras";

                    $updatedata = [
                        'jumlah_masuk' => $jumlah_masuk,
                        'sisa_stok' => $sisa_stok,
                        'tgl_beli' => $tglbelibaru[$i],
                    ];

                    $ubahdata = $this->stokbarang->setUpdateData($updatedata);

                    //periksa perubahan data
                    $field_update = $this->updatedfield($stoklama, $updatedata);

                    // update data ke database
                    $this->stokbarang->update($id[$i], $ubahdata);

                    // Periksa apakah query terakhir adalah operasi update
                    $lastQuery = $this->db->getLastQuery();

                    $this->riwayattrx->inserthistori($id[$i], $stoklama, $updatedata, $jenistrx, $lastQuery, $field_update);
                }
                $this->db->transComplete();

                if ($this->db->transStatus() === false) {
                    // Jika terjadi kesalahan pada transaction
                    $msg = ['error' => 'Gagal menyimpan data stok barang'];
                } else {
                    // Jika berhasil disimpan
                    $msg = ['success' => "Sukses $jmldata data stok barang berhasil di update"];
                }
            }
            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function transfermultiplebarang()
    {
        if ($this->request->isAJAX()) {
            $jenistrx = "transfer barang tetap";
            $jmldata = $this->request->getVar('jmldata');

            $validation =  \Config\Services::validation();
            $errors = array();
            for ($a = 0; $a < $jmldata; $a++) {
                $rules = [
                    "ruang_id.{$a}"  => [
                        'label' => 'Nama ruang',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                        ]
                    ],
                    "jumlah_keluar.{$a}"  => [
                        'label' => 'Jumlah keluar',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
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
                $id = $this->request->getVar('id');
                $ruang_id = $this->request->getVar('ruang_id');
                $jumlah_keluar = $this->request->getVar('jumlah_keluar');
                $sisa_stok = $this->request->getVar('sisa_stok');
                $tgl_beli = $this->request->getVar('tgl_belilama');
                $stoksarpras = array();

                $stokbrgall = $this->stokbarang->select('*')->get()->getResultArray();

                $this->db->transStart();
                $datalamastokbrg = array();
                for ($i = 0; $i < $jmldata; $i++) {
                    $stoksarpras = $this->db->table('stok_barang')->select('*')->where('id', $id[$i])->get()->getRowArray();
                    //pengubahan data di stok barang sarana dan prasarana
                    $updatedata1 = [
                        'jumlah_keluar' => intval($jumlah_keluar[$i]) + $stoksarpras['jumlah_keluar'],
                        'sisa_stok' => $sisa_stok[$i],
                    ];
                    $ubahdata1 = $this->stokbarang->setUpdateData($updatedata1);

                    //periksa perubahan data
                    $field_update1 = $this->updatedfield($stoksarpras, $updatedata1);

                    // update data ke database
                    $this->stokbarang->update($id[$i], $ubahdata1);

                    // Periksa apakah query terakhir adalah operasi update
                    $lastQuery1 = $this->db->getLastQuery();

                    $this->riwayattrx->inserthistori($id[$i], $stoksarpras, $updatedata1, "update $jenistrx", $lastQuery1, $field_update1);

                    $data_ditemukan = false;
                    $isDeleted = false;
                    $isSameLocation = false;
                    for ($j = 0; $j < count($stokbrgall); $j++) {
                        if ($stoksarpras['barang_id'] == $stokbrgall[$j]['barang_id'] && $ruang_id[$i] == $stoksarpras['ruang_id'] && $stokbrgall[$j]['deleted_at'] == null) {
                            $data_ditemukan = true;
                            $isSameLocation = true;
                            $isDeleted = false;
                        } else if ($stoksarpras['barang_id'] == $stokbrgall[$j]['barang_id'] && $ruang_id[$i] == $stokbrgall[$j]['ruang_id'] && $stokbrgall[$j]['deleted_at'] == null) {
                            $data_ditemukan = true;
                            $isSameLocation = false;
                            $isDeleted = false;
                            array_push($datalamastokbrg, $stokbrgall[$j]);
                        } else if ($stoksarpras['barang_id'] == $stokbrgall[$j]['barang_id'] && $ruang_id[$i] == $stokbrgall[$j]['ruang_id'] && $stokbrgall[$j]['deleted_at'] !== null) {
                            $data_ditemukan = true;
                            $isDeleted = true;
                            $isSameLocation = false;
                            array_push($datalamastokbrg, $stokbrgall[$j]);
                        }
                    }

                    if (!$data_ditemukan) {
                        //Inset stok barang di ruang yang baru
                        $simpandata = [
                            'barang_id' => $stoksarpras['barang_id'],
                            'ruang_id' => $ruang_id[$i],
                            'jumlah_masuk' => $jumlah_keluar[$i],
                            'jumlah_keluar' => 0,
                            'sisa_stok' => $jumlah_keluar[$i],
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
                            'jumlah_masuk' => ($datalamastokbrg[$i]['jumlah_masuk'] + intval($jumlah_keluar[$i])),
                            'jumlah_keluar' => 0,
                            'sisa_stok' => (intval($datalamastokbrg[$i]['sisa_stok']) + intval($jumlah_keluar[$i])),
                        ];
                        $ubahdata2 = $this->stokbarang->setUpdateData($updatedata2);

                        //periksa perubahan data
                        $field_update2 = $this->updatedfield($datalamastokbrg[$i], $updatedata2);

                        // update data ke database
                        $this->stokbarang->update($datalamastokbrg[$i]['id'], $ubahdata2);

                        // Periksa apakah query terakhir adalah operasi update
                        $lastQuery2 = $this->db->getLastQuery();

                        $this->riwayattrx->inserthistori($datalamastokbrg[$i]['id'], $datalamastokbrg[$i], $updatedata2, "update $jenistrx", $lastQuery2, $field_update2);
                    } else if ($data_ditemukan && !$isSameLocation && $isDeleted) {
                        $updatedata2 = [
                            'jumlah_masuk' => ($datalamastokbrg[$i]['jumlah_masuk'] + intval($jumlah_keluar[$i])),
                            'jumlah_keluar' => 0,
                            'sisa_stok' => (intval($datalamastokbrg[$i]['sisa_stok']) + intval($jumlah_keluar[$i])),
                            'deleted_by' => null,
                            'deleted_at' => null,
                        ];
                        $ubahdata2 = $this->stokbarang->setUpdateData($updatedata2);

                        //periksa perubahan data
                        $field_update2 = $this->updatedfield($datalamastokbrg[$i], $updatedata2);

                        // update data ke database
                        $this->stokbarang->update($datalamastokbrg[$i]['id'], $ubahdata2);

                        // Periksa apakah query terakhir adalah operasi update
                        $lastQuery2 = $this->db->getLastQuery();

                        $this->riwayattrx->inserthistori($datalamastokbrg[$i]['id'], $datalamastokbrg[$i], $updatedata2, "update $jenistrx", $lastQuery2, $field_update2);
                    }
                }

                if ($data_ditemukan && $isSameLocation && !$isDeleted) {
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
                        $msg = ['success' => "Sukses $jmldata data stok barang berhasil di pindahkan dari ruangan sebelumnya"];
                    }
                }
            }

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function updatedatabarang($id)
    {
        if ($this->request->isAJAX()) {
            $validation =  \Config\Services::validation();

            $valid = $this->validate([
                'kat_id' => [
                    'label' => 'Kode kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'kode_brg' => [
                    'label' => 'Kode barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ],
                ],
                'nama_brg' => [
                    'label' => 'Nama barang',
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
                $stokbrglama = $this->db->table('stok_barang sb')
                    ->select('sb.*, b.nama_brg, r.nama_ruang')
                    ->join('barang b', 'b.id = sb.barang_id')
                    ->join('ruang r', 'r.id=sb.ruang_id')
                    ->where('sb.barang_id', $id)
                    ->where('sb.ruang_id', $ruang_id)
                    ->get()
                    ->getRowArray();
                $sb_id = $stokbrglama['id'];
                $nama_ruang = $stokbrglama['nama_ruang'];
                $barang_id = $id;
                $satuan_id = $this->request->getVar('satuan_id');
                $jml_masuk = intval($this->request->getVar('jumlah_masuk'));
                $jml_keluar = $stokbrglama['jumlah_keluar'];
                $namabrg = $stokbrglama['nama_brg'];
                $sisa_stok = $jml_masuk - $jml_keluar;
                $jenistrx = strtolower($this->request->getVar('jenis_kat')) . " masuk";
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
                $field_update = $this->updatedfield($stokbrglama, $updatestok);

                // update data ke database
                $this->stokbarang->update($sb_id, $ubahstok);
                // Periksa apakah query terakhir adalah operasi update
                $lastQuery = $this->db->getLastQuery();

                $this->riwayattrx->inserthistori($sb_id, $stokbrglama, $updatestok, $jenistrx, $lastQuery, $field_update);

                $msg = ['success' => "Data barang: $namabrg di $nama_ruang berhasil diperbarui"];
            }
            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function simpanupload()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $files = $this->request->getFiles();
        if (!$files) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No files uploaded']);
        }
        $id = $this->request->getVar('id');
        $cekdata = $this->barang->find($id);
        $pathlama = $cekdata['path_foto'];
        $fotolama = json_decode($cekdata['foto_barang']);
        $path_upload = $pathlama ? $pathlama : "assets/images/foto_barang/$id/";
        $filenames = [];
        if ($fotolama !== null || $pathlama !== null) {
            foreach ($files['files'] as $key => $file) {
                $clientName = $file->getClientName();
                if ($file !== null && !$file->hasMoved()) {
                    $filename = $file->getRandomName();
                    if (isset($fotolama[$key])) unlink(FCPATH . $pathlama . $fotolama[$key]);
                    $file->move(FCPATH . $pathlama, $filename);
                    array_push($filenames, $filename);
                } else {
                    $msg = ['error' => 'Invalid file or no file uploaded.'];
                }
            }
        } else {
            foreach ($files['files'] as $key => $file) {
                if ($file !== null && !$file->hasMoved()) {
                    $clientName = $file->getClientName();
                    if (!empty($clientName)) {
                        $filename = $file->getRandomName();
                        $file->move(FCPATH . $path_upload, $filename);
                        array_push($filenames, $filename);
                    }
                } else {
                    $msg = ['error' => 'Invalid file or no file uploaded.'];
                }
            }
        }

        $updatefoto = [
            'path_foto' => $path_upload,
            'foto_barang' => json_encode($filenames)
        ];
        // Panggil fungsi setInsertData dari model sebelum data diupdate
        $ubahfoto = $this->barang->setUpdateData($updatefoto);
        $field_update = $this->updatedfield($cekdata, $updatefoto);
        $this->barang->update($id, $ubahfoto);
        // Periksa apakah query terakhir adalah operasi update
        $lastQuery = $this->db->getLastQuery();

        $this->riwayatbarang->inserthistori($id, $cekdata, $updatefoto, $lastQuery, $field_update);

        $msg = [
            'success' => 'File foto berhasil diupload'
        ];

        echo json_encode($msg);
    }

    public function hapusTemporaryRuangLain($id, $barang_id, $idsarpras)
    {
        $datasarpras = $this->stokbarang->getStokSarpras($barang_id, $idsarpras);
        $datahapus = $this->stokbarang->find($id);
        $updatesarpras = [
            'jumlah_keluar' => (intval($datasarpras['jumlah_keluar']) - intval($datahapus['jumlah_masuk'])),
            'sisa_stok' => (intval($datasarpras['sisa_stok']) + intval($datahapus['jumlah_masuk'])),
        ];
        $ubahsarpras = $this->stokbarang->setUpdateData($updatesarpras);
        // update data ke database
        $this->stokbarang->update($datasarpras['id'], $ubahsarpras);
        $field_update = $this->updatedfield($datasarpras, $updatesarpras);
        $lastQuery = $this->db->getLastQuery();
        $this->riwayattrx->inserthistori($datasarpras['id'], $datasarpras, $updatesarpras, "tambah stok barang dari ruang lain", $lastQuery, $field_update);
        $updatehapus = [
            'jumlah_masuk' => 0,
            'jumlah_keluar' => 0,
            'sisa_stok' => 0,
        ];
        $ubahhapus = $this->stokbarang->setUpdateData($updatehapus);
        // update data ke database
        $this->stokbarang->update($id, $ubahhapus);
        $data_lama_hapus = $datahapus;
        $data_baru_hapus = $updatehapus;
        $field_update_hapus = [];
        foreach ($data_baru_hapus as $key => $value) {
            if (isset($data_lama_hapus[$key]) && $data_lama_hapus[$key] !== $value) {
                $field_update_hapus[] = $key;
            }
        }
        $this->riwayattrx->inserthistori($id, $datahapus, $updatehapus, "pengembalian barang ke sarpras", $lastQuery, $field_update_hapus);

        $this->stokbarang->setSoftDelete($id);
    }

    public function deletetemporary($id = [])
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $inputData = json_decode($this->request->getBody(), true);
        $ids = $inputData ? $inputData["id"] : $this->request->getVar('id');
        $id = $inputData ? explode(",", $ids) : $ids;
        $jenis_kat = $inputData ? $inputData["jenis_kat"] : $this->request->getVar('jenis_kat');
        $jmldata = count($id);
        $idsarpras = 54;
        $this->db->transStart();
        foreach ($id as $key => $id) {
            $query = $this->stokbarang->find($id);
            $ruang_id = $query['ruang_id'];
            $barang_id = $query['barang_id'];
            if ($ruang_id == $idsarpras) {
                $stokbrgall = $this->stokbarang->select('*')
                    ->where('barang_id', $barang_id)
                    ->where('deleted_at IS NULL')->get()->getResultArray();
                foreach ($stokbrgall as $row) {
                    if (intval($row['ruang_id']) !== $idsarpras) {
                        $this->hapusTemporaryRuangLain($row['id'], $barang_id, $idsarpras);
                    } else {
                        $this->stokbarang->setSoftDelete($row['id']);
                    }
                }
                $this->barang->setSoftDelete($barang_id);
            } else {
                $this->hapusTemporaryRuangLain($id, $barang_id, $idsarpras);
            }
        }

        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            // Jika terjadi kesalahan pada transaction
            $msg = [
                'error' => ['transStatus' => 'Gagal menyimpan data stok barang',]
            ];
        } else {
            // Jika berhasil disimpan
            $p1 = ($jenis_kat == "Alokasi Barang Tetap") ? ' dan dikembalikan ke Sarana dan Prasarana' : '';
            $msg = [
                'success' => "$jmldata data " . strtolower($jenis_kat) . " berhasil dihapus secara temporary$p1",
            ];
        }

        echo json_encode($msg);
    }

    public function restoredata($id = [])
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $nama_brg = $this->request->getVar('nama_brg');
        $nama_ruang = $this->request->getVar('nama_ruang');
        $idruang = $this->request->getVar('ruangId');
        $idsarpras = 54;
        $ids = $this->request->getVar('id');
        $idbrg = $this->request->getVar('barangId');
        $id = explode(",", $ids);
        $barang_id = explode(",", $idbrg);
        $ruang_id = explode(",", $idruang);
        $restoredata = [
            'deleted_by' => null,
            'deleted_at' => null,
        ];

        $this->db->transStart();
        foreach ($id as $key => $stokId) {
            if ($ruang_id[$key] == $idsarpras) {
                $this->stokbarang->update($stokId, $restoredata);
                $this->barang->update($barang_id[$key], $restoredata);
            } else if ($ruang_id[$key] !== $idsarpras) {
                $historitrx1 = $this->riwayattrx->select('old_value')->where('stokbrg_id', $stokId)->where('jenis_transaksi', 'pengembalian barang ke sarpras')->orderBy('id', 'DESC')->get()->getRowArray();
                $stoksarpras = $this->db->table('stok_barang')->select('*')
                    ->where('barang_id', $barang_id[$key])
                    ->where('ruang_id', $idsarpras)->orderBy('id', 'DESC')->get()->getRowArray();

                //memulihkan table barang jika deleted_at tidak sama dengan null
                $barang = $this->db->table('barang')->select('*')->where('id', $barang_id[$key])->get()->getRowArray();
                if ($barang['deleted_at'] !== NULL) {
                    $this->barang->update($barang_id[$key], $restoredata);
                }

                $datalamastokbrg = $this->stokbarang->select('*')->where('id', $stokId)->get()->getRowArray();
                $historitrx = json_decode($historitrx1['old_value']);
                $jumlah_masuk1 = $historitrx->jumlah_masuk;
                $jumlah_keluar1 = $historitrx->jumlah_keluar;
                $sisa_stok1 = $historitrx->sisa_stok;
                $jumlah_keluar2 = intval($stoksarpras['jumlah_keluar']) + intval($historitrx->jumlah_masuk);
                $sisa_stok2 = intval($stoksarpras['sisa_stok']) - intval($historitrx->jumlah_masuk);
                $updatedata1 = [
                    'jumlah_masuk' => $jumlah_masuk1,
                    'jumlah_keluar' => $jumlah_keluar1,
                    'sisa_stok' => $sisa_stok1,
                ];

                $data1 = array_merge($updatedata1, $restoredata);
                $ubahdata1 = $this->stokbarang->setUpdateData($data1);
                $jenistransaksi = 'pemulihan data stok barang ' . $ruang_id[$key];
                //periksa perubahan data
                $field_update1 = $this->updatedfield($datalamastokbrg, $data1);

                $this->stokbarang->update($stokId, $ubahdata1);
                $lastQuery1 = $this->db->getLastQuery();
                $this->riwayattrx->inserthistori($stokId, $datalamastokbrg, $data1, $jenistransaksi, $lastQuery1, $field_update1);

                $data2 = [
                    'jumlah_keluar' => $jumlah_keluar2,
                    'sisa_stok' => $sisa_stok2,
                ];
                $ubahdata2 = $this->stokbarang->setUpdateData($data2);

                $field_update2 = $this->updatedfield($stoksarpras, $data2);

                $this->stokbarang->update($stoksarpras['id'], $ubahdata2);

                $lastQuery2 = $this->db->getLastQuery();

                $this->riwayattrx->inserthistori($stoksarpras['id'], $stoksarpras, $data2, "pemulihan data stok barang $idsarpras", $lastQuery2, $field_update2);
            }
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            $msg = ['error' => 'Gagal memulihkan data stok barang'];
        } else {
            // Jika berhasil disimpan
            $msg = ['success' => "Sukses memulihkan data stok barang."];
        }

        return json_encode($msg);
    }

    public function hapuspermanen($id = [])
    {
        if ($this->request->isAJAX()) {
            $inputData = json_decode($this->request->getBody(), true);
            $ids = $inputData ? $inputData["id"] : $this->request->getVar('id');
            $nama_brg = $this->request->getVar('nama_brg');
            $nama_ruang = $this->request->getVar('nama_ruang');
            $idruang = $inputData ? $inputData["ruangId"] : $this->request->getVar('ruangId');
            $idsarpras = 54;
            $idbrg = $inputData ? $inputData["barangId"] :  $this->request->getVar('barangId');
            $id = explode(",", $ids);
            $barang_id = explode(",", $idbrg);
            $ruang_id = explode(",", $idruang);

            try {
                $this->db->transException(true)->transStart();
                foreach ($id as $key => $stokId) {
                    $stoklama[] = $this->stokbarang->select('*')->where('id', $stokId)->get()->getRowArray();
                    if ($ruang_id[$key] == $idsarpras) {
                        $baranglama = $this->barang->select('*')->where('id', $barang_id[$key])->get()->getRowArray();

                        $this->riwayattrx->deletehistorimultiple([$stokId], $stoklama, "penghapusan permanen");

                        $this->barang->delete($stoklama[$key]['barang_id'], true);

                        if ($baranglama['foto_barang'] != NULL) {
                            unlink(FCPATH . 'assets/images/foto_barang/' . $baranglama['foto_barang']);
                        }
                    }

                    $this->stokbarang->delete($stokId, true);
                    $this->riwayattrx->deletehistorimultiple([$stokId], $stoklama, "penghapusan permanen stok");
                }

                $this->db->transComplete();
                $msg = count($id) > 1 ? ['success' => "Sukses " . count($id) . " data stok barang berhasil dihapus secara permanen"] : ['success' => "Sukses menghapus secara permanen data stok barang $nama_brg di $nama_ruang"];
            } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
                // Automatically rolled back already.
                $msg = ['error' => "Terjadi kesalahan saat menghapus data stok barang. Pastikan tidak ada ketergantungan data sebelum menghapus"];
            }
            return json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function insertmultiplebarang()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $jmldata = intval($this->request->getVar('jmldata'));
        $validation =  \Config\Services::validation();

        $errors = array();
        for ($a = 0; $a < $jmldata; $a++) {
            $rules = [
                "jenis_kat.{$a}" => [
                    'label' => 'Jenis Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                    ],
                ],
                "kat_id.{$a}" => [
                    'label' => 'Kode Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                    ],
                ],
                "kode_brg.{$a}" => [
                    'label' => 'Kode Barang',
                    'rules' => 'required|is_unique[barang.kode_brg]',
                    'errors' => [
                        'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                        'is_unique' => "{field} form " . ($a + 1) . " sudah ada dan tidak boleh sama",
                    ],
                ],
                "nama_brg.{$a}" => [
                    'label' => 'Nama Barang',
                    'rules' => 'required|is_unique[barang.nama_brg]',
                    'errors' => [
                        'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                        'is_unique' => "{field} form " . ($a + 1) . " sudah ada dan tidak boleh sama",
                    ]
                ],
                "merk.{$a}" => [
                    'label' => 'Merk barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                    ]
                ],
                "harga_beli.{$a}" => [
                    'label' => 'Harga beli barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                    ]
                ],
                "asal" . ($a + 1) => [
                    'label' => 'Asal barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                    ]
                ],
                "ruang_id.{$a}" => [
                    'label' => 'Nama ruang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                    ]
                ],
                "jumlah_masuk.{$a}" => [
                    'label' => 'Jumlah masuk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
                    ]
                ],
                "satuan_id.{$a}" => [
                    'label' => 'Nama Satuan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => "{field} form " . ($a + 1) . " tidak boleh kosong",
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
            $jenis_kat = $this->request->getVar('jenis_kat');
            $kat_id = $this->request->getVar('kat_id');
            $kd_kategori = $this->request->getVar('kd_kategori');
            $skbrg_lain = $this->request->getVar('skbrg_lain');
            $nama_brg = $this->request->getVar('nama_brg');
            $merk = $this->request->getVar('merk');
            $warna = $this->request->getVar('warna');
            $tipe = $this->request->getVar('tipe');
            // Array untuk menyimpan data yang memiliki awalan "asal"
            $asal = [];
            foreach ($this->request->getVar() as $key => $value) {
                // Memeriksa apakah kunci array diawali dengan "asal"
                if (strpos($key, 'asal') === 0) {
                    $asal[] = $value;
                }
            }
            $toko = $this->request->getVar('toko');
            $instansi = $this->request->getVar('instansi');
            $no_seri = $this->request->getVar('no_seri');
            $no_dokumen = $this->request->getVar('no_dokumen');
            $harga_beli = $this->request->getVar('harga_beli');
            $harga_jual = $this->request->getVar('harga_jual');
            $tgl_pembelian = $this->request->getVar('tgl_pembelian');
            $ruang_id = $this->request->getVar('ruang_id');
            $satuan_id = $this->request->getVar('satuan_id');
            $jml_masuk = $this->request->getVar('jumlah_masuk');
            $jml_keluar = 0;

            $this->db->transStart();

            for ($i = 0; $i < $jmldata; $i++) {
                $simpanbrgmt = [
                    'kat_id' => $kat_id[$i],
                    'satuan_id' => $satuan_id[$i],
                    'kode_brg' => $kd_kategori[$i] . '.' . $skbrg_lain[$i],
                    'nama_brg' => rtrim($nama_brg[$i]),
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
                $data_riwayat1['barang_id'] = $barang_id;
                $data_riwayat1['field'] = 'Semua field';
                $data_riwayat1['old_value'] = '';
                $data_riwayat1['new_value'] = json_encode($insertbrg);
                $setdatariwayat1 = $this->riwayatbarang->setInsertData($data_riwayat1);
                $this->riwayatbarang->save($setdatariwayat1);

                // Insert stok barang
                $simpanstok = [
                    'barang_id' => $barang_id,
                    'ruang_id' => $ruang_id[$i],
                    'jumlah_masuk' => $jml_masuk[$i],
                    'jumlah_keluar' => $jml_keluar,
                    'sisa_stok' => $jml_masuk[$i],
                    'tgl_beli' => $tgl_pembelian[$i],
                ];
                // Panggil fungsi setInsertData dari model sebelum data disimpan
                $insertstok = $this->stokbarang->setInsertData($simpanstok);
                // Simpan data ke database
                $this->stokbarang->save($insertstok);

                $stokbrg_id = $this->stokbarang->insertID();
                $data_riwayat2['stokbrg_id'] = $stokbrg_id;
                $data_riwayat2['jenis_transaksi'] = "$jenis_kat[$i] Masuk";
                $data_riwayat2['field'] = 'Semua field';
                $data_riwayat2['old_value'] = '';
                $data_riwayat2['new_value'] = json_encode($insertstok);

                $setdatariwayat2 = $this->riwayattrx->setInsertData($data_riwayat2);

                $this->riwayattrx->save($setdatariwayat2);
            }
            // Commit transaction
            $this->db->transComplete();

            if ($this->db->transStatus() === false) {
                // Jika terjadi kesalahan pada transaction
                $msg = ['error' => 'Gagal menyimpan data barang'];
            } else {
                // Jika berhasil disimpan
                $msg = ['success' => "$jmldata data barang berhasil tersimpan"];
            }
        }
        echo json_encode($msg);
    }

    public function tampiltransferform()
    {
        if ($this->request->isAJAX()) {
            $ids = $this->request->getVar('ids');
            $id = explode(",", $ids);
            $jmldata = $this->request->getVar('jmldata');
            $stoklama = [];

            foreach ($id as $idstokbrg) {
                $query = $this->db->table('stok_barang sb')->select('sb.*, b.nama_brg, r.nama_ruang, s.kd_satuan, k.jenis')
                    ->join('barang b', 'b.id=sb.barang_id')
                    ->join('kategori k', 'k.id=b.kat_id')
                    ->join('ruang r', 'r.id=sb.ruang_id')
                    ->join('satuan s', 's.id=b.satuan_id')
                    ->where('sb.id', $idstokbrg)
                    ->get()
                    ->getRowArray();
                $stoklama[] = $query;
            }

            if ($stoklama[0]['jenis'] && $stoklama[0]['ruang_id'] == 54) {
                $title = $stoklama[0]['jenis'] . " di " . $stoklama[0]['nama_ruang'];
            } else {
                $title = $stoklama[0]['jenis'];
            }

            $data = [
                'stoklama' => json_encode($stoklama),
                'title' => $title,
                'jmldata' => $jmldata,
            ];

            $msg = [
                'data' => view('barang/formtransferbarang', $data),
            ];

            echo json_encode($msg);
        } else {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
    }

    public function notifikasipersediaan()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $query = $this->db->table('stok_barang sb')
            ->select('sb.*, k.nama_kategori, b.nama_brg,b.warna, b.harga_beli, b.kode_brg, b.foto_barang, s.kd_satuan')
            ->join('barang b', 'b.id=sb.barang_id')
            ->join('kategori k', 'k.id=b.kat_id ')
            ->join('ruang r', 'sb.ruang_id = r.id')
            ->join('satuan s', 'b.satuan_id = s.id')
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

        $pusher = $this->handleNotification();
        $pusher->trigger('notifications-channel', 'supplyItems-event', $data);

        echo json_encode($data);
    }

    private function updatedfield($data1, $data2)
    {
        $data_lama = $data1;
        $data_baru = $data2;
        $field_update = [];
        foreach ($data_baru as $key => $value) {
            if (isset($data_lama[$key]) && $data_lama[$key] !== $value) {
                $field_update[] = $key;
            }
        }

        return $field_update;
    }
}
