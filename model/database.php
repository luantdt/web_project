<?php

    class database {
        private $sql, $db, $sth;

        function database(){
            $this->db = new mysqli('localhost', 'root', '', 'company1');
            if($this->db === false){
                die("ERROR: Không thể kết nối. " . $this->db->connect_error);
            }
        }

        function setSQL($sql_string){
            $this->sql = $sql_string;
        }

        function execute(){
            $this->sth = $this->db->prepare($this->sql);
            $this->sth->execute();  
            //$res = $this->db->query($this->sql);
            $this->sth = $this->sth->get_result();
            return $this->sth->num_rows;
        }

        function update() {
            $this->sth = $this->db->prepare($this->sql);
            $this->sth->execute(); 
        }

        function loadAllRow(){
            return $this->sth->fetch_all(MYSQLI_ASSOC);
        }

        function loadRow(){
            return $this->sth->fetch_object();
        }

        /* function lasInsertId(){
            return $this->db->                                                                                  ();
        } */
    }

?>