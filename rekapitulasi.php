<?php include "header.php";?>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4 mt-3">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rekapitulasi Pengunjung</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="" class="text-center">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dari Tanggal</label>
                                <input class="form-control" type="date" name="tanggal1" value="<?= isset($_POST['tanggal1'])? $_POST['tanggal1'] : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Sampai Tanggal</label>
                                <input class="form-control" type="date" name="tanggal2" value="<?= isset($_POST['tanggal2'])? $_POST['tanggal2'] : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <button class="btn btn-primary form-control" name="btampilkan"><i class="fa fa-search"></i> Tampilkan</button>    
                        </div>
                        <div class="col-md-2">
                            <a href="admin.php" class="btn btn-danger form-control"><i class="fa fa-backward"></i>Kembali</a>
                        </div>
                    </div>
                </form>
                <?php
                if (isset($_POST['btampilkan'])):
                    $tgl1 = $_POST['tanggal1'];
                    $tgl2 = $_POST['tanggal2'];

                    // Corrected SQL query and added proper query execution checks
                    $tampil = mysqli_query($koneksi, "SELECT * FROM tamu WHERE tanggal BETWEEN '$tgl1' AND '$tgl2' ORDER BY id DESC");
                    if ($tampil) {
                        ?>
                            <button class="btn btn-seccess form-control mt-3 mb-3" onclick="printDiv('print')"><i class="fa fa-print"></i> PRINT </button>
                            <div class="print" id="print">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Nama Pengunjung</th>
                                        <th>Alamat</th>
                                        <th>Tujuan</th>
                                        <th>No.HP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($tampil)) {
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['tanggal'] ?></td>
                                            <td><?= $data['nama'] ?></td>
                                            <td><?= $data['alamat'] ?></td>
                                            <td><?= $data['tujuan'] ?></td>
                                            <td><?= $data['nope'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    <?php } else {
                        echo "Query execution failed: " . mysqli_error($koneksi);
                    }
                endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php";?>
<script>
    function printDiv(el){
        var a = document.body.innerHTML;
        var b = document.getElementById(el).innerHTML;
        document.body.innerHTML = b;
        window.print();
        document.body.innerHTML = a;             
    }
</script>