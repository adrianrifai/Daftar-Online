<?php date_default_timezone_set("Asia/Jakarta"); ?>

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
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<!--===============================================================================================-->
</head>

<body>
	<ins class="adsbygoogle"
			 style="display:block"
			 data-ad-client="ca-pub-7793504852516578"
			 data-ad-slot="6900109718"
			 data-ad-format="auto"
			 data-full-width-responsive="true"></ins>
	<script>
			 (adsbygoogle = window.adsbygoogle || []).push({});
	</script>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55" style="background-color: rgba(239, 229, 220, 0.8);">
				<form class="login100-form validate-form flex-sb flex-w" action="data-pasien.php" method="get">
					<span class="login100-form-title p-b-32">
						Daftar Online RSU Natalia Boyolali
					</span>

					<span class="txt1 p-b-11">
						Pilih Tanggal Kunjungan
					</span>
					<?php $max_date = date('Y-m-d', strtotime("+1 day")); ?>
					<div class="wrap-input100 validate-input m-b-36">
						<input type="date" name="tanggal" id="tanggal" value="" class="form-control" max="<?php echo $max_date; ?>" min="<?php echo date('Y-m-d'); ?>">
						<span class="focus-input100"></span>
					</div>

					<span class="txt1 p-b-11">
						Pilih Waktu Kunjungan
					</span>
					<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
						<select class="form-control custom-select" name="waktu">
							<option value="0">Pagi</option>
							<option value="1">Siang</option>
							<option value="2">Sore</option>
						</select>
						<span class="focus-input100"></span>
					</div>


					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="tampilkan">
							Lanjutkan
						</button>
					</div>

				</form>
			</div>
		</div>
	</div>
	
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
