<?php
    include_once('./model/database.php');

    class xl_don_nghi_phep extends database{

        function xl_don_nghi_phep(){
            parent::database();
            $this->database();
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

        function hien_thi_tat_ca_don_nghi_phep_chua_hoac_da_duyet_tru_mot_id($type,$id){
            if ($type) {
                $string_sql = "SELECT * FROM `nghi_phep` WHERE `status` != '' AND `user_created` != $id";
            } else {
                $string_sql = "SELECT * FROM `nghi_phep` WHERE `status` = '' AND `user_created` != $id";
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

        function cap_phep_don_xin_phep_bang_id ($id, $status, $fb, $responder) {
            $string_sql = "UPDATE `nghi_phep` SET `status` = '$status', `feelback` = '$fb' , `responder` = '$responder' WHERE `nghi_phep`.`id` = '$id'";
            $this->setSQL($string_sql);
            $this->update();
        }

        function them_ngay_nghi_phep ($start_date, $end_date, $reason, $id_create) {
            $string_sql = "INSERT INTO `nghi_phep` (`id`, `user_created`, `start`, `end`, `reason`, `status`, `feelback`, `responder`) VALUES (NULL, '$id_create', '$start_date', '$end_date', '$reason', '', '', '')";
            $this->setSQL($string_sql);
            $this->update();
        }
    }
?>