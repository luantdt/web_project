<?php
    session_start();
    if(isset($_GET['route'])) {
        if(isset($_SESSION['thong_tin_user'])) {
            include_once('../lib/function_support.php');
            if($_GET['route'] == 'file'){
                if($_GET['alias'] == 'df') {
                    include_once('./file/tai_file_trong_task.php');
                } else {
                    header('location: ../?page=404');
                }
            } else {
                header('location: ../?page=404');
            }
        } else {
            header('location: ../?page=404');
        }
    }
    else {
        header('location: ../?page=404');
    }
?>