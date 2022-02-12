<?php 
    $thong_tin_user = $_SESSION['thong_tin_user'];

    if ($thong_tin_user->role != 'admin') {
        header('location: ./?page=404');
    }

    include_once('./model/xl_phong_ban.php');
    include_once('./model/xl_nguoi_dung.php');
    $xl_phong_ban = new xl_phong_ban();
    $xl_nguoi_dung = new xl_nguoi_dung();

    $all_dept = $xl_phong_ban->hien_thi_tat_ca_phong_ban();
    $all_employee = $xl_nguoi_dung->hien_thi_ten_va_id_nhan_vien();

    if (isset($_POST['btn-employeeToLeader'])) {
        if ( isset($_POST['employeeToLeader']) && 
        $_POST['employeeToLeader'] != '' &&
        $_POST['current-department'] != '' &&
        isset($_POST['current-department'])) 
        {
            $employeeToLeader = explode(' - ', $_POST['employeeToLeader']);
            $id_employee = $employeeToLeader[0];
            $id_department = decrypt($_POST['current-department']);
            $id_old_leader = $xl_phong_ban->hien_thi_id_leader_theo_id_phong_ban($id_department);

            $xl_nguoi_dung->thay_doi_role_thanh_truong_phong($id_employee);
            $xl_nguoi_dung->thay_doi_role_thanh_employee($id_old_leader->leader_id);
            $xl_phong_ban->tro_thanh_truong_phong($id_department, $id_employee);
            header("Refresh:0");
        } else {
            echo json_encode(
                array(
                    'error' => true,
                    'message' => 'your information is invalid',
                )
            );
            die();
        }
    };
?>
<div class="row h-100">
    
    <div class="col-sm-2 bg-func shadow">
        <?php
            include_once("./modules/hien_thi_chuc_nang.php");
        ?>
    </div>
    <div class="col-sm-10">
        <div class="mt-4 text-center">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createDepartment">+ Thêm phong ban mới</button>
        </div>
        <div class="container-fluid">
            <table class="table mt-3 table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên phòng ban</th>
                        <th scope="col">Số nhân viên tối đa</th>
                        <th scope="col">Số nhân viên hiện tại</th>
                        <th scope="col" class="col-3">Miêu tả</th>
                        <th scope="col">Trưởng phòng</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                        foreach($all_dept as $val) {
                            if (!empty($xl_phong_ban->hien_thi_ten_truong_phong_theo_phong_ban($val['id']))) {
                                $i += 1;
                                ?>
                                
                                    <tr>
                                        <th scope="row"><?php echo($i)?></th>
                                        <td class="dn-<?php echo($i)?>"><?php echo($val['name'])?></td>
                                        <td><?php echo($val['amount_people'])?></td>
                                        <td>
                                            <b><?php
                                                echo($xl_phong_ban->hien_thi_tong_so_nhan_su_theo_id($val['id'])[0]['tong_so'])
                                            ?></b>
                                        </td>
                                        <td><?php echo($val['description'])?></td>
                                        <td>
                                            <b><?php 
                                                echo($xl_phong_ban->hien_thi_ten_truong_phong_theo_phong_ban($val['id'])[0]['fullName'])
                                            ?></b>
                                        </td>
                                        <td>
                                            <input type="text" style="display: none" value='<?php echo(encrypt($val['id']))?>'>
                                            <button type="button" class="btn btn-danger show-modal-change-leader" id="btn-show-no-<?php echo($i)?>" data-toggle="modal" data-target="#ChangeLeaderDepartment"><b>Thay đổi</b></button>
                                        </td>
                                    </tr>
                                <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal thay đổi trưởng phòng -->
<div class="modal fade" id="ChangeLeaderDepartment" tabindex="-1" aria-labelledby="ChangeLeaderDepartment" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Thay đổi trưởng phòng</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="form-change-employee-to-leader">
            <div class="modal-body">
                <div class="form-group">
                    <label for="employeeToLeader" id="label-employee-to-leader"></label>
                    <select multiple class="form-control" id="employeeToLeader" name="employeeToLeader">
                        <?php
                            foreach($all_employee as $val) {
                                ?>
                                    <option 
                                        value="<?php echo($val['id']. ' - '. $val['fullName'])?>"
                                        name="employeeToLeader"
                                    >
                                        <?php echo($val['id']. ' - '. $val['fullName'])?>
                                    </option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <input type="text" style="display: none" value='' name="current-department" id="current-department">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-danger" name="btn-employeeToLeader">Thay đổi trưởng phòng</button>
            </div>
        </form> 
    </div>
  </div>
</div>

<!-- Modal tạo phòng ban-->
<div class="modal fade" id="createDepartment" tabindex="-1" aria-labelledby="createDepartment" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><b>Tạo phòng ban mới</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="">
                <div class="modal-body">
                <div class="form-group">
                    <label for="">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-success">Tạo phòng ban mới</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>