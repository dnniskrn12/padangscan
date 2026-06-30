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
        <div class="p-3 d-flex flex-column align-items-center">
            <img src="assets/img/logo2.png" width="200" class="mb-3 logo-brand" id="logoImage">
            <h5 class="text-center logo-brand" id="logoText">RM.SIANG MALAM MASAKAN PADANG</h5>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">MENU UTAMA</li>
                <li class="nav-item">
                    <a href="?page=dashboard"
                        class="nav-link <?= isset($_GET['page']) ? (($_GET['page'] === "dashboard") ? "active" : "") : "active" ?>">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="?page=data_diri"
                        class="nav-link <?= isset($_GET['page']) ? (($_GET['page'] === "data_diri") ? "active" : "") : "" ?>">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Data Diri
                        </p>
                    </a>
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