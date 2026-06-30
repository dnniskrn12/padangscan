<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h1>Data Admin</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <a href="?page=admin&method=tambah" class="btn btn-primary float-right">Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center td-fit">No</th>
                        <th class="text-center" style="width: 30%;">Nama</th>
                        <th class="text-center" style="width: 30%;">Email</th>
                        <th class="text-center" style="width: 20%;">Nomor Handphone</th>
                        <th class="text-center td-fit">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = "SELECT * FROM admin";
                    $no = 1;
                    if ($result = $mysqli->query($q)) {
                    } else
                        echo "Error: " . $q . "<br>" . $mysqli->error;
                    ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center td-fit" style="vertical-align: middle;"><?= $no++; ?></td>
                            <td style="vertical-align: middle;"><?= $row['nama'] ?></td>
                            <td style="vertical-align: middle;"><?= $row['email'] ?></td>
                            <td style="vertical-align: middle;"><?= $row['nomor_handphone'] ?></td>
                            <td class="text-center td-fit">
                                <a href="?page=admin&method=edit&id=<?= $row['id'] ?>"
                                    class="btn btn-sm btn-warning text-white">Edit</a>
                                <form action="?page=admin&method=hapus&id=<?= $row['id'] ?>" method="POST" class="d-inline">
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>