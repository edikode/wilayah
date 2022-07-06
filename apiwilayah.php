<?php

//--- Database configuration
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'wilayah';
$dbdsn = "mysql:dbname={$dbname};host={$dbhost}";
try {
    $db = new PDO($dbdsn, $dbuser, $dbpass);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$wil=array(
	2=>array(5,'Kota/Kabupaten','kab'),
	5=>array(8,'Kecamatan','kec'),
	8=>array(13,'Kelurahan','kel')
);

if (isset($_GET['id']) && !empty($_GET['id'])) {

    // $n jml character
    $n = strlen($_GET['id']);

    $query = $db->prepare("SELECT * FROM wilayah_2022 WHERE LEFT(kode,:n)=:id AND CHAR_LENGTH(kode)=:m ORDER BY nama");
    $query->execute(array(':n' => $n, ':id' => $_GET['id'], ':m' => $wil[$n][0]));

    $dataWilayah = array();

    while ($d = $query->fetchObject()) {
        $dataWilayah[] = $d;
    };

    header('Content-Type: application/json');
    echo json_encode($dataWilayah);
} else  {
    $query = $db->prepare("SELECT kode, nama FROM wilayah_2022 WHERE CHAR_LENGTH(kode)=2 ORDER BY nama");
    $query->execute();

    $dataProvinces = array();
    while ($data = $query->fetchObject()) {
        $dataProvinces[] = $data;
    };

    header('Content-Type: application/json');
    echo json_encode($dataProvinces);
}
