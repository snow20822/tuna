@extends('layouts.student.app')
@section('content')

<!-- container -->
<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">職涯歷程</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
				<div class="page-tag">
					<a @click="goTarget('lice')" :class="{'is-active': pageTag['lice']}" class="btn tag-link">專業證照</a>
					<a @click="goTarget('parc')" :class="{'is-active': pageTag['parc']}" class="btn tag-link">實習經驗</a>
					<a @click="goTarget('read')" :class="{'is-active': pageTag['read']}" class="btn tag-link">工讀經驗</a>
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<section class="page-section">
						<div id="lice" class="section-title">
							<h3>專業證照</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(liceAdd, 'add')">新增專業證照</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="liceAdd.isActive">
							<form class="validate" id="liceAdd-validate" @submit.prevent>
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label">證照類別：</label>
									<input type="text" class="form-inline form-control xs" v-model="insertData.lice.Lice_class">
								</div>
								<div class="form-group">
									<label class="form-label form-label">發證單位：</label>
									<input type="text" class="form-inline form-control xs" v-model="insertData.lice.Lice_unit">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">證照名稱：</label>
									<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.lice.Lice_name">
								</div>
								<div class="form-group">
									<label class="form-label form-label">取證時間：</label>
									<date-picker id="add_lice" class="date datepicker" :value="insertData.Lice_date" placeholder="取證時間" readonly></date-picker>
								</div>
								<div class="form-group">
									<label class="form-label form-label">心得分享：</label>
									<textarea class="form-inline form-control" v-model="insertData.lice.Lice_exp"></textarea>
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(liceAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="editPost(liceAdd, 'liceAdd')">確認</button>
								</div>
							</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">證照類別</th>
										<th class="th">發證單位</th>
										<th class="th">證照名稱</th>
										<th class="th">取證時間</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.lice">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="證照類別">@{{ info.Lice_class }}</td>
										<td data-th="發證單位">@{{ info.Lice_unit }}</td>
										<td data-th="證照名稱">@{{ info.Lice_name }}</td>
										<td data-th="取證時間">@{{ info.Lice_date }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop.prevent="deleteAction('{{ url("/student/workCourse/liceDelete") }}', info)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
										<transition name="fade">
										<div class="form-wrap form-required" v-show="info.isActive">
											<form class="validate" :id="'liceEdit' + key + '-validate'" @submit.prevent>
											<div class="form-required text-blue">＊ 為必填</div>
											<div class="form-group">
												<label class="form-label form-label-required">證照類別：</label>
												<input type="text" class="form-inline form-control xs" v-model="info.Lice_class">
											</div>
											<div class="form-group">
												<label class="form-label form-label-required">發證單位：</label>
												<input type="text" class="form-inline form-control xs" v-model="info.Lice_unit">
											</div>
											<div class="form-group">
												<label class="form-label form-label">證照名稱：</label>
												<input type="text" class="form-inline form-control xs" v-model="info.Lice_name">
											</div>
											<div class="form-group">
												<label class="form-label form-label">取證時間：</label>
												<date-picker :id="'edit_lice' + key" class="date datepicker" :value="info.Lice_date" placeholder="開始時間" readonly></date-picker>
											</div>
											<div class="form-group">
												<label class="form-label">心得分享：</label>
												<textarea class="form-inline form-control" v-model="info.Lice_exp"></textarea>
											</div>
											<div class="form-offset form-button">
												<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
												<button type="submit" class="btn btn-submit" @click="editPost(info, 'liceEdit', key)">確認</button>
											</div>
											</form>
										</div>
										</transition>
										<transition name="fade">
											<ul class="lead-list" v-show="info.info">
												<li><label>心得分享：</label><span>@{{ info.Lice_exp }}</span></li>
											</ul>
										</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="parc" class="section-title">
							<h3>實習經驗</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(parcAdd, 'add')">新增實習經驗</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="parcAdd.isActive">
								<form class="validate" id="parcAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期：</label>
										<select v-model="insertData.parc.parc_term" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											@foreach(getTermRound() as $term)
												<option value="{{ $term }}">{{ $term }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期上下：</label>
										<select v-model="insertData.parc.parc_term_type" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											<option value="1">1</option>
											<option value="2">2</option>
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">實習單位：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.parc.parc_unit">
									</div>
									<div class="form-group">
										<label class="form-label form-label">工作內容：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.parc.parc_work">
									</div>
									<div class="form-group">
										<label class="form-label form-label">實習照片(一)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 1)">
									</div>
									<div class="form-group" v-if="photoPreview_1">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">實習照片(二)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 2)">
									</div>
									<div class="form-group" v-if="photoPreview_2">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">實習照片(三)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 3)">
									</div>
									<div class="form-group" v-if="photoPreview_3">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">心得分享：</label>
										<textarea class="form-black form-control xs" v-model="insertData.parc.parc_exp"></textarea>
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(parcAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(parcAdd, 'parcAdd')">確認</button>
									</div>
								</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">學期</th>
										<th class="th">實習單位</th>
										<th class="th">工作內容</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.parc">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="學期">@{{ info.parc_term }}@{{ getTermName(info.parc_term_type) }} 學期</td>
										<td data-th="實習單位">@{{ info.parc_unit }}</td>
										<td data-th="工作內容">@{{ info.parc_work }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop.prevent="deleteAction('{{ url("/student/workCourse/parcDelete") }}', info)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="5" class="expand">
										<transition name="fade">
										<div class="form-wrap form-required" v-show="info.isActive">
											<form class="validate" :id="'parcEdit' + key + '-validate'" @submit.prevent>
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期：</label>
													<select v-model="info.parc_term" class="form-inline form-control xs validate[required]">
														<option disabled :value="null">請選擇學期</option>
														@foreach(getTermRound() as $term)
															<option value="{{ $term }}">{{ $term }}</option>
														@endforeach
													</select>
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期上下：</label>
													<select v-model="info.parc_term_type" class="form-inline form-control xs validate[required]">
														<option disabled :value="null">請選擇學期</option>
														<option value="1">1</option>
														<option value="2">2</option>
													</select>
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">實習單位：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.parc_unit">
												</div>
												<div class="form-group">
													<label class="form-label form-label">工作內容：</label>
													<input type="text" class="form-inline form-control xs" v-model="info.parc_work">
												</div>
												<div class="form-group">
													<label class="form-label form-label">實習照片(一)：</label>
													<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 1)">
												</div>
												<div class="form-group" v-if="photoPreview_1">
													<label class="form-label form-label"></label>
													<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
												</div>
												<div class="form-group">
													<label class="form-label form-label">實習照片(二)：</label>
													<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 2)">
												</div>
												<div class="form-group" v-if="photoPreview_2">
													<label class="form-label form-label"></label>
													<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
												</div>
												<div class="form-group">
													<label class="form-label form-label">實習照片(三)：</label>
													<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 3)">
												</div>
												<div class="form-group" v-if="photoPreview_3">
													<label class="form-label form-label"></label>
													<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
												</div>
												<div class="form-group">
													<label class="form-label form-label">心得分享：</label>
													<textarea class="form-black form-control xs" v-model="info.parc_exp"></textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
													<button type="submit" class="btn btn-submit" @click="editPost(info, 'parcEdit', key)">確認</button>
												</div>
											</form>
										</div>
										</transition>
										<transition name="fade">
											<ul class="lead-list" v-show="info.info">
												<li><label>事蹟：</label><span>@{{ info.parc_exp }}</span></li>
												<li>
													<label>活動照片：</label>
													<div class="gallery-list clearfix">
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_1" class="item" data-lightbox="image-parc_unit" :data-title="info.parc_unit" v-if="info.photo_decode.img_1 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_1 + ')' }"></div>
														        </div>
														    </div>
														</a>
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_2" class="item" data-lightbox="image-parc_unit" :data-title="info.parc_unit" v-if="info.photo_decode.img_2 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_2 + ')' }"></div>
														        </div>
														    </div>
														</a>
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_3" class="item" data-lightbox="image-parc_unit" :data-title="info.parc_unit" v-if="info.photo_decode.img_3 != ''">
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
						<div id="read" class="section-title">
							<h3>工讀經驗</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(readAdd, 'add')">新增工讀經驗</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="readAdd.isActive">
								<form class="validate" id="readAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期：</label>
										<select v-model="insertData.read.Read_term" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											@foreach(getTermRound() as $term)
												<option value="{{ $term }}">{{ $term }}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">學期上下：</label>
										<select v-model="insertData.read.Read_term_type" class="form-inline form-control xs validate[required]">
											<option disabled :value="null">請選擇學期</option>
											<option value="1">1</option>
											<option value="2">2</option>
										</select>
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">工讀單位：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.read.Read_unit">
									</div>
									<div class="form-group">
										<label class="form-label form-label">工作內容：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.read.Read_work">
									</div>
									<div class="form-group">
										<label class="form-label form-label">工讀照片(一)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 1)">
									</div>
									<div class="form-group" v-if="photoPreview_1">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">工讀照片(二)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 2)">
									</div>
									<div class="form-group" v-if="photoPreview_2">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">工讀照片(三)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 3)">
									</div>
									<div class="form-group" v-if="photoPreview_3">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">心得分享：</label>
										<textarea class="form-black form-control xs" v-model="insertData.read.Read_exp"></textarea>
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(readAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(readAdd, 'readAdd')">確認</button>
									</div>
								</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">學期</th>
										<th class="th">工讀單位</th>
										<th class="th">工作內容</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.read">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="學期">@{{ info.Read_term }}@{{ getTermName(info.Read_term_type) }} 學期</td>
										<td data-th="工讀單位">@{{ info.Read_unit }}</td>
										<td data-th="工作內容">@{{ info.Read_work }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop.prevent="deleteAction('{{ url("/student/workCourse/readDelete") }}', info)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="5" class="expand">
										<transition name="fade">
										<div class="form-wrap form-required" v-show="info.isActive">
											<form class="validate" :id="'readEdit' + key + '-validate'" @submit.prevent>
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期：</label>
													<select v-model="info.Read_term" class="form-inline form-control xs validate[required]">
														<option disabled :value="null">請選擇學期</option>
														@foreach(getTermRound() as $term)
															<option value="{{ $term }}">{{ $term }}</option>
														@endforeach
													</select>
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期上下：</label>
													<select v-model="info.Read_term_type" class="form-inline form-control xs validate[required]">
														<option disabled :value="null">請選擇學期</option>
														<option value="1">1</option>
														<option value="2">2</option>
													</select>
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">實習單位：</label>
													<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Read_unit">
												</div>
												<div class="form-group">
													<label class="form-label form-label">工作內容：</label>
													<input type="text" class="form-inline form-control xs" v-model="info.Read_work">
												</div>
												<div class="form-group">
													<label class="form-label form-label">實習照片(一)：</label>
													<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 1)">
												</div>
												<div class="form-group" v-if="photoPreview_1">
													<label class="form-label form-label"></label>
													<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
												</div>
												<div class="form-group">
													<label class="form-label form-label">實習照片(二)：</label>
													<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 2)">
												</div>
												<div class="form-group" v-if="photoPreview_2">
													<label class="form-label form-label"></label>
													<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
												</div>
												<div class="form-group">
													<label class="form-label form-label">實習照片(三)：</label>
													<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 3)">
												</div>
												<div class="form-group" v-if="photoPreview_3">
													<label class="form-label form-label"></label>
													<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
												</div>
												<div class="form-group">
													<label class="form-label form-label">心得分享：</label>
													<textarea class="form-black form-control xs" v-model="info.Read_exp"></textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
													<button type="submit" class="btn btn-submit" @click="editPost(info, 'readEdit', key)">確認</button>
												</div>
											</form>
										</div>
										</transition>
										<transition name="fade">
											<ul class="lead-list" v-show="info.info">
												<li><label>事蹟：</label><span>@{{ info.Read_exp }}</span></li>
												<li>
													<label>活動照片：</label>
													<div class="gallery-list clearfix">
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_1" class="item" data-lightbox="image-Read_unit" :data-title="info.Read_unit" v-if="info.photo_decode.img_1 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_1 + ')' }"></div>
														        </div>
														    </div>
														</a>
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_2" class="item" data-lightbox="image-Read_unit" :data-title="info.Read_unit" v-if="info.photo_decode.img_2 != ''">
														    <div class="itemFrame">
														        <div class="innerFrame">
													        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_2 + ')' }"></div>
														        </div>
														    </div>
														</a>
														<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_3" class="item" data-lightbox="image-Read_unit" :data-title="info.Read_unit" v-if="info.photo_decode.img_3 != ''">
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
    	photoPreview_1: '',
    	photoPreview_2: '',
    	photoPreview_3: '',
    	pageTag: {
    		'lice': false,
    		'parc': false,
    		'read': false,
    	},
    	liceAdd: {
    		isActive: false,
    	},
    	parcAdd: {
    		isActive: false,
    	},
    	readAdd: {
    		isActive: false,
    	},
    	editData: {},
    	formData: new FormData(),
    	insertData: {
    		lice: {
    			Lice_class: '',
    			Lice_unit: '',
    			Lice_name: '',
    			Lice_date: '',
    			Lice_exp: '',
    		},
    		parc: {
    			parc_term: '',
    			parc_unit: '',
    			parc_work: '',
    			parc_exp: '',
    			parc_term_type: '',
    		},
    		read: {
    			Read_term: '',
    			Read_unit: '',
    			Read_work: '',
    			Read_exp: '',
    			Read_term_type: '',
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
	            url: '/student/workCourse/init',
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
    			case 'liceAdd':
    				ajaxUrl = '/student/workCourse/liceAdd';
					container.formData.append('Lice_class',  container.insertData.lice.Lice_class);
                    container.formData.append('Lice_unit',  container.insertData.lice.Lice_unit);
                    container.formData.append('Lice_name',  container.insertData.lice.Lice_name);
                    container.formData.append('Lice_date',  $('#add_lice').val());
                    container.formData.append('Lice_exp',  container.insertData.lice.Lice_exp);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('liceAdd');
    				break;
    			case 'liceEdit':
    				ajaxUrl = '/student/workCourse/liceEdit';
					container.formData.append('Id',  target.Id);
					container.formData.append('Lice_class',  target.Lice_class);
                    container.formData.append('Lice_unit',  target.Lice_unit);
                    container.formData.append('Lice_name',  target.Lice_name);
                    container.formData.append('Lice_date',  $('#edit_lice' + key).val());
                    container.formData.append('Lice_exp',  target.Lice_exp);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'edit');
    				this.initInsertData('liceEdit');
    				break;
    			case 'parcAdd':
    				ajaxUrl = '/student/workCourse/parcAdd';
                    container.formData.append('parc_term',  container.insertData.parc.parc_term);
                    container.formData.append('parc_unit',  container.insertData.parc.parc_unit);
                    container.formData.append('parc_work',  container.insertData.parc.parc_work);
                    container.formData.append('parc_exp',  container.insertData.parc.parc_exp);
                    container.formData.append('parc_term_type',  container.insertData.parc.parc_term_type);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('parcAdd');
    				break;
    			case 'parcEdit':
    				ajaxUrl = '/student/workCourse/parcEdit';
                    container.formData.append('Id',  target.Id);
                    container.formData.append('Folder',  target.Folder);
                    container.formData.append('SubFolder',  target.SubFolder);
                    container.formData.append('parc_term',  target.parc_term);
                    container.formData.append('parc_unit',  target.parc_unit);
                    container.formData.append('parc_work',  target.parc_work);
                    container.formData.append('parc_exp',  target.parc_exp);
                    container.formData.append('parc_term_type',  target.parc_term_type);
                    container.formData.append('parc_photo',  target.parc_photo);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'edit');
    				break;
    			case 'readAdd':
    				ajaxUrl = '/student/workCourse/readAdd';
                    container.formData.append('Read_term',  container.insertData.read.Read_term);
                    container.formData.append('Read_unit',  container.insertData.read.Read_unit);
                    container.formData.append('Read_work',  container.insertData.read.Read_work);
                    container.formData.append('Read_exp',  container.insertData.read.Read_exp);
                    container.formData.append('Read_term_type',  container.insertData.read.Read_term_type);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('readAdd');
    				break;
    			case 'readEdit':
    				ajaxUrl = '/student/workCourse/readEdit';
                    container.formData.append('Id',  target.Id);
                    container.formData.append('Folder',  target.Folder);
                    container.formData.append('SubFolder',  target.SubFolder);
                    container.formData.append('Read_term',  target.Read_term);
                    container.formData.append('Read_unit',  target.Read_unit);
                    container.formData.append('Read_work',  target.Read_work);
                    container.formData.append('Read_exp',  target.Read_exp);
                    container.formData.append('Read_term_type',  target.Read_term_type);
                    container.formData.append('Read_photo',  target.Read_photo);

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
    			case 'liceAdd':
    				container.insertData.lice = {
		    			Lice_class: '',
		    			Lice_unit: '',
		    			Lice_name: '',
		    			Lice_date: '',
		    			Lice_exp: '',
		    		}
    				break;
    			case 'parcAdd':
    				container.insertData.parc = {
		    			parc_term: '',
		    			parc_unit: '',
		    			parc_work: '',
		    			parc_exp: '',
		    			parc_term_type: '',
		    		}
    				break;
    			case 'readAdd':
    				container.insertData.read = {
		    			Read_term: '',
		    			Read_unit: '',
		    			Read_work: '',
		    			Read_exp: '',
		    			Read_term_type: '',
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
