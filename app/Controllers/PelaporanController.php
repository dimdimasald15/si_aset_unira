<?php

namespace App\Controllers;

use Exception;
use App\Models\Ruang;
use App\Models\Barang;
use App\Models\Anggota;
use App\Models\Kategori;
use App\Models\Notifikasi;
use App\Models\StokBarang;
use App\Models\RiwayatBarang;
use App\Models\RiwayatTransaksi;
use App\Models\Pelaporankerusakan;
use App\Controllers\BaseController;

class PelaporanController extends BaseController
{
    protected $barang;
    protected $kategori;
    protected $uri;
    protected $stokbarang;
    protected $riwayatbarang;
    protected $ruang;
    protected $riwayattrx;
    protected $pelaporan;
    protected $notifikasi;
    protected $anggota;
    public function __construct()
    {
        $this->barang = new Barang();
        $this->riwayatbarang = new RiwayatBarang();
        $this->kategori = new Kategori();
        $this->ruang = new Ruang();
        $this->stokbarang = new StokBarang();
        $this->riwayattrx = new RiwayatTransaksi();
        $this->pelaporan = new Pelaporankerusakan();
        $this->notifikasi = new Notifikasi();
        $this->anggota = new Anggota();
        $this->uri = service('uri');
    }
    public function tampilpelaporanaset($url)
    {
        $kdbrg = substr($url, 0, strrpos($url, "-")); // mendapatkan string "C-02-06-01-001"
        $kode_brg = str_replace('-', '.', $kdbrg);
        $ruang_id = substr($url, strrpos($url, "-") + 1); // mendapatkan string "6"

        $query = $this->db->table('stok_barang sb')->select('sb.*, k.nama_kategori, b.nama_brg, b.kode_brg, b.foto_barang, b.harga_beli, b.harga_jual, b.asal, b.toko, b.instansi, b.no_seri, b.no_dokumen, b.merk, b.tgl_pembelian, b.warna, sb.ruang_id, r.nama_ruang, b.satuan_id, s.kd_satuan, b.created_at, b.created_by, b.deleted_at')
            ->join('barang b', 'sb.barang_id = b.id')
            ->join('kategori k', 'b.kat_id = k.id')
            ->join('ruang r', 'sb.ruang_id = r.id')
            ->join('satuan s', 'b.satuan_id = s.id')
            ->where('b.kode_brg', $kode_brg)
            ->where('sb.ruang_id', $ruang_id)
            ->groupBy('b.id')
            ->get();

        $result = $query->getRow();
        if ($result) {
            $title = $result->nama_brg . ' di ' . $result->nama_ruang;
        } else {
            $title = 'Detail Barang';
        }

        //Generate no laporan
        $today = date("ymd"); // Mendapatkan tanggal hari ini dalam format Ymd (misal: 230523)
        $randomNumber = rand(111111111, 999999999); // Menghasilkan angka acak antara 1000 dan 9999
        $no_laporan = "LP-" . $today . "-" . $randomNumber; // Menggabungkan tanggal hari ini dengan angka acak
        $data = [
            'title' => $title,
            'barang' => $result,
            'no_laporan' => $no_laporan,
            'url_detail_brg' => "detail-barang/" . $url,
        ];

        return view('pelaporan/tampilpelaporanaset', $data);
    }

    public function cekanggota()
    {
        $validation = \Config\Services::validation();
        $level = $this->request->getVar('level');
        $namalevel = $level ? $level : "pelapor";

        $rules = [
            'nama_anggota' => [
                'label' => 'Nama',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} " . strtolower($namalevel) . " tidak boleh kosong",
                ],
            ],
            'no_anggota' => [
                'label' => 'Nomor',
                'rules' => 'required|is_unique[anggota.no_anggota]|numeric|min_length[10]',
                'errors' => [
                    'required' => "{field} " . strtolower($namalevel) . " tidak boleh kosong",
                    'is_unique' => "{field} " . strtolower($namalevel) . " sudah ada dan tidak boleh sama",
                    'numeric' => "{field} " . strtolower($namalevel) . " harus berupa angka",
                    'min_length' => "{field} " . strtolower($namalevel) . " minimal terdiri dari 10 digit",
                ],
            ],
            'level' => [
                'label' => 'Level',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} " . strtolower($namalevel) . " tidak boleh kosong",
                ],
            ],
            'unit_id' => [
                'label' => 'Unit',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} " . strtolower($namalevel) . " tidak boleh kosong",
                ],
            ],
            'nohp' => [
                'label' => 'No Hp',
                'rules' => 'required|numeric|min_length[10]|max_length[13]',
                'errors' => [
                    'required' => "{field} " . strtolower($namalevel) . " tidak boleh kosong",
                    'numeric' => "{field} " . strtolower($namalevel) . " harus berupa angka",
                    'min_length' => "{field} " . strtolower($namalevel)  . " harus terdiri dari 11 hingga 13 digit",
                    'max_length' => "{field} " . strtolower($namalevel)  . " harus terdiri dari 11 hingga 13 digit",
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
        }
        if (!empty($errors)) {
            $msg = [
                'error' => $errors,
            ];
        } else {
            $msg = [
                'sukses' => 200
            ];
        }

        echo json_encode($msg);
    }

    public function simpanlaporan()
    {
        $validation = \Config\Services::validation();
        $rules = [];
        $errors = [];
        $rules = [
            'jml_barang' => [
                'label' => 'Jumlah barang rusak',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
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
        ];

        if ($this->request->getVar('pilihan') == "anggota lama") {
            $rules['anggota_id'] = [
                'label' => 'Nama anggota',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ];
        }
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
        }
        if (!empty($errors)) {
            $msg = [
                'error' => $errors,
            ];
        } else {
            $this->db->transStart();
            // tangkap file foto
            $filefoto = $this->request->getFile('foto_barang');
            $filename = $filefoto->getRandomName();
            $namaBaru = str_replace(' ', '_', strtolower($filename));
            // Menghapus ekstensi .jpg jika ada
            $namaBaru = str_replace('.jpg', '', $namaBaru);
            // Menghapus ekstensi .png jika ada
            $namaBaru = str_replace('.png', '', $namaBaru);

            // Menambahkan kembali ekstensi .png
            $namaBaru .= '.png';

            $filefoto->move(FCPATH . '/assets/images/foto_kerusakan/', $namaBaru);

            $anggota_id = "";
            $no_laporan = $this->request->getVar('no_laporan');
            if ($this->request->getVar('pilihan') == "anggota lama") {
                $anggota_id = $this->request->getVar('anggota_id');

                $simpanlaporan = [
                    'stokbrg_id' => $this->request->getVar('stokbrg_id'),
                    'anggota_id' => $anggota_id,
                    'no_laporan' => $no_laporan,
                    'jml_barang' => $this->request->getVar('jml_barang'),
                    'title' => $this->request->getVar('title'),
                    'deskripsi' => $this->request->getVar('deskripsi'),
                    'foto' => $namaBaru,
                ];
            } else {
                $simpananggota = [
                    'no_anggota' => $this->request->getVar('no_anggota'),
                    'nama_anggota' => $this->request->getVar('nama_anggota'),
                    'no_hp' => $this->request->getVar('no_hp'),
                    'level' => $this->request->getVar('level'),
                    'unit_id' => $this->request->getVar('unit_id'),
                ];

                $insertanggota = $this->anggota->setInsertData($simpananggota);

                $this->db->table('anggota')->insert($insertanggota);

                $anggota_id = $this->anggota->insertID();

                $simpanlaporan = [
                    'stokbrg_id' => $this->request->getVar('stokbrg_id'),
                    'anggota_id' => $anggota_id,
                    'no_laporan' => $no_laporan,
                    'jml_barang' => $this->request->getVar('jml_barang'),
                    'title' => $this->request->getVar('title'),
                    'deskripsi' => $this->request->getVar('deskripsi'),
                    'foto' => $namaBaru,
                ];
            }
            $data_anggota = $this->anggota->find($anggota_id);
            $namaanggota = $data_anggota['nama_anggota'];
            $insertlaporan = $this->pelaporan->setInsertData($simpanlaporan, $namaanggota);

            $this->db->table('pelaporan_kerusakan')->insert($insertlaporan);

            $laporan_id = $this->db->insertID();

            $simpannotif = [
                'laporan_id' => $laporan_id,
                'viewed_by_admin' => 0,
            ];

            $insertnotif = $this->notifikasi->setInsertData($simpannotif, $namaanggota);

            try {
                $this->db->table('notifikasi')->insert($insertnotif);
            } catch (Exception $e) {
                $msg = ['error' => "Simpan data notifikasi: " . $e->getMessage()];
            }

            $this->db->transComplete();
            if ($this->db->transStatus() === false) {
                // Jika terjadi kesalahan pada transaction
                $msg = ['error' => 'Gagal menyimpan data pelaporan aset'];
            } else {
                $msg = [
                    'sukses' => "Laporan anda berhasil terkirim. Terima kasih telah melapor.",
                    'laporan_id' => $no_laporan
                ];
            }
        }

        echo json_encode($msg);
    }

    public function tampileditlaporan($no_laporan)
    {
        $query = $this->db->table('pelaporan_kerusakan p')->select('p.*, a.nama_anggota, a.level, a.no_anggota, b.nama_brg, s.kd_satuan, r.nama_ruang, sb.barang_id, sb.ruang_id, b.satuan_id, b.kode_brg, u.singkatan')
            ->join('anggota a', 'a.id=p.anggota_id')
            ->join('unit u', 'u.id=a.unit_id')
            ->join('stok_barang sb', 'sb.id=p.stokbrg_id')
            ->join('barang b', 'b.id=sb.barang_id')
            ->join('ruang r', 'r.id=sb.ruang_id')
            ->join('satuan s', 's.id=b.satuan_id')
            ->where('p.no_laporan', $no_laporan);

        $laporan = $query->get()->getRow();
        $kode_brg = $laporan->kode_brg;
        $ruang_id = $laporan->ruang_id;
        $url_detail_brg = base_url() . 'laporan-kerusakan-aset/' . str_replace(".", "-", $kode_brg) . "-" . $ruang_id;
        $data = [
            'laporan' => $laporan,
            'url_detail_brg' => $url_detail_brg,
            'title' => 'Form Ubah Laporan'
        ];
        return view('pelaporan/editlaporan', $data);
    }

    public function updatelaporan($id)
    {
        $validation = \Config\Services::validation();
        $rules = [];
        $errors = [];
        $rules = [
            'jml_barang' => [
                'label' => 'Jumlah barang rusak',
                'rules' => 'required',
                'errors' => [
                    'required' => "{field} tidak boleh kosong",
                ],
            ],
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
        ];
        if (!$this->validate($rules)) {
            $errors = $validation->getErrors();
        }
        if (!empty($errors)) {
            $msg = [
                'error' => $errors,
            ];
        } else {
            $cekdata = $this->pelaporan->find($id);
            $no_laporan = $cekdata['no_laporan'];

            $fotolama = $cekdata['foto'];

            if (!empty($fotolama)) {
                $pathToPhoto = FCPATH . '/assets/images/foto_kerusakan/' . $fotolama;
                if (file_exists($pathToPhoto)) {
                    unlink($pathToPhoto);
                }
            }

            $filefoto = $this->request->getFile('foto_barang');

            if ($filefoto->isValid() && !$filefoto->hasMoved()) {
                $filename = $filefoto->getRandomName();
                $namaBaru = str_replace(' ', '_', strtolower($filename));

                // Menghapus ekstensi .jpg jika ada
                $namaBaru = str_replace('.jpg', '', $namaBaru);

                // Menghapus ekstensi .png jika ada
                $namaBaru = str_replace('.png', '', $namaBaru);

                // Menambahkan kembali ekstensi .png
                $namaBaru .= '.png';

                $filefoto->move(FCPATH . '/assets/images/foto_kerusakan/', $namaBaru);
            }

            $anggota_id = $this->request->getVar('anggota_id');

            $ubahlaporan = [
                'stokbrg_id' => $this->request->getVar('stokbrg_id'),
                'anggota_id' => $anggota_id,
                'jml_barang' => $this->request->getVar('jml_barang'),
                'title' => $this->request->getVar('title'),
                'deskripsi' => $this->request->getVar('deskripsi'),
                'foto' => $namaBaru,
            ];

            $data_anggota = $this->anggota->find($anggota_id);
            $namaanggota = $data_anggota['nama_anggota'];

            $updatelaporan = $this->pelaporan->setUpdateData($ubahlaporan, $namaanggota);

            $this->db->table('pelaporan_kerusakan')->where('id', $id)->update($updatelaporan);

            $msg = [
                'sukses' => "Laporan anda berhasil diupdate. Terima kasih telah melapor.",
                'laporan_id' => $no_laporan
            ];
        }

        echo json_encode($msg);
    }

    public function getlaporankerusakanaset()
    {
        $builder = $this->db->table('pelaporan_kerusakan p')->select('p.*, a.nama_anggota, a.level, a.no_anggota, b.nama_brg, r.nama_ruang')
            ->join('anggota a', 'a.id=p.anggota_id')
            ->join('stok_barang sb', 'sb.id=p.stokbrg_id')
            ->join('barang b', 'b.id=sb.barang_id')
            ->join('ruang r', 'r.id=sb.ruang_id')
            ->join('satuan s', 's.id=b.satuan_id')
            ->orderBy('p.id', 'DESC')
            ->limit(5);

        $results = $builder->get()->getResult();

        $msg = [
            'data' => $results,
        ];

        echo json_encode($msg);
    }

    public function getnotifikasipelaporan()
    {
        if (!$this->request->isAJAX()) {
            $data = [
                'title' => 'Error 404',
                'msg' => 'Maaf tidak dapat diproses',
            ];
            return view('errors/mazer/error-404', $data);
        }
        helper('converter_helper');
        $view = $this->request->getVar('view');
        if (isset($view)) {
            $query = $this->db->table('pelaporan_kerusakan p')->select('p.*,a.nama_anggota, a.no_anggota, a.level, u.singkatan, n.viewed_by_admin')
                ->join('anggota a', 'a.id=p.anggota_id')
                ->join('unit u', 'u.id=a.unit_id')
                ->join('notifikasi n', 'p.id=n.laporan_id')
                ->where('n.deleted_at IS NULL')
                ->where('a.deleted_at IS NULL')
                ->where('p.deleted_at IS NULL');

            $result = $query->orderBy('n.viewed_by_admin', 'ASC')
                ->orderBy('p.id', 'DESC')
                ->limit(5)
                ->get()->getResultArray();

            $output = '';

            if (count($result) > 0) {
                $output .= '<li>
                                <h5 class="dropdown-header">Pelaporan Kerusakan Aset</h5>
                                <hr class="dropdown-divider">
                            </li>';
                foreach ($result as $row) {
                    if (!$row['viewed_by_admin']) {
                        $output .= '
                        <li style="background-color:rgb(25, 135, 84, 0.1);">
                        <a href="' . site_url('admin/notification?no_laporan=') . $row['no_laporan'] . '" class="dropdown-item" style="padding: 0.3rem 1.5rem;">
                          <div class="d-flex w-100 justify-content-around align-items-center">
                          <div>
                          <h6 class="mb-1"> ' . $row["nama_anggota"] . ' (' . $row["no_anggota"] . ')-' . $row["level"] . '</h6>
                          <p class="mb-1">' . $row["title"] . '</p>
                          <small>' . ubahTanggal($row["created_at"]) . '</small>
                          </div>
                            <small style="margin-left:15px;"><i class="bi bi-circle-fill text-warning"></i></small>
                          </div>
                        </a>
                      </li>
                        ';
                    } else {
                        $output .= '
                        <li>
                        <a href="' . site_url('admin/notification?no_laporan=') . $row['no_laporan'] . '" class="dropdown-item" style="padding: 0.3rem 1.5rem;">
                          <div class="d-flex w-100 justify-content-between align-items-center">
                          <div>
                          <h6 class="mb-1"> ' . $row["nama_anggota"] . ' (' . $row["no_anggota"] . ')-' . $row["level"] . '</h6>
                          <p class="mb-1">' . $row["title"] . '</p>
                          <small>' . ubahTanggal($row["created_at"]) . '</small>
                          </div>
                          <span style="margin-left:15px;"><i class="bi bi-eye text-secondary"></i></span>
                          </div>
                        </a>
                      </li>
                        ';
                    }
                }
            } else {
                $output .= '<li><a href="#" class="dropdown-item" class="text-bold text-italic">Tidak ada notifikasi baru ditemukan</a></li>';
            }


            $query2 = $this->db->table('notifikasi n')->select('n.*')
                ->join('pelaporan_kerusakan p', 'p.id=n.laporan_id')
                ->join('anggota a', 'a.id=p.anggota_id')
                ->where('n.viewed_by_admin', 0)
                ->where('n.deleted_at IS NULL')
                ->where('a.deleted_at IS NULL')
                ->where('p.deleted_at IS NULL');
            $result2 = $query2->get()->getResultArray();
            $count = count($result2);

            $data = [
                'notification' => $output,
                'unseen_notification' => $count,
            ];

            $pusher = $this->handleNotification();
            $pusher->trigger('notifications-channel', 'pelaporan-event', $data);

            echo json_encode($data);
        }
    }

    public function index()
    {
        $no_laporan = '';
        if ($this->request->getGet('no_laporan')) {
            $no_laporan = $this->request->getGet('no_laporan');
        }
        $page    = isset($_GET["page_pelaporan"]) ? (int)$_GET["page_pelaporan"] : 1;

        $segments = $this->uri->getSegments();
        $breadcrumb = [];
        $link = '';

        foreach ($segments as $segment) {
            $link .= '/' . $segment;
            $name = ucwords(str_replace('-', ' ', $segment));
            $breadcrumb[] = ['name' => $name, 'link' => $link];
        }

        if ($no_laporan) {
            $query = $this->db->table('pelaporan_kerusakan p')->select('p.*, a.nama_anggota, a.no_anggota, a.level, u.singkatan,n.id as notif_id, n.viewed_by_admin,b.nama_brg, s.kd_satuan')
                ->join('anggota a', 'a.id=p.anggota_id')
                ->join('unit u', 'u.id=a.unit_id')
                ->join('stok_barang sb', 'sb.id=p.stokbrg_id')
                ->join('barang b', 'b.id=sb.barang_id')
                ->join('satuan s', 's.id=b.satuan_id')
                ->join('notifikasi n', 'p.id=n.laporan_id')
                ->where('p.no_laporan', $no_laporan);
            $pelaporan = $query->get()->getRow();

            $id = session()->get('id');

            $ubahnotif = [
                'petugas_id' => $id,
                'viewed_by_admin' => 1
            ];

            $updatenotif = $this->notifikasi->setUpdateData($ubahnotif);

            $this->db->table('notifikasi')->where('id', $pelaporan->notif_id)->update($updatenotif);
        } else if ($page) {
            $pelaporan = $this->pelaporan->paginatePelaporan(5, 'pelaporan');
            $pager = $this->pelaporan->pager;
            $notviewed = $this->db->table('notifikasi n')->select('*')->where('viewed_by_admin', 0);
            $belumdibaca = count($notviewed->get()->getResult());
        } else {
            $pelaporan = $this->pelaporan->paginatePelaporan(5, 'pelaporan');
            $pager = $this->pelaporan->pager;
            $notviewed = $this->db->table('notifikasi n')->select('*')->where('viewed_by_admin', 0);
            $belumdibaca = count($notviewed->get()->getResult());
        }
        $data = [
            'title' => 'Notifikasi Kerusakan Aset',
            'nav' => 'notification',
            'pelaporan' => $pelaporan,
            'no_laporan' => $no_laporan,
            'pager' => isset($pager) ? $pager : null,
            'belumdibaca' => isset($belumdibaca) ? "($belumdibaca)" : '',
            'breadcrumb' => $breadcrumb
        ];

        return view('pelaporan/index', $data);
    }

    public function tampildetailpelaporan($no_laporan)
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $viewed = array_key_exists('viewed', $this->request->getGet()) ? $this->request->getGet('viewed') : '';

        if ($viewed == 0) {
            $query = $this->db->table('notifikasi n')->select('n.*')->join('pelaporan_kerusakan p', 'p.id=n.laporan_id')->where('no_laporan', $no_laporan)->get();
            $notif = $query->getRow();

            $id = session()->get('id');

            $ubahnotif = [
                'petugas_id' => $id,
                'viewed_by_admin' => 1
            ];

            $updatenotif = $this->notifikasi->setUpdateData($ubahnotif);

            $this->db->table('notifikasi')->where('id', $notif->id)->update($updatenotif);
        }

        $data = [
            'no_laporan' => $no_laporan,
        ];
        $msg = [
            'data' => view('pelaporan/detailpelaporan', $data),
        ];

        echo json_encode($msg);
    }

    public function tampilcardpelaporan()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $keywords = array_key_exists('keywords', $this->request->getGet()) ? $this->request->getGet('keywords') : '';

        $isRestored = array_key_exists('isRestored', $this->request->getGet()) ? intval($this->request->getGet('isRestored')) : '';

        $query = $this->db->table('pelaporan_kerusakan p')->select('p.*, b.nama_brg, a.nama_anggota, a.no_anggota, a.level, u.singkatan, n.viewed_by_admin')
            ->join('anggota a', 'a.id=p.anggota_id')
            ->join('stok_barang sb', 'sb.id=p.stokbrg_id')
            ->join('barang b', 'b.id=sb.barang_id')
            ->join('unit u', 'u.id=a.unit_id')
            ->join('notifikasi n', 'p.id=n.laporan_id');
        if ($isRestored == 1) {
            $query->where('n.deleted_at IS NOT NULL')
                ->where('p.deleted_at IS NOT NULL');
        } else if ($isRestored == 0) {
            $query->where('n.deleted_at IS NULL')
                ->where('a.deleted_at IS NULL')
                ->where('p.deleted_at IS NULL');
        }
        if ($keywords !== '' && !empty($keywords)) {
            $query->like('a.nama_anggota', "%$keywords%")
                ->orLike('a.no_anggota', "%$keywords%")
                ->orLike('u.singkatan', "%$keywords%")
                ->orLike('b.nama_brg', "%$keywords%");
        }

        $pelaporan = $query->orderBy('p.id', 'DESC')->get()->getResultArray();

        $notviewed = $this->db->table('notifikasi n')->select('*')->where('viewed_by_admin', 0);
        $belumdibaca = count($notviewed->get()->getResult());

        $data = [
            'pelaporan' => $pelaporan,
            'belumdibaca' => $belumdibaca ? $belumdibaca : '',
        ];
        $msg = [
            'data' => view('pelaporan/semuapelaporan', $data),
        ];

        echo json_encode($msg);
    }

    public function getLaporanByNoLaporan()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $no_laporan = $this->request->getVar('no_laporan');
        $query = $this->db->table('pelaporan_kerusakan p')->select('p.*, a.nama_anggota, a.no_anggota, a.level, u.singkatan, n.viewed_by_admin,b.nama_brg, s.kd_satuan')
            ->join('anggota a', 'a.id=p.anggota_id')
            ->join('unit u', 'u.id=a.unit_id')
            ->join('stok_barang sb', 'sb.id=p.stokbrg_id')
            ->join('barang b', 'b.id=sb.barang_id')
            ->join('satuan s', 's.id=b.satuan_id')
            ->join('notifikasi n', 'p.id=n.laporan_id')
            ->where('p.no_laporan', $no_laporan);

        $pelaporan = $query->get()->getRow();

        echo json_encode($pelaporan);
    }

    public function multipledeletetemporary()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $jmldata = $this->request->getVar('jmldata');
        $ids = $this->request->getVar('ids');
        $id = explode(",", $ids);

        if (count($id) === 1) {
            $notif = $this->db->table('notifikasi')->select('*')->where('laporan_id', $id[0])->get()->getRow();

            $this->notifikasi->setSoftDelete($notif->id);
            $softdelete = $this->pelaporan->setSoftDelete();
            $this->db->table('pelaporan_kerusakan')->where('id', $id[0])->update($softdelete);
        } else {
            foreach ($id as $laporan_id) {
                $notif = $this->db->table('notifikasi')->select('*')->where('laporan_id', $laporan_id)->get()->getRow();
                $this->notifikasi->setSoftDelete($notif->id);
                $softdelete = $this->pelaporan->setSoftDelete();
                $this->db->table('pelaporan_kerusakan')->where('id', $laporan_id)->update($softdelete);
            }
        }

        $msg = [
            'sukses' => "$jmldata data pelaporan kerusakan aset berhasil dihapus secara permanen",
        ];

        echo json_encode($msg);
    }

    public function multipledeletepermanen()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $jmldata = $this->request->getVar('jmldata');
        $ids = $this->request->getVar('ids');
        $id = explode(",", $ids);

        if (count($id) === 1) {
            $notif = $this->db->table('notifikasi')->select('*')->where('laporan_id', $id[0])->get()->getRow();

            $this->notifikasi->delete($notif->id, true);
            $this->pelaporan->delete($id[0], true);
        } else {
            foreach ($id as $laporan_id) {
                $notif = $this->db->table('notifikasi')->select('*')->where('laporan_id', $laporan_id)->get()->getRow();

                $this->notifikasi->delete($notif->id, true);
                $this->pelaporan->delete($laporan_id, true);
            }
        }

        $msg = [
            'sukses' => "$jmldata data pelaporan kerusakan aset berhasil dihapus secara permanen",
        ];

        echo json_encode($msg);
    }

    public function restoredata()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }

        $jmldata = $this->request->getVar('jmldata');
        $ids = $this->request->getVar('ids');
        $id = explode(",", $ids);

        if (count($id) === 1) {
            $notif = $this->db->table('notifikasi')->select('*')->where('laporan_id', $id[0])->get()->getRow();

            $notifRestore = $this->notifikasi->setRestoreData();
            $this->notifikasi->update($notif->id, $notifRestore);

            $pelaporanRestore = $this->pelaporan->setRestoreData();

            $this->db->table('pelaporan_kerusakan')->where('id', $id[0])->update($pelaporanRestore);
        } else {
            foreach ($id as $laporan_id) {
                $notif = $this->db->table('notifikasi')->select('*')->where('laporan_id', $laporan_id)->get()->getRow();

                $notifRestore = $this->notifikasi->setRestoreData();
                $this->notifikasi->update($notif->id, $notifRestore);

                $pelaporanRestore = $this->pelaporan->setRestoreData();

                $this->db->table('pelaporan_kerusakan')->where('id', $laporan_id)->update($pelaporanRestore);
            }
        }

        $msg = [
            'sukses' => "$jmldata data pelaporan kerusakan aset berhasil dihapus secara permanen",
        ];

        echo json_encode($msg);
    }

    public function livesearchpelaporan()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $keywords = $this->request->getGet('keywords');
        $isRestored = filter_var($this->request->getGet('isRestored'), FILTER_VALIDATE_BOOLEAN);

        $query = $this->db->table('pelaporan_kerusakan p')->select('p.*, a.nama_anggota, a.no_anggota, a.level, u.singkatan, n.viewed_by_admin')
            ->join('anggota a', 'a.id=p.anggota_id')
            ->join('unit u', 'u.id=a.unit_id')
            ->join('notifikasi n', 'p.id=n.laporan_id')
            ->like('a.nama_anggota', "%$keywords%")
            ->orLike('a.no_anggota', "%$keywords%")
            ->orLike('u.singkatan', "%$keywords%");

        if ($isRestored) {
            $query->where('n.deleted_at IS NOT NULL')->where('a.deleted_at IS NOT NULL')
                ->where('p.deleted_at IS NOT NULL');
        } else {
            $query->where('n.deleted_at IS NULL')->where('a.deleted_at IS NULL')
                ->where('p.deleted_at IS NULL');
        }
        $pelaporan = $query->orderBy('p.id', 'DESC')->get()->getResultArray();

        $data = [
            'pelaporan' => $pelaporan,
        ];
        $msg = [
            'data' => view('pelaporan/semuapelaporan', $data),
        ];

        echo json_encode($msg);
    }

    function pilihanggota()
    {
        if (!$this->request->isAJAX()) {
            $data = $this->errorPage404();
            return view('errors/mazer/error-404', $data);
        }
        $search = $this->request->getGet('search');
        $level = $this->request->getGet('level');
        if ($level && !empty($search)) {
            $dataanggota = $this->db->table('anggota a')
                ->select('a.*, u.singkatan')
                ->join('unit u', 'u.id=a.unit_id')
                ->where('u.deleted_at is null')
                ->where('a.deleted_at is null')
                ->where('a.level', $level)
                ->like('a.no_anggota', $search)
                ->orderBy('a.level', 'ASC')
                ->orderBy('a.nama_anggota', 'ASC')->get();
        }

        if ($dataanggota->getNumRows() > 0) {
            $list = [];
            $key = 0;
            foreach ($dataanggota->getResultArray() as $row) {
                $list[$key]['id'] = $row['id'];
                $list[$key]['text'] = $row['no_anggota'];
                $list[$key]['nama'] = $row['nama_anggota'];

                $key++;
            }
        } else {
            $list = [
                ['id' => '', 'text' => 'Maaf keyword yang anda cari tidak ditemukan'],
            ];
        }
        echo json_encode($list);
    }
}
