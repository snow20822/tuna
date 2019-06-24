@extends('layouts.student.app')
@section('content')
<!-- container -->
<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">作品專區新增</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<div class="page-section">
						<div class="section-title">
							<h3>個人作品</h3>
							<div class="section-title-right">
								<button type="clear" class="btn" @click.stop="clickEdit">取消</button>
								<button type="submit" class="btn btn-submit" @click.stop="clickEdit">確認</button>
							</div>
						</div>
						<div class="section-content">
							<div class="project-content">
								<div class="form-wrap">
									<div class="form-group">
										<label class="form-label">作品名稱：</label>
										<input type="text" class="form-inline form-control sm">
									</div>
									<div class="form-group">
										<label class="form-label">作品描述：</label>
										<textarea class="form-inline form-control"></textarea>
									</div>
									<div class="form-group">
										<label class="form-label form-label">展出照片(一)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 1)">
									</div>
									<div class="form-group" v-if="photoPreview_1">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">展出照片(二)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 2)">
									</div>
									<div class="form-group" v-if="photoPreview_2">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">展出照片(三)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 3)">
									</div>
									<div class="form-group" v-if="photoPreview_3">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
									</div>
								</div>
							</div>
							<div class="project-video">
								<div class="form-wrap">
									<div class="form-group">
										<label class="form-label">影片連結：</label>
										<input type="text" class="form-inline form-control sm" placeholder="http://">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- container end -->
<script>
var container = new Vue({
    el: '#page-container',
    data: {
    	photoPreview_1: '',
    	photoPreview_2: '',
    	photoPreview_3: '',
    	formData: new FormData(),
    	postData: {
			Works_name: '',
			Works_introd: '',
			Works_vid: '',
			Works_photo: '',
			Folder: '',
			SubFolder: '',
    	},
    },
    mounted: function() {
    	//init data
    	this.initData();
    },
    methods: {
    	initData: function() {
    		header.toggleLoading();
	        $.ajax({
	            url: '/student/workProject/workInit',
	            type: "get",
	            success: function(response) {
	            	container.postData = response;
	            	header.toggleLoading();
	            }
	        });
    	},
    }
})
</script>
@stop







