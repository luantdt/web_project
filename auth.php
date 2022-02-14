<?php
    include_once('./model/xl_nguoi_dung.php');
    $xl_nguoi_dung = new xl_nguoi_dung();

    $thong_tin = $xl_nguoi_dung->thong_tin_user_theo_id_tai_khoan($_SESSION['thong_tin_user']->id);

    // Khi tài khoản thay đổi
    if ($thong_tin != $_SESSION['thong_tin_user']) {
        unset($_SESSION['thong_tin_user']);
        header('location: ./?page=redirect&func=re-login');
    }
?>