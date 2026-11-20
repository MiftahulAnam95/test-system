<?php
$host_user = "localhost";//nama server	
$username_user = "root";//usernya
$password_user = "";//password
$database_user = "test_user";//database

// $host_user = "anzio-db.id.domainesia.com";//nama server	
// $username_user = "mandir36_user";//usernya
// $password_user = "sso_IT2024";//password
// $database_user = "mandir36_test_user2025";//database 

// Buat koneksi ke database
$koneksi_user = mysqli_connect($host_user, $username_user, $password_user, $database_user);

// Cek koneksi
if (!$koneksi_user) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>


 