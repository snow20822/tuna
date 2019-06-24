@extends('layouts.student.app')
@section('content')

<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">個人簡歷</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
				<div class="page-tag">
					<a @click="goTarget('profile')" class="btn tag-link" :class="{'is-active': pageTag['profile']}">自我介紹</a>
					<a @click="goTarget('education')" class="btn tag-link" :class="{'is-active': pageTag['education']}">學歷</a>
					<a @click="goTarget('work')" class="btn tag-link" :class="{'is-active': pageTag['work']}">工作經歷</a>
					<a @click="goTarget('webUrl')" class="btn tag-link" :class="{'is-active': pageTag['webUrl']}">個人網址</a>
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<section class="page-section">
						<div id="profile" class="section-title">
							<h3>自我介紹</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="editClick(profile)">編輯自我介紹</a>
							</div>
						</div>
						<div class="section-content">
							<!--use pre-->
							<div class="lead" v-show="profile.info">
@{{ editData.about.Introduction }}
							</div>
							<!--end-->
							<div class="form-wrap" v-show="profile.edit">
								<form class="validate" id="profile-validate" @submit.prevent>
									<div class="form-group">
										<textarea class="form-black form-control validate[required]" name="userAbout" style="height: 200px;" v-model="editData.about.Introduction">
										</textarea>
									</div>
									<div class="form-button">
										<button type="clear" class="btn" @click="editClick(profile)">取消</button>
										<button type="button" class="btn btn-submit" @click="editPost(profile, 'profile')">確認</button>
									</div>
								</form>
							</div>
						</div>
					</section>
					<section class="page-section">
						<div id="education" class="section-title">
							<h3>學歷</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(educationAdd, 'add')">新增學歷資料</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
								<div class="form-wrap form-required" v-show="educationAdd.isActive">
									<form class="validate" id="educationAdd-validate" @submit.prevent>
										<div class="form-required text-blue">＊ 為必填</div>
										<div class="form-group">
											<label class="form-label form-label-required">學歷：</label>
											<select v-model="insertData.education.Education_type" class="form-inline form-control xs validate[required]">
												<option disabled :value="null">請選擇學歷</option>
												<option value="10">博士</option>
												<option value="9">碩士</option>
												<option value="8">大學</option>
												<option value="7">四技</option>
												<option value="6">二技</option>
												<option value="5">二專</option>
												<option value="4">三專</option>
												<option value="3">五專</option>
												<option value="2">高中</option>
												<option value="1">高職</option>
												<option value="0">國中(含)以下</option>
											</select>
										</div>
										<div class="form-group">
											<label class="form-label form-label-required">學校校名：</label>
											<input type="text" v-model="insertData.education.Sch_name" class="form-inline form-control xs validate[required]" value="">
										</div>
										<div class="form-group">
											<label class="form-label form-label-required">科系：</label>
											<input type="text" v-model="insertData.education.Dept_name" class="form-inline form-control xs validate[required]" value="">
										</div>
										<div class="form-group">
											<label class="form-label form-label-required">狀態：</label>
											<div class="form-inline form-radio-group">
												<label for="radio-1">
													<input type="radio" name="radio" id="radio-1" v-model="insertData.education.Status" value="1" checked="checked">
													畢業
												</label>
												<label for="radio-2">
													<input type="radio" name="radio" id="radio-2" v-model="insertData.education.Status" value="2">
													肄業
												</label>
												<label for="radio-3">
													<input type="radio" name="radio" id="radio-3" v-model="insertData.education.Status" value="3">
													就讀中
												</label>
											</div>
										</div>
										<div class="form-group">
											<label class="form-label">就學期間：</label>
											<div class="form-inline form-select-group">
												<date-picker id="add_during_start" placeholder="開始時間" readonly></date-picker>
											</div>
											<div class="form-offset">
												<div class="form-inline form-select-group">
													至
												<date-picker id="add_during_end" placeholder="結束時間" readonly></date-picker>
												</div>
											</div>
										</div>
										<div class="form-offset form-button">
											<a type="clear" class="btn" @click="listEdit(educationAdd, 'add')">取消</a>
											<button type="button" class="btn btn-submit" @click="editPost(educationAdd, 'educationAdd')">確認</button>
										</div>
									</form>
								</div>
							</transition>
							<table class="table list-table">
								<thead>
									<tr>
										<th class="th">學歷</th>
										<th class="th">學校校名</th>
										<th class="th">科系</th>
										<th class="th">狀態</th>
										<th class="th">就學期間</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.education">
									<tr>
										<td data-th="學歷">@{{ educationName(info.Education_type) }}</td>
										<td data-th="學校校名">@{{ info.Sch_name }}</td>
										<td data-th="科系">@{{ info.Dept_name }}</td>
										<td data-th="狀態">@{{ statusName(info.Status) }}</td>
										<td data-th="就學期間">@{{ info.During_start }} ~ @{{ info.During_end }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop="deleteAction('{{ url("/student/educationDelete") }}', info.Id)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand" v-show="info.edit">
										<td colspan="6" class="expand">
											<div class="form-wrap form-required">
												<form class="validate" :id="'educationEdit' + key + '-validate'" @submit.prevent>
													<div class="form-required text-blue">＊ 為必填</div>
													<div class="form-group">
														<label class="form-label form-label-required">學歷：</label>
														<select v-model="info.Education_type" class="form-inline form-control xs validate[required]">
															<option disabled :value="null">請選擇學歷</option>
															<option value="10">博士</option>
															<option value="9">碩士</option>
															<option value="8">大學</option>
															<option value="7">四技</option>
															<option value="6">二技</option>
															<option value="5">二專</option>
															<option value="4">三專</option>
															<option value="3">五專</option>
															<option value="2">高中</option>
															<option value="1">高職</option>
															<option value="0">國中(含)以下</option>
														</select>
													</div>
													<div class="form-group">
														<label class="form-label form-label-required">學校校名：</label>
														<input type="text" v-model="info.Sch_name" class="form-inline form-control xs validate[required]" value="">
													</div>
													<div class="form-group">
														<label class="form-label form-label-required">科系：</label>
														<input type="text" v-model="info.Dept_name" class="form-inline form-control xs validate[required]" value="">
													</div>
													<div class="form-group">
														<label class="form-label form-label-required">狀態：</label>
														<div class="form-inline form-radio-group">
															<label :for="'radio-education' + key + '-1'">
																<input type="radio" name="radio" :id="'radio-education' + key + '-1'" v-model="info.Status" value="1" checked="checked">
																畢業
															</label>
															<label :for="'radio-education' + key + '-2'">
																<input type="radio" name="radio" :id="'radio-education' + key + '-2'" v-model="info.Status" value="2">
																肄業
															</label>
															<label :for="'radio-education' + key + '-3'">
																<input type="radio" name="radio" :id="'radio-education' + key + '-3'" v-model="info.Status" value="3">
																就讀中
															</label>
														</div>
													</div>
													<div class="form-group">
														<label class="form-label">就學期間：</label>
														<div class="form-inline form-select-group">
															<date-picker :id="'edit_during_start' + key" class="date datepicker" :value="info.During_start" placeholder="開始時間" readonly></date-picker>
														</div>
														<div class="form-offset">
															<div class="form-inline form-select-group">
																至
															<date-picker :id="'edit_during_end' + key" class="date datepicker" :value="info.During_end" placeholder="開始時間" readonly></date-picker>
															</div>
														</div>
													</div>
													<div class="form-offset form-button">
														<a type="clear" class="btn" @click="listEdit(info, 'edit')">取消</a>
														<button type="button" class="btn btn-submit" @click="editPost(info, 'educationEdit', key)">確認</button>
													</div>
												</form>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="work" class="section-title">
							<h3>工作經驗</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(workAdd, 'add')">新增工作經驗</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="workAdd.isActive">
								<form class="validate" id="workAdd-validate" @submit.prevent>
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">企業名稱：</label>
									<input type="text" v-model="insertData.work.Work_name" class="form-inline form-control xs validate[required]">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">職務名稱：</label>
									<input type="text" v-model="insertData.work.Work_job_title" class="form-inline form-control xs">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">工作性質：</label>
									<input type="text" v-model="insertData.work.Work_nature" class="form-inline form-control xs">
								</div>
								<div class="form-group">
									<label class="form-label">就職期間：</label>
									<div class="form-inline form-select-group">
										<date-picker id="add_work_time_start" placeholder="開始時間" readonly></date-picker>
									</div>
									<div class="form-offset">
										<div class="form-inline form-select-group">
											至
										<date-picker id="add_work_time_end" placeholder="結束時間" readonly></date-picker>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="form-label">工作內容：</label>
									<textarea class="form-black form-control sm" v-model="insertData.work.Work_detail">
									</textarea>
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn"  @click="listEdit(workAdd, 'add')">取消</button>
									<button type="button" class="btn btn-submit" @click="editPost(workAdd, 'workAdd')">確認</button>
								</div>
								</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">企業名稱</th>
										<th class="th">職務名稱</th>
										<th class="th">就職期間</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.work">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="企業名稱">@{{ info.Work_name }}</td>
										<td data-th="職務名稱">@{{ info.Work_job_title }}</td>
										<td data-th="就職期間">@{{ info.Work_time_start }} ~ @{{ info.Work_time_end }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop="deleteAction('{{ url("/student/workDelete") }}', info.Id)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="info.edit">
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">企業名稱：</label>
													<input type="text" v-model="info.Work_name" class="form-inline form-control xs validate[required]" v-model="info.Work_name">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">職務名稱：</label>
													<input type="text" v-model="info.Work_job_title" class="form-inline form-control xs" v-model="info.Work_job_title">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">工作性質：</label>
													<input type="text" v-model="info.Work_nature" class="form-inline form-control xs">
												</div>
												<div class="form-group">
													<label class="form-label">就職期間：</label>
													<div class="form-inline form-select-group">
														<date-picker :id="'edit_work_start' + key" class="date datepicker" :value="info.Work_time_start" placeholder="開始時間" readonly></date-picker>
													</div>
													<div class="form-offset">
														<div class="form-inline form-select-group">
															至
														<date-picker :id="'edit_work_end' + key" class="date datepicker" :value="info.Work_time_end" placeholder="開始時間" readonly></date-picker>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="form-label">工作內容：</label>
													<textarea class="form-black form-control sm" v-model="info.Work_detail">
													</textarea>
												</div>
												<div class="form-offset form-button">
													<a type="clear" class="btn" @click="listEdit(info, 'edit')">取消</a>
													<button type="button" class="btn btn-submit" @click="editPost(info, 'workEdit', key)">確認</button>
												</div>
											</div>
											</transition>
											<transition name="fade">
											<ul class="lead-list"　v-show="info.info">
												<li><label>性質類別：</label><span>@{{ info.Work_nature }}</span></li>
												<li><label>工作內容：</label><span>@{{ info.Work_detail }}</span></li>
											</ul>
											</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="webUrl" class="section-title">
							<h3>個人網址</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="editClick(webUrl)">編輯個人網址</a>
							</div>
						</div>
						<div class="section-content">
							<ul class="lead-list" v-show="webUrl.info">
								<li><label>個人網址：</label><span><a href="" target="_blank">@{{ editData.web.URL }}</a></span></li>
								<li><label>描述：</label><span>@{{ editData.web.Remark }}</span></li>
							</ul>
							<div class="form-wrap" v-show="webUrl.edit">
								<form id="profileWeb-validate" @submit.prevent>
									<div class="form-group">
										<label class="form-label">個人網址：</label>
										<input type="text" class="form-inline form-control sm validate[required]" placeholder="http://" v-model="editData.web.URL">
									</div>
									<div class="form-group">
										<label class="form-label">描述：</label>
										<textarea class="form-inline form-control validate[required]" v-model="editData.web.Remark">
										</textarea>
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn">取消</button>
										<button type="button" class="btn btn-submit" @click="editPost(webUrl, 'profileWeb')">確認</button>
									</div>
								</form>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>

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
    	pageTag: {
    		'profile': false,
    		'education': false,
    		'teach': false,
    		'work': false,
    		'webUrl': false,
    	},
    	profile: {
    		info: true,
    		edit: false,
    	},
    	webUrl: {
    		info: true,
    		edit: false,
    	},
    	educationAdd: {
    		isActive: false,
    	},
    	workAdd: {
    		isActive: false,
    	},
    	editData: {
    		about: {
    			Introduction: '',
    		},
    		web: {
    			URL: '',
    			Remark: '',
    		},
    	},
    	insertData: {
    		education: {
    			Education_type: null,
    			Sch_name: '',
    			dept_name: '',
    			Status: 1,
    		},
    		work: {
    			Work_name: '',
    			Work_location: '',
    			Work_job_title: '',
    			Work_detail: '',
    			Work_nature: '',
    			Work_time_start: '',
    			Work_time_end: '',
    		}
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
	            url: '/student/resumeInit',
	            type: "get",
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
    	editPost: function(target, type, key) {
    		var ajaxUrl, postData;

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
    			case 'profile':
    				ajaxUrl = '/student/aboutEdit';
    				postData = {
    					Introduction: this.editData.about.Introduction,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				target.info = ! target.info;
    				break;
    			case 'profileWeb':
    				ajaxUrl = '/student/profileWeb';
    				postData = {
    					URL: this.editData.web.URL,
    					Remark: this.editData.web.Remark,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				target.info = ! target.info;
    				break;
    			case 'educationAdd':
    				ajaxUrl = '/student/educationAdd';
    				postData = {
    					Education_type: this.insertData.education.Education_type,
    					Sch_name: this.insertData.education.Sch_name,
    					Dept_name: this.insertData.education.Dept_name,
    					During_start: $('#add_during_start').val(),
    					During_end: $('#add_during_end').val(),
    					Status: this.insertData.education.Status,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				this.listEdit(target, 'add', '');
    				break;
    			case 'educationEdit':
    				ajaxUrl = '/student/educationEdit';
    				postData = {
    					Education_type: target.Education_type,
    					Sch_name: target.Sch_name,
    					Dept_name: target.Dept_name,
    					During_start: $('#edit_during_start' + key).val(),
    					During_end: $('#edit_during_end' + key).val(),
    					Status: target.Status,
    					Id: target.Id,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				break;
    			case 'workAdd':
    				ajaxUrl = '/student/workAdd';
    				postData = {
    					Work_name: this.insertData.work.Work_name,
    					Work_job_title: this.insertData.work.Work_job_title,
    					Work_nature: this.insertData.work.Work_nature,
    					Work_detail: this.insertData.work.Work_detail,
    					Work_time_start: $('#add_work_time_start').val(),
    					Work_time_end: $('#add_work_time_end').val(),
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				this.listEdit(target, 'add', '');
    				break;
    			case 'workEdit':
    				ajaxUrl = '/student/workEdit';
    				postData = {
    					Work_name: target.Work_name,
    					Work_job_title: target.Work_job_title,
    					Work_nature: target.Work_nature,
    					Work_detail: target.Work_detail,
    					Work_time_start: $('#edit_work_start' + key).val(),
    					Work_time_end: $('#edit_work_end').val(),
    					Id: target.Id,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				break;
    		}
    		if (target != '') {
	    		target.edit = ! target.edit;
    		}
    	},
    	clickDetail: function(target) {
    		target.info = ! target.info;
    	},
    	listEdit: function(target, type) {
    		if (type == 'add') {
    			target.isActive = ! target.isActive;
    		} else if  (type == 'edit') {
	    		target.edit = ! target.edit;
    		}
    	},
    	ajaxEdit: function(url, postData) {
    		header.toggleLoading();
        	var error = false;
        	var msg;
	        $.ajax({
	            url: url,
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            type: "post",
	            data: postData,
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
    	statusName: function(type) {
    		switch (parseInt(type)) {
    			case 1:
    				return '畢業';
    				break;
    			case 2:
    				return '肄業';
    				break;
    			case 3:
    				return '就讀中';
    				break;
    		}
    	},
    	educationName: function(type) {
    		switch (parseInt(type)) {
    			case 0:
    				return '國中(含)以下';
    				break;
    			case 1:
    				return '高職';
    				break;
    			case 2:
    				return '高中';
    				break;
    			case 3:
    				return '五專';
    				break;
    			case 4:
    				return '三專';
    				break;
    			case 5:
    				return '二專';
    				break;
    			case 6:
    				return '二技';
    				break;
    			case 7:
    				return '四技';
    				break;
    			case 8:
    				return '大學';
    				break;
    			case 9:
    				return '碩士';
    				break;
    			case 10:
    				return '博士';
    				break;
    		}
    	},
    	deleteAction: function(url, id) {
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
				container.goDelete(url, id);
			}, function(dismiss) {
				//cancel
			})
    	},
    	goDelete: function(url, id) {
    		header.toggleLoading();
        	var error = false;
        	var msg;
	        $.ajax({
	            url: url,
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            type: "delete",
	            data: {Id: id},
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







