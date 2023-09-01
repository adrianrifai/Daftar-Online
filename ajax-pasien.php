<?php
include 'koneksi.php';
$norm = $_GET['norm'];
// $norm = "000022";
// $query = ibase_query($dbh, "SELECT * FROM MH_PASIEN WHERE NORM LIKE '%$norm%'");
$query = mysqli_query($conn,"SELECT * FROM pasien where no_rkm_medis LIKE '%$norm%'");
// $pasien = ibase_fetch_object($query);
$pasien = mysqli_fetch_assoc($query);

$data = array(
  'nama'      =>  $pasien['nm_pasien'],
  'tgl_lahir' =>  $pasien['tgl_lahir'],
  'alamat'    =>  $pasien['alamat']
);

echo json_encode($data);
  ?>
