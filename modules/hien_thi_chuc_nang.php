<?php
    $role = $_SESSION['thong_tin_user']->role;
    $page = $_GET['page'];
    
    $permission = array(
        'dashboard' => 'Dashboard',
        'infor' => 'Thông tin người dùng',
        'letter' => 'Quản lý đơn xin phép',
        'employee' => 'Quản lý nhân viên',
        'department' => 'Quản lý phòng ban'
    );
    
    if ($role != "admin") { 
        $stop = 'Quản lý nhân viên';
    } else {
        $stop = "";
    }

    ?>
        <div class="function fs-23">
            <?php
                foreach($permission as $key => $element) {
                    if ($element == $stop) {
                        break;
                    }
                    ?>
                        <div class= "<?php 
                            if ($page == $key) {
                                echo("mt-3 func cur-pointer func-active");
                            } else {
                                echo("mt-1 func cur-pointer");
                            }
                        ?>">
                            <a href="<?php echo("./?page=" . $key)?>">
                                <?php echo($element) ?>
                            </a>
                        </div>
                    <?php
                }
            ?>
        </div>
    <?php

?>