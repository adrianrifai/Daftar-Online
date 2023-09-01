<?php
use LZCompressor\LZString as LZString;

require('LZCompressor/LZString.php');
require('LZCompressor/LZContext.php');
require('LZCompressor/LZData.php');
require('LZCompressor/LZReverseDictionary.php');
require('LZCompressor/LZUtil.php');
require('LZCompressor/LZUtil16.php');

// $data = "19733";
// $secretKey = "9Wc#Eo4sDq";
// $userkey = "d1e6a6ec712dfd6a65cbc110f3f2b633";

$data = "9667";
$secretKey = "9Wc#Eo4sDq";
$userkey = "16e789b4f9457c13b759d856f941d66d";

// Computes the timestamp
date_default_timezone_set('UTC');
$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
// Computes the signature by hashing the salt with the secret key as the key
$signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);
$key = $data.$secretKey.$tStamp;
// base64 encode…
$encodedSignature = base64_encode($signature);

$headers=array(
  "X-cons-id: ".$data,
  "X-timestamp: ".$tStamp,
  "X-signature: ".$encodedSignature,
  "user_key: ".$userkey,
  "Content-type: application/json"
);

$method = "POST";
$base_URL = "https://apijkn.bpjs-kesehatan.go.id/antreanrs/";

$json = '{
   "kodebooking": "'.$no_rawat.'",
   "jenispasien": "'.$penjamin.'",
   "nomorkartu": "'.$kartu.'",
   "nik": "'.$nik.'",
   "nohp": "'.$nohp.'",
   "kodepoli": "'.$cek_poli['kd_poli_bpjs'].'",
   "namapoli": "'.$cek_poli['nm_poli_bpjs'].'",
   "pasienbaru": 0,
   "norm": "'.$norm.'",
   "tanggalperiksa": "'.$date.'",
   "kodedokter": "'.$cek_dokter['kd_dokter_bpjs'].'",
   "namadokter": "'.$cek_dokter['nm_dokter_bpjs'].'",
   "jampraktek": "'.date('H:i', strtotime($dilayani['jam_mulai'])).'-'.date('H:i', strtotime($dilayani['jam_selesai'])).'",
   "jeniskunjungan": 1,
   "nomorreferensi": "'.$no_rujukan.'",
   "nomorantrean": "'.$no_reg.'",
   "angkaantrean": "'.(int) $no_reg.'",
   "estimasidilayani": "'.$tm_est_dilayani.'",
   "sisakuotajkn": "'.(int) $sisa_kuota.'",
   "kuotajkn": "'.(int) $cek_kuota['kuota'].'",
   "sisakuotanonjkn": "'.(int) $sisa_kuota.'",
   "kuotanonjkn": "'.(int) $cek_kuota['kuota'].'",
   "keterangan": "Peserta harap 30 menit lebih awal guna pencatatan administrasi."
}';

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL, $base_URL."antrean/add");
curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch,CURLOPT_TIMEOUT,3);
// curl_setopt($ch,CURLOPT_HTTPGET,1);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

$content=curl_exec($ch);
curl_close($ch);


// echo date('H:i', strtotime($dilayani->WKT_BUKA)).'-'.date('H:i', strtotime($dilayani->WKT_TUTUP));
$data=json_decode($content, true);
print_r($data);



 ?>
