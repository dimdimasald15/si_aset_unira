<div id="sidebar" class="active">
  <div class="sidebar-wrapper shadow active">
    <div class="sidebar-header">
      <div class="d-flex justify-content-between align-items-center">
        <div class="logo col-lg-8">
          <a href="dashboard"><img src="<?= base_url() ?>assets/images/logo/logouniralandscape.png" alt="Logo" style="max-width: 200px;"></a>
        </div>
        <div class="toggler">
          <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
        </div>
      </div>
    </div>
    <div class="sidebar-menu">
      <ul class="menu">
        <li class="sidebar-title">Menu</li>
        <li class="sidebar-item <?= ($nav == 'dashboard') ? 'active' : '' ?>">
          <a href="dashboard" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <?php $activeNavs = ['kategori', 'gedung', 'ruang', 'anggota', 'pengguna']; ?>
        <li class="sidebar-item <?= in_array($nav, $activeNavs) ? 'active' : '' ?> has-sub">
          <a href="#" class='sidebar-link'>
            <i class="bi bi-table"></i>
            <span>Master Data</span>
          </a>
          <ul class="submenu <?= in_array($nav, $activeNavs) ? 'active submenu-open' : '' ?>">
            <li class="submenu-item <?= ($nav == 'kategori') ? 'active' : '' ?>">
              <a href="kategori" class='submenu-link'>Data Kategori</a>
            </li>
            <li class="submenu-item <?= ($nav == 'gedung') ? 'active' : '' ?>">
              <a href="gedung" class='submenu-link'>Data Gedung</a>
            </li>
            <li class="submenu-item <?= ($nav == 'ruang') ? 'active' : '' ?>">
              <a href="ruang" class='submenu-link'>Data Ruang</a>
            </li>
            <li class="submenu-item <?= ($nav == 'anggota') ? 'active' : '' ?>">
              <a href="anggota" class='submenu-link'>Data Anggota & Unit</a>
            </li>
            <?php if (session('role') !== "Petugas"): ?>
              <li class="submenu-item <?= ($nav == 'pengguna') ? 'active' : '' ?>">
                <a href="pengguna" class='submenu-link'>Data Pengguna</a>
              </li>
            <?php endif ?>
          </ul>
        </li>
        <li class="sidebar-item <?= ($nav == 'kelola-barang') ? 'active' : '' ?>">
          <a href="kelola-barang" class='sidebar-link'>
            <i class="bi bi-box"></i>
            <span>Kelola Barang</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($nav == 'peminjaman-barang') ? 'active' : '' ?>">
          <a href="peminjaman-barang" class='sidebar-link'>
            <i class="bi bi-calendar-event"></i>
            <span>Peminjaman Barang</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($nav == 'permintaan-barang') ? 'active' : '' ?>">
          <a href="permintaan-barang" class='sidebar-link'>
            <i class="bi bi-clipboard-check"></i>
            <span>Permintaan Barang</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($nav == 'laporan') ? 'active' : '' ?>">
          <a href="laporan" class='sidebar-link'>
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Laporan Aset</span>
          </a>
        </li>
      </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
  </div>
</div>