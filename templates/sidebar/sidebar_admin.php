<style>
    .nav-link {
        color: white !important;
    }

    .nav-link:hover {
        /* background-color: #fff !important; */
        color: rgb(163, 26, 26) !important;
    }

    .nav-link.active {
        background-color: #b95e3a !important;
        color: white !important;
    }

    .logo-brand {
        transition: all 0.3s ease;
    }

    .small {
        width: 50px;
    }

    .hide-text {
        display: none;
    }

    .main-sidebar {
        transition: all 0.3s ease;
    }
</style>
<aside class="main-sidebar elevation-4 text-white" style="background-color: #252525;">
    <div class="sidebar">
        <!-- <div class="p-3 d-flex flex-column align-items-center">
            <img src="assets/img/logo2.png" width="200" class="mb-3">
            <h5 class="text-center">RM.SIANG MALAM MASAKAN PADANG</h5>
        </div> -->
        <div class="p-3 d-flex flex-column align-items-center">
            <img src="assets/img/logo2.png" width="200" class="mb-3 logo-brand" id="logoImage">
            <h5 class="text-center logo-brand" id="logoText">RM.SIANG MALAM MASAKAN PADANG</h5>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="?page=dashboard"
                        class="nav-link <?= isset($_GET['page']) ? (($_GET['page'] === "dashboard") ? "active" : "") : "active" ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-header">MASTER DATA</li>
                <li class="nav-item">
                    <a href="?page=admin"
                        class="nav-link <?= isset($_GET['page']) ? (($_GET['page'] === "admin") ? "active" : "") : "" ?>">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Admin
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=cabang"
                        class="nav-link <?= isset($_GET['page']) ? (($_GET['page'] === "cabang") ? "active" : "") : "" ?>">
                        <i class="nav-icon fas fa-store-alt"></i>
                        <p>
                            Cabang
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=pegawai"
                        class="nav-link <?= isset($_GET['page']) ? (($_GET['page'] === "pegawai") ? "active" : "") : "" ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Karyawan
                        </p>
                    </a>
                </li>
                <li class="nav-header">PRESENSI PEGAWAI</li>
                <li class="nav-item">
                    <a href="?page=scanner"
                        class="nav-link <?= isset($_GET['page']) ? (($_GET['page'] === "scanner") ? "active" : "") : "" ?>">
                        <i class="nav-icon fas fa-qrcode"></i>
                        <p>
                            Scanner
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=riwayat_presensi"
                        class="nav-link <?= isset($_GET['page']) ? (($_GET['page'] === "riwayat_presensi") ? "active" : "") : "" ?>">
                        <i class="nav-icon fas fa-history"></i>
                        <p>
                            Riwayat Presensi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=tabel_presensi"
                        class="nav-link <?= isset($_GET['page']) ? (($_GET['page'] === "tabel_presensi") ? "active" : "") : "" ?>">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                            Tabel Presensi
                        </p>
                    </a>
                </li>
                <li class="nav-header">LAPORAN</li>
                <li
                    class="nav-item <?= isset($_GET['page']) ? (($_GET['page'] == 'laporan') ? "menu-open" : "") : "" ?>">
                    <a href="#"
                        class="nav-link <?= isset($_GET['page']) ? (($_GET['page'] == 'laporan') ? "active" : "") : "" ?>">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Laporan
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="?page=laporan&method=pegawai"
                                class="nav-link <?= isset($_GET['method']) ? (($_GET['method'] === "pegawai") ? "active" : "") : "" ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Karyawan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=laporan&method=riwayat_presensi"
                                class="nav-link <?= isset($_GET['method']) ? (($_GET['method'] === "riwayat_presensi") ? "active" : "") : "" ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Riwayat Presensi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=laporan&method=presensi_bulanan"
                                class="nav-link <?= isset($_GET['method']) ? (($_GET['method'] === "presensi_bulanan") ? "active" : "") : "" ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Presensi Bulanan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=laporan&method=slip_gaji_pegawai"
                                class="nav-link <?= isset($_GET['method']) ? (($_GET['method'] === "slip_gaji_pegawai") ? "active" : "") : "" ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Slip Gaji Pegawai</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header">PENGATURAN</li>
                <li class="nav-item">
                    <a href="?page=ganti_password"
                        class="nav-link <?= isset($_GET['page']) ? (($_GET['page'] === "ganti_password") ? "active" : "") : "" ?>">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Ganti Password
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="halaman_auth/logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<div class="content-wrapper">
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function () {
            var logoImage = document.getElementById('logoImage');
            var logoText = document.getElementById('logoText');

            // Mengecilkan logo dan menyembunyikan teks
            logoImage.classList.toggle('small');
            logoText.classList.toggle('hide-text');
        });

        // Jika Anda menggunakan jQuery untuk sidebar, Anda bisa menambahkan event listener untuk mendeteksi ketika sidebar ditutup
        $(document).on('click', '.sidebar-toggle', function () {
            var logoImage = document.getElementById('logoImage');
            var logoText = document.getElementById('logoText');

            // Cek apakah sidebar dalam keadaan terbuka atau tertutup
            if ($('.main-sidebar').hasClass('sidebar-open')) {
                // Jika sidebar terbuka, kecilkan logo dan sembunyikan teks
                logoImage.classList.add('small');
                logoText.classList.add('hide-text');
            } else {
                // Jika sidebar tertutup, kembalikan logo ke ukuran semula dan tampilkan teks
                logoImage.classList.remove('small');
                logoText.classList.remove('hide-text');
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>