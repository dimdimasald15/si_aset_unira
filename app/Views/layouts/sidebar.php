<div id="sidebar" class="active">
  <div class="sidebar-wrapper active">
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
        <li class="sidebar-item <?= ($nav == 'barang') ? 'active' : '' ?> has-sub">
          <a href="#" class='sidebar-link'>
            <i class="bi bi-stack"></i>
            <span>Kelola Barang</span>
          </a>
          <ul class="submenu <?= ($nav == 'barang') ? 'active' : '' ?>">
            <li class="submenu-item <?= ($nav == 'barang') ? 'active' : '' ?>">
              <a href="barang">Barang</a>
            </li>
            <li class="submenu-item ">
              <a href="peminjaman">Peminjaman Barang</a>
            </li>
            <li class="submenu-item ">
              <a href="permintaan">Permintaan Barang</a>
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
        </li>
      </ul>
      </li>
      <li class="sidebar-item <?= ($nav == 'kategori') ? 'active' : '' ?>">
        <a href="kategori" class='sidebar-link'>
          <i class="bi bi-grid-fill"></i>
          <span>Kategori</span>
        </a>
      </li>

      <li class="sidebar-title">Pengaturan</li>
      <li class="sidebar-item <?= $nav == 'pengguna' ? 'active' : '' ?>">
        <a href="pengguna" class='sidebar-link'>
          <i class="bi bi-gear-fill"></i>
          <span>Pengguna</span>
        </a>
      </li>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
  </div>
</div>