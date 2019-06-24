@extends('layouts.student.app')
@section('content')
<!-- container -->
<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">作品專區編輯</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<div class="page-section">
						<div class="section-title">
							<h3>個人作品</h3>
							<div class="section-title-right" v-show="showEdit.info">
								<a class="btn btn-edit" @click.stop="clickEdit">編輯</a>
							</div>
							<div class="section-title-right" v-show="showEdit.edit">
								<a class="btn" @click.stop="clickEdit">取消</a>
								<a class="btn btn-submit" @click.stop="clickEdit">確認</a>
							</div>
						</div>
						<div class="section-content">
							<div class="project-content">
								<div class="project-title" v-show="showEdit.info">作品名稱</div>
								<div class="project-description" v-show="showEdit.info">作品描述</div>
								<div class="form-wrap" v-show="showEdit.edit">
									<div class="form-group">
										<label class="form-label">作品名稱：</label>
										<input type="text" class="form-inline form-control sm">
									</div>
									<div class="form-group">
										<label class="form-label">作品描述：</label>
										<textarea class="form-inline form-control"></textarea>
									</div>
								</div>
							</div>
							<div class="project-gallery">
								<ul class="gallery-list">
									<li>
										<a href="#" class="gallery-item-add" @click.prevent="lightBoxClick('add')">
											新增相片
										</a>
									</li>
									<li>
										<div class="gallery-item">
											<a>
												<div class="gallery-setting">
													<div class="setting-btn" title="編輯或刪除" @click="photoEditClick(0)">
														<i class="material-icons">mode_edit</i>
													</div>
													<div class="setting-list" v-show="photoFeatures[0].info">
														<span @click="lightBoxClick('edit')">編輯</span>
														<span>刪除</span>
													</div>
												</div>
												<div class="gallery-img">
													<img src="http://www.tnnua.edu.tw/ezfiles/0/1000/img/1/133606878.jpg" alt="註記">
												</div>
												<div class="gallery-title">
													<span class="title-class">分類</span>
													<span class="title-mark">註記</span>
												</div>
											</a>
										</div>
									</li>
									<li>
										<div class="gallery-item">
											<a>
												<div class="gallery-setting">
													<div class="setting-btn" title="編輯或刪除" @click="photoEditClick(1)">
														<i class="material-icons" @click="">mode_edit</i>
													</div>
													<div class="setting-list" v-show="photoFeatures[1].info">
														<span @click="lightBoxClick('edit')">編輯</span>
														<span>刪除</span>
													</div>
												</div>
												<div class="gallery-img">
													<img src="http://www.tnnua.edu.tw/ezfiles/0/1000/img/1/133606878.jpg" alt="註記">
												</div>
												<div class="gallery-title">
													<span class="title-class">分類</span>
													<span class="title-mark">註記</span>
												</div>
											</a>
										</div>
									</li>
								</ul>
							</div>
							<div class="project-video">	
								<div class="project-video-title" v-show="showEdit.info">影片連結：</div>
								<a href="https://www.youtube.com/watch?v=udNJp8Rr4yM" class="project-video-link" target="_blank" v-show="showEdit.info">https://www.youtube.com/watch?v=udNJp8Rr4yM</a>
								<div class="form-wrap" v-show="showEdit.edit">
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

	<!-- photo modal -->
	<div class="modal-overlay" :class="{ 'is-active': photoAdd }"> <!-- 展開要+ is-active -->
	    <div class="modal" :class="{ 'is-active': photoAdd }"> <!-- 展開要+ is-active -->
	        <a class="close-modal">
				<img src="{{ url('image/icon_close.svg') }}" alt="" @click="lightBoxClick">
	        </a>
	        <!-- close modal -->
	        <div class="modal-content">
	        <div class="form-wrap">
	         <div class="form-group">
	          <label class="form-label">分類：</label>
	          <select class="form-inline form-control sm">
	           <option value="">分類一</option>
	                 <option value="">分類二</option>
	                 <option value="">分類三</option>
	                 <option value="">分類四</option>
	          </select>
	         </div>
	         <div class="form-group">
	          <label class="form-label">註記：</label>
	          <input type="text" class="form-inline form-control sm">
	         </div>
	         <div class="form-group">
	          <label class="form-label">照片：</label>
	          <input type="file" class="form-inline form-control sm">
	         </div>
	         <div class="form-offset form-button">
	          <button type="clear" class="btn">取消</button>
	          <button type="submit" class="btn btn-submit">確認</button>
	         </div>
	        </div>
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
    	showEdit: {
    		info: true,
    		edit: false,
    	},
    	photoAdd: false,
    	photoFeatures: [
	    	{
	    		info: false,
	    	},
	    	{
	    		info: false,
	    	},
    	],
    	lightBoxType: 'add',
    },
    methods: {
        clickEdit: function() {
            this.showEdit.info = ! this.showEdit.info;
            this.showEdit.edit = ! this.showEdit.edit;
        },
        lightBoxClick: function($type) {
        	if ($type == 'add') {
        		this.lightBoxType = 'add';
        	} else if ($type == 'edit') {
        		this.lightBoxType = 'edit';
        	}
            this.photoAdd = ! this.photoAdd;
        },
        photoEditClick: function($key) {
            this.photoFeatures[$key].info = ! this.photoFeatures[$key].info;
        },
    }
})
</script>
@stop







