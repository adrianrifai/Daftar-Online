<!DOCTYPE html>
<html lang="en">

<head>
    <title>Daftar Online RSU Natalia Boyolali</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
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

    $id_reservasi = $_GET["id_reservasi"];
    $kode = mysqli_query($conn, "SELECT kode, no_reg FROM booking_registrasi WHERE kode = '$id_reservasi'");
    $kode1 = mysqli_fetch_assoc($kode);

    $est_dilayani = mysqli_query($conn, "SELECT booking_registrasi.*, booking_periksa.* FROM booking_registrasi JOIN booking_periksa ON booking_registrasi.kode = booking_periksa.no_booking WHERE booking_registrasi.kode = '$id_reservasi'");
    $est_dilayani = mysqli_fetch_assoc($est_dilayani);
    echo $est_dilayani['no_reg'];

    // $tempdir = "img-barcode/";
    // if (!file_exists($tempdir))
    // 	mkdir($tempdir, 0755);
    // $target_path = $tempdir . $kode1['kode'] . ".png";


    // /*using server localhost*/
    // $fileImage = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/barcode.php?text=" . $kode1['kode'] . "&codetype=code128&print=true&size=55";

    // /*get content from url*/
    // $content = file_get_contents($fileImage);

    // /*save file */
    // file_put_contents($target_path, $content);
    ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
                <span class="login100-form-title p-b-32">
                    Silahkan Screenshot / Catat Kode Reservasi Berikut : <b><?php echo $kode1['kode']; ?></b>
                </span>

                <span class="login100-form-title p-b-32">
                    <?php echo "<p><img src='barcode.php?text=" . $kode1['kode'] . "&codetype=code39&print=true&size=20' style='width:100%' /></p>"; ?>
                </span>


                <span class="txt1 p-b-11">
                    Kode Reservasi Anda
                </span>
                <div class="wrap-input100 validate-input m-b-12">
                    <b class="form-control-static"><?php echo $kode1['kode']; ?></b>
                </div>

                <span class="txt1 p-b-11">
                    No Antrian Anda
                </span>
                <div class="wrap-input100 validate-input m-b-12">
                    <p class="form-control-static"><?php echo $kode1['no_reg']; ?></p>
                </div>

                <!-- <span class="txt1 p-b-11">
					Estimasi Dilayani
				</span>
				<div class="wrap-input100 validate-input m-b-12">
					<p class="form-control-static" ><?php //echo $est_dilayani->EST_DILAYANI;
                                                    ?></p>
				</div> -->

                <span class="txt1 p-b-11">
                    Simpan Kode ini dan gunakan saat mendaftar
                </span>
                <br>
                <span class="txt1 p-b-11">
                    Datang 15 Menit sebelum Jam Pelayanan Dimulai
                </span>

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