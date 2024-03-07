<?php include "header.php"; ?>
<?php include "koneksi.php"; ?>

<?php
if (isset($_POST['bsimpan'])) {
    $tgl = date('Y-m-d');
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $tujuan = mysqli_real_escape_string($koneksi, $_POST['tujuan']);
    $nope = mysqli_real_escape_string($koneksi, $_POST['nope']);

    $simpan = mysqli_query($koneksi, "INSERT INTO tamu VALUES ('','$tgl','$nama','$alamat','$tujuan','$nope')");

    if ($simpan) {
        echo "<script>alert('Simpan data sukses, Terima kasih...!');
        document.location='?'</script>";
    } else {
        echo "<script>alert('Simpan data gagal!!!');
        document.location='?'</script>";
    }
}
?>

<div class="head text-center">
    <img src="asset/img/logo1.png" width="400">
    <h2 class="text-white">Sistem Informasi Buku Tamu  <br> Desa  sukamanah</h2>
</div>

<div class="row mt-2">
    <div class="col-lg-7 mb-3">
        <div class="card shadow bg-gradient-light">
            <div class="card-body">
            <div class="text-center">
                 <h1 class="h4 text-gray-950 mb-3">Identitas Pengunjung</h1>
            </div>
            <form class="user" method="POST" action="">
                                <div class="form-group">
                                    <input type="text" class="form-control
                                     form-control-user" name="nama" placeholder="Nama Pengunjung" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control
                                     form-control-user" name="alamat" placeholder="Alamat Pengunjung"required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control
                                     form-control-user" name="tujuan" placeholder="Tujuan Pengunjung"required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control
                                     form-control-user" name="nope" placeholder="Nohp.Pengunjung"required>
                                </div>

                                <button type="submit" name="bsimpan" class="btn btn-primary btn-user 
                                btn-block">Simpan Data</button>
                                
                            </form>
            </div>
        </div>
    </div>

    <div class="col-lg-5 mb-3">
        <div class="card shadow mt-3">
            <div class="card-body">
            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Statistik Pengunjung</h1>
                            </div>
                            <?php 
                            // deklarasi tanggal
                            $tgl_sekarang = date('Y-m-d');
                            //menampilkan tanggal kemarin
                            $kemarin = date('Y-m-d',strtotime('-1 day', strtotime(date('Y-m-d'))));


                           //mendapatkan 6 hari sebelum tgl sekarang
                           $seminggu = date('Y-m-d h:i:s',strtotime('-1 week +1 day', strtotime($tgl_sekarang)));

                           $sekarang = date('Y-m-d h:i:s');
                           // persiapan query tampilkan jumlah data pengunjung
                           $tgl_sekarang = mysqli_fetch_array(mysqli_query($koneksi,"SELECT count(*) FROM tamu
                            where tanggal like '%$tgl_sekarang%'"));


                            $kemarin = mysqli_fetch_array(mysqli_query($koneksi,"SELECT count(*) FROM tamu
                            where tanggal like '%$kemarin%'"));

                            $seminggu= mysqli_fetch_array(mysqli_query($koneksi,"SELECT count(*) FROM tamu
                            where tanggal  BETWEEN'$seminggu' and'$sekarang'"));
                            
                          
                          $bulan_ini = date('m');
                          $sebulan= mysqli_fetch_array(mysqli_query($koneksi,"SELECT count(*) FROM tamu
                          where month(tanggal) = '$bulan_ini'"));

                          $keseluruhan= mysqli_fetch_array(mysqli_query($koneksi,"SELECT count(*) FROM tamu"));

                            ?>
                            <table class="table table-bordered">
                                <tr>
                                    <td>Hari ini</td>
                                    <td>: <?=$tgl_sekarang[0]?></td>
                                </tr>
                                <tr>
                                    <td>Kemarin</td>
                                    <td>: <?=$kemarin[0]?></td>
                                </tr>
                                <td>Minggu ini</td>
                                    <td>:  <?=$seminggu[0]?></td>
                                <tr>
                                    <td>Bulan ini</td>
                                    <td>: <?=$sebulan[0]?></td>
                                </tr>
                                <tr>
                                    <td>Keseluruhan</td>
                                    <td>: <?=$keseluruhan[0]?></td>
                                </tr>
                            </table>
            </div>
            <!-- card body -->
            </div>
        </div>
    </div>
</div>

<div class=" mt-5 bg-gradient-success">
    <div class="text-center">
    </div>

    <div class="card-body">
        <div class="card shadow mb-4">
            <div class="card-header py-5">
                <h6 class="m-0 font-weight-bold text-primary">Data Pengunjung Hari ini [<?= date('d-m-Y') ?>]</h6>
            </div>
            <div class="card-body">
                <a href="rekapitulasi.php" class="btn btn-success mb-3"><i class="fa fa-table"></i> rekapitulasi Pengunjung</a>
                <a href="logout.php" class="btn btn-danger mb-3"><i class="fa fa-sign-out-alt"></i> logout</a>

                <div class="table-responsive mt-3">
                    <div class="container">
                    <table class="table table-bordered" id="dataTable" width="150%" cellspacing="0">
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
                        <tfoot>
                            <!-- ... Footer ... -->
                        </tfoot>
                        <tbody>
                            <?php
                            $tgl = date('Y-m-d');
                            $tampil = mysqli_query($koneksi, "SELECT * FROM tamu order by id desc");
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
        </div>
    </div>
</div>
</div>

<?php include "footer.php"; ?>
