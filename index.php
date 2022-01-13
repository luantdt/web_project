<?php
    session_start();
    include_once('./widgets/head.php');

    if(isset($_GET['page'])) {
        if(isset($_SESSION['thong_tin_user'])){
            //$thong_tin_user_cookie = $_COOKIE['thong_tin_user_cookie'];
            //echo '<pre>',print_r($_SESSION['thong_tin_user']),'</pre>';
            include_once('./lib/function_support.php');
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
            } else {
                include_once('./pages/404.php');
            }
        } else if($_GET['page'] == 'redirect' && !isset($_SESSION['thong_tin_user'])){
            include_once('./pages/trang_chuyen_huong.php');
        } else {
            header('location: http://localhost:8080/web/web_project/');
        }
        
    } 
    else {
        include_once('./pages/login.php');
    }
?>