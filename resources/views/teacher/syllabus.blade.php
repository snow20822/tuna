@extends('layouts.teacher.app')
@section('content')
	<div id="page-container">
		<div id="page-body">
			<div class="page-row clearfix">
				<div class="page-slide">
					<h1 class="page-title" title="title">教學成果</h1>
					<div class="mem-infor clearfix">
						@include('layouts.teacher.user-info')
					</div>
					<div class="page-tag">
						<a @click="goTarget('teaching')" class="btn tag-link" :class="{'is-active': pageTag['teaching']}">學期與歷年課表</a>
						<a @click="goTarget('teachstu')" class="btn tag-link" :class="{'is-active': pageTag['teachstu']}">指導學生</a>
					</div>
				</div>
				<div class="page-content">
					<div class="page-article">
						<div class="page-section">
							<div id="teaching" class="section-title">
								<h3>學期與歷年課表</h3>
							</div>
							<div class="section-content">
								<div class="section-feature">
									<div class="form-group">
										<select class="form-inline form-control xs" v-model="insertData.term.teaching" v-for="(info, key) in editData.getTeachingTerm" @change="teachingTerm(info)">
											<option value="@{{info}}">@{{info}}學年度</option>
											<option disabled :value="null">請選擇學年度</option>
										</select>
									</div>
								</div>
								<table class="table list-table">
									<thead>
										<tr>
											<th class="th">學期</th>
											<th class="th">課程名稱</th>
											<th class="th">學分數</th>
										</tr>
									</thead>
									<tbody v-for="(info, key) in editData.teaching">
										<tr>
											<td data-th="學期">@{{info.Results_term}}學年度</td>
											<td data-th="課程名稱">@{{info.Results_name}}</td>
											<td data-th="學分數">@{{info.Results_credits}}</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="page-section">
							<div id="teachstu" class="section-title">
								<h3>指導學生</h3>
								<div class="section-title-right">
									<a class="btn btn-edit" @click="listEdit(teachstuAdd, 'add')">新增指導學生</a>
								</div>
							</div>
							<div class="section-content">
								<transition name="fade">
								<div class="form-wrap form-required" v-show="teachstuAdd.isActive">
							<form class="validate" id="teachstuAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">學年度：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.teachstu.Results_term" value="">
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">學生姓名：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.teachstu.Results_stu"  value="">
									</div>
									<div class="form-group">
										<label class="form-label form-label">論文題目：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.teachstu.Results_paper" value="">
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(teachstuAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(teachstuAdd, 'teachstuAdd')">確認</button>
									</div>
									</form>
								</div>
								</transition>
								<div class="section-feature">
									<div class="form-group">
										<select class="form-inline form-control xs" v-model="insertData.term.teachstu" v-for="(info, key) in editData.getTeachstuTerm" @change="teachstuTerm(info)">
											<option value="@{{info}}">@{{info}}學年度</option>
											<option disabled :value="null">請選擇學年度</option>
										</select>
									</div>
								</div>
								<table class="table list-table">
									<thead>
										<tr>
											<th class="th">學生姓名</th>
											<th class="th">論文題目</th>
											<th class="th"></th>
										</tr>
									</thead>
									<tbody v-for="(info, key) in editData.teachstu">
										<tr>
											<td data-th="學期">@{{info.Results_stu}}</td>
											<td data-th="課程名稱">@{{info.Results_paper}}</td>
											<td data-th="功能" class="td-features">
												<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop="deleteAction('{{ url("/teacher/teachstuDelete") }}', info.Id)"><i class="material-icons">close</i><span>delete</span></a>
											</td>
										</tr>
										<tr class="js-expand" v-show="info.edit">
											<td colspan="5" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required">
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">學年度：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Results_term" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">學生姓名：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Results_stu" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">論文題目：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Results_paper" value="">
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
													<button type="submit" class="btn btn-submit"@click="editPost(info, 'teachstuEdit', key)">確認</button>
												</div>
											</div>
											</transition>
		
											</td>
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
    		'teaching': false,
    		'teachstu': false,
    	},
    	teaching: {
    		info: true,
    		edit: false,
    	},
    	teachstuAdd: {
    		isActive: false,
    	},
    	teachstu: [
	    	{
	    		isActive: false,
	    		edit: false,
	    	},
	    	{
	    		isActive: false,
	    		edit: false,
	    	},
    	],
    	editData: {
    	},
    	postData: {
    	},
    		insertData: {
    		term: {
    			teaching: null,
    			teachstu: null,
    		},
    		teachstu: {
    			Results_term: '',
    			Results_stu: '',
    			Results_paper: '',
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
	            url: '/teacher/syllabusInit',
	            type: "get",
	            success: function(response) {
	            	container.editData = response;
	            	header.notLoading.loaded = true;
	            }
	        });
    	},
    	teachingTerm: function(term) {
    		header.toggleLoading();
	        $.ajax({
	            url: '/teacher/teachingTerm',
	            type: "post",
	            data:{'Results_term':term},
	            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	            success: function(response) {
	            	container.editData.teaching = response;
	            	header.notLoading.loaded = true;
	            }
	        });
    	},
    	teachstuTerm: function(term) {
    		header.toggleLoading();
	        $.ajax({
	            url: '/teacher/teachstuTerm',
	            type: "post",
	            data:{'Results_term':term},
	            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
	            success: function(response) {
	            	container.editData.teachstu = response;
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
    			case 'teachstuAdd':
    				ajaxUrl = '/teacher/teachstuAdd';
    				postData = {
    					Results_term: this.insertData.teachstu.Results_term,
    					Results_stu: this.insertData.teachstu.Results_stu,
    					Results_paper: this.insertData.teachstu.Results_paper,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				this.initData();
    				this.listEdit(target, 'add', '');
    			break;
    			case 'teachstuEdit':
    				ajaxUrl = '/teacher/teachstuEdit';
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







