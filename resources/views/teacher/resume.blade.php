@extends('layouts.teacher.app')
@section('content')

<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">基本資料</h1>
				<div class="mem-infor clearfix">
					@include('layouts.teacher.user-info')
				</div>
				<div class="page-tag">
					<a @click="goTarget('introduction')" class="btn tag-link" :class="{'is-active': pageTag['introduction']}">簡介</a>
					<a @click="goTarget('education')" class="btn tag-link" :class="{'is-active': pageTag['education']}">學歷</a>
					<a @click="goTarget('work')" class="btn tag-link" :class="{'is-active': pageTag['work']}">經歷</a>
					<a @click="goTarget('honor')" class="btn tag-link" :class="{'is-active': pageTag['honor']}">榮譽獎項</a>
					<a @click="goTarget('room')" class="btn tag-link" :class="{'is-active': pageTag['room']}">研究室</a>
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<section class="page-section">
						<div id="introduction" class="section-title">
							<h3>簡介</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="editClick(editData.introduction)">編輯簡介</a>
							</div>
						</div>
						<div class="section-content">
							<div class="lead" v-show="editData.introduction.info">@{{ editData.introduction.Introduction }}
							</div>
							<div class="form-wrap" v-show="editData.introduction.edit">
								<div class="form-group">
									<textarea class="form-black form-control validate[required]" style="height: 200px;" v-model="editData.introduction.Introduction">@{{ editData.introduction.Introduction }}
									</textarea>
								</div>
								<div class="form-button">
									<button type="clear" class="btn" @click="editClick(introduction)">取消</button>
									<button type="submit" class="btn btn-submit" @click="editPost(editData.introduction, 'introductionEdit')">確認</button>
								</div>
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
									<label class="form-label form-label-required ">學歷：</label>
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
									<button type="clear" class="btn" @click="listEdit(educationAdd, 'add')">取消</button>
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
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.education">
									<tr>
										<td data-th="學歷">@{{educationName(info.Education_type)}}</td>
										<td data-th="學校校名">@{{info.Sch_name}}</td>
										<td data-th="科系">@{{info.Dept_name}}</td>
										<td data-th="狀態">@{{ info.During_start }} ~ @{{ info.During_end }}<br>(@{{ statusName(info.Status) }})</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop="deleteAction('{{ url("/teacher/educationDelete") }}', info.Id)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand"　v-show="info.edit">
										<td colspan="5" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required">
											<form class="validate" :id="'educationEdit' + key + '-validate'" @submit.prevent>
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required" >學歷：</label>
													<select class="form-inline form-control xs validate[required]" v-model="info.Education_type">
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
													<label class="form-label form-label-required ">學校校名：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Sch_name" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">科系：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Dept_name" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">狀態：</label>
													<div class="form-inline form-radio-group">
														<label :for="'radio-education' + key + '-1'">
														<input type="radio" name="radio" :id="'radio-education' + key + '-1'" v-model="info.Status" value="1" checked="checked">
																畢業
														</label>
														<label :for="'radio-education' + key + '-2'">
														<input type="radio" name="radio" :id="'radio-education' + key + '-2'" v-model="info.Status" value="2" checked="checked">
															肄業
														</label>
														<label :for="'radio-education' + key + '-3'">
															<input type="radio" name="radio" :id="'radio-education' + key + '-3'" v-model="info.Status" value="3" checked="checked">
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
													<button type="clear" class="btn" @click="listEdit(education, 'edit', 0)">取消</button>
													<button type="submit" class="btn btn-submit" @click="editPost(info, 'educationEdit', key)">確認</button>
												</div>
											</form>
											</div>
											</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="work" class="section-title">
							<h3>經歷</h3>
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
									<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.work.Work_name" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">職務名稱：</label>
									<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.work.Work_location" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">狀態：</label>
									<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.work.Work_time" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">性質類別：</label>
									<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.work.Work_class" value="">
								</div>
								<div class="form-group">
									<label class="form-label">工作內容：</label>
									<textarea class="form-black form-control sm" v-model="insertData.work.Work_detail">
									</textarea>
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn"  @click="listEdit(workAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit"  @click="editPost(workAdd, 'workAdd')">確認</button>
								</div>
							</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">序</th>
										<th class="th">企業名稱</th>
										<th class="th">職務名稱</th>
										<th class="th">狀態</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.work">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="序">最近工作</td>
										<td data-th="企業名稱">@{{ info.Work_name }}</td>
										<td data-th="職務名稱">@{{ info.Work_location }}</td>
										<td data-th="狀態">@{{ info.Work_time }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop="deleteAction('{{ url("/teacher/workDelete") }}', info.Id)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="info.edit">
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">企業名稱：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Work_name">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">職務名稱：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Work_location">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">狀態：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Work_time">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">性質類別：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Work_class">
												</div>
												<div class="form-group">
													<label class="form-label">工作內容：</label>
													<textarea class="form-black form-control sm" v-model="info.Work_detail">
													</textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
													<button type="submit" class="btn btn-submit"@click="editPost(info, 'workEdit', key)">確認</button>
												</div>
											</div>
											</transition>
											<transition name="fade">
												<ul class="lead-list" v-show="info.info">
													<li><label>性質類別：</label><span>@{{ info.Work_class }}</span></li>
													<li><label>工作內容：</label><span>
													@{{ info.Work_detail }}</span></li>
												</ul>
											</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="honor" class="section-title">
							<h3>榮譽獎項</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(honorAdd, 'add')">新增榮譽獎項</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="honorAdd.isActive">
							<form class="validate" id="honorAdd-validate" @submit.prevent>
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">日期：</label>
									<input type="text" v-model="insertData.honor.Honor_year" class="form-inline form-control xs validate[required]" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">頒發單位：</label>
									<input type="text" v-model="insertData.honor.Honor_unit" class="form-inline form-control xs validate[required]" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">獎項名稱：</label>
									<input type="text" v-model="insertData.honor.Honor_name" class="form-inline form-control xs validate[required]" value="">
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(honorAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="editPost(honorAdd, 'honorAdd')">確認</button>
								</div>
								</form>
							</div>
							</transition>
							<table class="table  list-table">
								<thead>
									<tr>
										<th class="th">年</th>
										<th class="th">頒發單位</th>
										<th class="th">獎項名稱</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.honor">
									<tr>
										<td data-th="年">@{{info.Honor_year}}</td>
										<td data-th="頒發單位">@{{info.Honor_unit}}</td>
										<td data-th="獎項名稱">@{{info.Honor_name}}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit', 0)"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop="deleteAction('{{ url("/teacher/honorDelete") }}', info.Id)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr class="js-expand" v-show="info.edit">
									<tr class="js-expand">
										<td colspan="5" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required">
											<form class="validate" :id="'honorEdit' + key + '-validate'" @submit.prevent>
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">日期：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Honor_year" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">頒發單位：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Honor_unit" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">獎項名稱：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Honor_name" value="">
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(honor, 'edit', 0)">取消</button>
													<button type="submit" class="btn btn-submit" @click="editPost(info, 'honorEdit', key)">確認</button>
												</div>
												</form>
											</div>
											</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="room" class="section-title">
							<h3>研究室</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(roomAdd, 'add')">新增研究室</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="roomAdd.isActive">
							<form class="validate" id="roomAdd-validate" @submit.prevent>
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">研究室名稱：</label>
									<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.room.Room_name" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">分機：</label>
									<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.room.Room_phone" value="">
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(roomAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="editPost(roomAdd, 'roomAdd')">確認</button>
								</div>
								</form>
							</div>
							</transition>
							<table class="table list-table">
								<thead>
									<tr>
										<th class="th">研究室名稱</th>
										<th class="th">分機</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.room">
									<tr class="js-drop">
										<td data-th="研究室名稱">@{{info.Room_name}}</td>
										<td data-th="分機">@{{info.Room_phone}}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop="deleteAction('{{ url("/teacher/roomDelete") }}', info.Id)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand" v-show="info.edit">
										<td colspan="5" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" >
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">研究室名稱：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Room_name" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">分機：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Room_phone" value="">
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn"  @click="listEdit(info, 'edit')">取消</button>
													<button type="submit" class="btn btn-submit" @click="editPost(info, 'roomEdit', key)">確認</button>
												</div>
											</div>
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
    		'introduction': false,
    		'education': false,
    		'about': false,
    		'work': false,
    		'honor': false,
    		'room': false,
    	},
    	introduction: {
    		info: true,
    		edit: false,
    	},
    	about: {
    		info: true,
    		edit: false,
    	},
    	workAdd: {
    		isActive: false,
    	},
    	educationAdd: {
    		isActive: false,
    	},
    	education: [
	    	{
	    		isActive: false,
	    		edit: false,
	    	},
	    	{
	    		isActive: false,
	    		edit: false,
	    	},
    	],
    	honorAdd: {
    		isActive: false,
    	},
    	honor: [
	    	{
	    		isActive: false,
	    		edit: false,
	    		info: false,
	    	},
	    	{
	    		isActive: false,
	    		edit: false,
	    		info: false,
	    	},
    	],
    	roomAdd: {
    		isActive: false,
    	},
    	room: [
	    	{
	    		isActive: false,
	    		edit: false,
	    		info: false,
	    	},
	    	{
	    		isActive: false,
	    		edit: false,
	    		info: false,
	    	},
    	],
    	editData: {
    	},
    	postData: {
    	},
    		insertData: {
    		education: {
    			Education_type: null,
    			Sch_name: '',
    			Dept_name: '',
    			Status: 1,
    			During_start: 1,
    			During_end: 1,
    		},
    		work: {
    			Work_name: null,
    			Work_location: '',
    			Work_time: '',
    			Work_class: '',
    			Work_detail: '',
    		},
    		honor: {
    			Honor_year: '',
    			Honor_unit: '',
    			Honor_name: '',
    		},
    		room: {
    			Room_name: '',
    			Room_phone: '',
    			Email: '',
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
	            url: '/teacher/resumeInit',
	            type: "get",
	            success: function(response) {
	            	container.editData = response;
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
    			case 'introductionEdit':
    				ajaxUrl = '/teacher/introductionEdit';
    				postData = {
    					Introduction: target.Introduction,
    					Id: target.Id,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				break;
    			case 'educationAdd':
    				ajaxUrl = '/teacher/educationAdd';
    				postData = {
    					Education_type: this.insertData.education.Education_type,
    					Sch_name: this.insertData.education.Sch_name,
    					Dept_name: this.insertData.education.Dept_name,
    					During_start: $('#add_during_start').val(),
    					During_end: $('#add_during_end').val(),
    					Status: this.insertData.education.Status,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				this.initData();
    				this.listEdit(target, 'add', '');
    			break;
    			case 'educationEdit':
    				ajaxUrl = '/teacher/educationEdit';
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
    				ajaxUrl = '/teacher/workAdd';
    				postData = {
    					Work_name: this.insertData.work.Work_name,
    					Work_location: this.insertData.work.Work_location,
    					Work_time: this.insertData.work.Work_time,
    					Work_class: this.insertData.work.Work_class,
    					Work_detail: this.insertData.education.Work_detail,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				this.initData();
    				this.listEdit(target, 'add', '');
    				target.info = ! target.info;
    			break;
    			case 'workEdit':
    				ajaxUrl = '/teacher/workEdit';
    				postData = {
    					Work_name: target.Work_name,
    					Work_location: target.Work_location,
    					Work_time: target.Work_time,
    					Work_class: target.Work_class,
    					Work_detail: target.Work_detail,
    					Id: target.Id,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				target.info = ! target.info;
    			break;
    			case 'honorAdd':
    				ajaxUrl = '/teacher/honorAdd';
    				postData = {
    					Honor_year: this.insertData.honor.Honor_year,
    					Honor_unit: this.insertData.honor.Honor_unit,
    					Honor_name: this.insertData.honor.Honor_name,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				this.initData();
    				this.listEdit(target, 'add', '');
    			break;
    			case 'honorEdit':
    				ajaxUrl = '/teacher/honorEdit';
    				postData = {
    					Honor_year: target.Honor_year,
    					Honor_unit: target.Honor_unit,
    					Honor_name: target.Honor_name,
    					Id: target.Id,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    			break;
    			case 'roomAdd':
    				ajaxUrl = '/teacher/roomAdd';
    				postData = {
    					Room_name: this.insertData.room.Room_name,
    					Room_phone: this.insertData.room.Room_phone,
    					Email: this.insertData.room.Email,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    				this.initData();
    				this.listEdit(target, 'add', '');
    			break;
    			case 'roomEdit':
    				ajaxUrl = '/teacher/roomEdit';
    				postData = {
    					Room_name: target.Room_name,
    					Room_phone: target.Room_phone,
    					//Email: target.Email,
    					Id: target.Id,
    				};
    				this.ajaxEdit(ajaxUrl, postData);
    			break;
    		}
    		if (target != '') {
    			target.info = ! target.info;
	    		target.edit = ! target.edit;
    		}
    		console.log(target);
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







