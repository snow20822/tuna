@extends('layouts.teacher.app')
@section('content')
<!-- container -->
<div id="page-container">
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">活動與輔導</h1>
				<div class="mem-infor clearfix">
					@include('layouts.teacher.user-info')
				</div>
				<div class="page-tag">
					<a @click="goTarget('activity')" class="btn tag-link" :class="{'is-active': pageTag['activity']}">活動成果表</a>
					<a @click="goTarget('talks')" class="btn tag-link" :class="{'is-active': pageTag['talks']}">會談記錄表</a>
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<div class="page-section">
						<div class="section-title">
							<h3>活動成果表</h3>
						</div>
						<div class="section-content">
							<div class="section-feature">
								<div class="form-group">
									<select class="form-inline form-control xs" v-model="insertData.term.activity" v-for="(info, key) in editData.getActivityTerm" @change="activityTerm(info)">
										<option value="@{{info}}">@{{info}}學年度</option>
											<option disabled :value="null">請選擇學年度</option>
									</select>
								</div>
							</div>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th" width="15%">學期</th>
										<th class="th">系所年級</th>
										<th class="th">活動名稱</th>
										<th class="th">活動時間</th>
										<th class="th">活動地點</th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.activity">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons">keyboard_arrow_down</i></td>
										<td data-th="學期">@{{info.Acti_term}}學年度</td>
										<td data-th="系所年級">@{{info.Acti_grade}}</td>
										<td data-th="活動名稱">@{{info.Acti_name}}</td>
										<td data-th="活動時間">@{{info.Acti_time_start}}~@{{info.Acti_time_end}}</td>
										<td data-th="活動地點">@{{info.Acti_location}}</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
											<ul class="lead-list" v-show="info.info">
												<li><label class="breakline">活動內容簡述暨成果檢討：</label>
												<span>@{{info.Acti_content}}</span></li>
												<li><label>活動照片：</label><span><a href="" class="table-img"><img src="http://www.tnnua.edu.tw/ezfiles/0/1000/img/1/133606878.jpg"></a>
												<a href="" class="table-img"><img src="http://www.tnnua.edu.tw/ezfiles/0/1000/img/1/133606878.jpg"></a>
												<a href="" class="table-img"><img src="http://www.tnnua.edu.tw/ezfiles/0/1000/img/1/133606878.jpg"></a></span></li>
											</ul>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="page-section">
						<div class="section-title">
							<h3>會談記錄表</h3>
						</div>
						<div class="section-content">
							<div class="section-feature">
								<div class="form-group">
									<select class="form-inline form-control xs" v-model="insertData.term.talks" v-for="(info, key) in editData.getTalksTerm" @change="talksTerm(info)">
										<option value="@{{info}}">@{{info}}學年度</option>
											<option disabled :value="null">請選擇學年度</option>
									</select>
								</div>
							</div>
							<table class="table list-table">
								<thead>
									<tr>
										<th class="th" width="15%">學期</th>
										<th class="th">學號</th>
										<th class="th">姓名</th>
										<th class="th">會談時間</th>
										<th class="th">會談類別</th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.talks">
									<tr>
										<td data-th="學期">@{{info.Talks_term}}學年度</td>
										<td data-th="學號">@{{info.Talks_num}}</td>
										<td data-th="姓名">@{{info.Talks_name}}</td>
										<td data-th="會談時間">@{{info.Talks_time}}</td>
										<td data-th="會談類別">@{{info.Talks_class}}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
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
    	pageTag: {
    		'activity': false,
    		'talks': false,
    	},
    	activity: {
    		info: true,
    		edit: false,
    	},
    	talks: {
    		info: true,
    		edit: false,
    	},
    	editData: {
    	},
    	postData: {
    	},
    	insertData: {
    		term: {
    			activity: null,
    			talks: null,
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
	            url: '/teacher/activityRecordInit',
	            type: "get",
	            success: function(response) {
	            	container.editData = response;
	            	header.notLoading.loaded = true;
	            }
	        });
    	},
    	activityTerm: function(term) {
    		header.toggleLoading();
	        $.ajax({
	            url: '/teacher/activityTerm',
	            type: "post",
	            data:{'Acti_term':term},
	            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	            success: function(response) {
	            	container.editData.activity = response;
	            	header.notLoading.loaded = true;
	            }
	        });
    	},
    	talksTerm: function(term) {
    		header.toggleLoading();
	        $.ajax({
	            url: '/teacher/talksTerm',
	            type: "post",
	            data:{'Talks_term':term},
	            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	            success: function(response) {
	            	container.editData.talks = response;
	            	header.notLoading.loaded = true;
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
    			case 'talksAdd':
    				ajaxUrl = '/teacher/talksAdd';
    				postData = {
    					Results_term: this.insertData.talks.Results_term,
    					Results_stu: this.insertData.talks.Results_stu,
    					Results_paper: this.insertData.talks.Results_paper,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				this.initData();
    				this.listEdit(target, 'add', '');
    			break;
    			case 'talksEdit':
    				ajaxUrl = '/teacher/talksEdit';
    				postData = {
    					Results_term: target.Results_term,
    					Results_stu: target.Results_stu,
    					Results_paper: target.Results_paper,
    					Id: target.Id,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    			break;
    		}
    		if (target != '') {
    			target.info = ! target.info;
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
    	deleteAction: function(url, id) {
			swal({
				title: "確定要刪除嗎？",
				text: "您將會刪除此筆資料",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "確認",
				cancelButtonText: "取消",
			}).then(function() {
				container.goDelete(url, id);
			}, function(dismiss) {
				//cancel
			})
    	},
    	goDelete: function(url, id) {
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







