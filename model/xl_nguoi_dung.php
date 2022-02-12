<?php
    include_once('./model/database.php');

    class xl_nguoi_dung extends database{

        function xl_nguoi_dung() {
            parent::database();
        }

        function thong_tin_nguoi_dung_theo_tai_khoan($tai_khoan){
            $string_sql = "SELECT * FROM users WHERE username = '$tai_khoan'";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadRow();
            return $result;
        }
        
        function thong_tin_nguoi_dung_theo_id_tai_khoan($id) {
            $string_sql = "SELECT u.*, s.* FROM users u inner join department s on u.department_id = s.id  WHERE u.id = $id";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadRow();
            return $result;
        }

        function cap_nhap_anh($url,$id) {
            $string_sql = "UPDATE users SET pic =  '$url'  WHERE users.id = $id";
            $this->setSQL($string_sql);
            $this->update();
        }

        function cap_nhao_mat_khau_theo_id ($id,$pass) {
            $string_sql = "UPDATE users SET password = '$pass'  WHERE users.id = $id";
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
        
        function hien_thi_tat_ca_thong_tin_nguoi_dung () {
            $string_sql = "SELECT * from users";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function them_tai_khoan_moi ($fullName, $username, $password, $birthday, $gender, $department_id) {
            $string_sql = "INSERT INTO `users` 
            (`id`, `fullName`, `username`, `password`, `birthday`, `gender`, `role`, `pic`, `department_id`) 
            VALUES 
            (NULL, '$fullName', '$username', '$password', '$birthday', '$gender', 'employee', '/public/avt/default.jpg', '$department_id')";
            $this->setSQL($string_sql);
            $this->update();
        }

        function hien_thi_ten_va_id_nhan_vien () {
            $string_sql = "SELECT id, fullName FROM `users` WHERE role = 'employee'";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function cap_nhap_role_thanh_leader ($id) {
            $string_sql = "UPDATE `users` SET `role` = 'leader' WHERE `users`.`id` = $id;";
            $this->setSQL($string_sql);
            $this->update();
        }

        function cap_nhap_role_thanh_employee ($id) {
            $string_sql = "UPDATE `users` SET `role` = 'employee' WHERE `users`.`id` = $id;";
            $this->setSQL($string_sql);
            $this->update();
        }

        function thay_doi_role_thanh_truong_phong ($id_user) {
            $string_sql = "UPDATE `users` SET `role` = 'leader' WHERE `users`.`id` = '$id_user';";
            $this->setSQL($string_sql);
            $this->update();
        }

        function thay_doi_role_thanh_employee ($id_user) {
            $string_sql = "UPDATE `users` SET `role` = 'employee' WHERE `users`.`id` = '$id_user';";
            $this->setSQL($string_sql);
            $this->update();
        }
    }
?>