@extends('layouts.student.app')
@section('content')

<!-- container -->
<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">活動歷程</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
				<div class="page-tag">
					<a @click="goTarget('activity')" :class="{'is-active': pageTag['activity']}" class="btn tag-link">活動紀錄</a>
					<a @click="goTarget('community')" :class="{'is-active': pageTag['community']}" class="btn tag-link">參與社團</a>
					<a @click="goTarget('practice')" :class="{'is-active': pageTag['practice']}" class="btn tag-link">幹部經歷</a>
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<section class="page-section">
						<div id="activity" class="section-title">
							<h3>活動紀錄</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(activityAdd, 'add')">新增活動紀錄</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="activityAdd.isActive">
								<form class="validate" id="activityAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期：</label>
										<select v-model="insertData.activity.Activ_term" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											@foreach(getTermRound() as $term)
												<option value="{{ $term }}">{{ $term }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期上下：</label>
										<select v-model="insertData.activity.Activ_term_type" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											<option value="1">一</option>
											<option value="2">二</option>
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">活動名稱：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.activity.Activ_name">
									</div>
									<div class="form-group">
										<label class="form-label form-label">負責工作：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.activity.resb_work">
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
										<label class="form-label form-label">事蹟：</label>
										<textarea class="form-black form-control xs" v-model="insertData.activity.Deeds"></textarea>
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(activityAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(activityAdd, 'activityAdd')">確認</button>
									</div>
								</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">學期</th>
										<th class="th">活動名稱</th>
										<th class="th">負責工作</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.activity">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="學期">@{{ info.Activ_term }}@{{ getTermName(info.Activ_term_type) }} 學期</td>
										<td data-th="活動名稱">@{{ info.Activ_name }}</td>
										<td data-th="負責工作">@{{ info.resb_work }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop.prevent="deleteAction('{{ url("/student/activityCourse/activityDelete") }}', info)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="5" class="expand">
										<transition name="fade">
										<div class="form-wrap form-required" v-show="info.edit">
											<form class="validate" :id="'activityEdit' + key + '-validate'" @submit.prevent>
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期：</label>
													<select v-model="info.Activ_term" class="form-inline form-control xs validate[required]">
														<option disabled :value="null">請選擇學期</option>
														@foreach(getTermRound() as $term)
															<option value="{{ $term }}">{{ $term }}</option>
														@endforeach
													</select>
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期上下：</label>
													<select v-model="info.Activ_term_type" class="form-inline form-control xs validate[required]">
														<option disabled :value="null">請選擇學期</option>
														<option value="1">一</option>
														<option value="2">二</option>
													</select>
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">活動名稱：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Activ_name">
												</div>
												<div class="form-group">
													<label class="form-label form-label">負責工作：</label>
													<input type="text" class="form-inline form-control xs" v-model="info.resb_work">
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
													<label class="form-label form-label">事蹟：</label>
													<textarea class="form-black form-control xs" v-model="info.Deeds"></textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
													<button type="submit" class="btn btn-submit" @click="editPost(info, 'activityEdit', key)">確認</button>
												</div>
											</form>
										</div>
										</transition>
										<transition name="fade">
										<ul class="lead-list" v-show="info.info">
											<li><label>事蹟：</label><span>@{{ info.Deeds }}</span></li>
											<li>
												<label>活動照片：</label>
												<div class="gallery-list clearfix">
													<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_1" class="item" data-lightbox="image-activ" :data-title="info.Activ_name" v-if="info.photo_decode.img_1 != ''">
													    <div class="itemFrame">
													        <div class="innerFrame">
												        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_1 + ')' }"></div>
													        </div>
													    </div>
													</a>
													<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_2" class="item" data-lightbox="image-activ" :data-title="info.Activ_name" v-if="info.photo_decode.img_2 != ''">
													    <div class="itemFrame">
													        <div class="innerFrame">
												        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_2 + ')' }"></div>
													        </div>
													    </div>
													</a>
													<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_3" class="item" data-lightbox="image-activ" :data-title="info.Activ_name" v-if="info.photo_decode.img_3 != ''">
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
						<div id="community" class="section-title">
							<h3>參與社團</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(communityAdd, 'add')">新增參與社團</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="communityAdd.isActive">
								<form class="validate" id="communityAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期：</label>
										<select v-model="insertData.community.League_term" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											@foreach(getTermRound() as $term)
												<option value="{{ $term }}">{{ $term }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期上下：</label>
										<select v-model="insertData.community.League_term_type" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											<option value="1">一</option>
											<option value="2">二</option>
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">活動名稱：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.community.League_name">
									</div>
									<div class="form-group">
										<label class="form-label form-label">負責工作：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.community.League_work">
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
										<label class="form-label form-label">事蹟：</label>
										<textarea class="form-black form-control xs" v-model="insertData.community.League_Deeds"></textarea>
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(communityAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(communityAdd, 'communityAdd')">確認</button>
									</div>
								</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">學期</th>
										<th class="th">活動名稱</th>
										<th class="th">負責工作</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.community">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="學期">@{{ info.League_term }}@{{ getTermName(info.League_term_type) }} 學期</td>
										<td data-th="活動名稱">@{{ info.League_name }}</td>
										<td data-th="負責工作">@{{ info.League_work }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop.prevent="deleteAction('{{ url("/student/activityCourse/communityDelete") }}', info)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="5" class="expand">
										<transition name="fade">
										<div class="form-wrap form-required" v-show="info.edit">
											<form class="validate" :id="'communityEdit' + key + '-validate'" @submit.prevent>
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期：</label>
													<select v-model="info.League_term" class="form-inline form-control xs validate[required]">
														<option disabled :value="null">請選擇學期</option>
														@foreach(getTermRound() as $term)
															<option value="{{ $term }}">{{ $term }}</option>
														@endforeach
													</select>
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期上下：</label>
													<select v-model="info.League_term_type" class="form-inline form-control xs validate[required]">
														<option disabled :value="null">請選擇學期</option>
														<option value="1">一</option>
														<option value="2">二</option>
													</select>
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">活動名稱：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.League_name">
												</div>
												<div class="form-group">
													<label class="form-label form-label">負責工作：</label>
													<input type="text" class="form-inline form-control xs" v-model="info.League_work">
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
													<label class="form-label form-label">事蹟：</label>
													<textarea class="form-black form-control xs" v-model="info.League_Deeds"></textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
													<button type="submit" class="btn btn-submit" @click="editPost(info, 'communityEdit', key)">確認</button>
												</div>
											</form>
										</div>
										</transition>
										<transition name="fade">
										<ul class="lead-list" v-show="info.info">
											<li><label>事蹟：</label><span>@{{ info.Deeds }}</span></li>
											<li>
												<label>活動照片：</label>
												<div class="gallery-list clearfix">
													<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_1" class="item" data-lightbox="image-League" :data-title="info.League_name" v-if="info.photo_decode.img_1 != ''">
													    <div class="itemFrame">
													        <div class="innerFrame">
												        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_1 + ')' }"></div>
													        </div>
													    </div>
													</a>
													<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_2" class="item" data-lightbox="image-League" :data-title="info.League_name" v-if="info.photo_decode.img_2 != ''">
													    <div class="itemFrame">
													        <div class="innerFrame">
												        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_2 + ')' }"></div>
													        </div>
													    </div>
													</a>
													<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_3" class="item" data-lightbox="image-League" :data-title="info.League_name" v-if="info.photo_decode.img_3 != ''">
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
						<div id="practice" class="section-title">
							<h3>幹部經歷</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(practiceAdd, 'add')">新增幹部經歷</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="practiceAdd.isActive">
								<form class="validate" id="practiceAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期：</label>
										<select v-model="insertData.practice.Cadre_term" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											@foreach(getTermRound() as $term)
												<option value="{{ $term }}">{{ $term }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期上下：</label>
										<select v-model="insertData.practice.Cadre_term_type" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											<option value="1">一</option>
											<option value="2">二</option>
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">幹部名稱：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.practice.Cadre_name">
									</div>
									<div class="form-group">
										<label class="form-label form-label">負責工作：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.practice.Cadre_work">
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
										<label class="form-label form-label">事蹟：</label>
										<textarea class="form-black form-control xs" v-model="insertData.practice.Cadre_Deeds"></textarea>
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(practiceAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(practiceAdd, 'practiceAdd')">確認</button>
									</div>
								</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">學期</th>
										<th class="th">幹部名稱</th>
										<th class="th">負責工作</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.practice">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="學期">@{{ info.Cadre_term }}@{{ getTermName(info.Cadre_term_type) }} 學期</td>
										<td data-th="幹部名稱">@{{ info.Cadre_name }}</td>
										<td data-th="負責工作">@{{ info.Cadre_work }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop.prevent="deleteAction('{{ url("/student/activityCourse/practiceDelete") }}', info)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="5" class="expand">
										<transition name="fade">
										<div class="form-wrap form-required" v-show="info.edit">
											<form class="validate" :id="'practiceEdit' + key + '-validate'" @submit.prevent>
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期：</label>
													<select v-model="info.Cadre_term" class="form-inline form-control xs validate[required]">
														<option disabled :value="null">請選擇學期</option>
														@foreach(getTermRound() as $term)
															<option value="{{ $term }}">{{ $term }}</option>
														@endforeach
													</select>
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期上下：</label>
													<select v-model="info.Cadre_term_type" class="form-inline form-control xs validate[required]">
														<option disabled :value="null">請選擇學期</option>
														<option value="1">一</option>
														<option value="2">二</option>
													</select>
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">幹部名稱：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Cadre_name">
												</div>
												<div class="form-group">
													<label class="form-label form-label">負責工作：</label>
													<input type="text" class="form-inline form-control xs" v-model="info.Cadre_work">
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
													<label class="form-label form-label">事蹟：</label>
													<textarea class="form-black form-control xs" v-model="info.Cadre_Deeds"></textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
													<button type="submit" class="btn btn-submit" @click="editPost(info, 'practiceEdit', key)">確認</button>
												</div>
											</form>
										</div>
										</transition>
										<transition name="fade">
										<ul class="lead-list" v-show="info.info">
											<li><label>事蹟：</label><span>@{{ info.Deeds }}</span></li>
											<li>
												<label>活動照片：</label>
												<div class="gallery-list clearfix">
													<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_1" class="item" data-lightbox="image-Cadre" :data-title="info.Cadre_name" v-if="info.photo_decode.img_1 != ''">
													    <div class="itemFrame">
													        <div class="innerFrame">
												        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_1 + ')' }"></div>
													        </div>
													    </div>
													</a>
													<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_2" class="item" data-lightbox="image-Cadre" :data-title="info.Cadre_name" v-if="info.photo_decode.img_2 != ''">
													    <div class="itemFrame">
													        <div class="innerFrame">
												        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_2 + ')' }"></div>
													        </div>
													    </div>
													</a>
													<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_3" class="item" data-lightbox="image-Cadre" :data-title="info.Cadre_name" v-if="info.photo_decode.img_3 != ''">
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
var container = new Vue({
    el: '#page-container',
    data: {
        photoClass: false,
    	pageTag: {
    		'activity': false,
    		'community': false,
    		'practice': false,
    	},
    	activityAdd: {
    		isActive: false,
    	},
    	communityAdd: {
    		isActive: false,
    	},
    	practiceAdd: {
    		isActive: false,
    	},
    	photoPreview_1: '',
    	photoPreview_2: '',
    	photoPreview_3: '',
    	formData: new FormData(),
    	editData: {},
    	insertData: {
    		activity: {
    			Activ_term: null,
    			Activ_name: '',
    			Deeds: '',
    			resb_work: '',
    			Activ_term_type: null,
    		},
    		community: {
    			League_term: null,
    			League_name: '',
    			League_Deeds: '',
    			League_work: '',
    			League_term_type: null,
    		},
    		practice: {
    			Cadre_term: null,
    			Cadre_name: '',
    			Cadre_Deeds: '',
    			Cadre_work: '',
    			Cadre_term_type: null,
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
	            url: '/student/activityCourse/init',
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
    			case 'activityAdd':
    				ajaxUrl = '/student/activityCourse/activityAdd';
                    container.formData.append('Activ_term',  container.insertData.activity.Activ_term);
                    container.formData.append('Activ_name',  container.insertData.activity.Activ_name);
                    container.formData.append('Deeds',  container.insertData.activity.Deeds);
                    container.formData.append('resb_work',  container.insertData.activity.resb_work);
                    container.formData.append('Activ_term_type',  container.insertData.activity.Activ_term_type);
    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('activityAdd');
    				break;
    			case 'activityEdit':
    				ajaxUrl = '/student/activityCourse/activityEdit';
                    container.formData.append('Id',  target.Id);
                    container.formData.append('Folder',  target.Folder);
                    container.formData.append('SubFolder',  target.SubFolder);
                    container.formData.append('Activ_term',  target.Activ_term);
                    container.formData.append('Activ_name',  target.Activ_name);
                    container.formData.append('Deeds',  target.Deeds);
                    container.formData.append('resb_work',  target.resb_work);
                    container.formData.append('Activ_term_type',  target.Activ_term_type);
                    container.formData.append('Activ_photo',  target.Activ_photo);
    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'edit');
    				break;
    			case 'communityAdd':
    				ajaxUrl = '/student/activityCourse/communityAdd';
                    container.formData.append('League_term',  container.insertData.community.League_term);
                    container.formData.append('League_name',  container.insertData.community.League_name);
                    container.formData.append('League_Deeds',  container.insertData.community.League_Deeds);
                    container.formData.append('League_work',  container.insertData.community.League_work);
                    container.formData.append('League_term_type',  container.insertData.community.League_term_type);
    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('communityAdd');
    				break;
    			case 'communityEdit':
    				ajaxUrl = '/student/activityCourse/communityEdit';
                    container.formData.append('Id',  target.Id);
                    container.formData.append('Folder',  target.Folder);
                    container.formData.append('SubFolder',  target.SubFolder);
                    container.formData.append('League_term',  target.League_term);
                    container.formData.append('League_name',  target.League_name);
                    container.formData.append('League_Deeds',  target.League_Deeds);
                    container.formData.append('League_work',  target.League_work);
                    container.formData.append('League_term_type',  target.League_term_type);
                    container.formData.append('League_photo',  target.League_photo);
    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'edit');
    			case 'practiceAdd':
    				ajaxUrl = '/student/activityCourse/practiceAdd';
                    container.formData.append('Cadre_term',  container.insertData.practice.Cadre_term);
                    container.formData.append('Cadre_name',  container.insertData.practice.Cadre_name);
                    container.formData.append('Cadre_Deeds',  container.insertData.practice.Cadre_Deeds);
                    container.formData.append('Cadre_work',  container.insertData.practice.Cadre_work);
                    container.formData.append('Cadre_term_type',  container.insertData.practice.Cadre_term_type);
    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('practiceAdd');
    				break;
    			case 'practiceEdit':
    				ajaxUrl = '/student/activityCourse/practiceEdit';
                    container.formData.append('Id',  target.Id);
                    container.formData.append('Folder',  target.Folder);
                    container.formData.append('SubFolder',  target.SubFolder);
                    container.formData.append('Cadre_term',  target.Cadre_term);
                    container.formData.append('Cadre_name',  target.Cadre_name);
                    container.formData.append('Cadre_Deeds',  target.Cadre_Deeds);
                    container.formData.append('Cadre_work',  target.Cadre_work);
                    container.formData.append('Cadre_term_type',  target.Cadre_term_type);
                    container.formData.append('Cadre_photo',  target.Cadre_photo);
    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'edit');
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
    			case 'activityAdd':
    				container.insertData.activity = {
		    			Activ_term: null,
		    			Activ_name: '',
		    			Deeds: '',
		    			resb_work: '',
		    			Activ_term_type: null,
		    		}
    				break;
    			case 'communityAdd':
    				container.insertData.activity = {
		    			League_term: null,
		    			League_name: '',
		    			League_Deeds: '',
		    			League_work: '',
		    			League_term_type: null,
		    		}
    				break;
    			case 'practiceAdd':
    				container.insertData.activity = {
		    			Cadre_term: null,
		    			Cadre_name: '',
		    			Cadre_Deeds: '',
		    			Cadre_work: '',
		    			Cadre_term_type: null,
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
