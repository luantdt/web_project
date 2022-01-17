<?php
    session_start();
    include_once('./widgets/head.php');
    if(isset($_GET['page'])) {
        if(isset($_SESSION['thong_tin_user'])){
            include_once('./lib/function_support.php');
            if ($_GET['page'] == 'changpwd') {
                include_once('./pages/trang_thay_doi_mat_khau.php');
            } else {
                include_once('./widgets/header.php');

                if($_GET['page'] == 'dashboard'){
                    include_once('./pages/dashboard.php');
                } else if ($_GET['page'] == 'test') {
                    include_once('./pages/test.php');
                } else if ($_GET['page'] == 'header') {
                    include_once('./widgets/header.php');
                } else if ($_GET['page'] == 'detail') {
                    include_once('./pages/trang_chi_tiet.php');
                } else if ($_GET['page'] == 'infor') {
                    include_once('./pages/trang_thong_tin_nguoi_dung.php');
                } else if ($_GET['page'] == 'letter') {
                    include_once('./pages/trang_quan_ly_don_xin_phep.php');
                } else if ($_GET['page'] == 'employee') {
                    include_once('./pages/trang_quan_ly_nhan_su.php');
                } else if ($_GET['page'] == 'department') {
                    include_once('./pages/trang_quan_ly_phong_ban.php');
                } else {
                    include_once('./pages/404.php');
                }
            }
        } else if($_GET['page'] == 'redirect' && !isset($_SESSION['thong_tin_user'])){
            include_once('./pages/trang_chuyen_huong.php');
        } else {
            header('location: ./');
        }
        
    } 
    else {
        include_once('./pages/login.php');
    }
?>