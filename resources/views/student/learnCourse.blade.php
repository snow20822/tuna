@extends('layouts.student.app')
@section('content')
<!--chart.js-->
<script src="{{ asset('js/chart.bundle.js') }}"></script>
<script src="{{ asset('js/utils.js') }}"></script>
<!-- container -->
<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">學習歷程</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
				<div class="page-tag">
					<a @click="goTarget('history')" :class="{'is-active': pageTag['history']}" class="btn tag-link">歷年修課紀錄</a>
					<a @click="goTarget('leave')" :class="{'is-active': pageTag['leave']}" class="btn tag-link">歷年請假缺曠紀錄</a>
					<a @click="goTarget('learn')" :class="{'is-active': pageTag['learn']}" class="btn tag-link">服務學習</a>
					<a @click="goTarget('exp')" :class="{'is-active': pageTag['exp']}" class="btn tag-link">心得與檢討</a>
					<a @click="goTarget('class')" :class="{'is-active': pageTag['class']}" class="btn tag-link">課程討論</a>
					<a @click="goTarget('radar')" :class="{'is-active': pageTag['radar']}" class="btn tag-link">雷達圖</a>
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<section class="page-section">
						<div id="history" class="section-title">
							<h3>歷年修課紀錄</h3>
						</div>
						<div class="section-content">
							<div class="section-feature">
								<div class="form-group">
									<select class="form-inline form-control xs" @change="searchTerm('history', $event)">
										<option v-for="(info, key) in allTerm.history" :value="key" :selected="(info.Sch_term == searchData.historyTerm) && (info.Sch_term_type == searchData.historyTermType)">@{{ info.Sch_term }}@{{ getTermName(info.Sch_term_type) }} 學期</option>
									</select>
								</div>
							</div>
							<table class="table list-table">
								<thead>
									<tr>
										<th class="th">學期</th>
										<th class="th">課程名稱</th>
										<th class="th">學分數</th>
										<th class="th">成績</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="info in infoData.history">
										<td data-th="學期">@{{ info.Sch_term }}@{{ getTermName(info.Sch_term_type) }} 學期</td>
										<td data-th="課程名稱">@{{ info.course_name }}</td>
										<td data-th="學分數">@{{ info.Credits }}</td>
										<td data-th="成績">@{{ info.score }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="leave" class="section-title">
							<h3>歷年請假缺曠紀錄</h3>
						</div>
						<div class="section-content">
							<div class="section-feature">
								<div class="form-group">
									<select class="form-inline form-control xs" @change="searchTerm('absent', $event)">
										<option v-for="(info, key) in allTerm.absent" :value="key" :selected="(info.Sch_term == searchData.absentTerm) && (info.Sch_term_type == searchData.absentTermType)">@{{ info.Sch_term }}@{{ getTermName(info.Sch_term_type) }} 學期</option>
									</select>
								</div>
							</div>
							<table class="table list-table">
								<thead>
									<tr>
										<th class="th">學期</th>
										<th class="th">課程名稱</th>
										<th class="th">請假/缺曠日期</th>
										<th class="th">請假/缺曠時數</th>
										<th class="th">請假/缺曠原因</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="info in infoData.absent">
										<td data-th="學期">@{{ info.Sch_term }}@{{ getTermName(info.Sch_term_type) }} 學期</td>
										<td data-th="課程名稱">@{{ info.course_name }}</td>
										<td data-th="請假/缺曠日期">@{{ info.Absent_date }}</td>
										<td data-th="請假/缺曠時數">@{{ info.Absent_time }}</td>
										<td data-th="請假/缺曠原因">@{{ info.Absent_reason }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="learn" class="section-title">
							<h3>服務學習</h3>
						</div>
						<div class="section-content">
							<div class="section-feature">
								<div class="form-group">
									<select class="form-inline form-control xs" @change="searchTerm('service', $event)">
										<option v-for="(info, key) in allTerm.service" :value="key" :selected="(info.Sch_term == searchData.serviceTerm) && (info.Sch_term_type == searchData.serviceTermType)">@{{ info.Sch_term }}@{{ getTermName(info.Sch_term_type) }} 學期</option>
									</select>
								</div>
							</div>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th" width="15%">學期</th>
										<th class="th">單位名稱</th>
										<th class="th">服務地點</th>
										<th class="th">起訖時間</th>
									</tr>
								</thead>
								<tbody v-for="info in infoData.service">
									<tr class="js-drop" :class="{'is-active': info.info }" @click="toggleInfo(info)">
										<td class="td-arrow align-center"><i class="material-icons">keyboard_arrow_down</i></td>
										<td data-th="學期">@{{ info.Sch_term }}@{{ getTermName(info.Sch_term_type) }} 學期</td>
										<td data-th="單位名稱">@{{ info.Unit_name }}</td>
										<td data-th="服務地點">@{{ info.Serv_location }}</td>
										<td data-th="起訖時間">@{{ info.Serv_date_start }} ~ @{{ info.Serv_date_end }}</td>
									</tr>
									<tr class="js-expand" v-show="info.info">
										<td colspan="8" class="expand">
											<ul class="lead-list">
												<li><label>心得分享：</label><span>@{{ info.Serv_Experience }}</span></li>
											</ul>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="exp" class="section-title">
							<h3>心得與檢討</h3>
						</div>
						<div class="section-content">
							<div class="section-feature">
								<div class="form-group">
									<select class="form-inline form-control xs">
										<option v-for="(info, key) in allTerm.service" :value="key" :selected="(info.Sch_term == searchData.serviceTerm) && (info.Sch_term_type == searchData.serviceTermType)">@{{ info.Sch_term }}@{{ getTermName(info.Sch_term_type) }} 學期</option>
									</select>
								</div>
							</div>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th" width="15%">學期</th>
										<th class="th">課程名稱</th>
										<th class="th">學分數</th>
										<th class="th">請假/缺曠時數</th>
										<th class="th">成績</th>
									</tr>
								</thead>
								<tbody>
									<tr class="js-drop">
										<td class="td-arrow align-center"><i class="material-icons">keyboard_arrow_down</i></td>
										<td data-th="學期">1001 學期</td>
										<td data-th="課程名稱">50</td>
										<td data-th="學分數">3</td>
										<td data-th="請假/缺曠時數">10</td>
										<td data-th="成績">98</td>
									</tr>
									<tr class="js-expand" style="display: none">
										<td colspan="8" class="expand">
											<ul class="lead-list">
												<li><label>心得與檢討：</label><span>test</span></li>
											</ul>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="class" class="section-title">
							<h3>課程討論</h3>
						</div>
						<div class="section-content">
							<table class="table list-table">
								<thead>
									<tr>
										<th class="th" width="30%">課程名稱</th>
										<th class="th">主題討論</th>
									</tr>
								</thead>
								<tbody>
									<tr class="js-drop">
										<td data-th="課程名稱">進階網球</td>
										<td data-th="主題討論"><a class="table-link" href="/student/learn/course/discuss">如何發出外炫發球 ??</a></td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="radar" class="section-title">
							<h3>雷達圖</h3>
						</div>
						<div class="section-content">
            				<canvas id="chart-legend-right"></canvas>
						</div>
					</section>
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
    	pageTag: {
    		'history': false,
    		'leave': false,
    		'learn': false,
    		'radar': false,
    		'exp': false,
    	},
    	infoData: {},
    	allTerm: {},
    	searchData: {},
    },
    mounted: function () {
    	//init data
    	this.initAllTerm();
    	this.initData();
    },
    methods: {
    	initData: function() {
    		header.toggleLoading();
	        $.ajax({
	            url: '/student/learnCourseInit',
	            type: "get",
	            success: function(response) {
	            	container.infoData = response.infoData;
	            	container.searchData = response.searchData;
	            	header.toggleLoading();
	            }
	        });
    	},
    	initAllTerm: function() {
	        $.ajax({
	            url: '/student/initAllTerm',
	            type: "get",
	            success: function(response) {
	            	container.allTerm = response;
	            }
	        });
    	},
    	setSearchData: function(search) {
	        $.ajax({
	            url: '/student/setSearchData',
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            },
	            data: search,
	            type: "post",
	            success: function(response) {
	            	if (response.status == 'success') {
	            		container.initData();
	            	}
	            }
	        });
    	},
        toggleInfo: function(target) {
            target.info = ! target.info;
    	},
        experience: function() {
            this.experienceClass = ! this.experienceClass;
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
    	getTermName: function(type) {
    		return type;
    	},
    	searchTerm: function(type, event) {
    		var key = event.target.value;
    		var search;

    		switch (type) {
    			case 'history':
    				search = {
    					historyTerm : this.allTerm.history[key].Sch_term,
    					historyTermType : this.allTerm.history[key].Sch_term_type
    				};
    				this.setSearchData(search);
    				break;
    			case 'absent':
    				search = {
    					absentTerm : this.allTerm.absent[key].Sch_term,
    					absentTermType : this.allTerm.absent[key].Sch_term_type
    				};
    				this.setSearchData(search);
    				break;
    			case 'service':
    				search = {
    					serviceTerm : this.allTerm.service[key].Sch_term,
    					serviceTermType : this.allTerm.service[key].Sch_term_type
    				};
    				this.setSearchData(search);
    				break;
    		}
    	}
    }
})
</script>
<script src="{{ asset('js/chart-setting.js') }}"></script>
@stop





