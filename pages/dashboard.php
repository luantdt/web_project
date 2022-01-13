
<?php
    $thong_thin_user = $_SESSION['thong_tin_user'];
    include_once('./model/xl_nguoi_dung.php');
    include_once('./model/xl_task.php');
    $xl_task = new xl_task();
    $xl_nguoi_dung = new xl_nguoi_dung();
    $user_department = $xl_nguoi_dung->hien_thi_thong_tin_user_theo_department_id($thong_thin_user->department_id);
    
    $mess_err_task = '';
    if(isset($_POST['btn-add-task'])) {
        if (isset($_POST['name_task']) && isset($_POST['sumary_task']) && isset($_POST['descript_task']) && isset($_POST['end_time']) && isset($_POST['select_user'])) {
            if ($_POST['name_task'] != '' && $_POST['sumary_task'] != '' && $_POST['descript_task'] != '' && $_POST['end_time'] != '' && $_POST['select_user'] != '') {
                $select_id = explode(' - ', $_POST['select_user']);
                $end_time = format_time($_POST['end_time']);

                $xl_task->them_task_moi ($_POST['name_task'], $_POST['sumary_task'], $_POST['descript_task'], $end_time, $select_id[0], $thong_thin_user->id, $thong_thin_user->department_id);
                header("Refresh:0");
            } else {
                $mess_err_task  =  "Các thông tin không được để trống";
            }
        } else {
            echo json_encode (
                array(
                    'error' => true,
                    'message' => 'Thiếu thông tin'
                )
            );
            die();
        }
    }

    
?>
    <div class="row h-100">
        <div class="col-sm-2 bg-func shadow">
            <?php
                include_once("./modules/hien_thi_chuc_nang.php");
            ?>
        </div>
        <div class="col-sm-9 task-list mt-3">
            <div class="row">
                <div class="col-sm-3 mt-3 " >
                    <div class="card he-default shadow-sm">
                        <div class="container p-4">
                            <div class="text-warning font-weight-bold">
                                <i class="bi bi-circle-fill mr-2"></i>Công việc mới
                            </div>
                            <div class="text-success font-weight-bold">
                                <i class="bi bi-circle-fill mr-2"></i>Công việc đã hoàn thành
                            </div>
                            <div class="text-primary font-weight-bold">
                                <i class="bi bi-circle-fill mr-2"></i>Công việc đang tiến hành 
                            </div>
                            <div class="text-danger font-weight-bold">
                                <i class="bi bi-circle-fill mr-2"></i>Công việc bị từ chối 
                            </div>
                            <div class="text-secondary font-weight-bold">
                                <i class="bi bi-circle-fill mr-2"></i>Công việc đã bị hủy 
                            </div>
                            <?php
                                if ($thong_thin_user->role != "employee") {
                                    ?>
                                        <button type="button" class="btn btn-dark mt-3" data-toggle="modal" data-target="#exampleModal">+ Thêm công việc mới</button>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                    include_once('./modules/hien_thi_task.php');
                ?>
            </div>
        </div>
    </div>
    <?php
    if ($thong_thin_user->role != "employee") {
        ?>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Thêm công việc mới</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="">
                                    <label for="name_task">Tên công việc</label>
                                    <input name="name_task" id="name_task" class="form-control" type="text" placeholder="Tên công việc">
                                </div>
                                <div class="mt-2">
                                    <label for="sumary_task">Tóm tắt</label>
                                    <input name="sumary_task" id="sumary_task" class="form-control" type="text" placeholder="Tóm tắt công việc">
                                </div>

                                <div class="mt-2">
                                    <label for="descript_task">Chi tiết</label>
                                    <textarea class="form-control" id="descript_task" name="descript_task" rows="5" placeholder="Chi tiết công việc"></textarea>
                                </div>

                                <div class="mt-2">
                                    <label for="end_time">Thời gian hết hạn</label>
                                    <input name="end_time" id="end_time" class="form-control" type="datetime-local">
                                </div>

                                <div class="mt-2">
                                    <label for="select_user">Chọn nhân viên nhận</label>
                                    <select class="form-control" id="select_user" name="select_user">
                                        <?php
                                            foreach ($user_department as $value) {
                                                if ($value['role'] == 'employee') {
                                                    ?>
                                                        <option><?php echo( $value['id'] . ' - '.$value['fullName'])?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary" id="btn-add-task" name="btn-add-task">Thêm công việc</button>
                            </div>
                        </div>
                        <div class="m-3">
                            <?php
                                if ($mess_err_task != '') {
                                    hien_alert(0,$mess_err_task);
                                }
                            ?>
                        </div> 
                    </form>
                </div>
                </div>
        <?php
    }
    if(isset($_POST['btn-add-task'])) {
        echo("<script>$('.modal').modal('show')</script>");
    }
    ?>
    
</body>

</html>