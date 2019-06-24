@extends('layouts.student.app')
@section('content')
<!-- container -->
<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">榮譽紀錄</h1>
				<div class="page-infor-wrap">
					<div class="mem-infor clearfix">
						@include('layouts.student.user-info')
					</div>
					<div class="page-tag">
						<a @click="goTarget('Schship')" :class="{'is-active': pageTag['Schship']}" class="btn tag-link is-active">獎學金</a>
						<a @click="goTarget('Race')" :class="{'is-active': pageTag['Race']}" class="btn tag-link">競賽獲獎</a>
						<a @click="goTarget('RandP')" :class="{'is-active': pageTag['RandP']}" class="btn tag-link">獎懲紀錄</a>
					</div>
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<div class="page-section">
						<div class="section-title">
							<h3>獎學金</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(SchshipAdd, 'add')">新增獎學金</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="SchshipAdd.isActive">
								<form class="validate" id="SchshipAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期：</label>
										<select v-model="insertData.Schship.Schship_term" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											@foreach(getTermRound() as $term)
												<option value="{{ $term }}">{{ $term }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期上下：</label>
										<select v-model="insertData.Schship.Schship_term_type" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											<option value="1">1</option>
											<option value="2">2</option>
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">獎學金名稱：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.Schship.Schship_name">
									</div>
									<div class="form-group">
										<label class="form-label form-label">心得分享：</label>
										<textarea class="form-black form-control xs" v-model="insertData.Schship.Schship_exp"></textarea>
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(SchshipAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(SchshipAdd, 'SchshipAdd')">確認</button>
									</div>
								</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th" width="15%">學期</th>
										<th class="th">獎學金名稱</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.Schship">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="學期">@{{ info.Schship_term }}@{{ getTermName(info.Schship_term_type) }} 學期</td>
										<td data-th="獎學金名稱">@{{ info.Schship_name }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop.prevent="deleteAction('{{ url("/student/honoraryRecord/schshipDelete") }}', info)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="8" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="info.isActive">
												<form class="validate" :id="'SchshipEdit' + key + '-validate'" @submit.prevent>
													<div class="form-required text-blue">＊ 為必填</div>
													<div class="form-group">
														<label class="form-label form-label-required">學期：</label>
														<select v-model="info.Schship_term" class="form-inline form-control xs validate[required]">
															<option disabled :value="null">請選擇學期</option>
															@foreach(getTermRound() as $term)
																<option value="{{ $term }}">{{ $term }}</option>
															@endforeach
														</select>
													</div>
													<div class="form-group">
														<label class="form-label form-label-required">學期上下：</label>
														<select v-model="info.Schship_term_type" class="form-inline form-control xs validate[required]">
															<option disabled :value="null">請選擇學期</option>
															<option value="1">1</option>
															<option value="2">2</option>
														</select>
													</div>
													<div class="form-group">
														<label class="form-label form-label-required">獎學金名稱：</label>
														<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Schship_name">
													</div>
													<div class="form-group">
														<label class="form-label form-label">心得分享：</label>
														<textarea class="form-black form-control xs" v-model="info.Schship_exp"></textarea>
													</div>
													<div class="form-offset form-button">
														<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
														<button type="submit" class="btn btn-submit" @click="editPost(info, 'SchshipEdit', key)">確認</button>
													</div>
												</form>
											</div>
											</transition>
											<transition name="fade">
												<ul class="lead-list" v-show="info.info">
													<li><label>事蹟：</label><span>@{{ info.Schship_exp }}</span></li>
												</ul>
											</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="page-section">
						<div class="section-title">
							<h3>競賽獲獎</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(RaceAdd, 'add')">新增競賽獲獎</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="RaceAdd.isActive">
								<form class="validate" id="RaceAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期：</label>
										<select v-model="insertData.Race.Race_term" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											@foreach(getTermRound() as $term)
												<option value="{{ $term }}">{{ $term }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期上下：</label>
										<select v-model="insertData.Race.Race_term_type" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											<option value="1">1</option>
											<option value="2">2</option>
										</select>
									</div>
									<div class="form-group">
										<label class="form-label">主辦單位：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.Race.Race_unit">
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">競賽名稱：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.Race.Race_name">
									</div>
									<div class="form-group">
										<label class="form-label form-label">獎項：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.Race.Race_award">
									</div>
									<div class="form-group">
										<label class="form-label">活動地點：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.Race.Race_location">
									</div>
									<div class="form-group">
										<label class="form-label form-label">活動照片(一)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 1)">
									</div>
									<div class="form-group" v-if="photoPreview_1">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">活動照片(二)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 2)">
									</div>
									<div class="form-group" v-if="photoPreview_2">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">活動照片(三)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 3)">
									</div>
									<div class="form-group" v-if="photoPreview_3">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">心得分享：</label>
										<textarea class="form-black form-control xs" v-model="insertData.Race.Race_exp"></textarea>
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(RaceAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(RaceAdd, 'RaceAdd')">確認</button>
									</div>
								</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th" width="15%">學期</th>
										<th class="th">主辦單位</th>
										<th class="th">競賽名稱</th>
										<th class="th">獎項</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.Race">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="學期">@{{ info.Race_term }}@{{ getTermName(info.Race_term_type) }} 學期</td>
										<td data-th="主辦單位">@{{ info.Race_unit }}</td>
										<td data-th="競賽名稱">@{{ info.Race_name }}</td>
										<td data-th="獎項">@{{ info.Race_award }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop.prevent="deleteAction('{{ url("/student/honoraryRecord/raceDelete") }}', info)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="8" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="info.isActive">
												<form class="validate" :id="'RaceEdit' + key + '-validate'" @submit.prevent>
													<div class="form-required text-blue">＊ 為必填</div>
													<div class="form-group">
														<label class="form-label form-label-required">學期：</label>
														<select v-model="info.Race_term" class="form-inline form-control xs validate[required]">
															<option disabled :value="null">請選擇學期</option>
															@foreach(getTermRound() as $term)
																<option value="{{ $term }}">{{ $term }}</option>
															@endforeach
														</select>
													</div>
													<div class="form-group">
														<label class="form-label form-label-required">學期上下：</label>
														<select v-model="info.Race_term_type" class="form-inline form-control xs validate[required]">
															<option disabled :value="null">請選擇學期</option>
															<option value="1">1</option>
															<option value="2">2</option>
														</select>
													</div>
													<div class="form-group">
														<label class="form-label">主辦單位：</label>
														<input type="text" class="form-inline form-control xs" v-model="info.Race_unit">
													</div>
													<div class="form-group">
														<label class="form-label form-label-required">競賽名稱：</label>
														<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Race_name">
													</div>
													<div class="form-group">
														<label class="form-label form-label">獎項：</label>
														<input type="text" class="form-inline form-control xs" v-model="info.Race_award">
													</div>
													<div class="form-group">
														<label class="form-label">活動地點：</label>
														<input type="text" class="form-inline form-control xs" v-model="info.Race_location">
													</div>
													<div class="form-group">
														<label class="form-label form-label">活動照片(一)：</label>
														<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 1)">
													</div>
													<div class="form-group" v-if="photoPreview_1">
														<label class="form-label form-label"></label>
														<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
													</div>
													<div class="form-group">
														<label class="form-label form-label">活動照片(二)：</label>
														<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 2)">
													</div>
													<div class="form-group" v-if="photoPreview_2">
														<label class="form-label form-label"></label>
														<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
													</div>
													<div class="form-group">
														<label class="form-label form-label">活動照片(三)：</label>
														<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 3)">
													</div>
													<div class="form-group" v-if="photoPreview_3">
														<label class="form-label form-label"></label>
														<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
													</div>
													<div class="form-group">
														<label class="form-label form-label">心得分享：</label>
														<textarea class="form-black form-control xs" v-model="info.Race_exp"></textarea>
													</div>
													<div class="form-offset form-button">
														<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
														<button type="submit" class="btn btn-submit" @click="editPost(info, 'RaceEdit', key)">確認</button>
													</div>
												</form>
											</div>
											</transition>
											<transition name="fade">
											<ul class="lead-list" v-show="info.info">
												<li><label>活動地點：</label><span>@{{ info.Race_exp }}</span></li>
												<li>
													<label>活動照片：</label>
													<div class="gallery-list clearfix">
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_1" class="item" data-lightbox="image-Race_name" :data-title="info.Race_name" v-if="info.photo_decode.img_1 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_1 + ')' }"></div>
														        </div>
														    </div>
														</a>
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_2" class="item" data-lightbox="image-Race_name" :data-title="info.Race_name" v-if="info.photo_decode.img_2 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_2 + ')' }"></div>
														        </div>
														    </div>
														</a>
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_3" class="item" data-lightbox="image-Race_name" :data-title="info.Race_name" v-if="info.photo_decode.img_3 != ''">
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
					</div>
					<div class="page-section">
						<div class="section-title">
							<h3>獎懲紀錄</h3>
						</div>
						<div class="section-content">
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th" width="15%">學期</th>
										<th class="th">獎懲原因</th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.RandP">
									<tr class="js-drop">
										<td class="td-arrow align-center"><i class="material-icons">keyboard_arrow_down</i></td>
										<td data-th="學期">@{{ info.RandP_term }}@{{ getTermName(info.RandP_term_type) }} 學期</td>
										<td data-th="獎懲原因">@{{ info.RandP_reason }}</td>
									</tr>
									<tr class="js-expand">
										<td colspan="8" class="expand">
											<transition name="fade">
												<ul class="lead-list" v-show="info.info">
													<li><label>心得分享：</label><span>@{{ info.RandP_exp }}</span></li>
												</ul>
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
<!-- container end -->
<script>
var container = new Vue({
    el: '#page-container',
    data: {
    	photoPreview_1: '',
    	photoPreview_2: '',
    	photoPreview_3: '',
    	pageTag: {
    		'Schship': false,
    		'Race': false,
    		'RandP': false,
    	},
    	SchshipAdd: {
    		isActive: false,
    	},
    	RaceAdd: {
    		isActive: false,
    	},
    	editData: {},
    	formData: new FormData(),
    	insertData: {
    		Schship: {
    			Schship_term: '',
    			Schship_term_type: '',
    			Schship_name: '',
    			Schship_exp: '',
    		},
    		Race: {
    			Race_term: '',
    			Race_term_type: '',
    			Race_unit: '',
    			Race_name: '',
    			Race_location: '',
    			Race_award: '',
    			Race_exp: '',
    			Race_term_type: '',
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
	            url: '/student/honoraryRecord/init',
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
    			case 'SchshipAdd':
    				ajaxUrl = '/student/honoraryRecord/schshipAdd';
					container.formData.append('Schship_term',  container.insertData.Schship.Schship_term);
                    container.formData.append('Schship_name',  container.insertData.Schship.Schship_name);
                    container.formData.append('Schship_exp',  container.insertData.Schship.Schship_exp);
                    container.formData.append('Schship_term_type',  container.insertData.Schship.Schship_term_type);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('SchshipAdd');
    				break;
    			case 'SchshipEdit':
    				ajaxUrl = '/student/honoraryRecord/schshipEdit';
					container.formData.append('Id',  target.Id);
					container.formData.append('Schship_term',  target.Schship_term);
                    container.formData.append('Schship_name',  target.Schship_name);
                    container.formData.append('Schship_exp',  target.Schship_exp);
                    container.formData.append('Schship_term_type',  target.Schship_term_type);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('SchshipEdit');
    				break;
    			case 'RaceAdd':
    				ajaxUrl = '/student/honoraryRecord/raceAdd';
                    container.formData.append('Race_term',  container.insertData.Race.Race_term);
                    container.formData.append('Race_unit',  container.insertData.Race.Race_unit);
                    container.formData.append('Race_name',  container.insertData.Race.Race_name);
                    container.formData.append('Race_location',  container.insertData.Race.Race_location);
                    container.formData.append('Race_award',  container.insertData.Race.Race_award);
                    container.formData.append('Race_exp',  container.insertData.Race.Race_exp);
                    container.formData.append('Race_term_type',  container.insertData.Race.Race_term_type);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('RaceAdd');
    				break;
    			case 'RaceEdit':
    				ajaxUrl = '/student/honoraryRecord/raceEdit';
                    container.formData.append('Id',  target.Id);
                    container.formData.append('Folder',  target.Folder);
                    container.formData.append('SubFolder',  target.SubFolder);
                    container.formData.append('Race_term',  target.Race_term);
                    container.formData.append('Race_unit',  target.Race_unit);
                    container.formData.append('Race_name',  target.Race_name);
                    container.formData.append('Race_location',  target.Race_location);
                    container.formData.append('Race_award',  target.Race_award);
                    container.formData.append('Race_exp',  target.Race_exp);
                    container.formData.append('Race_term_type',  target.Race_term_type);
                    container.formData.append('Race_photo',  target.Race_photo);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'edit');
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
    			case 'SchshipAdd':
    				container.insertData.Schship = {
		    			Schship_term: '',
		    			Schship_term_type: '',
		    			Schship_name: '',
		    			Schship_exp: '',
		    		}
    				break;
    			case 'RaceAdd':
    				container.insertData.Race = {
		    			Race_term: '',
		    			Race_term_type: '',
		    			Race_unit: '',
		    			Race_name: '',
		    			Race_location: '',
		    			Race_award: '',
		    			Race_exp: '',
		    			Race_term_type: '',
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






