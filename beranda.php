<?php
// Memulai sesi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Mengatur timezone
date_default_timezone_set('Asia/Jakarta'); // Set your timezone

// Menghubungkan ke database
include_once "database/koneksi.php";
include_once "utils/utils.php";
include_once "templates/header.php";

// Mengambil tanggal hari ini
$today = date('Y-m-d'); // Get today's date

// Query untuk menghitung jumlah pegawai, admin, dan cabang
$pegawai = $mysqli->query("SELECT * FROM pegawai");
$admin = $mysqli->query("SELECT * FROM admin");
$cabang = $mysqli->query("SELECT * FROM cabang");

// Query untuk menghitung jumlah presensi hari ini
$q_hadir = "SELECT COUNT(*) as total_hadir FROM presensi_pegawai WHERE DATE(tanggal_waktu) = '$today' AND status = 'Hadir'";
$q_izin = "SELECT COUNT(*) as total_izin FROM presensi_pegawai WHERE DATE(tanggal_waktu) = '$today' AND status = 'Izin'";
$q_sakit = "SELECT COUNT(*) as total_sakit FROM presensi_pegawai WHERE DATE(tanggal_waktu) = '$today' AND status = 'Sakit'";

$result_hadir = $mysqli->query($q_hadir);
$result_izin = $mysqli->query($q_izin);
$result_sakit = $mysqli->query($q_sakit);

$total_hadir = $result_hadir->fetch_assoc()['total_hadir'];
$total_izin = $result_izin->fetch_assoc()['total_izin'];
$total_sakit = $result_sakit->fetch_assoc()['total_sakit'];

// Query untuk mengambil jumlah kehadiran, izin, dan sakit selama 7 hari terakhir
$q_hadir = "
    SELECT DATE(tanggal_waktu) as tanggal, COUNT(*) as total_hadir 
    FROM presensi_pegawai 
    WHERE DATE(tanggal_waktu) >= CURDATE() - INTERVAL 6 DAY AND status = 'Hadir'
    GROUP BY DATE(tanggal_waktu)
    ORDER BY DATE(tanggal_waktu) ASC
";

$q_izin = "
    SELECT DATE(tanggal_waktu) as tanggal, COUNT(*) as total_izin 
    FROM presensi_pegawai 
    WHERE DATE(tanggal_waktu) >= CURDATE() - INTERVAL 6 DAY AND status = 'Izin'
    GROUP BY DATE(tanggal_waktu)
    ORDER BY DATE(tanggal_waktu) ASC
";

$q_sakit = "
    SELECT DATE(tanggal_waktu) as tanggal, COUNT(*) as total_sakit 
    FROM presensi_pegawai 
    WHERE DATE(tanggal_waktu) >= CURDATE() - INTERVAL 6 DAY AND status = 'Sakit'
    GROUP BY DATE(tanggal_waktu)
    ORDER BY DATE(tanggal_waktu) ASC
";

// Ambil data kehadiran, izin, dan sakit
$result_hadir = $mysqli->query($q_hadir);
$result_izin = $mysqli->query($q_izin);
$result_sakit = $mysqli->query($q_sakit);

// Menyimpan data ke dalam array
$hari = [];
$jumlah_hadir = [];
$jumlah_izin = [];
$jumlah_sakit = [];

// Mengisi data untuk hadir
while ($row = $result_hadir->fetch_assoc()) {
    $hari[] = $row['tanggal'];
    $jumlah_hadir[] = $row['total_hadir'];
}

// Mengisi data untuk izin
while ($row = $result_izin->fetch_assoc()) {
    $jumlah_izin[] = $row['total_izin'];
}

// Mengisi data untuk sakit
while ($row = $result_sakit->fetch_assoc()) {
    $jumlah_sakit[] = $row['total_sakit'];
}

// Pastikan semua array memiliki panjang yang sama
while (count($hari) < 7) {
    $hari[] = date('Y-m-d', strtotime('-' . (count($hari)) . ' days'));
    $jumlah_hadir[] = 0; // Tambahkan 0 untuk hari yang tidak ada data
    $jumlah_izin[] = 0; // Tambahkan 0 untuk hari yang tidak ada data
    $jumlah_sakit[] = 0; // Tambahkan 0 untuk hari yang tidak ada data
}

?>



<link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css">
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=manage_accounts" />

<style>
    :root {
        --poppins: 'Poppins', sans-serif;
        --light: rgba(255, 254, 254, 0.81);
        --blue: #3C91E6;
        --light-blue: #CFE8FF;
        --grey: #eee;
        --dark-grey: #AAAAAA;
        --dark: #342E37;
        --red: #DB504A;
        --yellow: #FFCE26;
        --light-yellow: #FFF2C6;
        --orange: #FD7238;
        --light-orange: #FFE0D3;
    }

    .box-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        grid-gap: 24px;
        margin-top: 36px;
        padding: 0 35px;
    }

    .box-item {
        padding: 24px;
        background: var(--light);
        border-radius: 20px;
        display: flex;
        align-items: center;
        grid-gap: 24px;
    }

    .box-item .bx {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        font-size: 36px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .box-item:nth-child(1) .bx {
        background: var(--light-blue);
        color: var(--blue);
    }

    .box-item:nth-child(2) .bx {
        background: var(--light-yellow);
        color: var(--yellow);
    }

    .box-item:nth-child(3) .bx {
        background: var(--light-orange);
        color: var(--orange);
    }

    .box-item .text h3 {
        font-size: 24px;
        font-weight: 600 color: var(--dark);
    }

    .box-item .text p {
        color: var(--dark);
    }

    .data {
        display: flex;
        grid-gap: 20px;
        margin-top: 20px;
        flex-wrap: wrap;
        padding: 0 35px;
    }

    .content-data {
        flex-grow: 1;
        flex-basis: 400px;
        padding: 20px;
        background: var(--light);
        border-radius: 10px;
        box-shadow: 4px 4px 16px rgba(0, 0, 0, .1);
    }

    .content-data .head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .content-data .head h3 {
        font-size: 20px;
        font-weight: 600;
    }

    .content-data .head .menu {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .content-data .head .menu .icon {
        cursor: pointer;
    }

    .content-data .chart {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .content-data .chart::-webkit-scrollbar {
        display: none;
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h1>Dasboard</h1>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="box-info">
        <div class="box-item">
            <i class='bx bxs-group'></i>
            <span class="text">
                <h1><b><?= $pegawai->num_rows; ?></b></h1>
                <h3><b>Jumlah Karyawan</b></h3>
            </span>
        </div>
        <div class="box-item">
            <i class='bx bxs-user'></i>
            <span class="text">
                <h1><b><?= $admin->num_rows; ?></b></h1>
                <h3><b>Jumlah Admin</b></h3>
            </span>
        </div>
        <div class="box-item">
            <i class='bx bxs-store'></i>
            <span class="text">
                <h1><b><?= $cabang->num_rows; ?></b></h1>
                <h3><b>Jumlah Cabang</b></h3>
            </span>
        </div>
    </div>
</section>


<section>
    <div class="data">
        <div class="content-data">

            <div class="head">
                <h3>Riwayat Presensi Hari Ini</h3>
                <br>
                <h3>Tanggal: <?= date('d-m-Y', strtotime($today)); ?></h3>
            </div>
            <div class="chart">
                <div class="box-info">
                    <div class="box-item">
                        <i class='bx bx-calendar-check'></i>
                        <span class="text">
                            <h3><?= $total_hadir; ?></h3>
                            <p>Hadir</p>
                        </span>
                    </div>
                    <div class="box-item">
                        <i class='bx bx-calendar-x'></i>
                        <span class="text">
                            <h3><?= $total_izin; ?></h3>
                            <p>Izin</p>
                        </span>
                    </div>
                    <div class="box-item">
                        <i class='bx bx-calendar-minus'></i>
                        <span class="text">
                            <h3><?= $total_sakit; ?></h3>
                            <p>Sakit</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-data">
            <div class="head">
                <h3>Tingkat Kehadiran Karyawan</h3>
                <p>Jumlah Kehadiran karyawan 7 hari terakhir</p>

            </div>
            <div class="chart">
                <canvas id="kehadiranChart"></canvas>
            </div>

        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('kehadiranChart').getContext('2d');
    const kehadiranChart = new Chart(ctx, {
        type: 'bar', // Tipe grafik
        data: {
            labels: <?= json_encode($hari); ?>, // Label untuk sumbu X
            datasets: [
                {
                    label: 'Hadir',
                    data: <?= json_encode($jumlah_hadir); ?>, // Data untuk sumbu Y
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Warna untuk Hadir
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Izin',
                    data: <?= json_encode($jumlah_izin); ?>, // Data untuk sumbu Y
                    backgroundColor: 'rgba(255, 206, 86, 0.2)', // Warna untuk Izin
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Sakit',
                    data: <?= json_encode($jumlah_sakit); ?>, // Data untuk sumbu Y
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Warna untuk Sakit
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    const updateChartData = async () => {
    const response = await fetch("path/to/your/data/endpoint"); // Ganti dengan endpoint yang sesuai
    const data = await response.json();

    // Misalkan data yang diterima adalah objek dengan format:

    kehadiranChart.data.labels = data.hari;
    kehadiranChart.data.datasets[0].data = data.jumlah_hadir;
    kehadiranChart.data.datasets[1].data = data.jumlah_izin;
    kehadiranChart.data.datasets[2].data = data.jumlah_sakit;

    kehadiranChart.update(); // Perbarui grafik
    console.log(data); // Hanya untuk debugging
};

// Panggil fungsi ini setelah menambahkan presensi
updateChartData();

</script>
<?php
include_once "templates/footer.php";
?>