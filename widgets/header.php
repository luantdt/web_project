<?php
    $name = $_SESSION['thong_tin_user']->fullName;
    
    if (isset($_GET['func'])) {
        $func = $_GET['func'];

        if ($func =="logout") {
            unset($_SESSION['thong_tin_user']);
            header('location: http://localhost:8080/web/final/?page=redirect&func=log-out');
        } else {
            header('location: http://localhost:8080/web/final/?page=404');
        }
    }
?>

<body>
    <div class="col-sm-12 nav shadow ">
        <div class="name text-header col-sm-2">
            <a href="http://localhost:8080/web/final/?page=dashboard">
                conpanyADMIN
            </a>
        </div>

        <div class="col-sm-7"></div>
        <div class="col-sm-3 center-center-row-flex">
            <div class="usname fs-25 ">
                <a href="http://localhost:8080/web/final/?page=infor" class="hover-red">
                    <?php
                        echo($name)
                    ?>
                </a>
            </div>
            <div class="log-out fs-25 ml-3">
                <div class="">
                    <a href="http://localhost:8080/web/final/?page=404&func=logout" class="hover-red">
                        LOG OUT
                    </a>
                </div>
            </div>
        </div>
    </div>