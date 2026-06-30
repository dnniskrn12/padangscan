<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Slip Gaji Pegawai</title>
    <link href="bootstrap.css" rel="stylesheet">
</head>

<body>
    <?php include_once('header.php'); ?>
    <h4 class="text-center my-3">Laporan Slip Gaji Pegawai</h4>
    <section class="p-3">
        <?php $pegawai = $mysqli->query("SELECT p.*, c.nama_cabang FROM pegawai p INNER JOIN cabang c ON p.id_cabang = c.id WHERE p.id=" . $_POST['id_pegawai'])->fetch_assoc(); ?>
        <?php if (isset($_POST['id_pegawai'])): ?>
            <?php
// Query data kehadiran
$hadir = $mysqli->query("SELECT COUNT(*) AS hadir FROM presensi_pegawai WHERE id_pegawai = {$_POST['id_pegawai']} 
                        AND MONTH(tanggal_waktu) = {$_POST['bulan']} AND YEAR(tanggal_waktu) = {$_POST['tahun']} 
                        AND status = 'Hadir'")->fetch_assoc()['hadir'] ?? 0;

$sakit = $mysqli->query("SELECT COUNT(*) AS sakit FROM presensi_pegawai WHERE id_pegawai = {$_POST['id_pegawai']} 
                        AND MONTH(tanggal_waktu) = {$_POST['bulan']} AND YEAR(tanggal_waktu) = {$_POST['tahun']} 
                        AND status = 'Sakit'")->fetch_assoc()['sakit'] ?? 0;

// Tambahkan query untuk menghitung jumlah hari izin
$izin = $mysqli->query("SELECT COUNT(*) AS izin FROM presensi_pegawai WHERE id_pegawai = {$_POST['id_pegawai']} 
                        AND MONTH(tanggal_waktu) = {$_POST['bulan']} AND YEAR(tanggal_waktu) = {$_POST['tahun']} 
                        AND status = 'Izin'")->fetch_assoc()['izin'] ?? 0;

$total_hari = workingDays($_POST['tahun'], $_POST['bulan'], [0, 6]);
$alpha = $total_hari - $hadir - $sakit - $izin; // Menghitung alpha dengan memperhitungkan izin

// Data pegawai
$pegawai = $mysqli->query("SELECT p.*, c.nama_cabang FROM pegawai p INNER JOIN cabang c ON c.id = p.id_cabang 
                           WHERE p.id = {$_POST['id_pegawai']}")->fetch_assoc();

// Perhitungan gaji
$gaji_hadir = $hadir * 70000;
$gaji_izin = $izin * 0; // Gaji untuk izin, jika ada
$gaji_sakit = $sakit * 25000;
$potongan = $alpha * 80000;
$total_gaji = $gaji_hadir + $gaji_izin + $gaji_sakit - $potongan;
?>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <table class="table">
                            <tr>
                                <td>No Karyawan</td>
                                <td><?= $pegawai['no_karyawan']; ?></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td><?= $pegawai['nama']; ?></td>
                            </tr>
                            <tr>
                                <td>Penempatan</td>
                                <td><?= $pegawai['nama_cabang']; ?></td>
                            </tr>
                            <tr>
                                <td>Bulan</td>
                                <td><?= MONTH_IN_INDONESIA[$_POST['bulan'] - 1]; ?></td>
                            </tr>
                            <tr>
                                <td>Tahun</td>
                                <td><?= $_POST['tahun']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Hadir</td>
                        <td><?= $hadir; ?> hari</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Izin</td>
                        <td><?= $izin; ?> hari</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Sakit</td>
                        <td><?= $sakit; ?> hari</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Alpha</td>
                        <td><?= $alpha; ?> hari</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Gaji Hadir</td>
                        <td>Rp <?= number_format($gaji_hadir, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Gaji Izin</td>
                        <td>Rp <?= number_format($gaji_izin, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Gaji Sakit</td>
                        <td>Rp <?= number_format($gaji_sakit, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Potongan / Alpha</td>
                        <td>Rp <?= number_format($potongan, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Total</td>
                        <td>Rp <?= number_format($total_gaji, 0, ',', '.'); ?></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
    <?php endif; ?>
        <?php include_once('footer.php'); ?>
    </section>
    <script>
    function updateFields() {
        var select = document.getElementById('id_pegawai');
        var selectedOption = select.options[select.selectedIndex];

        // Ambil nilai dari data-nip dan data-cabang
        var noKaryawan = selectedOption.getAttribute('data-nip');
        var penempatan = selectedOption.getAttribute('data-cabang');

        // Isi nilai ke input No Karyawan dan Penempatan
        document.querySelector('input[name="no_karyawan"]').value = noKaryawan;
        document.querySelector('input[name="penempatan"]').value = penempatan;
    }
</script>
</body>

</html>