<?php
    include_once('./model/database.php');

    class xl_task extends database {
        function xl_task (){
            parent::database();
        }

        
        // hiển thị toàn bộ công việc hiện 
        function hien_thi_toan_bo_cong_viec () {
            
            $str_sql = "SELECT * FROM task";
            //echo $string_sql; exit;
            $this->setSQL($str_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        // hiện thị công việc dành cho user được chỉ định
        function hien_thi_cong_viec_theo_user_id ($us_id) {
            $str_sql = "SELECT * FROM task WHERE user_id = $us_id";
            $this->setSQL($str_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        // hiển thị chi tiết 1 công việc theo id của công việc
        function hien_thi_cong_viec_theo_id ($id) {
            $str_sql = "SELECT * FROM task WHERE id = $id";
            $this->setSQL($str_sql);
            $this->execute();
            $result = $this->loadRow();
            return $result;
        }
        // nhập thông tin về tương tác task
        function nhap_thong_tin_tuong_tac_task ($task_id, $link, $comment, $id, $status) {
            $time = date('Y-m-d H:i:s');
            $str_sql = "INSERT INTO tuong_tac_task (task_id, file, time, comment, user_id, status) VALUES ('$task_id', '$link', '$time', '$comment', '$id', '$status')";
            $this->setSQL($str_sql);
            $this->update();
        }

        function hien_thi_thong_tin_nop_task_theo_file($file) {
            $str_sql = "SELECT * FROM tuong_tac_task WHERE file = '$file'";
            $this->setSQL($str_sql);
            $this->execute();
            $result = $this->loadRow();
            return $result;
        }

        function hien_thi_tat_ca_thong_tin_nop_task ($id) {
            $str_sql = "SELECT * FROM tuong_tac_task WHERE task_id = '$id'";
            $this->setSQL($str_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function cap_nhap_trang_thai_task ($id, $status) {
            $str_sql = "UPDATE task SET status = '$status' WHERE task.id = $id";
            $this->setSQL($str_sql);
            $this->update();
        }

        function cap_nhap_trang_thai_tuong_tac_task ($id, $status_old, $status_new) {
            $str_sql = "UPDATE tuong_tac_task SET status = '$status_new' WHERE tuong_tac_task.task_id = $id AND tuong_tac_task.status = '$status_old'";
            $this->setSQL($str_sql);
            $this->update();
        }
    }
?>