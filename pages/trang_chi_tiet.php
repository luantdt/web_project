<?php
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header('location: ./?page=404');
    }

    $id = decrypt($_GET['id']);
    if(!$id || !is_numeric($id)) {
        header('location: ./?page=404');
    }
    include_once('./model/xl_task.php');
    $xl_task = new xl_task();
    $cong_viec = $xl_task->hien_thi_cong_viec_theo_id($id);

    if ($_SESSION['thong_tin_user']->id != $cong_viec->user_id) {
        if ($_SESSION['thong_tin_user']->role == 'employee') {
            header('location: ./?page=404');
        }
    }

    // Xử lý file từ employee
    if (isset($_FILES['file']) && $_FILES['file']['tmp_name'] != '') {
        $f = $_FILES['file'];
        $name = $f['name']; 
        $tmp = $f['tmp_name'];
        $size = $f['size'];
    
        if ($size > 1 * 1024 * 1024 * 1024) {
            echo json_encode(
                array(
                    'error' => true,
                    'message' => 'File size exceeds the allowed limit',
                )
            );
        } else {
            $dest = '/public/task/' . $name;
            if (file_exists($dest)) {
                $arr = explode('.',$name);
                $type = array_pop($arr);
                $nname = $arr[0];

                $dest = '/public/task/'. $nname . '(new)' . '.' .$type;
            }

            move_uploaded_file($tmp, $_SERVER["DOCUMENT_ROOT"].' /web_project'.$dest);
            $mess = '';
            if ($_POST['comment']) {
                $mess = $_POST['comment'];
            }
            $xl_task->cap_nhap_trang_thai_task($id,'waiting');
            $xl_task->nhap_thong_tin_tuong_tac_task($id, $dest , $mess, $_SESSION['thong_tin_user']->id, 'waiting');

            echo json_encode(
                array(
                    'error' => false,
                    'message' => 'Upload file is successfull',
                )
            );
        }
        die();
    }

    // Xử lý file từ cấp trên
    if (isset($_POST['btnClick']) && $_POST['btnClick'] != '') {
        if (isset($_POST['comment_fb']) && $_POST['comment_fb'] != '') {
            // chuyển file nếu có, không thì bỏ qua
            $dest = "";
            if (isset($_FILES['file_fb']) && $_FILES['file_fb']['tmp_name'] != '') {
                $f = $_FILES['file_fb'];
                $name = $f['name']; 
                $tmp = $f['tmp_name'];
                $size = $f['size'];

                if ($size > 1 * 1024 * 1024 * 1024) {
                    echo json_encode(
                        array(
                            'error' => true,
                            'message' => 'File size exceeds the allowed limit',
                        )
                    );
                } else {
                    $dest = '/public/task/' . $name;
                    if (file_exists($dest)) {
                        $arr = explode('.',$name);
                        $type = array_pop($arr);
                        $nname = $arr[0];
        
                        $dest = '/public/task/'. $nname . '(new)' . '.' .$type;
                    }
                    move_uploaded_file($tmp, $_SERVER["DOCUMENT_ROOT"].'/web_project'.$dest);
                }
            }
            $mess = $_POST['comment_fb'];
            $fb = '';
            if ($_POST['btnClick'] == 'reject') {
                $fb = 'reject';
            } else {
                $fb = 'completed';
            }
            $xl_task->nhap_thong_tin_tuong_tac_task($id, $dest, $mess, $_SESSION['thong_tin_user']->id, $fb);
            $xl_task->cap_nhap_trang_thai_task($id, $fb);
            $xl_task->cap_nhap_trang_thai_tuong_tac_task($id, 'waiting', $fb);
            echo json_encode(
                array(
                    'error' => false,
                    'message' => 'Upload file is successfull',
                )
            );
        } else {
            echo json_encode (
                array(
                    'error' => true,
                    'message' => 'Message does not exist'
                )
            );
        }

        die();
    }

    if (isset($_POST['btn-start-task'])) {
        $xl_task->cap_nhap_trang_thai_task($id,"in progress");
        $cong_viec = $xl_task->hien_thi_cong_viec_theo_id($id);
    }

    // xử lý thay đổi thời gian end_time
    $mess_err_change_time = '';
    if (isset($_POST['btn-change-end-time'])) {
        if (isset($_POST['end-time-change']) && isset($_POST['id-task'])) { 
            if ($_POST['end-time-change'] != '' && $_POST['id-task'] != '') {
                $time_format = format_time_ymd($_POST['end-time-change']);
                $id_task = decrypt($_POST['id-task']);
                
                $xl_task->thay_doi_thoi_gian_het_han($id_task, $time_format); 
                header("Refresh:0"); 
            } else {
                $mess_err_change_time  =  "Thông tin không được để trống";
            }
        } else {
            echo json_encode (
                array(
                    'error' => true,
                    'message' => 'Information is invalid'
                )
            );
            die();
        }
    }

    if (isset($_POST['btn-cancel-task'])) {
        if (isset($_POST['id-task'])) {
            if ($_POST['id-task'] != '') {
                $id_task = decrypt($_POST['id-task']);
                $xl_task->cap_nhap_trang_thai_task($id_task, 'canceled');
                header("Refresh:0");
            } else {
                echo json_encode (
                    array(
                        'error' => true,
                        'message' => 'Information is invalid'
                    )
                );
                die();
            }
        } else {
            echo json_encode (
                array(
                    'error' => true,
                    'message' => 'Information is invalid'
                )
            );
            die();
        }
    }

    $res_task = $xl_task->hien_thi_tat_ca_thong_tin_nop_task($id);
    include_once('./model/xl_nguoi_dung.php');
    $xl_nguoi_dung = new xl_nguoi_dung();
    $thong_tin_nguoi_tao = $xl_nguoi_dung->thong_tin_nguoi_dung_theo_id_tai_khoan($cong_viec->user_created);
?>

<div class="container-fluid p-5">
    <div class="row">
        <div class="col-sm-8 ">
            <div class="title">
                <div class="row">
                    <div class="col-sm-12">
                        <h3>
                            <?php
                                echo($cong_viec->name);
                            ?>
                        </h3>
                    </div>
                    <div class="col-sm-6 date">
                        <?php
                            echo(format_time_dmy($cong_viec->creation_time));
                        ?>
                    </div>
                    <div class="col-sm-6 deadline">
                        <?php
                            echo("Đến hạn ". format_time_dmy($cong_viec->end_time));
                        ?>
                    </div>
                </div>
            </div>
            <div class="detail fs-23 mt-3 ">
                <?php
                    echo($cong_viec->description);
                ?>

            </div>
            <hr>
            <div class="mt-1">
                Người tạo: <b><?php echo($thong_tin_nguoi_tao->fullName)?></b>
            </div>
            <div class="mt-1">
                Văn phòng: <b><?php echo($thong_tin_nguoi_tao->name)?></b>
            </div>
            <div class="mt-1">
                Chức vụ: <b><?php echo($thong_tin_nguoi_tao->role)?></b>
            </div>
            <div class="mt-1">
                Đã tạo vào: <b><?php echo(format_time_dmy($cong_viec->creation_time))?></b>
            </div>
            <div class="history mt-4">
                <div class="title">
                    <h3>
                        Lịch sử tương tác
                    </h3>
                </div>
                <div class="history-line">

                    <?php 
                        foreach ($res_task as $value) {
                            $thong_tin = $xl_nguoi_dung->thong_tin_nguoi_dung_theo_id_tai_khoan($value['user_id']);
                            $margin = '';
                            if($value['user_id'] == $_SESSION['thong_tin_user']->id ) {
                                $margin = 'you';
                            } else {
                                $margin = 'some-one';
                            }
                            hien_thi_tuong_tac_task($value,$thong_tin->role, $margin, $thong_tin->fullName,$thong_tin->pic, $cong_viec->end_time, $_SESSION['thong_tin_user']->role);
                        }
                    ?>

                </div> 
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card w-100 shadow">
                <div class="card-body">
            <?php
                hien_thi_theo_tac_task_cho_user($cong_viec->status, $_SESSION['thong_tin_user']->role);        
            ?>
                </div>
            </div>
            <div class="box-err"></div>
        </div>
    </div>
</div>
<?php
    if ($_SESSION['thong_tin_user']->role != 'employee') {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h3 class="modal-title text-white" id="staticBackdropLabel"><?php 
                            if ($cong_viec->status == 'new') {
                                echo('Chú ý');
                            } else {
                                echo('Thay đổi thời gian hết hạn');
                            }
                        ?></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                        if ($cong_viec->status == 'new') {
                            ?>
                                <form action="" method="post">
                                    <div class="modal-body">
                                        <div class="mt-2 text-danger">
                                            <b>
                                                Bạn có chắc chắn muốn cancel công việc này?
                                            </b>
                                        </div>
                                        <input type="text" value="<?php echo($_GET['id'])?>" style="display: none" name="id-task">
                                    </div>
                                    <div class="modal-footer">
                                        <?php
                                            if ($cong_viec->status == 'new') {
                                                ?>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                                                    <button type="submit" class="btn btn-primary" name="btn-cancel-task">Có</button>
                                                <?php
                                            } else {
                                                ?>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="btn-cancel-task">Thay đổi</button>
                                                <?php
                                            }
                                        ?>
                                        
                                    </div>
                                    <div class="m-3">
                                        <?php
                                            if ($mess_err_change_time != '') {
                                                hien_alert(0,$mess_err_change_time);
                                            }
                                        ?>
                                    </div> 
                                </form>
                            <?php
                        }  else {
                            ?>
                                <form action="" method="post">
                                    <div class="modal-body">
                                        <div class="mt-2">
                                            <label for="end-time-change">Thời gian hết hạn</label>
                                            <input name="end-time-change" id="end-time-change" class="form-control" type="datetime-local">
                                        </div>
                                        <input type="text" value="<?php echo($_GET['id'])?>" style="display: none" name="id-task">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="btn-change-end-time">Thay đổi</button>
                                    </div>
                                    <div class="m-3">
                                        <?php
                                            if ($mess_err_change_time != '') {
                                                hien_alert(0,$mess_err_change_time);
                                            }
                                        ?>
                                    </div> 
                                </form>
                            <?php
                        }
                    ?>
                    </div>
                </div>

            </div>
        <?php
        if(isset($_POST['btn-change-end-time'])) {
            echo("<script>$('.modal').modal('show')</script>");
        }
    }
?>