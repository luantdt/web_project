    
    <div class="container">
        <div class="card mb-3 shadow p-5 success-pw-alert" style="max-width: 100%; margin-top: 20%;">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="./public/images/ok.png" alt="OK" class="w-100 h-100">
                </div>
                <div class="col-md-8">
                    <?php
                        if (isset($_GET['func'])) {
                            if ($_GET['func'] == 'log-out') {
                                ?>
                                    <div class="card-body">
                                        <h3 class="card-title text-success"><b>Thành công!</b></h3>
                                        <p class="card-text">
                                            Đăng xuất tài khoản thành công, bạn sẽ được chuyển hướng đến trang đăng nhập trong 
                                            <b class="count-down">5</b> 
                                            giây nữa.
                                        </p>
                                        <button type="button" class="btn btn-success redirect-login">Đăng nhập lại ngay</button>
                                    </div>
                                <?php
                            }
                        } else {
                            ?>
                                <div class="card-body">
                                    <h3 class="card-title text-success"><b>Chức mừng!</b></h3>
                                    <p class="card-text">
                                        Bạn đã thay đổi mật khẩu thành công. Bạn sẽ phải đăng nhập vào tài khoản trong 
                                        <b class="count-down">5</b> 
                                        giây nữa.
                                    </p>
                                    <button type="button" class="btn btn-success redirect-login">Đăng nhập lại ngay</button>
                                </div>
                            <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>