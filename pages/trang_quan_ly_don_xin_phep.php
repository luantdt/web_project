<?php
    $thong_thin_user = $_SESSION['thong_tin_user'];
    include_once('./model/xl_don_nghi_phep.php');
    include_once('./model/xl_nguoi_dung.php');
    $xl_don_nghi_phep = new xl_don_nghi_phep();
    $xl_nguoi_dung = new xl_nguoi_dung();

    if (isset($_POST['btn-accept-letter']) || isset($_POST['btn-deny-letter'])) {
        if ( isset($_POST['id-letter']) && $_POST['id-letter'] != '' && isset($_POST['feelback-letter']) && $_POST['feelback-letter'] != '') {
            $id_letter = decrypt($_POST['id-letter']);
            if(is_numeric($id_letter)) {
                if(isset($_POST['btn-accept-letter'])) {
                    $xl_don_nghi_phep->cap_phep_don_xin_phep_bang_id($id_letter, 'đồng ý', $_POST['feelback-letter'], $thong_thin_user->role);
                    
                } else {
                    
                    $xl_don_nghi_phep->cap_phep_don_xin_phep_bang_id($id_letter, 'từ chối', $_POST['feelback-letter'], $thong_thin_user->role);
                }
                
                header("Refresh:0"); 
            } else {
                echo json_encode(
                    array(
                        'error' => true,
                        'message' => 'Your letter does not exist',
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

    if (isset($_POST['btn-send-letter'])) {
        if ( isset($_POST['start-date']) && $_POST['start-date'] != '' && isset($_POST['your-reason']) && $_POST['your-reason'] != '' && isset($_POST['start-date']) && $_POST['start-date'] != '') { 
            if (strtotime($_POST['start-date']) < strtotime($_POST['end-date'])) {
                $xl_don_nghi_phep->them_ngay_nghi_phep($_POST['start-date'], $_POST['end-date'], $_POST['your-reason'], $thong_thin_user->id);
                header("Refresh:0"); 
            } else {
                echo json_encode(
                    array(
                        'error' => true,
                        'message' => 'your date is invalid',
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
    $my_letter_review = $xl_don_nghi_phep->hien_thi_don_da_duyet_theo_my_id($thong_thin_user->id);
    $my_letter_not_review = $xl_don_nghi_phep->hien_thi_don_chua_duyet_theo_my_id($thong_thin_user->id);
    $all_not_review = $xl_don_nghi_phep->hien_thi_don_nghi_phep_chua_cap_phep();
    $all_reviewed = $xl_don_nghi_phep->hien_thi_don_nghi_phep_da_cap_phep();

    $tmp_not = $xl_don_nghi_phep->hien_thi_tat_ca_don_nghi_phep_chua_hoac_da_duyet_tru_mot_id(false,$thong_thin_user->id);
    $tmp_yes = $xl_don_nghi_phep->hien_thi_tat_ca_don_nghi_phep_chua_hoac_da_duyet_tru_mot_id(true,$thong_thin_user->id);

    $not_review = [];
    $reviewed = [];

    foreach ($tmp_not as $el) {
        $infor_employee = $xl_nguoi_dung->thong_tin_nguoi_dung_theo_id_tai_khoan($el['user_created']);
        if ($infor_employee->department_id == $thong_thin_user->department_id) {
            array_push($not_review, $el);
        }
    }
    foreach ($tmp_yes as $el) {
        $infor_employee = $xl_nguoi_dung->thong_tin_nguoi_dung_theo_id_tai_khoan($el['user_created']);
        if ($infor_employee->department_id == $thong_thin_user->department_id) {
            array_push($reviewed, $el);
        }
    }
    
?>

<div class="row h-100">
    <div class="col-sm-2 bg-func shadow">
        <?php
            include_once("./modules/hien_thi_chuc_nang.php");
        ?>
    </div>
    <div class="col-sm-10 mt-3">
        <div class="container-fluid">
            <?php
                if($thong_thin_user->role != 'admin') {
                    ?>
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Tạo đơn xin nghỉ phép</button>
                        </div>
                    <?php
                }
            ?>
            <?php
                if ($thong_thin_user->role == 'leader' ||$thong_thin_user->role == 'employee') {
                    ?>
                        <div>
                            <h3>
                                Đơn xin phép của bạn
                            </h3>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" >#</th>
                                        <th scope="col" >Họ và tên</th>
                                        <th scope="col" >Ngày bắt đầu</th>
                                        <th scope="col" >Ngày kết thúc</th>
                                        <th scope="col" >Lý do</th>
                                        <th scope="col" >Trạng thái</th>
                                        <th scope="col" >Phản hồi</th>
                                        <th scope="col" >Người duyệt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        in_hang_trong_don_nghi_phep(false, $my_letter_review);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <h3>
                                Đơn xin phép của bạn đang chờ duyệt
                            </h3>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" >#</th>
                                        <th scope="col" >Họ và tên</th>
                                        <th scope="col" >Ngày bắt đầu</th>
                                        <th scope="col" >Ngày kết thúc</th>
                                        <th scope="col" >Lý do</th>
                                        <th scope="col" >Trạng thái</th>
                                        <th scope="col" >Phản hồi</th>
                                        <th scope="col" >Người duyệt</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        in_hang_trong_don_nghi_phep(false, $my_letter_not_review);
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                }
            ?>
            
                
            <?php
                if ($thong_thin_user->role == 'leader' || $thong_thin_user->role == 'admin') {
                    ?>
                        <div class="mt-4">
                            <h3>
                                Đơn xin phép cần duyệt
                            </h3>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Họ và tên</th>
                                        <th scope="col">Ngày bắt đầu</th>
                                        <th scope="col">Ngày kết thúc</th>
                                        <th scope="col" class="col-2">Lý do</th>
                                        <th scope="col" class="col-3">Phản hồi</th>
                                        <th scope="col" class="col-2">Thao tác</th>     
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if ($thong_thin_user->role == 'leader') {
                                            in_hang_trong_don_nghi_phep(true, $not_review);
                                        }
                                        if ($thong_thin_user->role == 'admin') {
                                            in_hang_trong_don_nghi_phep(true, $all_not_review);
                                        } 
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <h3>
                                Đơn xin phép của nhân viên
                            </h3>
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Họ và tên</th>
                                        <th scope="col">Ngày bắt đầu</th>
                                        <th scope="col">Ngày kết thúc</th>
                                        <th scope="col" class="col-4">Lý do</th>
                                        <th scope="col" >Trạng thái</th>
                                        <th scope="col" >Phản hồi</th>
                                        <th scope="col" >Người duyệt</th>
                                    </tr>
                                </thead>
                                <tbody>  
                                    <?php
                                        if ($thong_thin_user->role == 'leader') {
                                            in_hang_trong_don_nghi_phep(false, $reviewed);
                                        }
                                        if ($thong_thin_user->role == 'admin') {
                                            in_hang_trong_don_nghi_phep(false, $all_reviewed);
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>
<?php
    if($thong_thin_user->role != 'admin') {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">+ Thêm ngày nghỉ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="form-send-letter">
                    <div class="modal-body">
                        <div class="mt-2">
                            <label for="start-date">Thời gian bắt đầu</label>
                            <input type="date" class="form-control" id="start-date" name="start-date">
                        </div>
                        <div class="mt-2">
                            <label for="end-date">Thời gian kết thúc</label>
                            <input type="date" class="form-control" id="end-date" name="end-date">
                        </div>
                        <div class="mt-2">
                            <label for="your-reason">Lý do</label>
                            <textarea class="form-control" id="your-reason" name="your-reason" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" name="btn-send-letter">Gửi</button>
                    </div>
                    </div>
                </form>
            </div>
            </div>
        <?php
    }
?>

</body>
</html>