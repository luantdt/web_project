<?php
    if (isset($_POST['btn-employeeToLeader'])) {
        if ( isset($_POST['employeeToLeader']) && 
        $_POST['employeeToLeader'] != '' &&
        $_POST['current-department'] != '' &&
        isset($_POST['current-department'])) 
        {
            $employeeToLeader = explode(' - ', $_POST['employeeToLeader']);
            $id_employee = $employeeToLeader[0];
            echo($id_employee);
        } else {
            
        };
    };
?>