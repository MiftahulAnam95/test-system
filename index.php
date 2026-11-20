<?php 
include "akses.php";

// Pastikan token tersedia di cookie
if (!isset($_COOKIE['jwt_token_test'])) {
    header("Location: http://localhost/test-sso/logout.php?url=" . urlencode($current_domain)); // Jika token tidak ada, redirect ke logout
    exit();
}

$jwt = $_COOKIE['jwt_token_test'];

// Query untuk mendapatkan informasi role pengguna berdasarkan token
$query = "SELECT 
                u.id_user,
                ur.nama_role,
                u.nama_user
              FROM user_token ut
              LEFT JOIN user_status us ON ut.id_token = us.id_token
              LEFT JOIN user_akses ua ON us.id_user_akses = ua.id_user_akses
              LEFT JOIN user u ON ua.id_user = u.id_user
              LEFT JOIN user_role ur ON u.id_user_role = ur.id_user_role
              WHERE ut.token = '$jwt'";
$result = mysqli_query($koneksi_user, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nama_role = $row['nama_role'];

    if ($nama_role == 'Super Admin') {
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: http://localhost/test-sso/logout.php?url=" . urlencode($current_domain));
        exit();
    }
} else {
    header("Location: http://localhost/test-sso/logout.php?url=" . urlencode($current_domain));
    exit();
}
?>