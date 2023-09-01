<?php

include 'koneksi.php';

date_default_timezone_set('Asia/Jakarta');
$today = date("Y-m-d");
if (isset($_GET["tampilkan"])) {
	$date = date('Y-m-d', strtotime($_GET["tanggal"]));
	$jam = date('H:i:s');
	$dokter = $_GET["dokter"];
	// $hari = $_GET["hari"];
	$penjamin = $_GET["penjamin"];
	$norm = $_GET["norm"];
	$poli = $_GET["poli"];
	$waktu = $_GET["waktu"];
	$tgl_antrian = date("Y-m-d H:i:s", strtotime("$date $jam"));
	$no_rujukan = $_GET["no_rujukan"];

	$tanggal = $_GET['tanggal'];
	$tentukan_hari = date('D', strtotime($tanggal));
	$day = array(
		'Sun' => 'AKHAD',
		'Mon' => 'SENIN',
		'Tue' => 'SELASA',
		'Wed' => 'RABU',
		'Thu' => 'KAMIS',
		'Fri' => 'JUMAT',
		'Sat' => 'SABTU'
	);
	$hari = $day[$tentukan_hari];


	$data = mysqli_query($conn, "SELECT MAX(no_reg) AS no_antrian FROM booking_registrasi
	where tanggal_periksa = '$date' AND kd_poli = '$poli'
	GROUP BY tanggal_periksa");

	$quota = mysqli_query($conn, "SELECT kuota FROM jadwal WHERE kd_dokter = '$dokter' AND hari_kerja = '$hari'");
	$quota_new = mysqli_fetch_assoc($quota);

	$quota_new['kuota'];


	$cek_data = mysqli_query($conn, "SELECT a.no_rkm_medis FROM booking_registrasi a
		JOIN reg_periksa b ON a.no_rkm_medis = b.no_rkm_medis
		WHERE CAST(a.tanggal_periksa AS DATE) = '$date' AND b.no_rkm_medis = '$norm'");

	// $id1 = mysqli_query($conn, "SELECT MAX(no_reg) AS max_no_reg FROM reg_periksa where kd_dokter = '$dokter' AND tgl_registrasi='$date'");
	// $id1 = mysqli_fetch_assoc($id1);
	//
	// $id_reservasi = $id1['max_no_reg'];
	// $id_reservasi_baru = (int) $id_reservasi;
	//
	// $id_reservasi_baru++;

	//mencari no rawat terakhir
	$tgl_reg = date('Y/m/d', strtotime($date));
	$no_rawat_akhir = mysqli_fetch_array(mysqli_query($conn, "SELECT max(no_rawat) FROM reg_periksa WHERE tgl_registrasi='$tanggal'"));
	$no_urut_rawat = substr($no_rawat_akhir[0], 11, 6);
	$no_rawat = $tgl_reg . '/' . sprintf('%06s', ($no_urut_rawat + 1));

	//mencari no reg terakhir
	// $no_reg_akhir = mysqli_fetch_array(mysqli_query($conn, "SELECT max(a.no_reg) AS ca FROM reg_periksa a
	// JOIN booking_registrasi b ON a.tgl_registrasi = b.tanggal_periksa  WHERE b.kd_dokter='$dokter'
	// and b.kd_poli ='$poli' AND b.tanggal_periksa='$date' AND b.tanggal_booking='$date'"));
	// $no_urut_reg = substr($no_reg_akhir[0], 0, 3);
	// echo $no_reg = sprintf('%03s', ($no_urut_reg + 1));

	// $no_reg_akhir = mysqli_fetch_array(mysqli_query($conn, "SELECT max(no_reg) FROM reg_periksa WHERE kd_dokter='$dokter'
	// and kd_poli ='$poli' AND tgl_registrasi='$date'"));
	$no_reg_akhir1 = mysqli_fetch_array(mysqli_query($conn, "SELECT max(no_reg) FROM booking_registrasi WHERE kd_dokter='$dokter'
	and kd_poli ='$poli' AND tanggal_periksa='$date'"));

	$no_urut_reg = substr($no_reg_akhir[0], 0, 3);
	$no_urut_reg1 = substr($no_reg_akhir1[0], 0, 3);
	// if ($no_reg_akhir == NULL OR $no_reg_akhir1 == NULL){
	// 	echo $no_urut = 001;
	// }else{
	$no_reg = sprintf('%03s', ($no_urut_reg1 + 1));
	// $no_reg1 =(int) $no_reg_akhir1;
	// $no_reg1 = sprintf('%03s', ($no_reg1));
	//  $no_reg1 ++;
	// 	echo $no_urut = $no_reg + $no_reg1;
	// }
	// echo "<br>";
	// echo $no_urut;

	$get_pasien = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM pasien WHERE no_rkm_medis = '$norm'"));

	//menentukan umur sekarang
	list($cY, $cm, $cd) = explode('-', date('Y-m-d'));
	list($Y, $m, $d) = explode('-', date('Y-m-d', strtotime($get_pasien['tgl_lahir'])));
	$umurdaftar = $cY - $Y;


	if ($row = mysqli_fetch_assoc($data)) {
		$antrian = $row['no_antrian'];
	} else {
		$antrian = 0;
	}

	$urutan = (int) $antrian;
	$urutan = sprintf("%03s", $urutan);

	$urutan++;

	// $no_antrian = sprintf("%03s", $urutan);

	$data2 = mysqli_query($conn, "SELECT jam_mulai, jam_selesai FROM jadwal WHERE kd_poli = '$poli' AND hari_kerja = '$hari'");
	$dilayani = mysqli_fetch_assoc($data2);
	$est_dilayani = date("Y-m-d H:i:s", strtotime("$date $dilayani[jam_mulai]"));

	$k = date("dm", strtotime("$tanggal"));
	$j = date("his", strtotime("$jam"));
	$kodebooking = (int) $k . $j;
	// $kodebooking++;


	if ($urutan < $quota_new['kuota']) {
		if ($penjamin == "BPJ") {
			if (mysqli_fetch_assoc($cek_data)) {
				$daftar = "ANDA SUDAH MEMPUNYAI RESERVASI DI HARI YANG SAMA";
			} else {
				$reservasi = mysqli_query($conn, "INSERT INTO booking_registrasi (`tanggal_booking`, `jam_booking`, `no_rkm_medis`, `tanggal_periksa`, `kd_dokter`, `kd_poli`, `no_reg`, `kd_pj`, `limit_reg`, `status`,`no_rujukan`,`kode`)	VALUES ('$today','$jam', '$norm','$date','$dokter','$poli','$no_reg','$penjamin','0','Belum','$no_rujukan','$kodebooking')");
				$reservasi1 = mysqli_fetch_assoc($reservasi);

				$noka = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pasien WHERE no_rkm_medis = '$norm'"));
				$nik = $noka['no_ktp'];
				$kartu = $noka['no_peserta'];
				$nohp = $noka['no_tlp'];
				$nama = $noka['nm_pasien'];
				$alamat = $noka['alamat'];

				$cek_poli = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nm_poli_bpjs, kd_poli_bpjs FROM maping_poli_bpjs WHERE kd_poli_rs = '$poli'"));

				$cek_dokter = mysqli_fetch_assoc(mysqli_query($conn, "SELECT kd_dokter_bpjs,nm_dokter_bpjs FROM maping_dokter_dpjpvclaim WHERE kd_dokter ='$dokter'"));

				$antrian = mysqli_query($conn, "INSERT INTO booking_periksa
					SET no_booking		= '$kodebooking',
						tanggal			= '$date',
						nama		 	= '$nama',
						alamat			= '$alamat',
						no_telp		    = '$nohp',
						email			= '-',
						kd_poli			= '$poli',
						tambahan_pesan	= '-',
						status			= 'Pending',
						tanggal_booking	= '$today $time',
						no_rkm_medis	= '$norm',
						kd_pj			= '$penjamin',
						kode		  	= '$kodebooking'
						");

				// $no_antrian1 = mysqli_fetch_assoc($antrian);
				$no_antrian1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM booking_periksa WHERE no_booking = '$no_rawat' "));

				$cek_kuota = mysqli_fetch_assoc(mysqli_query($conn, "SELECT kuota FROM jadwal WHERE kd_poli = '$poli' AND kd_dokter ='$dokter' AND hari_kerja = '$hari' "));
				$cek_antrian_sekarang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(no_reg) AS kuota FROM reg_periksa WHERE kd_poli = '$poli' AND kd_dokter ='$dokter'
					AND CAST(tgl_registrasi AS DATE) = '$date'"));
				$sisa_kuota = ($cek_kuota['kuota'] - $cek_antrian_sekarang['kuota']);
				$jam_reg_bpjs = date("H:i:s", strtotime($no_antrian1['tanggal_booking']));
				$tm_est_dilayani = strtotime(str_replace("/", "-", $jam_reg_bpjs)) * 1000;

				// include 'add_antrian.php';
			}
		} else {
			// code...
			if (mysqli_fetch_assoc($cek_data)) {
				$daftar = "ANDA SUDAH MEMPUNYAI RESERVASI DI HARI YANG SAMA";
			} else {
				$reservasi = mysqli_query($conn, "INSERT INTO booking_registrasi (`tanggal_booking`, `jam_booking`, `no_rkm_medis`, `tanggal_periksa`, `kd_dokter`, `kd_poli`, `no_reg`, `kd_pj`, `limit_reg`, `status`,`no_rujukan`,`kode`)	VALUES ('$today','$jam', '$norm','$date','$dokter','$poli','$no_reg','$penjamin','0','Belum','$no_rujukan','$kodebooking')");
				$reservasi1 = mysqli_fetch_assoc($reservasi);

				$noka = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pasien WHERE no_rkm_medis = '$norm'"));
				$nik = $noka['no_ktp'];
				$kartu = $noka['no_peserta'];
				$nohp = $noka['no_tlp'];
				$nama = $noka['nm_pasien'];
				$alamat = $noka['alamat'];

				$cek_poli = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nm_poli_bpjs, kd_poli_bpjs FROM maping_poli_bpjs WHERE kd_poli_rs = '$poli'"));

				$cek_dokter = mysqli_fetch_assoc(mysqli_query($conn, "SELECT kd_dokter_bpjs,nm_dokter_bpjs FROM maping_dokter_dpjpvclaim WHERE kd_dokter ='$dokter'"));

				$antrian = mysqli_query($conn, "INSERT INTO booking_periksa
					SET no_booking		= '$kodebooking',
						tanggal			= '$date',
						nama		 	= '$nama',
						alamat			= '$alamat',
						no_telp		    = '$nohp',
						email			= '-',
						kd_poli			= '$poli',
						tambahan_pesan	= '-',
						status			= 'Pending',
						tanggal_booking	= '$today $time',
						no_rkm_medis	= '$norm',
						kd_pj			= '$penjamin',
						kode		  	= '$kodebooking'
						");

				// $no_antrian1 = mysqli_fetch_assoc($antrian);
				$no_antrian1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM booking_periksa WHERE no_booking = '$no_rawat' "));

				$cek_kuota = mysqli_fetch_assoc(mysqli_query($conn, "SELECT kuota FROM jadwal WHERE kd_poli = '$poli' AND kd_dokter ='$dokter' AND hari_kerja = '$hari' "));
				$cek_antrian_sekarang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(no_reg) AS kuota FROM reg_periksa WHERE kd_poli = '$poli' AND kd_dokter ='$dokter'
					AND CAST(tanggal_registrasi AS DATE) = '$date'"));
				$sisa_kuota = ($cek_kuota['kuota'] - $cek_antrian_sekarang['kuota']);
				$jam_reg_bpjs = date("H:i:s", strtotime($antrian1['tanggal_booking']));
				$tm_est_dilayani = strtotime(str_replace("/", "-", $jam_reg_bpjs)) * 1000;

				// include 'add_antrian.php';
			}
		}
		//Kondisi apakah berhasil atau tidak
		if ($antrian && $reservasi) {
			// header('Location: index2.php');
			echo "<script>alert('Anda sudah berhasil daftar online');window.location = 'landing.php?id_reservasi=" . $kodebooking . "';</script>";
			// echo "<script>";
			// echo "yoiii";
			// echo "alert('Anda Sudah Berhasil Daftar Online');";
			// echo "window.location='landing.php?id_reservasi='".$id_reservasi_baru.";";
			// echo "</script>";
			// exit;
			exit;
		} elseif ($daftar) {
			echo "<script>alert('ANDA SUDAH MEMPUNYAI RESERVASI DI HARI YANG SAMA');window.location = 'index.php';</script>";
		} else {
			echo "<script>alert('Data gagal diproses');window.location = 'index.php';</script>";
			exit;
		}
	} else {
		echo "<script>alert('QUOTA SUDAH PENUH');window.location = 'index.php';</script>";
		exit;
	}
}
