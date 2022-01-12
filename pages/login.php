<?php
    if(isset($_SESSION['thong_tin_user'])){
      header('location: ./?page=dashboard');
      die();
    }
    if(isset($_POST['username']) && isset($_POST['password'])){
        //xử lý đăng nhập
        $tai_khoan = $_POST['username'];
        $mat_khau = $_POST['password'];
        include_once('./model/xl_nguoi_dung.php');
        
        $xl_nguoi_dung = new xl_nguoi_dung();
        $nguoi_dung = $xl_nguoi_dung->thong_tin_nguoi_dung_theo_tai_khoan($tai_khoan);

        if($nguoi_dung) {
            if(password_verify($mat_khau, $nguoi_dung->password)){//đúng mật khẩu
                echo 'Login successfull';
                /* if($_POST['remember']){
                    setcookie("thong_tin_user_cookie", $nguoi_dung->tai_khoan, time()+3600);
                }
                else{
                    $_SESSION['thong_tin_user'] = $nguoi_dung;
                } */
                $_SESSION['thong_tin_user'] = $nguoi_dung;
                header('location: /web/final/?page=dashboard');
            }
            else {
                echo 'tài khoản hoặc mật khẩu không hợp lệ';
            }
        }
        else {
            echo 'alert("Tai khoan chua duoc tao")';
        }
    }
?>
<body>
	<header>
		<nav>
			<h1>Company management</h1>
		</nav>
	</header>
	<div class="divider"></div>

	<div class="card mx-auto" style="width: 30rem;">
		<!-- <img class="card-img-top mx-auto" style="width:60%;" src="./images/login.png" alt="Login Icon"> -->
		<div class="card-body">
			
		  <form action="" method="POST">
			<div class="form-group">
			  <label>Username</label>
			  <input type="text" class="form-control" name="username" placeholder="Enter username" required="required">
			</div>
			<div class="form-group">
			  <label>Password</label>
			  <input type="password" class="form-control" name="password" placeholder="Enter password" required="required">
				<!-- <small id="p_error" class="form-text text-muted"></small> -->
			</div>
			<input type="submit" class="btn btn-primary" name="login-submit" value="Login">
		  </form>
		</div>
	  </div>			
</body>
</html>