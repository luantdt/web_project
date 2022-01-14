<?php
    $id = $_SESSION['thong_tin_user']->id;
    
    include_once('./model/xl_task.php');
    $xl_task = new xl_task();

    if ($_SESSION['thong_tin_user']->role == "employee") {
        $tasks = $xl_task->hien_thi_cong_viec_theo_user_id($id);
    } else {
        $tasks = $xl_task->hien_thi_toan_bo_cong_viec($id);
    }

    foreach($tasks as $arr) {
        foreach($arr as $key => $element) {
            if ($key === 'name') {
                $name = $element;
            }
            if ($key === 'summary') {
                $summary = $element;
            }

            if ($key === 'id') {
                $id_task = $element;
            }

            if ($key === 'status') {
                $status = $element;
            }
        }

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