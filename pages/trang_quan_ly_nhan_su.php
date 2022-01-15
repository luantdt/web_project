<?php 
    $thong_tin_user = $_SESSION['thong_tin_user'];
    include_once('./model/xl_nguoi_dung.php');
    include_once('./model/xl_phong_ban.php');
    $xl_nguoi_dung = new xl_nguoi_dung();
    $xl_phong_ban = new xl_phong_ban();
    $alert_reset_pwd = false;

    $all_users = $xl_nguoi_dung->hien_thi_tat_ca_thong_tin_nguoi_dung();
    if (isset($_POST['btn-reset-pwd-users'])) {
        $id_user_reset = decrypt($_POST['id-users']);
        if (
            isset($_POST['id-users']) && 
            $_POST['id-users'] != '' && 
            isset($_POST['usn']) &&
            $_POST['usn'] != '' && 
            is_numeric($id_user_reset)
        ) {
            $us_reset = decrypt($_POST['usn']);
            $hashed = password_hash($us_reset, PASSWORD_BCRYPT);
            $xl_nguoi_dung->cap_nhao_mat_khau_theo_id($id_user_reset, $hashed);
            $alert_reset_pwd = true;
        } else {
            echo json_encode(
                array(
                    'error' => true,
                    'message' => 'your information is invalid',
                )
            );
            die();
        }
    }

    if (isset($_POST['btn-create-new-user'])) {
        if (
            isset($_POST['full-name']) && 
            $_POST['full-name'] != '' && 
            isset($_POST['username']) &&
            $_POST['username'] != '' &&
            isset($_POST['birthday']) && 
            $_POST['birthday'] != '' &&
            isset($_POST['gender']) && 
            $_POST['gender'] != '' &&
            isset($_POST['department']) &&
            $_POST['department'] != '' 
        ) {
            $hashed = password_hash($_POST['username'], PASSWORD_BCRYPT);
            $depart_id = explode(' - ', $_POST['department']);
            $xl_nguoi_dung->them_tai_khoan_moi($_POST['full-name'],$_POST['username'],$hashed,$_POST['birthday'],$_POST['gender'],$depart_id[0]);
            header("Refresh:0");
        } else {
            echo json_encode(
                array(
                    'error' => true,
                    'message' => 'your information is invalid',
                )
            );
            die();
        }
    }
?>
<div class="row h-100">
    
    <div class="col-sm-2 bg-func shadow">
        <?php
            include_once("./modules/hien_thi_chuc_nang.php");
        ?>
    </div>
    <div class="col-sm-10">
        <div class="mt-4 text-center">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddUser">+ Thêm nhân viên mới</button>
        </div>
        <div class="row mt-4">
            <?php
                foreach($all_users as $arr) {
                    if ($thong_tin_user->id != $arr['id']) {
                
                        ?>
                            <div class="col-sm-4 mt-2">
                                <div class="card mb-3 shadow-sm border border-success" style="max-width: 540px; height: 300px">
                                    <div class="row no-gutters h-100">
                                        <div class="col-md-6 ">
                                            <img src="<?php echo('.'.$arr['pic'])?>" alt="" class="h-100 w-100">
                                        </div>
                                        <div class="col-md-6 h-100">
                                            <div class="card-body h-100">
                                                <h5 class="card-title"><?php echo($arr['fullName'])?></h5>
                                                <div class="card-text">
                                                    <div class="">
                                                        Giới tính: <b><?php echo($arr['gender'])?></b>
                                                    </div>
                                                    <div class="">
                                                        Ngày sinh: <?php echo($arr['birthday'])?>
                                                    </div> 
                                                    <div class="">
                                                        Chức vụ: <?php echo($arr['role'])?>
                                                    </div>
                                                    <div class="">
                                                        Phòng: <?php
                                                            $val = $xl_phong_ban->hien_thi_phong_ban_theo_id($arr['department_id']);
                                                            echo($val->name);
                                                        ?>
                                                    </div>
                                                    <div class="mt-1">
                                                        <form id="form-reset-pwd" action="" method="post">
                                                            <input type="text" value="<?php echo(encrypt($arr['id']))?>" style="display:none" name="id-users">
                                                            <input type="text" value="<?php echo(encrypt($arr['username']))?>" style="display:none" name="usn" >
                                                            <button type="submit" name="btn-reset-pwd-users" class="btn btn-warning">Đặt lại mật khẩu</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                    }
                }
            ?>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="modalAddUser" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Thêm nhân viên mới</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" id="form-create-new-user">
            
                <div class="modal-body">
                    <div class="form-group">
                        <label for="full-name">Họ và tên</label>
                        <input type="text" class="form-control" id="full-name" placeholder="Nhập họ và tên" name="full-name">
                    </div>
                    <div class="form-group">
                        <label for="username">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" placeholder="Nhập tên đăng nhập" name="username">
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày sinh</label>
                        <input type="date" class="form-control" id="birthday" placeholder="Nhập ngày sinh" name="birthday">
                    </div>
                    <div class="form-group">
                    
                        <label for="gender">Example select</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    <div class="form-group">
                        <label for="department">Chọn phòng ban</label>
                        <select multiple class="form-control" id="department" name="department">
                            <?php
                                $all_department = $xl_phong_ban->hien_thi_tat_ca_phong_ban();
                                foreach($all_department as $arr) {
                                    if ($arr['name'] != 'Giám Đốc') {
                                        ?>
                                            <option value="<?php echo($arr['id'].' - '.$arr['name'])?>">
                                                <?php echo($arr['id'].' - '.$arr['name'])?>
                                            </option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" name="btn-create-new-user">Thêm nhân viên</button>
                </div>
            </form>
        </div>
    </div>
    </div>
<?php
    if ($alert_reset_pwd) {
        echo("<script>alert('Đặt lại mật khẩu thành công');</script>");
    }
?>
</div>

</body>
</html>