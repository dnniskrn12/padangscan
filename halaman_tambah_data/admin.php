<?php
if (isset($_POST['submit'])) {
    $nama = $mysqli->real_escape_string($_POST['nama']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $nomor_handphone = $mysqli->real_escape_string($_POST['nomor_handphone']);

    $q = "
        INSERT INTO admin (
            nama,
            email,
            nomor_handphone  
        ) VALUES (
            '$nama',
            '$email',
            '$nomor_handphone' 
        )
    ";

    if ($mysqli->query($q)) {
        echo "<script>alert('Berhasil menambah data admin');</script>";
        echo "<script>window.location.href = '?page=" . $_GET['page'] . "';</script>";
    } else
        echo "Error: " . $q . "<br>" . $mysqli->error;
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row justify-content-center mb-2">
            <div class="col-sm-6">
                <h1 class="text-center">Form Admin</h1>
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
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" name="nama" id="nama" required autofocus
                                    autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" autocomplete="off"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="nomor_handphone">Nomor Handphone</label>
                                <input type="text" class="form-control" name="nomor_handphone" id="nomor_handphone"
                                    required autocomplete="off">
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