<?php
    $id = $_SESSION['thong_tin_user']->id;
    $department_id = $_SESSION['thong_tin_user']->department_id;
    $role = $_SESSION['thong_tin_user']->role;
    include_once('./model/xl_task.php');
    $xl_task = new xl_task();

    if ($_SESSION['thong_tin_user']->role == "employee") {
        $tasks = $xl_task->hien_thi_cong_viec_theo_user_id($id);
    } else {
        $tasks = $xl_task->hien_thi_toan_bo_cong_viec($id);
    }
    $name = '';
    $summary = '';
    $id_task = '';
    $status = '';
    foreach($tasks as $arr) {
        $flag = false;
        if (count($arr) )
        if ($role != 'admin') {
            if ($arr['department_id'] == $department_id) {
                in_task_dashboard($arr['status'],$arr['name'],$arr['summary'],$arr['id']);
            }
        } else {
            in_task_dashboard($arr['status'],$arr['name'],$arr['summary'],$arr['id']);
        }
    }
?>