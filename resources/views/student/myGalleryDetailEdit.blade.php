@extends('layouts.student.app')
@section('content')
<!-- container -->
<div id="page-container" v-cloak>
    <div id="page-body">
        <div class="page-row clearfix">
            <div class="page-slide">
                <h1 class="page-title" title="title">個人相簿照片</h1>
                <div class="mem-infor clearfix">
                    @include('layouts.student.user-info')
                </div>
            </div>
            <div class="page-content">
                <div class="page-article">
                    <div class="page-section">
                        <div class="section-title">
                            @if( ! empty($parentName) && ! empty($grandpaName) )
                            <h3><a href="{{ url('/student/myGallery') }}">個人相簿</a> / <a href="{{ url('/student/myGallery') . '?folderId=' . $pId }}">{{ $grandpaName }}</a> / {{ $parentName }} / 新增照片</h3>
                            @elseif ( empty($grandpaName) )
                            <h3><a href="{{ url('/student/myGallery') }}">個人相簿</a> / {{ $parentName }} / 新增照片</h3>
                            @endif
                        </div>
                        <div class="section-content">
                            <div class="project-gallery">
                                <div class="gallery-list clearfix">
                                    <a v-if="count < 3" @click.prevent="lightBoxClick('add')" class="item item-add">
                                        <div class="itemFrame">
                                            <div class="innerFrame">
                                                <div class="item-add-txt">新增照片</div>
                                            </div>
                                        </div>
                                    </a>
                                    <a v-for="(info, key) in photoList" class="item" :href="info.img_use_photo" data-lightbox="image-1" :data-title="info.Album_Mark">
                                        <div class="itemFrame">
                                            <div class="innerFrame">
                                                <div class="setting">
                                                    <div class="setting-btn" title="編輯或刪除">
                                                        <i class="material-icons" @click="">mode_edit</i>
                                                    </div>
                                                    <div class="setting-list">
                                                        <span @click.prevent.stop="lightBoxClick('edit', key)">編輯</span>
                                                        <span @click.prevent.stop="deleteAction('{{ url("/student/myGalleryDetail/delete") }}', info.Id, info.Album_Photo_Path)">刪除</span>
                                                    </div>
                                                </div>
                                                <div class="title" v-if="info.Album_Class_Name != null">
                                                    @{{ info.Album_Class_Name }}
                                                </div>
                                                <div class="img" :style="{ backgroundImage: 'url(' + info.img_use_photo + ')' }"></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- photo add modal -->
    <div class="modal-overlay" :class="{ 'is-active': photoAdd, 'is-hidden': photoAddLeave }">
        <!-- 展開要+ is-active -->
        <div class="modal" :class="{ 'is-active': photoAdd }">
            <!-- 展開要+ is-active -->
            <a class="close-modal">
            <img src="{{ url('image/icon_close.svg') }}" alt="" @click="lightBoxClick('add')">
            </a>
            <!-- close modal -->
            <div class="modal-content">
                <form class="validate" id="validateAdd" @submit.prevent>
                    <div class="form-wrap">
                        <div class="form-group">
                            <label class="form-label">分類：</label>
                            <select class="form-inline form-control sm validate[required]" v-model="insert.Album_Class_Id">
                                @foreach($albumClass as $class)
                                <option value="{{ $class['Id'] }}">{{ $class['Name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">註記：</label>
                            <input type="text" class="form-inline form-control sm validate[required]" v-model="insert.Album_Mark">
                        </div>
                        <div class="form-group">
                            <label class="form-label">照片：</label>
                            <input id="addFile" type="file" class="form-inline form-control sm validate[required]" @change="processFile($event, 'add')">
                        </div>
                        <div class="form-group">
                            <label class="form-label"></label>
                            <img v-if="photoPreview" :src="photoPreview" style="width: 100px" />
                        </div>
                        <div class="form-offset form-button">
                            <button type="clear" class="btn" @click="lightBoxClick('add')">取消</button>
                            <button type="submit" class="btn btn-submit" @click="photoCreate">確認</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- content -->
        </div>
        <!-- modal -->
    </div>

    <!-- photo edit modal -->
    <div class="modal-overlay" :class="{ 'is-active': photoEdit, 'is-hidden': photoEditLeave }">
        <!-- 展開要+ is-active -->
        <div class="modal" :class="{ 'is-active': photoEdit }">
            <!-- 展開要+ is-active -->
            <a class="close-modal">
                <img src="{{ url('image/icon_close.svg') }}" alt="" @click="lightBoxClick('edit')">
            </a>
            <!-- close modal -->
            <div class="modal-content">
                <form class="validate" id="validateEdit" @submit.prevent>
                    <div class="form-wrap">
                        <div class="form-group">
                            <label class="form-label">分類：</label>
                            <select class="form-inline form-control sm" v-model="edit.Album_Class_Id">
                                @foreach($albumClass as $class)
                                <option value="{{ $class['Id'] }}">{{ $class['Name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">註記：</label>
                            <input type="text" class="form-inline form-control sm validate[required]" v-model="edit.Album_Mark">
                        </div>
                        <div class="form-group">
                            <label class="form-label">照片：</label>
                            <input type="file" class="form-inline form-control sm" @change="processFile($event, 'edit')">
                        </div>
                        <div class="form-group">
                            <label class="form-label"></label>
                            <img v-if="!photoEditPreview" :src="edit.img_use_photo" style="width: 100px" />
                            <img v-if="photoEditPreview" :src="photoEditPreview" style="width: 100px" />
                        </div>
                        <div class="form-offset form-button">
                            <button type="clear" class="btn" @click="lightBoxClick('edit')">取消</button>
                            <button type="submit" class="btn btn-submit" @click="photoEditPost">確認</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- content -->
        </div>
        <!-- modal -->
    </div>
</div>
<!-- container end -->
<script>
    var container = new Vue({
        el: '#page-container',
        data: {
            parentFolderName: "{{ $parentFolderName }}",
            grandpaFolderName: "{{ $grandpaFolderName }}",
            showEdit: {
                info: true,
                edit: false,
            },
            photoAdd: false,
            photoAddLeave: true,
            photoEdit: false,
            photoEditLeave: true,
            photoList: [],
            count: 0,
            photoPreview: '',
            photoEditPreview: '',
            insert: {
                Album_Class_Id: '',
                Album_Mark: '',
                photo_file: '',
                Folder_Name_Id: "{{ $folderId }}",
            },
            edit: [],
            formData: new FormData(),
            defaultAddHeight: {
                height: 130 + 'px',
            },
        },
        mounted: function () {
            //init data
            this.initData();
        },
        methods: {
            initData: function() {
                header.toggleLoading();
                $.ajax({
                    url: '/student/myGalleryDetail/init',
                    type: "get",
                    data: {folderId: "{{ $folderId }}"},
                    success: function(response) {
                        container.photoList = response.album;
                        container.count = response.count;

                        header.toggleLoading();
                    }
                });

                //init insert data
                this.insert.Album_Class_Id = '';
                this.insert.Album_Mark = '';
                this.insert.photo_file = '';
                $('#addFile').val('');
                this.photoPreview = '';
            },
            processFile: function(event, type) {
                if (typeof event.target.files[0] == "undefined") {
                    return;
                } else {
                    var type = event.target.files[0].type;
                    if (type == 'image/jpeg' || type == 'image/png' || type == 'image/gif') {
                        this.formData.append('img',  event.target.files[0]);
                        this.createImage(event.target.files[0], type);
                    } else {
                        swal({
                            title: "OOPS..",
                            text: '檔案格式錯誤！允許格式: jpg, png, gif',
                            type: "error"
                        });
                    }
                }
            },
            createImage: function(file, type) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;
                if (type == 'add') {
                    reader.onload = function(e) {
                        container.photoPreview = e.target.result;
                    };
                } else if (type == 'edit') {
                    reader.onload = function(e) {
                        container.photoEditPreview = e.target.result;
                    };
                }

                reader.readAsDataURL(file);
            },
            formatPostData: function(type) {
                if (type == 'add') {
                    container.formData.append('Album_Class_Id',  container.insert.Album_Class_Id);
                    container.formData.append('Album_Mark',  container.insert.Album_Mark);
                    container.formData.append('Folder_Name_Id',  container.insert.Folder_Name_Id);
                    container.formData.append('parentFolderName',  container.parentFolderName);
                    container.formData.append('grandpaFolderName',  container.grandpaFolderName);
                } else if (type == 'edit') {
                    container.formData.append('Album_Class_Id',  container.edit.Album_Class_Id);
                    container.formData.append('Album_Mark',  container.edit.Album_Mark);
                    container.formData.append('parentFolderName',  container.parentFolderName);
                    container.formData.append('grandpaFolderName',  container.grandpaFolderName);
                    container.formData.append('Album_Photo_Path',  container.edit.Album_Photo_Path);
                    container.formData.append('Id',  container.edit.Id);
                }
            },
            photoCreate: function() {
                if( ! $('#validateAdd').validationEngine("validate") || this.count >= 3) {
                    return;
                } else {
                    header.toggleLoading();
                    var error = false;
                    var msg;
                    //format
                    container.formatPostData('add');
                    $.ajax({
                        url: '/student/myGalleryDetail/add',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        type: "post",
                        data: container.formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status == 'error') {
                                swal({
                                    title: "OOPS..",
                                    text: response.msg,
                                    type: "error"
                                });
                                error = true;
                                msg = response.msg;
                            } else {
                                msg = '新增成功!';
                            }
                            header.toggleLoading();
                            container.initData();
                            container.alertModel(error, msg);
                            container.lightBoxClick('add');
                        }
                    });
                }
            },
            photoEditPost: function() {
                if( ! $('#validateEdit').validationEngine("validate")) {
                    return;
                } else {
                    header.toggleLoading();
                    var error = false;
                    var msg;
                    //format
                    container.formatPostData('edit');
                    $.ajax({
                        url: '/student/myGalleryDetail/editPost',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        type: "post",
                        data: container.formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status == 'error') {
                                swal({
                                    title: "OOPS..",
                                    text: response.msg,
                                    type: "error"
                                });
                                error = true;
                                msg = response.msg;
                            } else {
                                msg = '編輯成功!';
                            }
                            header.toggleLoading();
                            container.initData();
                            container.alertModel(error, msg);
                            container.lightBoxClick('edit');
                        }
                    });
                }
            },
            checkHeight: function() {
                if (this.photoList.length == 0) {
                    return this.defaultAddHeight;
                }
            },
            clickEdit: function() {
                this.showEdit.info = ! this.showEdit.info;
                this.showEdit.edit = ! this.showEdit.edit;
            },
            lightBoxClick: function($type, key) {
                if ($type == 'add') {
                    this.lightBoxType = 'add';
                    this.photoAdd = ! this.photoAdd;
                    this.photoAddLeave = ! this.photoAddLeave;
                } else if ($type == 'edit') {
                    if(typeof key != "undefined") {
                        this.edit = this.photoList[key];
                    }

                    this.lightBoxType = 'edit';
                    this.photoEdit = ! this.photoEdit;
                    this.photoEditLeave = ! this.photoEditLeave;
                }
            },
            alertModel: function(error, msg) {
                header.alert.show = true;
                header.alert.msg = msg;
                header.alert.error = error;

                setTimeout(function(){
                    header.alert.show = false;
                }, 2000);
            },
            deleteAction: function(url, id, filePath) {
                swal({
                    title: "確定要刪除嗎？",
                    text: "您將會刪除此筆資料",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "確認",
                    cancelButtonText: "取消",
                    reverseButtons: true
                }).then(function() {
                    container.goDelete(url, id, filePath);
                }, function(dismiss) {
                    //cancel
                })
            },
            goDelete: function(url, id, filePath) {
                header.toggleLoading();
                var error = false;
                var msg;
                $.ajax({
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "delete",
                    data: {Id: id, filePath: filePath},
                    success: function(response) {
                        if (response.status == 'error') {
                            swal({
                                title: "OOPS..",
                                text: response.msg,
                                type: "error"
                            });
                            error = true;
                            msg = response.msg;
                        } else {
                            msg = '刪除成功!';
                        }
                        header.toggleLoading();
                        container.alertModel(error, msg);
                        container.initData();
                    }
                });
            }
        }
    })
</script>
@stop