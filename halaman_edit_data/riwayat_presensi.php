<?php

if (isset($_GET['id'])) {
    $q = "
        SELECT 
            pp.*,
            DATE(pp.tanggal_waktu) tanggal,
            DATE_FORMAT(pp.tanggal_waktu, '%H:%i') waktu,
            p.no_karyawan,
            p.nama,
            c.nama_cabang 
        FROM 
            presensi_pegawai pp 
        INNER JOIN 
            pegawai p 
        ON 
            p.id=pp.id_pegawai 
        INNER JOIN 
            cabang c 
        ON 
            c.id=p.id_cabang 
        WHERE 
            pp.id=" . $_GET['id'] . "
    ";
    $result = $mysqli->query($q);
    $data = $result->fetch_assoc();
} else {
    echo "<script>alert('id tidak ditemukan');</script>";
    echo "<script>window.location.href = '?page=" . $_GET['page'] . "';</script>";
}

if (isset($_POST['submit'])) {
    $id_pegawai = $mysqli->real_escape_string($_POST['id_pegawai']);
    $status = $mysqli->real_escape_string($_POST['status']);
    $jenis = $mysqli->real_escape_string($_POST['jenis'] ?? '');
    $tanggal = $mysqli->real_escape_string($_POST['tanggal'] ?? '');
    $waktu = $mysqli->real_escape_string($_POST['waktu'] ?? '00:00:00');

    $q = "
        UPDATE presensi_pegawai SET  
            id_pegawai='$id_pegawai',
            tanggal_waktu='" . ("$tanggal $waktu") . "',
            status='$status',
            jenis='$jenis' 
        WHERE 
            id=" . $_GET['id'] . "
    ";

    if ($mysqli->query($q)) {
        echo "<script>alert('Berhasil memperbaharui data presensi');</script>";
        echo "<script>window.location.href = '?page=" . $_GET['page'] . "';</script>";
    } else echo "Error: " . $q . "<br>" . $mysqli->error;
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row justify-content-center mb-2">
            <div class="col-sm-6">
                <h1 class="text-center">Form Presensi</h1>
            </div>
        </div>
    </div>
</section>
<form action="" method="POST">
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="id_pegawai">Nama</label>
                                <?php
                                $q = "
                                    SELECT 
                                        p.id,
                                        p.no_karyawan,
                                        p.nama,
                                        c.nama_cabang 
                                    FROM 
                                        pegawai p
                                    INNER JOIN 
                                        cabang c
                                    ON 
                                        c.id=p.id_cabang
                                ";
                                if (!$result = $mysqli->query($q))
                                    echo "Error: " . $q . "<br>" . $mysqli->error;
                                ?>
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
                            
                            <div class="form-group">
                                    <label>No Karyawan</label>
                                    <input type="text" readonly class="form-control" name="no_karyawan"
                                        value="<?= $_POST['no_karyawan'] ?? ''; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Penempatan</label>
                                    <input type="text" readonly class="form-control" name="penempatan"
                                        value="<?= $_POST['penempatan'] ?? ''; ?>">
                                </div>
                            <div class="form-group">
                                <label for="status">Status Kehadiran</label>
                                <select class="form-control select2bs4" name="status" id="status" required>
                                    <option value="" disabled selected>Pilih Status Kehadiran</option>
                                    <option <?= $data['status'] == 'Hadir' ? 'selected' : ''; ?> value="Hadir">Hadir</option>
                                    <option <?= $data['status'] == 'Sakit' ? 'selected' : ''; ?> value="Sakit">Sakit</option>
                                    <option <?= $data['status'] == 'Izin' ? 'selected' : ''; ?> value="Izin">Izin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jenis">Jenis Presensi</label>
                                <select class="form-control select2bs4" name="jenis" id="jenis" required disabled>
                                    <option value="" disabled selected>Pilih Jenis Presensi</option>
                                    <option <?= $data['jenis'] == 'Masuk' ? 'selected' : ''; ?> value="Masuk">Masuk</option>
                                    <option <?= $data['jenis'] == 'Pulang' ? 'selected' : ''; ?> value="Pulang">Pulang</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $data['tanggal']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="waktu">Waktu</label>
                                <input type="time" class="form-control" name="waktu" id="waktu" value="<?= $data['waktu']; ?>" required disabled>
                            </div>
                            <div>
                                <a href="?page=<?= $_GET['page']; ?>" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary float-right" name="submit">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<script>
    document.querySelector("select[name=id_pegawai]").addEventListener('change', function() {
        document.querySelector("input[name=no_karyawan]").value = this[this.selectedIndex].getAttribute('data-no_karyawan');
        document.querySelector("input[name=cabang]").value = this[this.selectedIndex].getAttribute('data-cabang');
    });
    document.querySelector("select[name=status]").addEventListener('change', function() {
        if (this[this.selectedIndex].value == 'Hadir') {
            document.querySelector("select[name=jenis]").removeAttribute('disabled');
            document.querySelector('input[name=waktu]').removeAttribute('disabled');
            return;
        }

        document.querySelector("select[name=jenis]").setAttribute('disabled', '');
        document.querySelector('input[name=waktu]').setAttribute('disabled', '');
        return;
    });
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