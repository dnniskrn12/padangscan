<?php
if (isset($_POST['submit'])) {
    $nama_cabang = $mysqli->real_escape_string($_POST['nama_cabang']);
    $alamat = $mysqli->real_escape_string($_POST['alamat']);
    $status = $mysqli->real_escape_string($_POST['status']);

    $q = "
        INSERT INTO cabang (
            nama_cabang,
            alamat,
            status  
        ) VALUES (
            '$nama_cabang',
            '$alamat',
            '$status' 
        )
    ";

    if ($mysqli->query($q)) {
        echo "<script>alert('Berhasil menambah data cabang');</script>";
        echo "<script>window.location.href = '?page=" . $_GET['page'] . "';</script>";
    } else echo "Error: " . $q . "<br>" . $mysqli->error;
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row justify-content-center mb-2">
            <div class="col-sm-6">
                <h1 class="text-center">Form Cabang</h1>
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
                                <label for="nama_cabang">Nama Cabang</label>
                                <input type="text" class="form-control" name="nama_cabang" id="nama_cabang" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" name="alamat" id="alamat" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" class="form-control" name="status" id="status" required autocomplete="off">
                            </div>
                            <div>
                                <a href="?page=<?= $_GET['page']; ?>" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary float-right" name="submit">Tambah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>