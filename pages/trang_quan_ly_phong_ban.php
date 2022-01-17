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
        if (isset($_POST['employeeToLeader']) && $_POST['employeeToLeader'] != '') {
            $employeeToLeader = explode(' - ', $_POST['employeeToLeader']);
            $id_employee = $employeeToLeader[0];
        };
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

                            $i += 1;
                            if (!empty($xl_phong_ban->hien_thi_ten_truong_phong_theo_phong_ban($val['id']))) {
                                ?>
                                
                                    <tr>
                                        <th scope="row"><?php echo($i)?></th>
                                        <td><?php echo($val['name'])?></td>
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
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ChangeLeaderDepartment"><b>Thay đổi</b></button>
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

<!-- Modal -->
<div class="modal fade" id="ChangeLeaderDepartment" tabindex="-1" aria-labelledby="ChangeLeaderDepartment" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content"> 
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>Thay đổi trưởng phòng</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post">
            <div class="modal-body">
                <div class="form-group">
                    <label for="employeeToLeader">Chọn nhân viên thành trưởng phòng</label>
                    <select multiple class="form-control" id="employeeToLeader" name="employeeToLeader">
                        <?php
                            foreach($all_employee as $val) {
                                ?>
                                    <option value="<?php echo($val['id']. ' - '. $val['fullName'])?>">
                                        <?php echo($val['id']. ' - '. $val['fullName'])?>
                                    </option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="submit" class="btn btn-danger" name="btn-employeeToLeader">Thay đổi trưởng phòng</button>
            </div>
        </form> 
    </div>
  </div>
</div>

<!-- Modal -->
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