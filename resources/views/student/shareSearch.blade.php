@extends('layouts.student.app')
@section('content')
<!-- container -->
<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">我的分享</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
				<div class="page-tag">
					<a @click="goTarget('Share')" :class="{'is-active': pageTag['Share']}" class="btn tag-link">我的分享</a>
					<a @click="goTarget('Other')" :class="{'is-active': pageTag['Other']}" class="btn tag-link">分享列表</a>
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<section class="page-section">
						<div id="Share" class="section-title">
							<h3>我的分享</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(ShareAdd, 'add')">新增我的分享</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="ShareAdd.isActive">
								<form class="validate" id="ShareAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">標題：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.Share.Share_title">
									</div>
									<div class="form-group">
										<label class="form-label form-label">作者：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.Share.Share_author">
									</div>
									<div class="form-group">
										<label class="form-label form-label">地點：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.Share.Share_location">
									</div>
									<div class="form-group">
										<label class="form-label form-label">時間：</label>
										<date-picker id="add_share" class="date datepicker" :value="insertData.Share_time" placeholder="取證時間" readonly></date-picker>
									</div>
									<div class="form-group">
										<label class="form-label form-label">分享照片(一)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 1)">
									</div>
									<div class="form-group" v-if="photoPreview_1">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">分享照片(二)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 2)">
									</div>
									<div class="form-group" v-if="photoPreview_2">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">分享照片(三)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 3)">
									</div>
									<div class="form-group" v-if="photoPreview_3">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">心得分享：</label>
										<textarea class="form-black form-control xs" v-model="insertData.Share.Share_cont"></textarea>
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(ShareAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(ShareAdd, 'ShareAdd')">確認</button>
									</div>
								</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">作者</th>
										<th class="th" width="40%">標題</th>
										<th class="th">時間</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.Share">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="作者">@{{ info.Share_author }}</td>
										<td data-th="標題">@{{ info.Share_title }}</td>
										<td data-th="時間">@{{ info.Share_time }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop.prevent="deleteAction('{{ url("/student/shareSearch/delete") }}', info)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
										<transition name="fade">
										<div class="form-wrap form-required" v-show="info.isActive">
											<form class="validate" :id="'parcEdit' + key + '-validate'" @submit.prevent>
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">標題：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Share_title">
												</div>
												<div class="form-group">
													<label class="form-label form-label">作者：</label>
													<input type="text" class="form-inline form-control xs" v-model="info.Share_author">
												</div>
												<div class="form-group">
													<label class="form-label form-label">地點：</label>
													<input type="text" class="form-inline form-control xs" v-model="info.Share_location">
												</div>
												<div class="form-group">
													<label class="form-label form-label">時間：</label>
													<date-picker :id="'edit_share' + key" class="date datepicker" :value="info.Share_time" placeholder="時間" readonly></date-picker>
												</div>
												<div class="form-group">
													<label class="form-label form-label">分享照片(一)：</label>
													<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 1)">
												</div>
												<div class="form-group" v-if="photoPreview_1">
													<label class="form-label form-label"></label>
													<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
												</div>
												<div class="form-group">
													<label class="form-label form-label">分享照片(二)：</label>
													<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 2)">
												</div>
												<div class="form-group" v-if="photoPreview_2">
													<label class="form-label form-label"></label>
													<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
												</div>
												<div class="form-group">
													<label class="form-label form-label">分享照片(三)：</label>
													<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 3)">
												</div>
												<div class="form-group" v-if="photoPreview_3">
													<label class="form-label form-label"></label>
													<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
												</div>
												<div class="form-group">
													<label class="form-label form-label">心得分享：</label>
													<textarea class="form-black form-control xs" v-model="info.Share_cont"></textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
													<button type="submit" class="btn btn-submit" @click="editPost(info, 'ShareEdit', key)">確認</button>
												</div>
											</form>
										</div>
										</transition>
										<transition name="fade">
											<ul class="lead-list" v-show="info.info">
												<li><label>地點：</label><span>@{{ info.Share_location }}</span></li>
												<li><label>心得分享：</label><span>@{{ info.Share_cont }}</span></li>
												<li>
													<label>活動照片：</label>
													<div class="gallery-list clearfix">
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_1" class="item" data-lightbox="image-Share_title" :data-title="info.Share_title" v-if="info.photo_decode.img_1 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_1 + ')' }"></div>
														        </div>
														    </div>
														</a>
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_2" class="item" data-lightbox="image-Share_title" :data-title="info.Share_title" v-if="info.photo_decode.img_2 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_2 + ')' }"></div>
														        </div>
														    </div>
														</a>
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_3" class="item" data-lightbox="image-Share_title" :data-title="info.Share_title" v-if="info.photo_decode.img_3 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_3 + ')' }"></div>
														        </div>
														    </div>
														</a>
													</div>
												</li>
											</ul>
										</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="Other" class="section-title">
							<h3>分享列表</h3>
						</div>
						<div class="section-content">
							<div class="section-feature">
								<div class="form-group">
									<form>
										<input name="search" type="text" value="{{ $search }}">
										<button class="btn btn-edit">搜尋</button>
									</form>
								</div>
							</div>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">作者</th>
										<th class="th" width="40%">標題</th>
										<th class="th">時間</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.Other">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="作者">@{{ info.Share_author }}</td>
										<td data-th="標題">@{{ info.Share_title }}</td>
										<td data-th="時間">@{{ info.Share_time }}</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
										<transition name="fade">
											<ul class="lead-list" v-show="info.info">
												<li><label>地點：</label><span>@{{ info.Share_location }}</span></li>
												<li><label>心得分享：</label><span>@{{ info.Share_cont }}</span></li>
												<li>
													<label>活動照片：</label>
													<div class="gallery-list clearfix">
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_1" class="item" data-lightbox="image-Share_title" :data-title="info.Share_title" v-if="info.photo_decode.img_1 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_1 + ')' }"></div>
														        </div>
														    </div>
														</a>
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_2" class="item" data-lightbox="image-Share_title" :data-title="info.Share_title" v-if="info.photo_decode.img_2 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_2 + ')' }"></div>
														        </div>
														    </div>
														</a>
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_3" class="item" data-lightbox="image-Share_title" :data-title="info.Share_title" v-if="info.photo_decode.img_3 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_3 + ')' }"></div>
														        </div>
														    </div>
														</a>
													</div>
												</li>
											</ul>
										</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- container end -->
<script>
//datepicker
Vue.component('date-picker', {
  template: '<input class="date" />',
	mounted: function() {
		$(this.$el).datepicker({
		    format: 'YYYY-mm-dd',
		    autoHide: true
		});
	}
});

var container = new Vue({
    el: '#page-container',
    data: {
    	search: '{{ $search }}',
    	photoPreview_1: '',
    	photoPreview_2: '',
    	photoPreview_3: '',
    	pageTag: {
    		'Share': false,
    		'Other': false,
    	},
    	ShareAdd: {
    		isActive: false,
    	},
    	editData: {},
    	formData: new FormData(),
    	insertData: {
    		Share: {
    			Share_time: '',
    			Share_location: '',
    			Share_cont: '',
    			Share_author: '',
    			Share_title: '',
    		},
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
	            url: '/student/shareSearch/init',
	            type: "get",
	            data: { search: this.search },
	            success: function(response) {
	            	container.editData = response;
	            	header.toggleLoading();
	            }
	        });
    	},
    	goTarget: function(targetId) {
    		var top = $('#' + targetId).offset().top;

		    $('body, html').animate({
		      scrollTop: top
		    }, 500);

		    //change active
		    var keys = Object.keys(this.pageTag);
		    keys.map(function(info){
		    	if (targetId == info) {
		    		container.pageTag[info] = true;
		    	} else {
		    		container.pageTag[info] = false;
		    	}
		    });

    	},
    	editClick: function(target) {
    		target.info = ! target.info;
    		target.edit = ! target.edit;
    	},
    	clickDetail: function(target) {
    		target.info = ! target.info;
    	},
    	listEdit: function(target, type) {
    		container.photoPreview_1 = '';
    		container.photoPreview_2 = '';
    		container.photoPreview_3 = '';

    		if (type == 'add') {
    			target.isActive = ! target.isActive;
    		} else if  (type == 'edit') {
    			if (typeof target.photo_decode != "undefined") {
	    			//img
	    			if (target.photo_decode.img_1 != '') {
	    				container.photoPreview_1 = "{{ url('/') }}" + '/' + target.photo_decode.img_1;
	    			}
	    			if (target.photo_decode.img_2 != '') {
	    				container.photoPreview_2 = "{{ url('/') }}" + '/' + target.photo_decode.img_2;
	    			}
	    			if (target.photo_decode.img_3 != '') {
	    				container.photoPreview_3 = "{{ url('/') }}" + '/' + target.photo_decode.img_3;
	    			}
    			}

	    		target.isActive = ! target.isActive;
	    		target.edit = ! target.edit;
	    		target.info = false;
    		}
    	},
	    processFile: function(event, type) {
	    	if (typeof event.target.files[0] == "undefined") {
			    return;
			} else {
				var mime = event.target.files[0].type;
				if (mime == 'image/jpeg' || mime == 'image/png' || mime == 'image/gif') {
					this.formData.append('img' + '_' + type, event.target.files[0]);
			        this.createImage(event.target.files[0], type);

				} else {
					swal({
		                title: "OOPS..",
		                text: '檔案格式錯誤！允許格式: jpg, png, gif',
		                type: "error"
		            });

		            //清空非法格式
		            $(event.target).val('');
				}
			}
	    },
        createImage: function(file, type) {
            var image = new Image();
            var reader = new FileReader();

            if (type == '1') {
                reader.onload = function(e) {
                    container.photoPreview_1 = e.target.result;
                };
            } else if (type == '2') {
                reader.onload = function(e) {
                    container.photoPreview_2 = e.target.result;
                };
            } else if (type == '3') {
                reader.onload = function(e) {
                    container.photoPreview_3 = e.target.result;
                };
            }

            reader.readAsDataURL(file);
        },
    	editPost: function(target, type, key) {
    		var ajaxUrl;

    		if (type != '') {
    			if (typeof key != 'undefined') {
	                if( ! $('#' + type + key +'-validate').validationEngine("validate")) {
	                    return;
	                }
    			} else {
	                if( ! $('#' + type + '-validate').validationEngine("validate")) {
	                    return;
	                }
    			}
    		}
    		switch (type) {
    			case 'ShareAdd':
    				ajaxUrl = '/student/shareSearch/add';
                    container.formData.append('Share_author',  container.insertData.Share.Share_author);
                    container.formData.append('Share_title',  container.insertData.Share.Share_title);
                    container.formData.append('Share_location',  container.insertData.Share.Share_location);
                    container.formData.append('Share_cont',  container.insertData.Share.Share_cont);
                    container.formData.append('Share_time',  $('#add_share').val());

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('ShareAdd');
    				break;
    			case 'ShareEdit':
    				ajaxUrl = '/student/shareSearch/edit';
					container.formData.append('Id',  target.Id);
					container.formData.append('Share_author',  target.Share_author);
					container.formData.append('Share_title',  target.Share_title);
                    container.formData.append('Share_location',  target.Share_location);
                    container.formData.append('Share_cont',  target.Share_cont);
                    container.formData.append('Share_time',  $('#edit_share' + key).val());
                    container.formData.append('Share_photo',  target.Share_photo);
                    container.formData.append('Folder',  target.Folder);
                    container.formData.append('SubFolder',  target.SubFolder);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'edit');
    				this.initInsertData('ShareEdit');
    				break;
    		}

    		if (target != '') {
	    		target.edit = ! target.edit;
    		}
    	},
    	ajaxEdit: function(url) {
    		header.toggleLoading();
        	var error = false;
        	var msg;
	        $.ajax({
	            url: url,
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
	            }
	        });
    	},
    	alertModel: function(error, msg) {
    		header.alert.show = true;
    		header.alert.msg = msg;
    		header.alert.error = error;

            setTimeout(function(){
                header.alert.show = false;
            }, 2000);
    	},
    	initInsertData: function(type) {
    		switch (type) {
    			case 'ShareAdd':
    				container.insertData.Share = {
		    			Share_time: '',
		    			Share_location: '',
		    			Share_cont: '',
		    			Share_author: '',
		    			Share_title: '',
		    		}
    				break;
    		}

    		container.photoPreview_1 = '';
    		container.photoPreview_2 = '';
    		container.photoPreview_3 = '';
    		container.formData = new FormData();
    		$('.addFile').val('');
    	},
    	getTermName: function(type) {
    		return type;
    	},
        deleteAction: function(url, info) {
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
                container.goDelete(url, info);
            }, function(dismiss) {
                //cancel
            })
        },
        goDelete: function(url, info) {
            header.toggleLoading();
            var error = false;
            var msg;
            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "delete",
                data: info,
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






