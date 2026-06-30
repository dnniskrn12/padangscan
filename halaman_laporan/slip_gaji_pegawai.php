<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan Slip Gaji Pegawai</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title flex-grow-1">Filter</h3>
                    <form action="halaman_cetak_laporan/slip_gaji_pegawai.php" method="POST" target="_blank">
                        <?php foreach (['id_pegawai', 'bulan', 'tahun'] as $field): ?>
                            <?php if (isset($_POST[$field])): ?>
                                <input type="hidden" name="<?= $field ?>" value="<?= $_POST[$field] ?>">
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <button class="btn btn-success">Cetak</button>
                    </form>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    <?php $result = $mysqli->query("SELECT p.*, c.nama_cabang FROM pegawai p INNER JOIN cabang c ON p.id_cabang = c.id ORDER BY p.nama"); ?>
                                    <label for="id_pegawai">Karyawan</label>
                                    <select class="form-control select2bs4" name="id_pegawai" id="id_pegawai" required
                                        onchange="updateFields()">
                                        <option value="" disabled selected>Pilih Karyawan</option>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <option value="<?= $row['id']; ?>" <?= ($row['id'] == ($_POST['id_pegawai'] ?? '')) ? 'selected' : ''; ?> data-nip="<?= $row['no_karyawan']; ?>"
                                                data-cabang="<?= $row['nama_cabang']; ?>">
                                                <?= $row['nama']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    <label>No Karyawan</label>
                                    <input type="text" readonly class="form-control" name="no_karyawan"
                                        value="<?= $_POST['no_karyawan'] ?? ''; ?>">
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    <label>Penempatan</label>
                                    <input type="text" readonly class="form-control" name="penempatan"
                                        value="<?= $_POST['penempatan'] ?? ''; ?>">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="bulan">Bulan</label>
                                    <select class="form-control select2bs4" name="bulan" id="bulan" required>
                                        <option value="" disabled selected>Pilih Bulan</option>
                                        <?php foreach (MONTH_IN_INDONESIA as $index => $month): ?>
                                            <option value="<?= $index + 1; ?>" 
                                                <?= (($_POST['bulan'] ?? '') == ($index + 1)) ? 'selected' : ''; ?>>
                                                <?= $month; ?>
                                            </option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" class="form-control" name="tahun" id="tahun" min="1"
                                        value="<?= $_POST['tahun'] ?? date('Y'); ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="?page=<?= $_GET['page']; ?>&method=<?= $_GET['method']; ?>"
                                class="ml-2 btn btn-secondary">Reset</a>
                            <button type="submit" class="ml-2 btn btn-info">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
 
$total_hari = workingDays($_POST['tahun'], $_POST['bulan'], [0, 7]);
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