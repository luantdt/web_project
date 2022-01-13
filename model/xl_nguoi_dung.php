<?php
    include_once('./model/database.php');

    class xl_nguoi_dung extends database{

        function xl_nguoi_dung(){
            parent::database();
        }

        function thong_tin_nguoi_dung_theo_tai_khoan($tai_khoan){
            $string_sql = "SELECT * FROM users WHERE username = '$tai_khoan'";
            $this->setSQL($string_sql);
            $this->execute();
            // echo '<pre>',print_r($re),'</pre>';exit;
            $result = $this->loadRow();
            return $result;
        }
        
        function thong_tin_nguoi_dung_theo_id_tai_khoan($id){
            $string_sql = "SELECT u.*, s.* FROM users u inner join department s on u.department_id = s.id  WHERE u.id = $id";
            $this->setSQL($string_sql);
            $this->execute();
            // echo '<pre>',print_r($re),'</pre>';exit;
            $result = $this->loadRow();
            return $result;
        }

        function cap_nhap_anh($url,$id) {
            $string_sql = "UPDATE users SET pic =  '$url'  WHERE users.id = $id";
            $this->setSQL($string_sql);
            $this->update();
        }

        function cap_nhao_mat_khau_theo_id ($id,$pass) {
            $string_sql = "UPDATE users SET password =  '$pass'  WHERE users.id = $id";
            $this->setSQL($string_sql);
            $this->update();
        }

        function hien_thi_thong_tin_user_theo_department_id ($department_id) {
            $string_sql = "SELECT * FROM `users` WHERE `department_id` = $department_id";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }
    }
?>