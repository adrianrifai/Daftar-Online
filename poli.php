<!DOCTYPE html>
<html lang="en">
<head>
	<title>Daftar Online RSU Natalia Boyolali</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
</head>
<body>
	<?php
	include 'koneksi.php';
	if(isset($_GET["tampilkan"])){
		 $tanggal = date('Y-m-d', strtotime( $_GET["tanggal"]));
		 $date = date('Y-m-d H:i:s', strtotime( $_GET["tanggal"]));
		 $hari = $_GET["hari"];
		 $waktu = $_GET["waktu"];
		 $norm = $_GET["norm"];

		 $tgl_lahir = date("Y-m-d", strtotime($_GET["tgl_lahir"]));


		$sql_norm = mysqli_query($conn, "SELECT no_rkm_medis, no_peserta FROM pasien WHERE no_rkm_medis LIKE '%$norm'");
		if ($norm = mysqli_fetch_assoc($sql_norm)) {
			$kartu = $norm['no_peserta'];
			$norm = $norm['no_rkm_medis'];

		}else {
			echo "<script>alert('DATA TIDAK TERDAFTAR');window.location = 'index.php';</script>";
			// echo "data tidak terdaftar";
		}



		// $sql = ibase_query($dbh,"SELECT MH_TEMPATLAYANAN.TEMPAT_LAYANAN, MH_TEMPATLAYANAN.ID FROM MH_TEMPATLAYANAN
		// 	JOIN TH_JADWAL ON TH_JADWAL.ID_TMPLAYANAN = MH_TEMPATLAYANAN.ID
		// 	WHERE MH_TEMPATLAYANAN.TEMPAT_LAYANAN LIKE '%POLI%' AND TH_JADWAL.HARI = '$hari' AND TH_JADWAL.WAKTU = '$waktu' AND TH_JADWAL.AKTIF = 'TRUE'
		// 	GROUP BY MH_TEMPATLAYANAN.TEMPAT_LAYANAN, MH_TEMPATLAYANAN.ID ");

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
		$jadwal_poli = mysqli_query($conn,"SELECT a.*, b.* from jadwal a join poliklinik b ON a.kd_poli = b.kd_poli where a.hari_kerja = '$hari'
		group by b.kd_poli");
		}
		?>
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
					<form class="login100-form validate-form flex-sb flex-w" action="validasi.php" method="get">
						<span class="login100-form-title p-b-32">
							Pilih Poli Tujuan
						</span>
						<input type="hidden" name="hari" id="hari" value="<?php echo $hari;?>">
						<input type="hidden" name="tanggal" id="tanggal" value="<?php echo $date;?>">
						<input type="hidden" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $tanggal;?>">
						<input type="hidden" name="waktu" id="waktu" value="<?php echo $waktu;?>">
						<input type="hidden" name="norm" value="<?php echo $norm?>">
						<input type="hidden" name="kartu" value="<?php echo $kartu; ?>" id="kartu">
						<span class="txt1 p-b-11">
							Pilih Poliklinik
						</span>
						<div class="wrap-input100 validate-input m-b-12">
							<select class="form-control custom-select" name="poli" id="poli">
								<option value="">Pilih Poli Tujuan</option>
								<?php while ($row = mysqli_fetch_assoc($jadwal_poli)) {?>
									<option value="<?php echo $row['kd_poli'];?>"><?php echo $row['nm_poli']; ?></option>
									<?php
								}
								?>
							</select>
						</div>

						<span class="txt1 p-b-11">
							Pilih Dokter
						</span>
						<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
							<select class="form-control custom-select" name="dokter" id="dokter">
							</select>
						</div>

						<span class="txt1 p-b-11">
							Pilih Penjamin
						</span>
						<div class="wrap-input100 validate-input m-b-12">
							<select class="form-control custom-select" id="penjamin" name="penjamin">
								<option value="">Pilih Penjamin</option>

									<option value="A09">UMUM</option>
									<option value="BPJ">BPJS</option>

							</select>
						</div>

						<div id="no_rujukan" style="display:none; width:100%;">
							<span class="txt1 p-b-11">
								Masukkan No Rujukan
							</span>
							<div class="wrap-input100 validate-input m-b-12">
								<input type="text" name="no_rujukan" value="" id="no_rujukan_1" class="form-control">
							</div>
						</div>

						<div class="container-login100-form-btn">
							<button class="login100-form-btn" name="tampilkan">
								Daftar
							</button>
						</div>

					</form>
				</div>
			</div>
		</div>


		<!--===============================================================================================-->
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="sweetalert/sweetalert2.all.min.js"></script>
		<script type="text/javascript">
		$(function(){
			$("#poli").change(function(){
				if($(this).val() != 0){
					$.get("proses-ajax.php?poli="+$(this).val()+"&hari="+$("#hari").val()+"&waktu="+$("#waktu").val()+"&tanggal="+$("#tgl_kunjungan").val(),function(dokter){
						var p_html = "";
						for(var i=0;i<dokter.length;i++){
							p_html += "<option value='"+dokter[i].kd_dokter+"'>"+dokter[i].nama+"</option>";
						}
						$("#dokter").html(p_html);
					},"json");
				}
			});
		});

		$(function(){
			$("#penjamin").change(function(){
				if($(this).val() == 'BPJ'){
					var aktif ="";
					document.getElementById('no_rujukan').style.display = 'block';
					$.get("cek_aktif.php?no_kartu="+$("#kartu").val(),function(aktif){
					},"json");
					if (aktif == 0) {
						// window.location.replace("https://portalqrcode.bpjs-kesehatan.go.id/portalqrcode/landing/WmMxVHdyMTROckl4TXF6SlZsMVhxQT09");
						$.get("ajax-rujukan.php?no_kartu="+$("#kartu").val(),function(rujukan){
							var p_html = "<option value=''>Pilih No Rujukan</option>";
							var list_rujuk = "";
							for(var i=0;i<rujukan.length;i++){
								p_html += "<option value='"+rujukan[i].id+"'>"+rujukan[i].nama+"("+rujukan[i].id+")"+"</option>";
								// arr_rujukan[i] = {nama: rujukan[i].nama, id:rujukan[i].id};
								list_rujuk += '<input type="button" class="form-control" name="" value="'+rujukan[i].id+'" onclick="isi_rujukan(this);swal.close(); ">'+ rujukan[i].nama;
							}
							if (list_rujuk.includes("RUJUKAN TIDAK ADA")) {
								Swal.fire({
									title: 'Error!',
									text: 'RUJUKAN TIDAK DITEMUKAN',
									icon: 'error',
									confirmButtonText: 'Ok'
								});
								document.getElementById('no_rujukan').style.display = 'none';
								$("#no_rujukan_1").val('');
								$("#penjamin").val('');
							}else {
								Swal.fire({
									title: 'Pilih No Rujukan',
									html:
									list_rujuk
								});
							}
							// console.log("Hello world!");
							// $("#no_rujukan_1").html(p_html);
							// $("#no_rujukan_1").val(rujukan.id);
						},"json");
						// console.log(rujukan);

					}else {
						Swal.fire({
							title: 'Error!',
							text: 'No Kartu Tidak Terdaftar / Atau Tidak Aktif /n SILAHKAN MENGHUBUNGI PENDAFTARAN',
							icon: 'error',
							confirmButtonText: 'Ok'
						});
					}
				} else {
					document.getElementById('no_rujukan').style.display = 'none';
					$("#no_rujukan_1").val('');
				}
			});
		});

		function isi_rujukan(a) {
			var rujukan = $(a).val();
			$("#no_rujukan_1").val(rujukan);
		}
	</script>
	<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
