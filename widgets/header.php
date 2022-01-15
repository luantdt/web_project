<?php
    if (isset($_GET['func'])) {
        $func = $_GET['func'];

        if ($func =="logout") {
            unset($_SESSION['thong_tin_user']);
            header('location: ./?page=redirect&func=log-out');
        } else {
            header('location: ./?page=404');
        }
    }
    $check = password_verify($_SESSION['thong_tin_user']->username, $_SESSION['thong_tin_user']->password);
    if ($check) {
        header('location: ./?page=changpwd');
    }
?>
<body>
    <div class="col-sm-12 nav shadow ">
        <div class="name text-header col-sm-2">
            <a href="./?page=dashboard">
                conpanyADMIN
            </a>
        </div>

        <div class="col-sm-6"></div>
        <div class="col-sm-4 center-center-row-flex">
            <div class="usname fs-25 ">
                <a href="./?page=infor" class="hover-red">
                    <img src="<?php echo('.' . $_SESSION['thong_tin_user']->pic)?>" class=" circle-shadow">
                    <?php
                        echo($_SESSION['thong_tin_user']->fullName);
                    ?>
                </a>
            </div>
            <div class="log-out fs-25 ml-3">
                <div class="">
                    <a href="./?page=404&func=logout" class="hover-red">
                        LOG OUT
                    </a>
                </div>
            </div>
        </div>
    </div>