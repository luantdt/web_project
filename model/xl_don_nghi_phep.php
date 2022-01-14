<?php
    include_once('./model/database.php');

    class xl_don_nghi_phep extends database{

        function xl_don_nghi_phep(){
            parent::database();
        }

        function hien_thi_don_nghi_phep_theo_user_created($user_created){
            $string_sql = "SELECT * FROM `nghi_phep` WHERE `user_created` = $user_created";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function hien_thi_don_nghi_phep_chua_cap_phep(){
            $string_sql = "SELECT * FROM `nghi_phep` WHERE `status` = ''";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function hien_thi_don_nghi_phep_da_cap_phep(){
            $string_sql = "SELECT * FROM `nghi_phep` WHERE `status` != ''";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function hien_thi_tat_ca_don_nghi_phep_tru_mot_id($id){
            $string_sql = "SELECT * FROM `nghi_phep` WHERE `user_created` != $id";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function hien_thi_don_chua_duyet_theo_phong_ban_tru_truong_phong ($type,$department_id, $leader_id) {
            if ($type) {
                $string_sql = "SELECT u.*, s.* FROM nghi_phep u inner join users s on u.user_created = s.id WHERE s.department_id = '$department_id' AND u.status = '' AND u.user_created != '$leader_id'";
            } else {
                $string_sql = "SELECT u.*, s.* FROM nghi_phep u inner join users s on u.user_created = s.id WHERE s.department_id = '$department_id' AND u.status != '' AND u.user_created != '$leader_id'";
            }
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function hien_thi_don_chua_duyet_theo_my_id ($myid) {
            $string_sql = "SELECT * FROM `nghi_phep` WHERE `user_created` = '$myid' AND `status` = ''";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }

        function hien_thi_don_da_duyet_theo_my_id ($myid) {
            $string_sql = "SELECT * FROM `nghi_phep` WHERE `user_created` = '$myid' AND `status` != ''";
            $this->setSQL($string_sql);
            $this->execute();
            $result = $this->loadAllRow();
            return $result;
        }
    }
?>