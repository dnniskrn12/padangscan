<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h1>Data Cabang</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <a href="?page=cabang&method=tambah" class="btn btn-primary float-right">Tambah</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center td-fit">No</th>
                        <th class="text-center">Nama Cabang</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center">Status</th>
                        <th class="text-center td-fit">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = "SELECT * FROM cabang";
                    $no = 1;
                    if ($result = $mysqli->query($q)) {
                    } else
                        echo "Error: " . $q . "<br>" . $mysqli->error;
                    ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center td-fit" style="vertical-align: middle;"><?= $no++; ?></td>
                            <td style="vertical-align: middle;"><?= $row['nama_cabang'] ?></td>
                            <td style="vertical-align: middle;"><?= $row['alamat'] ?></td>
                            <td class="text-center" style="vertical-align: middle;"><?= $row['status'] ?></td>
                            <td class="text-center td-fit">
                                <a href="?page=cabang&method=edit&id=<?= $row['id'] ?>"
                                    class="btn btn-sm btn-warning text-white">Edit</a>
                                <form action="?page=cabang&method=hapus&id=<?= $row['id'] ?>" method="POST"
                                    class="d-inline">
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