<?php
    function encrypt($string){
        $number = 2;
        $new_string = $string;
    
        for($i = 0; $i < $number; $i++){
            $new_string = base64_encode($new_string);
        }
    
        return $new_string;
    }
    
    
    function decrypt($string){
        $number = 2;
        $new_string = $string;
    
        for($i = 0; $i < $number; $i++){
            $new_string = base64_decode($new_string);
        }
    
        return $new_string;
    }

    function format_time_ymd ($time) {
        return date('y-m-d H:i:s',strtotime($time));
    }

    function format_time_dmy ($time) {
        return date('d-m-y H:i:s',strtotime($time));
    }

    function hien_alert($flag_err,$mess) {
         /* show message */
        if ($mess != '') {
            ?>
                <div class="alert 
                    <?php 
                        if($flag_err == 0) {
                            echo('alert-warning');
                        } else {
                            echo('alert-success');
                        }
                    ?> 
                     alert-dismissible fade show mt-3" role="alert">
                    <strong>
                        <?php 
                            if($flag_err == 0) {
                                echo('Lỗi!');
                            } else {
                                echo('Chức mừng!');
                            }
                        ?>
                    </strong> <?php echo($mess)?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
        }
    }

    function hien_thi_tuong_tac_task ($arr, $role, $is_you, $fullname, $pic, $deadline, $role_now) {
        $fileName = '';
        if ($arr['file'] != '') {
            $fileName = explode('/', $arr['file']);
        }
      
        ?>
            <div class="<?php echo($is_you)?>">
                <div class="card mt-3" style="width: 70%;">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <div class="row">
                                <div class="col-sm-9">
                                    <img src="<?php echo('.' . $pic)?>" class=" circle-shadow">
                                    <?php echo($fullname)?>
                                </div>

                                <div class="col-sm-3 text-secondary font-time" >
                                    <?php echo(format_time_dmy($arr['time']))?>
                                </div>
                            </div>
                        </h5>
                        <p class="card-text"><?php echo($arr['comment'])?></p>
                        <div class="file-submit mt-1">
                            <?php
                                if ($fileName != '') {
                                    ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
                                            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
                                        </svg>
                                        <a class="text-secondary link-hover-black" href="./api/tai_file_trong_task.php/?file=<?php echo(urlencode($arr['file']))?>"><?php echo($fileName[count($fileName) - 1])?></a>
                                    <?php
                                }
                            ?>
                        </div>
                        <hr>
                        <div class="mt-1">
                            <div class="">Phản hồi
                                <?php
                                    if ($role_now == 'employee') {
                                        if ($is_you == 'you') {
                                            echo(' từ cấp trên');
                                        } else {
                                            echo(' của cấp trên');
                                        }
                                    } else {
                                        if ($is_you == 'you') {
                                            echo(' của bạn');
                                        } else {
                                            if ($role == 'employee') {
                                                echo(' trạng thái');
                                            } else {
                                                echo(' từ ' . $role);
                                            }     
                                        }
                                    }
                                ?>: <b class="upper">
                                <?php if($arr['status'] == 'waiting') {
                                    echo($arr['status'] . '...');
                                } else {
                                    echo($arr['status']);
                                }
                                ?></b>
                        </div>
                        </div>
                        <?php 
                            if ($role == 'employee') {
                                ?>
                                    <div class="mt-1">
                                        Trạng thái: <b><?php
                                            if ($arr['time'] > $deadline) {
                                                echo('Đã nộp trễ');
                                            } else {
                                                echo('Nộp đúng hạn');
                                            }
                                        ?></b>
                                    </div>
                                <?php
                            }
                        ?>
                        <small id="uploadHelp" class="form-text text-muted w-100">Được gửi bởi <?php 
                            if ($is_you == 'you') {
                                echo('bạn');
                            } else {
                                echo($role);
                            }
                        ?>
                        </small>
                    </div>
                </div>
            </div>
        <?php
    }

    function hien_thi_theo_tac_task_cho_user ($status, $role) {
        if ($role == "employee") {
            if ($status == 'new') {
                ?>
                    <p>
                        Hãy nhấn nút "<b class="text-success">bắt đầu tiến hành</b>" để tiến hành nhận công việc
                    </p>
                    <form action="" method="post">
                        <button type="submit" class="btn btn-success" name="btn-start-task">BẮT ĐẦU TIẾN HÀNH</button>
                    </form>
                <?php
            } else if ($status == 'canceled') {
                ?>
                    <p>
                        Công việc đã bị hủy bởi <b class="text-danger">CẤP TRÊN</b>
                    </p>
                    <button type="button" class="btn btn-danger" id="redirect">QUAY VỀ DASHBOARD</button>
                <?php
            } else if ($status == 'completed') {
                ?>
                    <p>
                        <div class="row">
                            
                            <div class="col-sm-2">
                                <img class="w-100 h-100" src="./public/images/task_finish.png" alt="finish">
                            </div>

                            <div class="col-sm-10 text-success mt-2">
                                <b>Xin chúc mừng!</b> Bạn đã hoàn thành công việc
                            </div>
                            
                        </div>
                    </p>
                    <button type="button" class="btn btn-success" id="redirect">QUAY VỀ DASHBOARD</button>
                <?php
            } else if ($status == 'waiting') {
                ?>
                <p class="">
                    Đang đợi duyệt từ <b class="text-warning">CẤP TRÊN...</b>
                </p>
                <button type="button" class="btn btn-warning" id="redirect">QUAY VỀ DASHBOARD</button>
            <?php
            } else {
                ?>
                    <form action="" id="form-upload" method="post" enctype="multipart/form-data">
                        <h3 class="card-title">Hoàn thành công việc</h3>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="fileSubmit">Tải lên</label>
                            <input type="file" class="form-control" id="fileSubmit" aria-describedby="uploadHelp">
                            <small id="uploadHelp" class="form-text text-muted w-100">Dung lượng của tập tin phải nhỏ hơn hoặc bằng 1GB</small>
                        </div>
                        <div class="form-floating">
                            <label for="comment">Comments</label>
                            <textarea class="form-control" placeholder="Bình luận tại đây" id="comment" style="height: 200px" ></textarea>
                            <div class="progress mt-3">
                                <div id="progressBar" class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                        <button id="btn-submit-task" type="submit" class="btn btn-primary mt-3" style="width: 120px;" >Nộp</button>
                    </form>
                       
                <?php
            }
        } else {
            if ($status == 'new') {
                ?>
                    <p>
                        Công việc <b class="text-danger">chưa được nhân viên bắt đầu</b>, bạn có thể hủy công việc này!
                    </p>
                    <button type="button" class="btn btn-primary" id="redirect">QUAY VỀ DASHBOARD</button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#staticBackdrop">HỦY CÔNG VIỆC</button>
                <?php
            } else if ($status == 'canceled') {
                ?>
                    <p>
                        Công việc đã bị hủy bởi <b class="text-danger">TRƯỞNG PHÒNG HOẶC GIÁM ĐỐC</b>
                    </p>
                    <button type="button" class="btn btn-danger" id="redirect">QUAY VỀ DASHBOARD</button>
                <?php
            } else if ($status == 'waiting') {
                ?>
                    <form action="" id="form-feedback" method="post" enctype="multipart/form-data">
                        <h3 class="card-title">Phản hồi tới nhân viên</h3>
                        <p>
                            Nhân viên đã gửi tập tin hoàn thành công việc. Hãy phản hồi cho nhân viên
                        </p>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="fileSubmit">Tải lên</label>
                            <input type="file" class="form-control" id="fileSubmit" aria-describedby="uploadHelp">
                            <small id="uploadHelp" class="form-text text-muted w-100">Dung lượng của tập tin phải nhỏ hơn hoặc bằng 1GB</small>
                        </div>
                        <div class="form-floating">
                            <label for="comment">Comments</label>
                            <textarea class="form-control" placeholder="Bình luận tại đây" id="comment" style="height: 200px" ></textarea>
                            
                            <div class="progress mt-3">
                                <div id="progressBar" class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                        <button id="btn-reject-task" type="submit" class="btn btn-danger mt-3" style="width: 120px;" name="btn-reject-task">Từ chối</button>
                        <button id="btn-success-task" type="submit" class="btn btn-success mt-3" style="width: 150px;" name="btn-success-task">Hoàn thành</button>
                    </form>
                <?php
            } else if ($status == "completed"){
                ?>
                    <p>
                        <div class="row">
                            <div class="col-sm-2">
                                <img class="w-100 h-100" src="./public/images/task_finish.png" alt="finish">
                            </div>
                            <div class="col-sm-10 text-success mt-2">
                                Công việc đã được <b>nhân viên</b> hoàn thành.
                            </div>
                        </div>
                    </p>
                    <button type="button" class="btn btn-success" id="redirect">QUAY VỀ DASHBOARD</button>
                <?php
            } else {
                ?>
                    <p>
                        Công việc <b class="text-primary">đang được nhân viên hoàn thành</b>.
                    </p>
                    <button type="button" class="btn btn-primary" id="redirect">QUAY VỀ DASHBOARD</button>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#staticBackdrop">Thay đổi thời gian nộp</button> 
                <?php
            }
            
        }
    }

    function in_hang_trong_don_nghi_phep ($isbutton, $arr) {
        include_once('./model/xl_nguoi_dung.php');
        $xl_nguoi_dung = new xl_nguoi_dung();
        $i = 0;
        foreach ($arr as $el) {
            $i += 1;
            ?>
                <tr>
                    <?php

                        echo('<th>'.$i.'</th>');
                        foreach($el  as $key => $val) {
                            if ($key == 'user_created') {
                                $infor = $xl_nguoi_dung->thong_tin_nguoi_dung_theo_id_tai_khoan($val);
                                echo('<td>'.$infor->fullName.'</td>');
                            } else  if( $key == 'id' ) {
                                continue;
                            } else if ($key == 'fullName'){
                                break;
                            } else if (($key == 'status' || $key == 'responder' || $key == 'feelback') && $isbutton == true){
                                break;
                            } else if ($val == '') {
                                echo('<td>'.'<b class="text-warning">WAITING...</b>'.'</td>');
                            } else {
                                if ($key == 'status') {
                                    if ($val == 'đồng ý') {
                                        echo('<td>'.'<b class="text-success">ĐỒNG Ý</b>'.'</td>');
                                    } else {
                                        echo('<td>'.'<b class="text-danger">TỪ CHỐI</b>'.'</td>');
                                    }
                                } else {
                                    echo('<td>'.$val.'</td>');
                                }
                            }
                        }
                        if($isbutton) {
                            ?>
                                <form action="" method="post" id="form-letter">
                                    <td>
                                        <textarea id="feelback-letter" name="feelback-letter" class="form-control" rows="3" placeholder="Nhập phản hồi để gửi thao tác"></textarea>
                                    </td>
                                    <td>
                                        <div class="btn-group rounded" role="group">
                                            <input type="text" value="<?php echo(encrypt($el['id']))?>" name="id-letter" style="display:none">
                                            <button name="btn-accept-letter" type="submit" class="btn btn-success rounded-left">Đồng ý</button>
                                            <button name="btn-deny-letter" type="submit" class="btn btn-danger rounded-right">Từ chối</button>
                                        </div>
                                    </td>
                                </form>
                            <?php
                        }
                    ?>
                </tr>

            <?php
        }
    }

    function in_task_dashboard ($status,$name,$summary,$id_task) {
        ?>
            <div class="col-sm-3 mt-3 " >
                <div class="card he-default shadow-sm">
                    <h5 class="card-header <?php
                        if ($status == "new") {
                            echo('bg-orange');
                        } else if ($status == "in progress") {
                            echo('bg-primary');
                        } else if ($status == "completed") {
                            echo('bg-success');
                        } else if ($status == "reject") {
                            echo('bg-danger');
                        } else if ($status == "waiting") {
                            echo('bg-warning');
                        } else {
                            echo('bg-secondary');
                        }
                    ?>">
                        <b><?php echo ($name) ?></b>
                    </h5>
                    <div class="card-body">
                        <p class="card-text">
                            <?php echo ($summary)?>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href=<?php echo("./?page=detail&id=" . encrypt($id_task))?> class="btn btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            </div>
        <?php
    }
?>