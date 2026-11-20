<?php include "config/koneksi_user.php";
            $query_profile = "SELECT 
                                                    user.*, 
                                                    user_role.nama_role,
                                                    user_history.login_time,
                                                    photo_profile.nama_file
                                                FROM user
                                                LEFT JOIN user_role ON user.id_user_role = user_role.id_user_role
                                                LEFT JOIN user_history ON user_history.id_user = user.id_user
                                                LEFT JOIN photo_profile ON photo_profile.id_user = user.id_user
                                                WHERE user.id_user = '$id_user'";
            $result_profile = $koneksi_user->query($query_profile);
            if ($result_profile->num_rows > 0) {
                $row = $result_profile->fetch_assoc();
                $nama_file = $row['nama_file'];
                $nama = $row['nama_user'];
                $jenis_kelamin = $row['jenis_kelamin'];
            }
        ?>
        <?php
    if (!empty($nama_file)) {
        $profileImage = "https://test-user-account.mandirialkesindo.co.id/profile user/" . $nama_file;
        $isImage = true;
    } else {
        $isImage = false;

        // Ambil inisial dari nama
        $nameParts = explode(" ", trim($nama)); // Pisahkan nama berdasarkan spasi
        $count = count($nameParts);

        if ($count == 1) {
            $initials = strtoupper(substr($nameParts[0], 0, 1)); // Jika hanya satu kata, ambil huruf pertama
        } elseif ($count == 2) {
            $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1)); // 2 kata: huruf pertama dari 2 kata
        } else {
            $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[$count - 1], 0, 1)); // 3 kata atau lebih: ambil pertama & terakhir
        }

        // Tentukan warna background berdasarkan jenis kelamin
        $bgColor = ($jenis_kelamin == "Male") ? "#0060D4" : "#FF4ECB";
    }
?>

<div class="position-relative" style="width: 35px; height: 35px;">
    <?php if ($isImage): ?>
        <img src="<?php echo $profileImage . '?t=' . time(); ?>" 
             class="user-avtar"
             style="border-radius: 50%; width: 35px; height: 35px; object-fit: cover;" 
             alt="profile-image">
    <?php else: ?>
        <div class="user-avtar" style="
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            background-color: <?php echo $bgColor; ?>;
            color: white;
            font-size: 15px;
            font-weight: bold;
            text-transform: uppercase;
            padding-top: 2px;">
            <?php echo $initials; ?>
        </div>
    <?php endif; ?>

    <!-- Tanda aktif -->
    <span class="position-absolute bg-success border border-white rounded-circle"
          style="width: 10px; height: 10px; bottom: 5px; right: 5px; transform: translate(50%, 50%);">
    </span>
</div>
