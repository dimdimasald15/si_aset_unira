<div id="sidebar" class="active">
  <div class="sidebar-wrapper shadow active">
    <div class="sidebar-header">
      <div class="d-flex justify-content-between">
        <div class="logo">
          <a href="index.html"><img src="<?= base_url() ?>/assets/images/logo/logouniralandscape.jpg" alt="Logo" srcset=""></a>
        </div>
        <div class="toggler">
          <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
        </div>
      </div>
    </div>
    <div class="sidebar-menu">
      <ul class="menu">
        <li class="sidebar-title">Menu</li>

        <li class="sidebar-item <?= ($nav == 'Dashboard') ? 'active' : '' ?>">
          <a href="dashboard" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="sidebar-item <?= ($nav == 'barang-tetap-masuk') ? 'active' : '' ?> has-sub">
          <a href="#" class='sidebar-link'>
            <i class="bi bi-bounding-box"></i>
            <span>Kelola Transaksi Barang</span>
          </a>
          <ul class="submenu <?= ($nav == 'barang-tetap-masuk') ? 'active' : '' ?>">
            <li class="submenu-item <?= ($nav == 'barang-tetap-masuk') ? 'active' : '' ?>">
              <a href="barang-tetap-masuk">Barang Tetap Masuk</a>
            </li>
            <li class="submenu-item <?= ($nav == 'barang-persediaan-masuk') ? 'active' : '' ?>">
              <a href="barang-persediaan-masuk">Barang Persediaan Masuk</a>
            </li>
            <li class="submenu-item ">
              <a href="peminjaman">Peminjaman Barang</a>
            </li>
            <li class="submenu-item ">
              <a href="permintaan">Permintaan Barang</a>
            </li>
          </ul>
        </li>
        <li class="sidebar-item <?= ($nav == 'barang-tetap') ? 'active' : '' ?> has-sub">
          <a href="#" class='sidebar-link'>
            <i class="bi bi-bounding-box"></i>
            <span>Kelola Barang</span>
          </a>
          <ul class="submenu <?= ($nav == 'barang-tetap') ? 'active' : '' ?>">
            <li class="submenu-item <?= ($nav == 'barang-tetap') ? 'active' : '' ?>">
              <a href="barang-tetap">Barang Tetap</a>
            </li>
            <li class="submenu-item <?= ($nav == 'barangpersediaan') ? 'active' : '' ?>">
              <a href="barang-persediaan">Barang Persediaan</a>
            </li>
          </ul>
        </li>
        <li class="sidebar-item has-sub <?= ($nav == 'ruang' || $nav == 'gedung') ? 'active' : '' ?>">
          <a href="#" class='sidebar-link'>
            <i class="bi bi-building"></i>
            <span>Kelola Ruang</span>
          </a>
          <ul class="submenu <?= ($nav == 'ruang' || $nav == 'gedung') ? 'active' : '' ?>">
            <li class="submenu-item <?= ($nav == 'ruang') ? 'active' : '' ?>">
              <a href="ruang">Ruang</a>
            </li>
            <li class="submenu-item <?= ($nav == 'gedung') ? 'active' : '' ?>">
              <a href="gedung">Gedung</a>
            </li>
          </ul>
        </li>

        <li class="sidebar-item <?= ($nav == 'kategori-tetap' || $nav == 'kategori-persediaan') ? 'active' : '' ?> has-sub">
          <a href="#" class='sidebar-link'>
            <i class="bi bi-layers"></i>
            <span>Kelola Kategori</span>
          </a>
          <ul class="submenu <?= ($nav == 'kategori-tetap' || $nav == 'kategori-persediaan') ? 'active' : '' ?>">
            <li class="submenu-item <?= ($nav == 'kategori-tetap') ? 'active' : '' ?>">
              <a href=" kategori-tetap">Kategori Tetap</a>
            </li>
            <li class="submenu-item <?= ($nav == 'kategori-persediaan') ? 'active' : '' ?>">
              <a href=" kategori-persediaan">Kategori Persediaan</a>
            </li>
          </ul>
        </li>

        <li class="sidebar-title">Pengaturan</li>
        <li class="sidebar-item <?= $nav == 'pengguna' ? 'active' : '' ?>">
          <a href="pengguna" class='sidebar-link'>
            <i class="bi bi-gear-fill"></i>
            <span>Pengguna</span>
          </a>
        </li>
      </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
  </div>
</div>