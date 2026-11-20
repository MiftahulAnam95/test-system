<?php  
// Ambil Authorization header
$headers = getallheaders();
$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? $headers['Authorization'] ?? '';
$jwt = '';

// Ambil token dari header Authorization
if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
    $jwt = $matches[1];
}

// Jika tidak ada token, kirim respon 401
if (!$jwt) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token tidak ditemukan']);
    exit;
}

// Cek apakah token sudah diverifikasi sebelumnya (cache di session)
if (!isset($_SESSION['token_verified']) || $_SESSION['token_verified'] !== $jwt) {
    // Verifikasi token ke auth server
    $ch = curl_init($domain_sso .'api/verify-token.php');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $jwt
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);

    if ($response === false) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Gagal terhubung ke auth server',
            'error' => curl_error($ch)
        ]);
        curl_close($ch);
        exit;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $authBody = json_decode($response, true);

    if ($httpCode !== 200 || !isset($authBody['success']) || !$authBody['success']) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Token tidak valid']);
        exit;
    }

    // Simpan token yang sudah diverifikasi
    $_SESSION['token_verified'] = $jwt;
}
?>