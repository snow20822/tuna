@extends('layouts.student.app')
@section('content')
<!-- container -->
<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">作品專區</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
				<div class="page-tag">
					<a @click="goTarget('Perworks')" :class="{'is-active': pageTag['Perworks']}" class="btn tag-link is-active">個人作品</a>
					<a @click="goTarget('Exhi')" :class="{'is-active': pageTag['Exhi']}" class="btn tag-link">參展記錄</a>
					<a @click="goTarget('Show')" :class="{'is-active': pageTag['Show']}" class="btn tag-link">演出記錄</a>
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<div class="page-section">
						<div class="section-title">
							<h3>個人作品</h3>
							<div class="section-title-right">
								<a @click="listEdit(PerworksAdd, 'add')" class="btn btn-edit">新增個人作品</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="PerworksAdd.isActive">
								<form class="validate" id="PerworksAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">作品名稱：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.Perworks.Works_name">
									</div>
									<div class="form-group">
										<label class="form-label">影片連結：</label>
										<input type="text" class="form-inline form-control sm" v-model="insertData.Perworks.Works_vid" placeholder="http://">
									</div>
									<div class="form-group">
										<label class="form-label form-label">作品描述：</label>
										<textarea class="form-black form-control xs" v-model="insertData.Perworks.Works_introd"></textarea>
									</div>
									<div class="form-group">
										<label class="form-label form-label">作品照片(一)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 1)">
									</div>
									<div class="form-group" v-if="photoPreview_1">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">作品照片(二)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 2)">
									</div>
									<div class="form-group" v-if="photoPreview_2">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
									</div>
									<div class="form-group">
										<label class="form-label form-label">作品照片(三)：</label>
										<input type="file" class="form-inline form-control xs addFile" @change="processFile($event, 3)">
									</div>
									<div class="form-group" v-if="photoPreview_3">
										<label class="form-label form-label"></label>
										<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(PerworksAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(PerworksAdd, 'PerworksAdd')">確認</button>
									</div>
								</form>
							</div>
							</transition>
							<div class="gallery-list clearfix">
								<a :href="'{{ url('/student/myGalleryDetail/edit') }}?folderId=' + info.album_id + '&pId=' + info.album_p_id" class="item" v-for="(info, key) in editData.Perworks">
								    <div class="itemFrame">
								        <div class="innerFrame">
								        	<div class="setting">
								        		<div class="setting-btn" title="編輯或刪除">
								        			<i class="material-icons">mode_edit</i>
								        		</div>
								        		<div class="setting-list">
								        			<span @click.stop.prevent="lightBoxClick(info)">編輯</span>
								        			<span @click.stop.prevent="deleteAction('{{ url("/student/workProject/perworksDelete") }}', info)">刪除</span>
								        		</div>
								        	</div>
								        	<div class="title">
								        		@{{ info.Works_name }}
								        	</div>
								            <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_1 + ')' }"></div>
								        </div>
								    </div>
								</a>
							</div>
						    <div class="modal-overlay" :class="{ 'is-active': photoEdit, 'is-hidden': photoEditLeave }">
						        <!-- 展開要+ is-active -->
						        <div class="modal" :class="{ 'is-active': photoEdit }">
						            <!-- 展開要+ is-active -->
						            <a class="close-modal" @click="lightBoxClick()">
						                <img src="{{ url('image/icon_close.svg') }}" alt="">
						            </a>
						            <!-- close modal -->
						            <div class="modal-content">
										<form class="validate" id="PerworksEdd-validate" @submit.prevent>
											<div class="form-required text-blue">＊ 為必填</div>
											<div class="form-group">
												<label class="form-label form-label-required">作品名稱：</label>
												<input type="text" class="form-inline form-control xs validate[required]" v-model="photoData.Works_name">
											</div>
											<div class="form-group">
												<label class="form-label">影片連結：</label>
												<input type="text" class="form-inline form-control sm" v-model="photoData.Works_vid" placeholder="http://">
											</div>
											<div class="form-group">
												<label class="form-label form-label">作品描述：</label>
												<textarea class="form-black form-control xs" v-model="photoData.Works_introd"></textarea>
											</div>
											<div class="form-group">
												<label class="form-label form-label">作品照片(一)：</label>
												<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 1)">
											</div>
											<div class="form-group" v-if="photoPreview_1">
												<label class="form-label form-label"></label>
												<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
											</div>
											<div class="form-group">
												<label class="form-label form-label">作品照片(二)：</label>
												<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 2)">
											</div>
											<div class="form-group" v-if="photoPreview_2">
												<label class="form-label form-label"></label>
												<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
											</div>
											<div class="form-group">
												<label class="form-label form-label">作品照片(三)：</label>
												<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 3)">
											</div>
											<div class="form-group" v-if="photoPreview_3">
												<label class="form-label form-label"></label>
												<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
											</div>
											<div class="form-offset form-button">
												<button type="clear" class="btn" @click="lightBoxClick()">取消</button>
												<button type="submit" class="btn btn-submit" @click="editPost(photoData, 'PerworksEdit')">確認</button>
											</div>
										</form>
						            </div>
						            <!-- content -->
						        </div>
						        <!-- modal -->
						    </div>
						</div>
					</div>
					<div class="page-section">
						<div class="section-title">
							<h3>參展紀錄</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(ExhiAdd, 'add')">新增參展紀錄</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="ExhiAdd.isActive">
								<form class="validate" id="ExhiAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">主辦單位：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.Exhi.Exhi_unit">
									</div>
									<div class="form-group">
										<label class="form-label form-label">展出地點：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.Exhi.Exhi_location">
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">展出時間：</label>
										<div class="form-inline form-select-group">
											<date-picker id="add_Exhi_start" placeholder="開始時間" readonly></date-picker>
										</div>
										<div class="form-offset">
											<div class="form-inline form-select-group">
												至
											<date-picker id="add_Exhi_end" placeholder="結束時間" readonly></date-picker>
											</div>
										</div>
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
									<div class="form-group">
										<label class="form-label form-label">心得分享：</label>
										<textarea class="form-black form-control xs" v-model="insertData.Exhi.Exhi_exp"></textarea>
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(ExhiAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(ExhiAdd, 'ExhiAdd')">確認</button>
									</div>
								</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">主辦單位</th>
										<th class="th">展出時間</th>
										<th class="th">展出地點</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.Exhi">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="主辦單位">@{{ info.Exhi_unit }}</td>
										<td data-th="展出時間">@{{ info.Exhi_time_start }} ~ @{{ info.Exhi_time_end }}</td>
										<td data-th="展出地點">@{{ info.Exhi_location }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop.prevent="deleteAction('{{ url("/student/workProject/exhiDelete") }}', info)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="8" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="info.isActive">
												<form class="validate" :id="'ExhiEdit' + key + '-validate'" @submit.prevent>
													<div class="form-required text-blue">＊ 為必填</div>
													<div class="form-group">
														<label class="form-label form-label-required">主辦單位：</label>
														<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Exhi_unit">
													</div>
													<div class="form-group">
														<label class="form-label form-label">展出地點：</label>
														<input type="text" class="form-inline form-control xs" v-model="info.Exhi_location">
													</div>
													<div class="form-group">
														<label class="form-label form-label-required">展出時間：</label>
														<div class="form-inline form-select-group">
															<date-picker :id="'edit_Exhi_start' + key" class="date datepicker" :value="info.Exhi_time_start" placeholder="開始時間" readonly></date-picker>
														</div>
														<div class="form-offset">
															<div class="form-inline form-select-group">
																至
															<date-picker :id="'edit_Exhi_end' + key" class="date datepicker" :value="info.Exhi_time_end" placeholder="結束時間" readonly></date-picker>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="form-label form-label">展出照片(一)：</label>
														<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 1)">
													</div>
													<div class="form-group" v-if="photoPreview_1">
														<label class="form-label form-label"></label>
														<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
													</div>
													<div class="form-group">
														<label class="form-label form-label">展出照片(二)：</label>
														<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 2)">
													</div>
													<div class="form-group" v-if="photoPreview_2">
														<label class="form-label form-label"></label>
														<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
													</div>
													<div class="form-group">
														<label class="form-label form-label">展出照片(三)：</label>
														<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 3)">
													</div>
													<div class="form-group" v-if="photoPreview_3">
														<label class="form-label form-label"></label>
														<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
													</div>
													<div class="form-group">
														<label class="form-label form-label">心得分享：</label>
														<textarea class="form-black form-control xs" v-model="info.Exhi_exp"></textarea>
													</div>
													<div class="form-offset form-button">
														<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
														<button type="submit" class="btn btn-submit" @click="editPost(info, 'ExhiEdit', key)">確認</button>
													</div>
												</form>
											</div>
											</transition>
											<transition name="fade">
												<ul class="lead-list" v-show="info.info">
													<li><label>事蹟：</label><span>@{{ info.Exhi_exp }}</span></li>
													<li>
														<label>活動照片：</label>
														<div class="gallery-list clearfix">
															<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_1" class="item" data-lightbox="image-Exhi_unit" :data-title="info.Exhi_unit" v-if="info.photo_decode.img_1 != ''">
															    <div class="itemFrame">
															        <div class="innerFrame">
														        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_1 + ')' }"></div>
															        </div>
															    </div>
															</a>
															<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_2" class="item" data-lightbox="image-Exhi_unit" :data-title="info.Exhi_unit" v-if="info.photo_decode.img_2 != ''">
															    <div class="itemFrame">
															        <div class="innerFrame">
														        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_2 + ')' }"></div>
															        </div>
															    </div>
															</a>
															<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_3" class="item" data-lightbox="image-Exhi_unit" :data-title="info.Exhi_unit" v-if="info.photo_decode.img_3 != ''">
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
							<h3>演出紀錄</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(ShowAdd, 'add')">新增演出紀錄</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="ShowAdd.isActive">
								<form class="validate" id="ShowAdd-validate" @submit.prevent>
									<div class="form-required text-blue">＊ 為必填</div>
									<div class="form-group">
										<label class="form-label form-label-required">主辦單位：</label>
										<input type="text" class="form-inline form-control xs validate[required]" v-model="insertData.Show.Show_unit">
									</div>
									<div class="form-group">
										<label class="form-label form-label">展出地點：</label>
										<input type="text" class="form-inline form-control xs" v-model="insertData.Show.Show_location">
									</div>
									<div class="form-group">
										<label class="form-label form-label-required">展出時間：</label>
										<div class="form-inline form-select-group">
											<date-picker id="add_Show_start" placeholder="開始時間" readonly></date-picker>
										</div>
										<div class="form-offset">
											<div class="form-inline form-select-group">
												至
											<date-picker id="add_Show_end" placeholder="結束時間" readonly></date-picker>
											</div>
										</div>
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
									<div class="form-group">
										<label class="form-label form-label">心得分享：</label>
										<textarea class="form-black form-control xs" v-model="insertData.Show.Show_exp"></textarea>
									</div>
									<div class="form-offset form-button">
										<button type="clear" class="btn" @click="listEdit(ShowAdd, 'add')">取消</button>
										<button type="submit" class="btn btn-submit" @click="editPost(ShowAdd, 'ShowAdd')">確認</button>
									</div>
								</form>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">主辦單位</th>
										<th class="th">展出時間</th>
										<th class="th">展出地點</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody v-for="(info, key) in editData.Show">
									<tr class="js-drop" :class="{'is-active': info.info}" @click="clickDetail(info)">
										<td class="td-arrow align-center"><i class="material-icons" :class="info.info == true ? 'is-active' : ''">keyboard_arrow_down</i></td>
										<td data-th="主辦單位">@{{ info.Show_unit }}</td>
										<td data-th="展出時間">@{{ info.Show_time_start }} ~ @{{ info.Show_time_end }}</td>
										<td data-th="展出地點">@{{ info.Show_location }}</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="info.edit == true ? 'is-active' : ''" @click.stop="listEdit(info, 'edit')"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop.prevent="deleteAction('{{ url("/student/workProject/showDelete") }}', info)"><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="8" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="info.isActive">
												<form class="validate" :id="'ShowEdit' + key + '-validate'" @submit.prevent>
													<div class="form-required text-blue">＊ 為必填</div>
													<div class="form-group">
														<label class="form-label form-label-required">主辦單位：</label>
														<input type="text" class="form-inline form-control xs validate[required]" v-model="info.Show_unit">
													</div>
													<div class="form-group">
														<label class="form-label form-label">展出地點：</label>
														<input type="text" class="form-inline form-control xs" v-model="info.Show_location">
													</div>
													<div class="form-group">
														<label class="form-label form-label-required">展出時間：</label>
														<div class="form-inline form-select-group">
															<date-picker :id="'edit_Show_start' + key" class="date datepicker" :value="info.Show_time_start" placeholder="開始時間" readonly></date-picker>
														</div>
														<div class="form-offset">
															<div class="form-inline form-select-group">
																至
															<date-picker :id="'edit_Show_end' + key" class="date datepicker" :value="info.Show_time_end" placeholder="結束時間" readonly></date-picker>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label class="form-label form-label">展出照片(一)：</label>
														<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 1)">
													</div>
													<div class="form-group" v-if="photoPreview_1">
														<label class="form-label form-label"></label>
														<img v-if="photoPreview_1" :src="photoPreview_1" style="width: 100px" />
													</div>
													<div class="form-group">
														<label class="form-label form-label">展出照片(二)：</label>
														<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 2)">
													</div>
													<div class="form-group" v-if="photoPreview_2">
														<label class="form-label form-label"></label>
														<img v-if="photoPreview_2" :src="photoPreview_2" style="width: 100px" />
													</div>
													<div class="form-group">
														<label class="form-label form-label">展出照片(三)：</label>
														<input type="file" class="form-inline form-control xs editFile" @change="processFile($event, 3)">
													</div>
													<div class="form-group" v-if="photoPreview_3">
														<label class="form-label form-label"></label>
														<img v-if="photoPreview_3" :src="photoPreview_3" style="width: 100px" />
													</div>
													<div class="form-group">
														<label class="form-label form-label">心得分享：</label>
														<textarea class="form-black form-control xs" v-model="info.Show_exp"></textarea>
													</div>
													<div class="form-offset form-button">
														<button type="clear" class="btn" @click="listEdit(info, 'edit')">取消</button>
														<button type="submit" class="btn btn-submit" @click="editPost(info, 'ShowEdit', key)">確認</button>
													</div>
												</form>
											</div>
											</transition>
											<transition name="fade">
												<ul class="lead-list" v-show="info.info">
													<li><label>事蹟：</label><span>@{{ info.Show_exp }}</span></li>
													<li>
														<label>活動照片：</label>
														<div class="gallery-list clearfix">
															<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_1" class="item" data-lightbox="image-Show_unit" :data-title="info.Show_unit" v-if="info.photo_decode.img_1 != ''">
															    <div class="itemFrame">
															        <div class="innerFrame">
														        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_1 + ')' }"></div>
															        </div>
															    </div>
															</a>
															<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_2" class="item" data-lightbox="image-Show_unit" :data-title="info.Show_unit" v-if="info.photo_decode.img_2 != ''">
															    <div class="itemFrame">
															        <div class="innerFrame">
														        	    <div class="img" :style="{ backgroundImage: 'url(' + '{{ url('/') }}' + '/' + info.photo_decode.img_2 + ')' }"></div>
															        </div>
															    </div>
															</a>
															<a :href="'{{ url('/') }}' + '/' + info.photo_decode.img_3" class="item" data-lightbox="image-Show_unit" :data-title="info.Show_unit" v-if="info.photo_decode.img_3 != ''">
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
        photoEdit: false,
        photoEditLeave: true,
    	pageTag: {
    		'Perworks': false,
    		'Exhi': false,
    		'Show': false,
    	},
    	PerworksAdd: {
    		isActive: false,
    	},
    	ExhiAdd: {
    		isActive: false,
    	},
    	ShowAdd: {
    		isActive: false,
    	},
    	editData: {},
    	formData: new FormData(),
    	insertData: {
    		Perworks: {
    			Works_name: '',
    			Works_introd: '',
    			Works_vid: '',
    		},
    		Exhi: {
    			Exhi_unit: '',
    			Exhi_time_start: '',
    			Exhi_time_end: '',
    			Exhi_location: '',
    			Exhi_exp: '',
    		},
    		Show: {
    			Show_unit: '',
    			Show_time_start: '',
    			Show_time_end: '',
    			Show_location: '',
    			Show_exp: '',
    		},
    	},
    	photoData: {},
    },
    mounted: function() {
    	//init data
    	this.initData();
    },
    methods: {
    	initData: function() {
    		header.toggleLoading();
	        $.ajax({
	            url: '/student/workProject/init',
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
    			case 'PerworksAdd':
    				ajaxUrl = '/student/workProject/perworksAdd';
					container.formData.append('Works_name',  container.insertData.Perworks.Works_name);
                    container.formData.append('Works_introd',  container.insertData.Perworks.Works_introd);
                    container.formData.append('Works_vid',  container.insertData.Perworks.Works_vid);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('ExhiAdd');
    				break;
    			case 'PerworksEdit':
    				ajaxUrl = '/student/workProject/perworksEdit';
					container.formData.append('Id',  target.Id);
					container.formData.append('Works_name',  target.Works_name);
                    container.formData.append('Works_introd',  target.Works_introd);
                    container.formData.append('Works_vid',  target.Works_vid);
                    container.formData.append('Works_photo',  target.Works_photo);
                    container.formData.append('Folder',  target.Folder);
                    container.formData.append('SubFolder',  target.SubFolder);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'edit');
    				this.initInsertData('ExhiEdit');
    				this.lightBoxClick();
    				break;
    			case 'ExhiAdd':
    				ajaxUrl = '/student/workProject/exhiAdd';
					container.formData.append('Exhi_unit',  container.insertData.Exhi.Exhi_unit);
                    container.formData.append('Exhi_location',  container.insertData.Exhi.Exhi_location);
                    container.formData.append('Exhi_exp',  container.insertData.Exhi.Exhi_exp);
                    container.formData.append('Exhi_time_start',  $('#add_Exhi_start').val());
                    container.formData.append('Exhi_time_end',  $('#add_Exhi_end').val());

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('ExhiAdd');
    				break;
    			case 'ExhiEdit':
    				ajaxUrl = '/student/workProject/exhiEdit';
					container.formData.append('Id',  target.Id);
					container.formData.append('Exhi_unit',  target.Exhi_unit);
                    container.formData.append('Exhi_location',  target.Exhi_location);
                    container.formData.append('Exhi_exp',  target.Exhi_exp);
                    container.formData.append('Exhi_time_start',  $('#edit_Exhi_start' + key).val());
                    container.formData.append('Exhi_time_end',  $('#edit_Exhi_end' + key).val());
                    container.formData.append('Exhi_photo',  target.Exhi_photo);
                    container.formData.append('Folder',  target.Folder);
                    container.formData.append('SubFolder',  target.SubFolder);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'edit');
    				this.initInsertData('ExhiEdit');
    				break;
    			case 'ShowAdd':
    				ajaxUrl = '/student/workProject/showAdd';
					container.formData.append('Show_unit',  container.insertData.Show.Show_unit);
                    container.formData.append('Show_location',  container.insertData.Show.Show_location);
                    container.formData.append('Show_exp',  container.insertData.Show.Show_exp);
                    container.formData.append('Show_time_start',  $('#add_Show_start').val());
                    container.formData.append('Show_time_end',  $('#add_Show_end').val());

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'add');
    				this.initInsertData('ShowAdd');
    				break;
    			case 'ShowEdit':
    				ajaxUrl = '/student/workProject/showEdit';
					container.formData.append('Id',  target.Id);
					container.formData.append('Show_unit',  target.Show_unit);
                    container.formData.append('Show_location',  target.Show_location);
                    container.formData.append('Show_exp',  target.Show_exp);
                    container.formData.append('Show_time_start',  $('#edit_Show_start' + key).val());
                    container.formData.append('Show_time_end',  $('#edit_Show_end' + key).val());
                    container.formData.append('Show_photo',  target.Show_photo);
                    container.formData.append('Folder',  target.Folder);
                    container.formData.append('SubFolder',  target.SubFolder);

    				this.ajaxEdit(ajaxUrl);
    				this.listEdit(target, 'edit');
    				this.initInsertData('ShowEdit');
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
    			case 'ExhiAdd':
    				container.insertData.Exhi = {
		    			Exhi_unit: '',
		    			Exhi_time_start: '',
		    			Exhi_time_end: '',
		    			Exhi_location: '',
		    			Exhi_exp: '',
		    		}
    				break;
    			case 'ShowAdd':
    				container.insertData.Show = {
		    			Show_unit: '',
		    			Show_time_start: '',
		    			Show_time_end: '',
		    			Show_location: '',
		    			Show_exp: '',
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
        },
        lightBoxClick: function(info) {
            if(typeof info != "undefined") {
                this.photoData = info;

				if (typeof info.photo_decode != "undefined") {
	    			//img
	    			if (info.photo_decode.img_1 != '') {
	    				container.photoPreview_1 = "{{ url('/') }}" + '/' + info.photo_decode.img_1;
	    			}
	    			if (info.photo_decode.img_2 != '') {
	    				container.photoPreview_2 = "{{ url('/') }}" + '/' + info.photo_decode.img_2;
	    			}
	    			if (info.photo_decode.img_3 != '') {
	    				container.photoPreview_3 = "{{ url('/') }}" + '/' + info.photo_decode.img_3;
	    			}
				}
            }

            this.photoEdit = ! this.photoEdit;
            this.photoEditLeave = ! this.photoEditLeave;
        },
    }
})
</script>
@stop






