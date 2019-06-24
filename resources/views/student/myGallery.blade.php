@extends('layouts.student.app')
@section('content')

<!-- container -->
<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">
				個人相簿
				</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<div class="page-section">
						<div class="section-title">
							@if( ! empty($parentName))
								<h3><a href="{{ url('/student/myGallery') }}">個人相簿</a> / {{ $parentName }}</h3>
							@else
								<h3>個人相簿</h3>
							@endif
							@if( $folderId == 0 )
							<div class="section-title-right">
								<a @click="lightBoxClick" class="btn btn-edit">新增個人相簿</a>
							</div>
							@endif
						</div>
						<div class="section-content">
							<div class="project-gallery">
								<div class="gallery-list clearfix" v-for="group in gallery">
									<a :href="checkHasChildren(info.Id, info.has_children)" class="item" v-for="info in group" v-if=" ! info.empty">
									    <div class="itemFrame">
									        <div class="innerFrame">
									        	<div class="setting">
													<div class="setting-btn" title="編輯或刪除">
														<i class="material-icons">mode_edit</i>
													</div>
													<div class="setting-list">
														<span @click.stop.prevent="editClick(info.Id, info.Name)">編輯</span>
														<span v-if="info.P_Id == 0" @click.stop.prevent="deleteAction('{{ url("/student/myGallery/delete") }}', info.Id, info.Path_Name, '{{ $parentFolder }}')">刪除</span>
													</div>
												</div>
									        	<div class="title">
									        		@{{ info.Name }}
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
	<!-- modal -->
	<div class="modal-overlay" :class="{ 'is-active': photoAdd }"> <!-- 展開要+ is-active -->
		<div class="modal" :class="{ 'is-active': photoAdd }"> <!-- 展開要+ is-active -->
		<a class="close-modal">
			<img src="{{ url('image/icon_close.svg') }}" alt="" @click="lightBoxClick">
		</a>
		<!-- close modal -->
		<div class="modal-content">
			<div class="form-wrap">
				<form class="validate" id="validate" @submit.prevent>
					<div class="form-group">
						<label class="form-label">相簿名稱：</label>
						<input type="text" class="form-inline form-control sm validate[required]" v-model="folderAddName">
					</div>
					<div class="form-offset form-button">
						<button type="clear" class="btn" @click="lightBoxClick">取消</button>
						<button type="submit" @click="folderAdd" class="btn btn-submit">確認</button>
					</div>
				</form>
			</div>
		</div>
		<!-- content -->
		</div>
	</div>
	<!-- modal -->

	<!-- edit modal -->
	<div class="modal-overlay" :class="{ 'is-active': photoEdit }"> <!-- 展開要+ is-active -->
		<div class="modal" :class="{ 'is-active': photoEdit }"> <!-- 展開要+ is-active -->
			<a class="close-modal">
				<img src="{{ url('image/icon_close.svg') }}" alt="" @click="editClick">
			</a>
			<!-- close modal -->
			<div class="modal-content">
				<div class="form-wrap">
					<form class="validate" id="validateEdit" @submit.prevent>
						<div class="form-group">
							<label class="form-label">相簿名稱：</label>
							<input type="text" class="form-inline form-control sm validate[required]" v-model="edit.name">
						</div>
						<div class="form-offset form-button">
							<button type="clear" class="btn" @click="editClick">取消</button>
							<button type="submit" @click="goEdit" class="btn btn-submit">確認</button>
						</div>
					</form>
				</div>
			</div>
			<!-- content -->
		</div>
	</div>
	<!-- modal -->
</div>
<!-- container end -->

<script>
var container = new Vue({
    el: '#page-container',
    data: {
    	photoAdd: false,
    	photoEdit: false,
    	gallery: [],
    	folderAddName: '',
    	edit: {
    		name: '',
    		id: '',
    	}
    },
    mounted: function () {
    	//init data
    	this.initData();
    },
    methods: {
        lightBoxClick: function() {
            this.photoAdd = ! this.photoAdd;
        },
        editClick: function(id, name) {
        	this.edit.id = id;
        	this.edit.name = name;
        	this.photoEdit = ! this.photoEdit;
        },
		initData: function() {
			header.toggleLoading();
	        $.ajax({
	            url: '/student/myGallery/init',
	            type: "get",
	            data: {folderId: "{{ $folderId }}"},
	            success: function(response) {
	            	if (response.length == 0) {
	            		location.href = "{{ url('/student/myGallery') }}";
	            	} else {
		            	container.gallery = response;
		            	header.toggleLoading();
	            	}
	            }
	        });
		},
		checkHasChildren: function(id, check) {
			if (check) {
				return "{{ url('/student/myGallery') }}?folderId=" + id + '&pId={{ $folderId }}';
			} else {
				return "{{ url('/student/myGalleryDetail/edit') }}?folderId=" + id + '&pId={{ $folderId }}';
			}
		},
        goEdit: function() {
            if( ! $('#validateEdit').validationEngine("validate")) {
                return;
            } else {
	    		header.toggleLoading();
	        	var error = false;
	        	var msg;
		        $.ajax({
		            url: '/student/myGallery/edit',
		            headers: {
		                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		            },
		            type: "post",
		            data: {Name: container.edit.name, Id: container.edit.id},
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
		            	container.editClick();
		            }
		        });
            }
        },
		folderAdd: function() {
            if( ! $('#validate').validationEngine("validate")) {
                return;
            } else {
	    		header.toggleLoading();
	        	var error = false;
	        	var msg;
		        $.ajax({
		            url: '/student/myGallery/add',
		            headers: {
		                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		            },
		            type: "post",
		            data: {Name: container.folderAddName, folderId: "{{ $folderId }}"},
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
		            	container.lightBoxClick();
		            }
		        });
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
    	deleteAction: function(url, id, folderName, parentFolder) {
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
				container.goDelete(url, id, folderName, parentFolder);
			}, function(dismiss) {
				//cancel
			})
    	},
    	goDelete: function(url, id, folderName, parentFolder) {
    		header.toggleLoading();
        	var error = false;
        	var msg;
	        $.ajax({
	            url: url,
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            type: "delete",
	            data: {Id: id, folderName: folderName, parentFolder: parentFolder},
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
});
</script>
@stop






