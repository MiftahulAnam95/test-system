<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<?php
require_once "config/koneksi_user.php";
require_once "vendor/autoload.php";
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

date_default_timezone_set('Asia/Jakarta');
session_start();

$current_domain = 'http://' . $_SERVER['HTTP_HOST'] . '/test-system';
$jwt = $_COOKIE['jwt_token_test'] ?? null;
// Cek token di URL atau cookie
if ($jwt) {
    // Ambil data dari DB berdasarkan token
    $query = "SELECT 
                ut.key_token,
                ut.expired_token_time,
                us.id_user_status,
                us.status_perangkat, 
                us.id_user_akses, 
                us.status_klik_active,
                u.id_user,
                ur.nama_role,
                u.nama_user,
                w.url_website,
                ua.is_blocked
              FROM user_token ut
              LEFT JOIN user_status us ON us.id_token = ut.id_token
              LEFT JOIN user_akses ua ON us.id_user_akses = ua.id_user_akses
              LEFT JOIN website_management w ON ua.id_website = w.id_website
              LEFT JOIN user u ON ua.id_user = u.id_user
              LEFT JOIN user_role ur ON u.id_user_role = ur.id_user_role
              WHERE ut.token = '$jwt' and w.url_website = '$current_domain'
              LIMIT 1";

    $result = mysqli_query($koneksi_user, $query);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        // Verifikasi JWT menggunakan key dari database
        try {
            $decoded = JWT::decode($jwt, new Key($data['key_token'], 'HS256'));

            // Validasi ID user dari payload dengan yang ada di DB 
            if ($decoded->id_user !== $data['id_user']) {
                throw new Exception("Token ID tidak cocok");
            }

            // Token belum kadaluarsa?
            $current_time = time();
            $expired_token_time = strtotime($data['expired_token_time']);
            if ($current_time >= $expired_token_time) {
                header("Location: http://localhost/test-sso/logout.php?url=" . urlencode($current_domain));
                exit();
            }

            // Session timeout 30 menit
            $session_time = 1800; 
            $id_user_status = $data['id_user_status'];
            $id_user = $data['id_user'];
            $nama_user = $data['nama_user'];
            $nama_role = $data['nama_role'];

            if ($data['status_perangkat'] === 'Online') {
                if (isset($_SESSION['last_activity']) && ($current_time - $_SESSION['last_activity']) > $session_time) {
                    header("Location: http://localhost/test-sso/logout.php?url=" . urlencode($current_domain));
                    exit();
                } else {
                    $_SESSION['last_activity'] = $current_time;
                }

                if (empty($data['id_user_akses'])) {
                    header("Location: http://localhost/test-sso/logout.php?url=" . urlencode($current_domain));
                    exit();
                }

                if ($data['is_blocked'] == 1) {
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Maaf akses anda telah diblokir',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.href = 'http://localhost/test-sso/logout.php?url=" . urlencode($current_domain) . "';
                            });
                          </script>";
                    exit();
                }

                // Reset gagal login
                $query_update = "UPDATE user SET jumlah_gagal_login = 0 WHERE id_user = '{$data['id_user']}'";
                mysqli_query($koneksi_user, $query_update);

                // Tambah klik aktif
                $query_status_klik = "UPDATE user_status 
                                      SET status_klik_active = status_klik_active + 1 
                                      WHERE id_user_status = '$id_user_status'";
                mysqli_query($koneksi_user, $query_status_klik);
            } else {
                header("Location: http://localhost/test-sso/logout.php?url=" . urlencode($current_domain));
                exit();
            }

        } catch (Exception $e) {
            // JWT tidak valid atau salah key
            header("Location: http://localhost/test-sso/logout.php?url=" . urlencode($current_domain));
            exit();
        }

    } else {
        // Token tidak ditemukan
        header("Location: http://localhost/test-sso/logout.php?url=" . urlencode($current_domain));
        exit();
    }
} else {
    // Tidak ada token
    header("Location: http://localhost/test-sso/logout.php?url=" . urlencode($current_domain));
    exit();
}
?>
</body>
</html>
