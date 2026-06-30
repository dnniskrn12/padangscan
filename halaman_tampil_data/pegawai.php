<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12">
                <h1>Data Karyawan</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="card">
        <div class="card-header">
            <a href="?page=pegawai&method=tambah" class="btn btn-primary float-right">Tambah</a>
        </div>
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center td-fit" >No</th>
                        <th class="text-center" style="width: 20%;">No Karyawan</th>
                        <th class="text-center" style="width: 40%;">Nama</th>
                        <th class="text-center" style="width: 20%;">Penempatan</th>
                        <th class="text-center td-fit" style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = "
                    SELECT 
                        p.*,
                        c.nama_cabang 
                    FROM 
                        pegawai p
                    INNER JOIN 
                        cabang c 
                    ON 
                        c.id = p.id_cabang 
                    ORDER BY 
                        c.nama_cabang";  
                    

                    $no = 1;
                    if ($result = $mysqli->query($q)) {
                    } else
                        echo "Error: " . $q . "<br>" . $mysqli->error;
                    ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center td-fit" style="vertical-align: middle;"><?= $no++; ?></td>
                            <td class="text-center td-fit" style="vertical-align: middle;"><?= $row['no_karyawan'] ?></td>
                            <td style="vertical-align: middle;"><?= $row['nama'] ?></td>
                            <td class="text-center" style="vertical-align: middle;"><?= $row['nama_cabang'] ?></td>
                            <td class="text-center td-fit">
                                <a href="?page=pegawai&method=detail&id=<?= $row['id'] ?>"
                                    class="btn btn-sm btn-info">Detail</a>
                                <a href="?page=pegawai&method=edit&id=<?= $row['id'] ?>"
                                    class="btn btn-sm btn-warning text-white">Edit</a>
                                <form action="?page=pegawai&method=hapus&id=<?= $row['id'] ?>" method="POST"
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