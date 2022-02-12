<?php
    include_once('./model/database.php');

    class xl_phong_ban extends database {
        function xl_phong_ban (){
            parent::database();
        }
        
        function hien_thi_phong_ban_theo_id ($id) {
            $string_sql = "SELECT id, name FROM department WHERE id = '$id'";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadRow();
            return $result;
        }

        function hien_thi_ten_va_id_phong_ban () {
            $string_sql = "SELECT id, name FROM department";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function hien_thi_tat_ca_phong_ban () {
            $string_sql = "SELECT * FROM department";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function hien_thi_tong_so_nhan_su_theo_id ($id) {
            $string_sql = "SELECT COUNT(fullName) AS tong_so FROM users WHERE department_id = $id";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function hien_thi_ten_truong_phong_theo_phong_ban ($id) {
            $string_sql = "SELECT fullName FROM users WHERE department_id = $id AND role = 'leader'";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function tro_thanh_truong_phong ($id_department, $id_user) {
            $string_sql = " UPDATE `department` SET `leader_id` = '$id_user' WHERE `department`.`id` = '$id_department';";
            $this->setSQL($string_sql);
            $this->update();
        }

        function hien_thi_id_leader_theo_id_phong_ban ($id_department) {
            $string_sql = "SELECT leader_id FROM `department` WHERE `id` = $id_department";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadRow();
            return $result;
        }
    }
?>