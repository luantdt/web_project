<?php
    $thong_thin_user = $_SESSION['thong_tin_user'];
    include_once('./model/xl_don_nghi_phep.php');
    $xl_don_nghi_phep = new xl_don_nghi_phep();

    $my_letter_review = $xl_don_nghi_phep->hien_thi_don_da_duyet_theo_my_id($thong_thin_user->id);
    $my_letter_not_review = $xl_don_nghi_phep->hien_thi_don_chua_duyet_theo_my_id($thong_thin_user->id);
    $not_review = $xl_don_nghi_phep->hien_thi_don_chua_duyet_theo_phong_ban_tru_truong_phong(true,$thong_thin_user->department_id,$thong_thin_user->id);
    $reviewed = $xl_don_nghi_phep->hien_thi_don_chua_duyet_theo_phong_ban_tru_truong_phong(false,$thong_thin_user->department_id,$thong_thin_user->id);
    $all_not_review = $xl_don_nghi_phep->hien_thi_don_nghi_phep_chua_cap_phep();
    $all_reviewed = $xl_don_nghi_phep->hien_thi_don_nghi_phep_da_cap_phep();
?>

<div class="row h-100">
    <div class="col-sm-2 bg-func shadow">
        <?php
            include_once("./modules/hien_thi_chuc_nang.php");
        ?>
    </div>
    <div class="col-sm-10 mt-3">
        <div class="container-fluid">
            <div class="text-center mt-3">
                <button type="button" class="btn btn-primary">Tạo đơn xin nghỉ phép</button>
            </div>
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
                                        <th scope="col" class="col-5">Lý do</th>
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