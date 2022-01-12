<?php
    $id = $_SESSION['thong_tin_user']->id;
    include_once('./model/xl_nguoi_dung.php');
    $xl_nguoi_dung = new xl_nguoi_dung();

    $thong_tin = $xl_nguoi_dung->thong_tin_nguoi_dung_theo_id_tai_khoan($id);
    $date = DateTime::createFromFormat('Y-m-d', $thong_tin->birthday)->format('d-m-Y');

    $mess_av = '';
    $flag_err = 0;
    $mess_pw = '';

   /*  Xử lý cập nhập hình ảnh */
    if (isset($_POST['btn-update-av'])) {
        if (isset($_FILES['avatar']) && $_FILES['avatar']['tmp_name'] != '') {
            $f = $_FILES['avatar'];
            $name = $f['name'];
            $tmp = $f['tmp_name'];
            $size = $f['size'];
            $arr = explode('.',$name);
            $type = $arr[count($arr)-1];
    
            if ($size > 2 * 1024 * 1024) {
                $mess_av  = "Tập tin hình ảnh lớn hơn quy định cho phép.";
            } else if ($type === "jpg" || $type === "jpeg" || $type === "png" ) {
                $dest = $_SERVER['DOCUMENT_ROOT'] . '/web/final/public/avt/' .'av' . $id . '.' . $type;
                move_uploaded_file($tmp, $dest);
                $xl_nguoi_dung->cap_nhap_anh('/public/avt/' .'av' . $id . '.' . $type , $id);
                $mess_av  = "Bạn đã cập nhập hình ảnh đại diện thành công.";
                $flag_err = 1;
                header("Refresh:0");
            } else {
                $mess_av  = "Tập tin tải lên không đúng với quy định.";
            }
        } else {
            $mess_av  =  "Bạn chưa nhập và tải lên tập tin hình ảnh của bạn.";
        }
    }

    /*  Xử lý thay đổi mật khẩu */
    if (isset($_POST['btn-change-pw'])) {
        $oldpass = $_POST['oldpass'];
        $newpass = $_POST['newpass'];
        $rppass = $_POST['rppass'];

        if ($oldpass != '' || $newpass != '' || $rppass !='') { // kiểm tra thông tin gửi lên không được rỗng
            if (password_verify($oldpass, $thong_tin->password)) { // kiểm tra đúng mật khẩu
                if ($newpass == $rppass) { // kiểm tra mật khẩu mới khớp với xác nhận mật khẩu
                    if ($newpass != $thong_tin->username) { // kiểm tra mật khẩu khác với username
                        if (strlen($newpass) > 6) {
                            $hashed = password_hash($newpass, PASSWORD_BCRYPT);
                            $xl_nguoi_dung->cap_nhao_mat_khau_theo_id($id,$hashed);
                            unset($_SESSION['thong_tin_user']);
                            header('location: http://localhost:8080/web/final/?page=redirect');
                        } else {
                            $mess_pw  =  "Mật khẩu mới phải có độ dài lớn hơn 7 ký tự";
                        }
                    } else {
                        $mess_pw  =  "Mật khẩu mói không được giống với username";
                    }
                } else {
                    $mess_pw  =  "Xác nhận lại mật khẩu chưa đúng.";
                }
            } else {
                $mess_pw  =  "Nhập mật khẩu cũ không đúng";
            }
            
        } else {
            $mess_pw  =  "Bạn chưa nhập tất cả các thông tin.";
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
            <div class="container mt-5 mb-5">
                <div class="row">
                    <!-- Hiển thị thông tin người dùng -->
                    <div class="col-sm-6 infor p-4">
                        <h3>
                            Thông tin người dùng
                        </h3>
                        <div class="mt-4">
                            <img src=".<?php echo($thong_tin->pic)?>" class="rounded mx-auto d-block avatar border border-success" alt="Hình ảnh đại diện">
                        </div>
                        <div class="mt-3">
                            <label for="exampleInputPassword1">Họ và tên</label>
                            <input type="text" class="form-control " id="exampleInputPassword1" value="<?php echo($thong_tin->fullName)?>" disabled>
                        </div>

                        <div class="mt-3">
                            <label for="exampleInputPassword1">Ngày sinh</label>
                            <input type="text" class="form-control " id="exampleInputPassword1" value="<?php echo($date)?>" disabled>
                        </div>

                        <div class="mt-3">
                            <label for="exampleInputPassword1">Giới tính</label>
                            <input type="text" class="form-control " id="exampleInputPassword1" value="<?php echo($thong_tin->gender)?>" disabled>
                        </div>

                        <div class="mt-3">
                            <label for="exampleInputPassword1">Phòng ban</label>
                            <input type="text" class="form-control " id="exampleInputPassword1" value="<?php echo($thong_tin->name)?>" disabled>
                        </div>

                        <div class="mt-3">
                            <label for="exampleInputPassword1">Chức vụ</label>
                            <input type="text" class="form-control " id="exampleInputPassword1" value="<?php echo($thong_tin->role)?>" disabled>
                        </div>
                    </div>

                    <div class="col-sm-6">

                        <div class="card w-100 shadow">
                            <div class="card-body">
                                <h3 class="card-title">Thao tác</h3>
                                <!-- Upload file để thay đổi ảnh đại diện -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="inputGroupFile01">Tải lên</label>
                                        <input name="avatar" accept="image/png, image/jpg, image/jpeg" type="file" class="form-control" id="inputGroupFile01" aria-describedby="uploadHelp">
                                        <small id="uploadHelp" class="form-text text-muted w-100">Chỉ tải lên tập tin có đuôi là .jpg , .jpeg và .png</small>
                                        <small id="uploadHelp" class="form-text text-muted w-100">Chỉ tải lên tập tin có dung lượng dưới 2MB</small>
                                    </div>
                                    <button type="submit" name="btn-update-av" class="btn btn-success">Thay đổi hình đại diện</button>
                                </form>
                                <button type="button"  class="btn btn-danger mt-3" data-toggle="modal" data-target="#exampleModal">
                                    Thay đổi mật khẩu
                                </button>

                                <!-- Modal change password -->
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content ">
                                            <form action="" method="post">
                                                <div class="modal-header text-white bg-danger">
                                                    <h3 class="modal-title" id="exampleModalLabel">Thay đổi mật khẩu</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Mật khẩu cũ</label>
                                                        <input type="password" class="form-control" id="exampleInputPassword1" name="oldpass">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Mật khẩu mới</label>
                                                        <input type="password" class="form-control" id="exampleInputPassword1" name="newpass">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputPassword1">Xác nhận mật khẩu mới</label>
                                                        <input type="password" class="form-control" id="exampleInputPassword1" name="rppass">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-danger" name="btn-change-pw">Đổi mật khẩu</button>
                                                </div>
                                            </form>
                                            <div class="m-3">
                                                <?php
                                                    hien_alert(0,$mess_pw);
                                                ?>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                           hien_alert($flag_err,$mess_av);
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php 
        if(isset($_POST['btn-change-pw'])) {
            echo("<script>$('.modal').modal('show')</script>");
        }
    ?>
</body>

</html>