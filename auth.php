<?php
    include_once('./model/xl_nguoi_dung.php');
    $xl_nguoi_dung = new xl_nguoi_dung();

    $thong_tin = $xl_nguoi_dung->thong_tin_nguoi_dung_theo_id_tai_khoan($_SESSION['thong_tin_user']->id);

    // Khi tài khoản thay đổi
    if ($thong_tin->role != $_SESSION['thong_tin_user']->role) {
        unset($_SESSION['thong_tin_user']);
        header('location: ./?page=redirect&func=re-login');
    }
?>