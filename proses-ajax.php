<?php
include 'koneksi.php';

$poli       = $_GET['poli'];
$hari				= $_GET['hari'];
$waktu			= $_GET['waktu'];
// $tanggal		= $_GET['tanggal'];

$tanggal=$_GET['tanggal'];
$tentukan_hari=date('D',strtotime($tanggal));
 $day = array(
	'Sun' => 'AKHAD',
	'Mon' => 'SENIN',
	'Tue' => 'SELASA',
	'Wed' => 'RABU',
	'Thu' => 'KAMIS',
	'Fri' => 'JUMAT',
	'Sat' => 'SABTU'
	);
	$hari=$day[$tentukan_hari];
// $query      = mysql_query("SELECT * FROM `province` WHERE country_id=".$country_id);
// $sql        = ibase_query($dbh, "SELECT MH_PROVIDER.NAMA, MH_PROVIDER.ID FROM MH_PROVIDER
// 	JOIN TH_JADWAL ON MH_PROVIDER.ID = TH_JADWAL.ID_PROVIDER
// 	WHERE TH_JADWAL.ID_TMPLAYANAN = '$poli' AND TH_JADWAL.HARI = '$hari' AND TH_JADWAL.WAKTU = '$waktu' AND MH_PROVIDER.ID NOT IN (SELECT ID_PROVIDER FROM TH_CUTI WHERE CAST(TGL_CUTI AS DATE) = '$tanggal') AND
// 	CAST('$tanggal' AS DATE) NOT IN (SELECT CAST(TGL_LIBUR AS DATE) FROM RH_LIBUR) AND TH_JADWAL.AKTIF = 'TRUE'
// 	GROUP BY MH_PROVIDER.NAMA, MH_PROVIDER.ID ");

$sql = mysqli_query($conn,"SELECT a.*, b.*, c.kd_dokter AS kd_d, c.nm_dokter from jadwal a 
							join poliklinik b ON a.kd_poli = b.kd_poli
							join dokter c ON a.kd_dokter = c.kd_dokter
							 where a.hari_kerja = '$hari' AND a.kd_poli = '$poli'");	
	$dokter  = array();
	while($data = mysqli_fetch_assoc($sql)){
		
		$dokter[] = array('kd_dokter'=>$data['kd_d'],'nama'=>$data['nm_dokter']);
	}
	echo json_encode($dokter);
	?>
