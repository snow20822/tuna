<div class="mem-infor-photo">
    <div class="file-input">
        <label class="file-btn">
            <i class="material-icons">file_upload</i>
            <form id="userImg" enctype="multipart/form-data">
                <input id="file-input-file" class="none" type="file">
            </form>
        </label>
    </div>
    <img src="{{ getTeacherPhotoUrl() }}" title="莊筱婷" alt="莊筱婷" class="img-circle">
</div>
<div class="mem-infor-list">
    <div class="mem-infor-name">莊筱婷</div>
    <div class="mem-infor-identity">身分<span class="teacher">老師</span></div>
    <div class="mem-infor-update">
        <span>更新日期：</span>
        <span>2017/5/31</span>
    </div>
</div>

<script>
$(function(){
    $("#file-input-file").change(function() {
        var formData = new FormData();
        formData.append('img', $(this)[0].files[0]);

        $.ajax({
            url: '/student/userUpload',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(res) {
                if (res.status == 'success') {
                    swal({
                        title: "Good job!",
                        text: res.msg,
                        type: "success"
                    }).then(function () {
                        location.reload();
                    });
                } else {
                    swal({
                        title: "OOPS..",
                        text: res.msg,
                        type: "error"
                    }).then(function () {
                        //code
                    });
                }
            }
        });
    });
});
</script>