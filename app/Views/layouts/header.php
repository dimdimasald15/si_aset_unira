<header class='mb-3'>
    <nav class="navbar navbar-fixed navbar-expand navbar-light ">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block">
                <i class="bi bi-justify fs-3"></i>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown me-1 mt-2">
                        <label class="switch">
                            <input type="checkbox" id="lightSwitch">
                            <span class="slider"></span>
                        </label>
                    </li>
                    <li class="nav-item dropdown me-1">
                        <a class="nav-link active dropdown-toggle count" data-bs-toggle="button" id="pelaporanmasuk"
                            onClick="notif.showNotification('showpelaporan','shownotif')" aria-expanded="false">
                            <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
                            <span class="badge rounded-pill badge-sm badge-notification bg-danger" style="color:white;cursor:pointer;" id="pelaporan_count"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" id="showpelaporan" aria-labelledby="pelaporanmasuk"></ul>
                    </li>
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link active dropdown-toggle" data-bs-toggle="button" id="notifpersediaan"
                            onClick="notif.showNotification('shownotif','showpelaporan')" aria-expanded="false">
                            <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                            <span class="badge rounded-pill badge-sm badge-notification bg-warning" style="color:black;cursor:pointer;" id="notification_count"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" id="shownotif" aria-labelledby="dropdownMenuButton"></ul>
                    </li>
                </ul>
                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600"><?= $_SESSION['username'] ?></h6>
                                <p class="mb-0 text-sm text-gray-600"><?= $_SESSION['role'] ?></p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md" id="avatar">
                                    <img src="<?= base_url(); ?>/uploads/<?= $_SESSION['foto'] ? $_SESSION['foto'] : 'default.jpg' ?>" alt="Profile Picture">
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li>
                            <h6 class="dropdown-header">Hello, <?= $_SESSION['username'] ?></h6>
                        </li>
                        <li><a class="dropdown-item" href="profile"><i class="icon-mid bi bi-person me-2"></i> My Profile</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item" href="<?= site_url('logout') ?>"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>