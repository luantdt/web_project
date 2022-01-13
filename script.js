$(document).ready(function(){
    let btnClick = '';

    if($(".success-pw-alert").length > 0) {
        let time = 5;
        setInterval(function () {
            time -= 1;
            if (time == -1 ) {
                window.location="http://localhost:8080/web/web_project/";
            } else {
                $('.count-down').text(time);
            }
        }, 1000);

        $('.redirect-login').click(function (){
            window.location="http://localhost:8080/web/web_project/";
        });
    };
    $('#btn-reject-task').click(function (){
        btnClick = 'reject';
    });

    $('#btn-success-task').click(function (){
        btnClick = 'success';
    });

    $( "#form-feedback" ).submit(function(e) {
        e.preventDefault(); 
        let mess = '';
        let comment = $('#comment').val();
        let f = $('#fileSubmit');
        let file = '';
        let xhr = new XMLHttpRequest;
        let data = new FormData;

        f.attr('disabled','disabled');
        $('#btn-submit-task').attr('disabled','disabled');
        $('#comment').attr('disabled','disabled');

        if (f[0].files.length != 0 ) {
            if (f[0].files[0].size > 1 * 1024 * 1024 * 1024) {
                mess = 'Tập tin có dung lượng vượt mức cho phép.';
            } else {
                file = f[0].files[0];
            }
        }

        if (comment == '' ) {
            mess = 'Bạn cần điền comment để có thể tiếp tục gửi';
        }
        
        if (mess != '') {
            showAleart(0, mess, 'box-err');

            enableSubmitTask();
        } else {
            data.append('comment_fb', comment);
            data.append('file_fb', file);
            data.append('btnClick', btnClick);
            
            xhr.addEventListener('error', e => {
                showAleart(0,'Xảy ra lỗi trong quá trình gửi tập tin', 'box-err');
                enableSubmitTask();
            })
            xhr.addEventListener('timeout', e=> {
                showAleart(0,'Thời gian tải lên vượt mức cho phép', 'box-err');
                enableSubmitTask();
            })
            xhr.upload.addEventListener('progress', e=> {
                let loaded = e.loaded;
                let total = e.total;
                let progress = loaded * 100 / total;
                let percent = Math.round(progress);
                
                $('#progressBar').css('width',percent + '%');
                $('#progressBar').text(percent + '%');

                if (percent == 100) {
                    enableSubmitTask();
                    $('#fileSubmit').val('');
                    $('#comment').val('');
                    window.location.reload();
                }
            })
            xhr.addEventListener('load', e => {
                if (xhr.status === 200 ) {
                    showAleart(1,'Đã nộp thành công', 'box-err');
                } else {
                    showAleart(0,'Tải lên hệ thống thất bại', 'box-err');

                    enableSubmitTask();
                }
            })
            xhr.open('POST', '', true);
            xhr.send(data);
        }
    });

    $( "#form-upload" ).submit(function( e ) {
        e.preventDefault();

        let mess = '';
        let comment = $('#comment').val();
        let f = $('#fileSubmit');
        let file = [];
        let xhr = new XMLHttpRequest;
        let data = new FormData;

        f.attr('disabled','disabled');
        $('#btn-submit-task').attr('disabled','disabled');
        $('#comment').attr('disabled','disabled');

        if (f[0].files.length == 0 ) {
            mess = 'Tập tin của bạn chưa được tải lên, hãy kiểm tra lại các thông tin tải lên vào.';
        } else if (f[0].files[0].size > 1 * 1024 * 1024 * 1024) {
            mess = 'Tập tin có dung lượng vượt mức cho phép.';
        }
        else {
            file = f[0].files[0];
        }

        if (mess != '') {
            showAleart(0, mess, 'box-err');

            enableSubmitTask();
        } else {
            data.append('comment', comment);
            data.append('file', file);
            
            xhr.addEventListener('error', e => {
                showAleart(0,'Xảy ra lỗi trong quá trình gửi tập tin', 'box-err');

                enableSubmitTask();
            })
            xhr.addEventListener('timeout', e=> {
                showAleart(0,'Thời gian tải lên vượt mức cho phép', 'box-err');

                enableSubmitTask();
            })
            xhr.upload.addEventListener('progress', e=> {
                let loaded = e.loaded;
                let total = e.total;
                let progress = loaded * 100 / total;
                let percent = Math.round(progress);
                
                $('#progressBar').css('width',percent + '%');
                $('#progressBar').text(percent + '%');

                if (percent == 100) {
                    enableSubmitTask();
                    $('#fileSubmit').val('');
                    $('#comment').val('');
                    window.location.reload();
                }
            })
            xhr.addEventListener('load', e => {
                if (xhr.status === 200 ) {
                    showAleart(1,'Đã nộp thành công', 'box-err');
                } else {
                    showAleart(0,'Tải lên hệ thống thất bại', 'box-err');

                    enableSubmitTask();
                }
            })
            xhr.open('POST', '', true);
            xhr.send(data);
        }
    });
    function enableSubmitTask () {
        $('#fileSubmit').removeAttr("disabled");
        $('#btn-submit-task').removeAttr('disabled');
        $('#comment').removeAttr('disabled');
    }
    function showAleart (type, mess, area) {
        let alert = ""
        if (type == 0 ) {
            alert += '<div class="alert alert-warning alert-dismissible fade show mt-4" role="alert"><strong>Lỗi!</strong>';
        } else {
            alert += '<div class="alert alert-success alert-dismissible fade show mt-4" role="alert"><strong>Thành công!</strong>';
        }
        alert += ` ${mess}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>`

        $("." + area).append(alert);
    }
    $('#redirect').click(function (){
        window.location="http://localhost:8080/web/web_project/";
    });
})