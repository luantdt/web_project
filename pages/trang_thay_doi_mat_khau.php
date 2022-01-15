<?php 
    $thong_tin_user = $_SESSION['thong_tin_user'];
    include_once('./model/xl_nguoi_dung.php');
    $xl_nguoi_dung = new xl_nguoi_dung();
    if(isset($_POST['change-pwd-access'])) {
        if (isset($_POST['new-passowrd']) && $_POST['new-passowrd'] != '' && isset($_POST['new-re-passowrd']) && $_POST['new-re-passowrd'] != '') {
            if ($_POST['new-passowrd'] == $_POST['new-re-passowrd']) {
                $hashed = password_hash($_POST['new-passowrd'], PASSWORD_BCRYPT);
                $xl_nguoi_dung->cap_nhao_mat_khau_theo_id($thong_tin_user->id, $hashed); 
                unset($_SESSION['thong_tin_user']);
                header('location: ./?page=redirect');
            } else {
                echo json_encode(
                    array(
                        'error' => true,
                        'message' => 'password and repeat password are not the same',
                    )
                );
                die();
            }
        } else {
            echo json_encode(
                array(
                    'error' => true,
                    'message' => 'Information is invalid',
                )
            );
            die();
        }
    }
?>
<body>
    <div class="container">
        
        <div class="col-sm-12 m-5 text-center">
            <div class="">
                <img src="<?php echo('.'.$thong_tin_user->pic)?>" class="circle-shadow-lg">
            </div>
            <div class="m-3">
                <h3>
                    Xin chào <b class="text-success"><?php echo($thong_tin_user->fullName)?></b>
                </h3>
            </div>
            <div class="m-3">
           
                Bạn cần phải thay đổi mật khẩu để có thể tiếp tục truy cập website
            
            </div>
        </div>
        <div class="col-sm-12 m-5">
            <div class="card shadow " style="width: 100%;">
                <div class="card-body">

                    <form action="" method="post" id="change-pwd-access">
                        <div class="form-group">
                            <label for="new-passowrd">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="new-passowrd" name="new-passowrd">
                        </div>
                        <div class="form-group">
                            <label for="new-re-passowrd">Xác nhận mật khẩu mới</label>
                            <input type="password" class="form-control" id="new-re-passowrd" name="new-re-passowrd">
                        </div>
                        <button type="submit" class="btn btn-primary" name="change-pwd-access">Thay đổi mật khẩu</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>