<?php
/* UPdate SQL */
/* UPDATE `task` SET `submit_status` = 'Đã giao' WHERE `task`.`id` = 2; */
    /* include_once('./model/xl_task.php');
    $xl_task = new xl_task();

    $cong_viec = $xl_task->hien_thi_cong_viec_theo_user_id(16); */
    /* echo '<pre>',print_r($cong_viec),'</pre>'; */


    
    /* foreach($cong_viec as $key => $element) {
        
        if ($key == "name") {
            $name = $element;
        }
        echo($key . " ");
        if ($key == "creation_time ") {
            $creation_time  = $element;
        }

        if ($key == "end_time ") {
            $end_time  = $element;
        }

        if ($key == "description ") {
            $description  = $element;
        }

    } */
    /* $id = $_SESSION['thong_tin_user']->id;
    include_once('./model/xl_nguoi_dung.php');
    $xl_nguoi_dung = new xl_nguoi_dung();
    $thong_tin = $xl_nguoi_dung->thong_tin_nguoi_dung_theo_id_tai_khoan($id);
    echo '<pre>',print_r($thong_tin),'</pre>'; */
    /* echo($thong_tin->id); */
    /* echo '<pre>',print_r($_FILES['avatar']),'</pre>'; */
    /* if (isset($_FILES['avatar']) && $_FILES['avatar']['tmp_name'] != '') {
        $f = $_FILES['avatar'];
        $name = $f['name'];
        $tmp = $f['tmp_name'];
        $size = $f['size'];
        $arr = explode('.',$name);
        $type = $arr[count($arr)-1];
        echo($type);
        if ($size > 3 * 1024 * 1024) {
            echo("file hinh qua lon");
        };

        if ($type === "jpg" || $type === "jpeg" || $type === "png" ) {
            $dest = $_SERVER['DOCUMENT_ROOT'] . '/web/web_project/public/avt/' .'av' . $id . '.' . $type;
            move_uploaded_file($tmp, $dest);
            echo "tai len thanh cong";
        } else {
            echo "phai la file ....";
        }
    } else {
        echo "khong co file";
    } */
    /* include_once('./model/xl_task.php');
    $xl_task = new xl_task();
    $xl_task->cap_nhap_trang_thai_task(1,"in progress"); */

    /* $res = $xl_task->hien_thi_tat_ca_thong_tin_nop_task(1);

    include_once('./model/xl_nguoi_dung.php');
    $xl_nguoi_dung = new xl_nguoi_dung();
    echo '<pre>',print_r($res),'</pre>';
    foreach ($res as &$value) {
        echo('</br>');
        var_dump($value['comment']);
        $thong_tin = $xl_nguoi_dung->thong_tin_nguoi_dung_theo_id_tai_khoan($value['user_id']);
        echo($thong_tin->role);
    } */

    /* echo '<pre>',print_r($_SESSION['thong_tin_user']),'</pre>';
    echo($_SESSION['thong_tin_nguoi_dung']->role); */
    /* /%2Fpublic%2Ftask%2F51900815_TranVuLuan_Tuan1.png
    http://localhost:8080/web/web_project/api/tai_file_trong_task.php/?file=%2Fpublic%2Ftask%2F51900815_TranVuLuan_Tuan1.png */
    /* echo(urlencode('/public/task/51900815_TranVuLuan_Tuan1.png')) */

    /* include_once('./model/xl_nguoi_dung.php');
    $xl_nguoi_dung = new xl_nguoi_dung();
    $res = $xl_nguoi_dung->hien_thi_thong_tin_user_theo_department_id(1);
    foreach ($user_department as $value) {
        if ($value['role'] == 'employee') {
            
        }
    } */
    /* $tiem = '2022-01-13T13:39';
    /* print_r(explode(' - ', '16 - aaa')) */
    /* include_once('./model/xl_don_nghi_phep.php');
    $xl_don_nghi_phep = new xl_don_nghi_phep();
    $res = $xl_don_nghi_phep->hien_thi_don_nghi_phep_theo_user_created(16);   
    echo '<pre>',print_r($res),'</pre>'; */
    /* echo($_SERVER["DOCUMENT_ROOT"]); */

    
?>


