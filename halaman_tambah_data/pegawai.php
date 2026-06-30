<?php
if (isset($_POST['submit'])) {
    $no_karyawan = $mysqli->real_escape_string($_POST['no_karyawan']);
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $nomor_telepon = $mysqli->real_escape_string($_POST['nomor_telepon']);
    $tanggal_lahir = $mysqli->real_escape_string($_POST['tanggal_lahir']);
    $tempat_lahir = $mysqli->real_escape_string($_POST['tempat_lahir']);
    // $nama_cabang = $mysqli->real_escape_string($_POST['nama_cabang']); // Mengganti id_jabatan dengan nama_cabang
    $id_cabang = $mysqli->real_escape_string($_POST['id_cabang']);
    $tmt = $mysqli->real_escape_string($_POST['tmt']);
    $password = $mysqli->real_escape_string($_POST['password']);

    // 
    try {
        $mysqli->begin_transaction();

        $target_dir = "uploads/";
        $gambar = $target_dir . Date("YmdHis") . '.' . strtolower(pathinfo(basename($_FILES["gambar"]["name"]), PATHINFO_EXTENSION));
        if (!is_dir($target_dir))
            mkdir($target_dir, 0700, true);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $gambar);

        $q = "
            INSERT INTO user (
                username,
                password,
                status  
            ) VALUES (
                '$no_karyawan',
                '$password',
                'PEGAWAI' 
            )
        ";
        $mysqli->query($q);
        var_dump($id_cabang);
        $q = "
        
            INSERT INTO pegawai (
                id_cabang, 
                id_user,
                no_karyawan,
                nama,
                nomor_telepon,
                tanggal_lahir,
                tempat_lahir,
                tmt,
                gambar 
            ) VALUES (
                '$id_cabang',
                '" . $mysqli->insert_id . "',
                '$no_karyawan',
                '$nama',
                '$nomor_telepon',
                '$tanggal_lahir',
                '$tempat_lahir',
                '$tmt',
                '$gambar'
            )
        ";
        $mysqli->query($q);

        $id_pegawai = $mysqli->insert_id;

        // foreach ($id_tunjangan as $id) {
        //     $q = "
        //         INSERT INTO tunjangan_pegawai (
        //             id_pegawai,
        //             id_tunjangan 
        //         ) VALUES (
        //             $id_pegawai,
        //             $id
        //         )
        //     ";
        //     $mysqli->query($q);
        // }

        $mysqli->commit();
        echo "<script>alert('Berhasil menambah data karyawan');</script>";
        echo "<script>window.location.href = '?page=" . $_GET['page'] . "';</script>";
    } catch (\Throwable $e) {
        $mysqli->rollback();
        throw $e;
    }
    ;
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Form Karyawan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Form Karyawan</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<form action="" method="POST" enctype="multipart/form-data">
    <section class="content">
        <div class="container-fluid">
            <di class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Identitas Karyawan</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="no_karyawan">Nomor Karyawan</label>
                                <input type="text" class="form-control" name="no_karyawan" id="no_karyawan" required
                                    autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" required
                                    autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="nomor_telepon">Nomor Telepon</label>
                                <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" required
                                    autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir" required
                                    autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required
                                    autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="gambar">Gambar</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="gambar" name="gambar"
                                            accept="image/*" onchange="previewImage(this)">
                                        <label class="custom-file-label" for="gambar">Pilih Gambar</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Penempatan</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama_cabang">Nama Cabang</label>
                                <?php
                                if (!$result = $mysqli->query("SELECT * FROM cabang"))
                                    echo "Error: " . $q . "<br>" . $mysqli->error;
                                ?>
                                <select class="form-control select2bs4" name="id_cabang" id="id_cabang" required>
                                    <option value="" disabled selected>Pilih Cabang</option>
                                    <?php while ($row = $result->fetch_assoc()): ?>
                                        <option value="<?= $row['id']; ?>"><?= $row['nama_cabang']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tmt">TMT</label>
                                <input type="date" class="form-control" name="tmt" id="tmt"
                                    value="<?= Date("Y-m-d"); ?>">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Preview Gambar</h3>
                        </div>
                        <div class="card-body d-flex justify-content-center" style="height: 470.5px; padding: 20px;">
                            <img id="preview" class="w-50" style="object-fit: cover;">
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Akun Karyawan</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" disabled>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="?page=<?= $_GET['page']; ?>" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary float-right" name="submit">Tambah</button>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </section>
</form>
<script>
    function previewImage(input) {
        input.nextElementSibling.innerHTML = input.files[0].name;

        const oFReader = new FileReader();
        oFReader.readAsDataURL(input.files[0]);

        oFReader.onload = function (oFREvent) {
            document.querySelector('#preview').src = oFREvent.target.result;
        }
    }

    document.querySelector("input[name=nip]").addEventListener('input', function () {
        document.querySelector("input[name=username]").value = this.value;
    });

    document.querySelector("select[name=nama_cabang]").addEventListener('change', function () {
        // Tidak ada data golongan dan gaji pokok untuk nama cabang
    });
</script>