<div id="sidebar" class="active">
  <div class="sidebar-wrapper shadow active text-white bg-dark">
    <div class="sidebar-header">
      <div class="d-flex justify-content-between align-items-center">
        <div class="logo col-lg-8">
          <a href="dashboard"><img src="<?= base_url() ?>assets/images/logo/logouniralandscape.jpg" alt="Logo" style="max-width: 200px;"></a>
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
        <li class="sidebar-item <?= ($nav == 'kategori') ? 'active' : '' ?>">
          <a href="kategori" class='sidebar-link'>
            <i class="bi bi-layers"></i>
            <span>Kategori</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($nav == 'ruang') ? 'active' : '' ?>">
          <a href="ruang" class='sidebar-link'>
            <i class="bi bi-building"></i>
            <span>Ruang</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($nav == 'laporan') ? 'active' : '' ?>">
          <a href="laporan" class='sidebar-link'>
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span>Laporan Aset</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($nav == 'anggota') ? 'active' : '' ?>">
          <a href="anggota" class='sidebar-link'>
            <i class="bi bi-people"></i>
            <span>Anggota & Unit</span>
          </a>
        </li>
      </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
  </div>
</div>