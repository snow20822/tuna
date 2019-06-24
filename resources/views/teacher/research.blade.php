@extends('layouts.teacher.app')
@section('content')

<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">研究成果</h1>
				<div class="mem-infor clearfix">
					@include('layouts.teacher.user-info')
				</div>
				<div class="page-tag" style="z-index: 10;">
					<a @click="goTarget('book')" class="btn tag-link" :class="{'is-active': pageTag['book']}">著作</a>
					<a @click="goTarget('study')" class="btn tag-link" :class="{'is-active': pageTag['study']}">研究計劃</a>
					<a @click="goTarget('paper')" class="btn tag-link" :class="{'is-active': pageTag['paper']}">期刊論文</a>
					<a @click="goTarget('published')" class="btn tag-link" :class="{'is-active': pageTag['published']}">研討會發表</a>
					<a @click="goTarget('patent')" class="btn tag-link" :class="{'is-active': pageTag['patent']}">專利</a>
					<a @click="goTarget('technology')" class="btn tag-link" :class="{'is-active': pageTag['technology']}">技術移轉</a>
					<a @click="goTarget('service')" class="btn tag-link" :class="{'is-active': pageTag['service']}">專業服務</a>
					<a @click="goTarget('show')" class="btn tag-link" :class="{'is-active': pageTag['show']}">展演活動</a>
					<a @click="goTarget('works')" class="btn tag-link" :class="{'is-active': pageTag['works']}">作品</a>
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<section class="page-section">
						<div id="book" class="section-title">
							<h3>著作</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(bookAdd, 'add')">新增著作</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="bookAdd.isActive">
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">學期：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">作者：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">書名：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">出版社：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">ISBN：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">出版年月：</label>
									<input type="date" class="form-inline form-control xs" value="">
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(activityRecordAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="listEdit(activityRecordAdd, 'add')">確認</button>
								</div>
							</div>
							</transition>
							<table class="table list-table">
								<thead>
									<tr>
										<th class="th">學期</th>
										<th class="th">作者</th>
										<th class="th">書名</th>
										<th class="th">出版社</th>
										<th class="th">ISBN</th>
										<th class="th">出版年月</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td data-th="學期">106</td>
										<td data-th="作者">劉軒</td>
										<td data-th="書名">心理學如何幫助了我：享受美好人生的八堂生活課</td>
										<td data-th="出版社">天下文化</td>
										<td data-th="ISBN">664754653</td>
										<td data-th="出版年月">106/08</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="book[0].edit == true ? 'is-active' : ''" @click.stop="listEdit(book, 'edit', 0)"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="5" class="expand">
										<transition name="fade">
										<div class="form-wrap form-required" v-show="book[0].isActive">
											<div class="form-required text-blue">＊ 為必填</div>
											<div class="form-group">
												<label class="form-label form-label-required">學期：</label>
												<input type="text" class="form-inline form-control xs" value="">
											</div>
											<div class="form-group">
												<label class="form-label form-label-required">作者：</label>
												<input type="text" class="form-inline form-control xs" value="">
											</div>
											<div class="form-group">
												<label class="form-label form-label">書名：</label>
												<input type="text" class="form-inline form-control xs" value="">
											</div>
											<div class="form-group">
												<label class="form-label form-label">出版社：</label>
												<input type="text" class="form-inline form-control xs" value="">
											</div>
											<div class="form-group">
												<label class="form-label form-label">ISBN：</label>
												<input type="text" class="form-inline form-control xs" value="">
											</div>
											<div class="form-group">
												<label class="form-label form-label">出版年月：</label>
												<input type="date" class="form-inline form-control xs" value="">
											</div>
											<div class="form-offset form-button">
												<button type="clear" class="btn" @click="listEdit(book, 'edit', 0)">取消</button>
												<button type="submit" class="btn btn-submit" @click="listEdit(book, 'edit', 0)">確認</button>
											</div>
										</div>
										</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="study" class="section-title">
							<h3>研究計劃</h3>
							<div class="section-title-right">
								<a class="btn btn-edit"  @click="listEdit(studyAdd, 'add')">新增研究計劃</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="studyAdd.isActive">
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">開始學期：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">計畫名稱：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">計畫單位：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">成果摘要：</label>
									<textarea class="form-inline form-control"></textarea>
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(activityRecordAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="listEdit(activityRecordAdd, 'add')">確認</button>
								</div>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">開始學期</th>
										<th class="th">計畫名稱</th>
										<th class="th">計畫單位</th>
									</tr>
								</thead>
								<tbody>
									<tr class="js-drop" :class="{'is-active': study[0].info}" @click="clickDetail(study, 0)">
										<td class="td-arrow align-center" @click="clickDetail(study, 0)"><i class="material-icons" :class="study[0].info == true ? 'is-active' : ''">keyboard_arrow_down</i>
										<td data-th="開始學期">006</td>
										<td data-th="計畫名稱">大眾災難文學中的共同傷痕心理研究</td>
										<td data-th="計畫單位">國立台南藝術大學</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="study[0].edit == true ? 'is-active' : ''" @click.stop="listEdit(study, 'edit', 0)"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="study[0].isActive">
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">開始學期：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">計畫名稱：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">計畫單位：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">成果摘要：</label>
													<textarea class="form-inline form-control"></textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(study, 'edit', 0)">取消</button>
													<button type="submit" class="btn btn-submit" @click="listEdit(study, 'edit', 0)">確認</button>
												</div>
											</div>
											</transition>
											<transition name="fade">
												<ul class="lead-list" v-show="study[0].info">
													<li><label>成果摘要</label><span>臺灣歷經九二一大地震後的漫長修復過程，倒塌的房屋已經重建，十二年來，每每歷經震難周年的日子，便會有創作者再回憶起當時的天搖地動，文學紀錄的陸續出現，無論是在情感上、實情上，都有別於歷史的冰冷記載，闊別集體的傷痛記憶後，回頭看這累積成塔的文學作品，有別於一般個人生命劇變的文學創作，而有著族群受災的記憶，豐富的紀錄顯現出一個議題：是否文學本身具有療癒本文透過文本分析法與訪談法，結合文學與心理學研究，以文本出發，探討在九二一大地震中，敘事行為產生心理治療的功效性，並著重於文學作品本身的心理價值，嘗試確立災難文學產生的背景與原因。</span></li>
												</ul>
											</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="paper" class="section-title">
							<h3>期刊論文</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(paperAdd, 'add')">新增期刊論文</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="paperAdd.isActive">
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">學期：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">作者：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">題目：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">期刊名稱：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">出版年月：</label>
									<input type="date" class="form-inline form-control xs" value="">
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(paperAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="listEdit(paperAdd, 'add')">確認</button>
								</div>
							</div>
							</transition>
							<table class="table list-table">
								<thead>
									<tr>
										<th class="th">學期</th>
										<th class="th">作者</th>
										<th class="th">題目</th>
										<th class="th">期刊名稱</th>
										<th class="th">出版年月</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td data-th="學期">106</td>
										<td data-th="作者">劉軒</td>
										<td data-th="題目">心理學如何幫助了我</td>
										<td data-th="期刊名稱">某某期刊</td>
										<td data-th="出版年月">106/08</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="paper[0].edit == true ? 'is-active' : ''" @click.stop="listEdit(paper, 'edit', 0)"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="paper[0].isActive">
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">作者：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">題目：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">期刊名稱：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">出版年月：</label>
													<input type="date" class="form-inline form-control xs" value="">
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(paper, 'edit', 0)">取消</button>
													<button type="submit" class="btn btn-submit" @click="listEdit(paper, 'edit', 0)">確認</button>
												</div>
											</div>
											</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="published" class="section-title">
							<h3>研討會發表</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(publishedAdd, 'add')">新增研討會發表</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="publishedAdd.isActive">
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">學期：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">研討會名稱：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">場次：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">發表主題：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">主辦單位：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">時間：</label>
									<input type="date" class="form-inline form-control xs" value="">
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(publishedAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="listEdit(publishedAdd, 'add')">確認</button>
								</div>
							</div>
							</transition>
							<table class="table list-table">
								<thead>
									<tr>
										<th class="th">學期</th>
										<th class="th">研討會名稱</th>
										<th class="th">場次</th>
										<th class="th">發表主題</th>
										<th class="th">主辦單位</th>
										<th class="th">年月</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td data-th="學期">106</td>
										<td data-th="研討會名稱">以科技接受模式探討臺北國際花卉博覽會行動導覽服務之研究</td>
										<td data-th="場次">台中</td>
										<td data-th="發表主題">科技接受模式</td>
										<td data-th="主辦單位">國立台南藝術大學</td>
										<td data-th="年月">106/08</td>
											<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="published[0].edit == true ? 'is-active' : ''" @click.stop="listEdit(published, 'edit', 0)"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="5" class="expand">
										<transition name="fade">
										<div class="form-wrap form-required" v-show="published[0].isActive">
											<div class="form-required text-blue">＊ 為必填</div>
											<div class="form-group">
												<label class="form-label form-label-required">學期：</label>
												<input type="text" class="form-inline form-control xs" value="">
											</div>
											<div class="form-group">
												<label class="form-label form-label-required">研討會名稱：</label>
												<input type="text" class="form-inline form-control xs" value="">
											</div>
											<div class="form-group">
												<label class="form-label form-label">場次：</label>
												<input type="text" class="form-inline form-control xs" value="">
											</div>
											<div class="form-group">
												<label class="form-label form-label">發表主題：</label>
												<input type="text" class="form-inline form-control xs" value="">
											</div>
											<div class="form-group">
												<label class="form-label form-label">主辦單位：</label>
												<input type="text" class="form-inline form-control xs" value="">
											</div>
											<div class="form-group">
												<label class="form-label form-label">時間：</label>
												<input type="date" class="form-inline form-control xs" value="">
											</div>
											<div class="form-offset form-button">
												<button type="clear" class="btn" @click="listEdit(published, 'edit', 0)">取消</button>
												<button type="submit" class="btn btn-submit" @click="listEdit(published, 'edit', 0)">確認</button>
											</div>
										</div>
										</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="patent" class="section-title">
							<h3>專利</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(patentAdd, 'add')">新增專利</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="patentAdd.isActive">
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">取得學期：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">專利名稱：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">成果摘要：</label>
									<textarea class="form-inline form-control"></textarea>
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(patentAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="listEdit(patentAdd, 'add')">確認</button>
								</div>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">取得學期</th>
										<th class="th">專利名稱</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody>
									<tr class="js-drop" :class="{'is-active': patent[1].info}" @click="clickDetail(patent, 1)">
										<td class="td-arrow align-center"><i class="material-icons" :class="patent[1].info == true ? 'is-active' : ''">keyboard_arrow_down</i>
										<td data-th="取得學期">106</td>
										<td data-th="專利名稱">本創作係有關一種不易滾動之筷子</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="patent[1].edit == true ? 'is-active' : ''" @click.stop="listEdit(patent, 'edit', 1)"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="patent[1].isActive">
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">取得學期：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">專利名稱：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">成果摘要：</label>
													<textarea class="form-inline form-control"></textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(patent, 'edit', 1)">取消</button>
													<button type="submit" class="btn btn-submit" @click="listEdit(patent, 'edit', 1)">確認</button>
												</div>
											</div>
											</transition>
											<transition name="fade">
												<ul class="lead-list" v-show="patent[1].info">
													<li><label>成果摘要</label><span>臺灣歷經九二一大地震後的漫長修復過程，倒塌的房屋已經重建，十二年來，每每歷經震難周年的日子，便會有創作者再回憶起當時的天搖地動，文學紀錄的陸續出現，無論是在情感上、實情上，都有別於歷史的冰冷記載，闊別集體的傷痛記憶後，回頭看這累積成塔的文學作品，有別於一般個人生命劇變的文學創作，而有著族群受災的記憶，豐富的紀錄顯現出一個議題：是否文學本身具有療癒本文透過文本分析法與訪談法，結合文學與心理學研究，以文本出發，探討在九二一大地震中，敘事行為產生心理治療的功效性，並著重於文學作品本身的心理價值，嘗試確立災難文學產生的背景與原因。</span></li>
												</ul>
											</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="technology" class="section-title">
							<h3>技術移轉</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(technologyAdd, 'add')">新增技術移轉</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="technologyAdd.isActive">
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">學期：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">技術名稱：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">移轉對象：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">成果摘要：</label>
									<textarea class="form-inline form-control"></textarea>
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(technologyAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="listEdit(technologyAdd, 'add')">確認</button>
								</div>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">學期</th>
										<th class="th">技術名稱</th>
										<th class="th">移轉對象</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody>
									<tr class="js-drop" :class="{'is-active': technology[1].info}" @click="clickDetail(technology, 1)">
										<td class="td-arrow align-center"><i class="material-icons" :class="technology[1].info == true ? 'is-active' : ''">keyboard_arrow_down</i>
										<td data-th="學期">106</td>
										<td data-th="技術名稱">範例技術名稱</td>
										<td data-th="移轉對象">學生</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="technology[1].edit == true ? 'is-active' : ''" @click.stop="listEdit(technology, 'edit', 1)"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
											<transition name="fade">
												<div class="form-wrap form-required" v-show="technology[1].isActive">
													<div class="form-required text-blue">＊ 為必填</div>
													<div class="form-group">
														<label class="form-label form-label-required">學期：</label>
														<input type="text" class="form-inline form-control xs" value="">
													</div>
													<div class="form-group">
														<label class="form-label form-label-required">技術名稱：</label>
														<input type="text" class="form-inline form-control xs" value="">
													</div>
													<div class="form-group">
														<label class="form-label form-label">移轉對象：</label>
														<input type="text" class="form-inline form-control xs" value="">
													</div>
													<div class="form-offset form-button">
														<button type="clear" class="btn" @click="listEdit(technology, 'edit', 1)">取消</button>
														<button type="submit" class="btn btn-submit" @click="listEdit(technology, 'edit', 1)">確認</button>
													</div>
												</div>
											</transition>
											<transition name="fade">
												<ul class="lead-list" v-show="technology[1].info">
													<li><label>成果摘要</label><span>臺灣歷經九二一大地震後的漫長修復過程，倒塌的房屋已經重建，十二年來，每每歷經震難周年的日子，便會有創作者再回憶起當時的天搖地動，文學紀錄的陸續出現，無論是在情感上、實情上，都有別於歷史的冰冷記載，闊別集體的傷痛記憶後，回頭看這累積成塔的文學作品，有別於一般個人生命劇變的文學創作，而有著族群受災的記憶，豐富的紀錄顯現出一個議題：是否文學本身具有療癒本文透過文本分析法與訪談法，結合文學與心理學研究，以文本出發，探討在九二一大地震中，敘事行為產生心理治療的功效性，並著重於文學作品本身的心理價值，嘗試確立災難文學產生的背景與原因。</span></li>
												</ul>
											</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="service" class="section-title">
							<h3>專業服務</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(serviceAdd, 'add')">新增專業服務</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="serviceAdd.isActive">
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">學期：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">服務名稱：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">服務單位：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">成果摘要：</label>
									<textarea class="form-inline form-control"></textarea>
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(serviceAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="listEdit(serviceAdd, 'add')">確認</button>
								</div>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">學期</th>
										<th class="th">服務名稱</th>
										<th class="th">服務單位</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody>
									<tr class="js-drop" :class="{'is-active': service[1].info}" @click="clickDetail(service, 1)">
										<td class="td-arrow align-center"><i class="material-icons" :class="service[1].info == true ? 'is-active' : ''">keyboard_arrow_down</i>
										<td data-th="學期">106</td>
										<td data-th="服務名稱">範例專業服務</td>
										<td data-th="服務單位">範例服務單位</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="service[1].edit == true ? 'is-active' : ''" @click.stop="listEdit(service, 'edit', 1)"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="service[1].isActive">
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">服務名稱：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">服務單位：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">成果摘要：</label>
													<textarea class="form-inline form-control"></textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(service, 'edit', 1)">取消</button>
													<button type="submit" class="btn btn-submit" @click="listEdit(service, 'edit', 1)">確認</button>
												</div>
											</div>
											</transition>
											<transition name="fade">
												<ul class="lead-list" v-show="service[1].info">
													<li><label>成果摘要</label><span>臺灣歷經九二一大地震後的漫長修復過程，倒塌的房屋已經重建，十二年來，每每歷經震難周年的日子，便會有創作者再回憶起當時的天搖地動，文學紀錄的陸續出現，無論是在情感上、實情上，都有別於歷史的冰冷記載，闊別集體的傷痛記憶後，回頭看這累積成塔的文學作品，有別於一般個人生命劇變的文學創作，而有著族群受災的記憶，豐富的紀錄顯現出一個議題：是否文學本身具有療癒本文透過文本分析法與訪談法，結合文學與心理學研究，以文本出發，探討在九二一大地震中，敘事行為產生心理治療的功效性，並著重於文學作品本身的心理價值，嘗試確立災難文學產生的背景與原因。</span></li>
												</ul>
											</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="show" class="section-title">
							<h3>展演活動</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(showAdd, 'add')">新增展演活動</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="showAdd.isActive">
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">學期：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">活動名稱：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">主辦單位：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">成果摘要：</label>
									<textarea class="form-inline form-control"></textarea>
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(showAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="listEdit(showAdd, 'add')">確認</button>
								</div>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">學期</th>
										<th class="th">活動名稱</th>
										<th class="th">主辦單位</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody>
									<tr class="js-drop" :class="{'is-active': show[1].info}" @click="clickDetail(show, 1)">
										<td class="td-arrow align-center"><i class="material-icons" :class="show[1].info == true ? 'is-active' : ''">keyboard_arrow_down</i>
										<td data-th="學期">106</td>
										<td data-th="活動名稱">範例活動名稱</td>
										<td data-th="主辦單位">範例主辦單位</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="show[1].edit == true ? 'is-active' : ''" @click.stop="listEdit(show, 'edit', 1)"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="show[1].isActive">
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">活動名稱：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">主辦單位：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">成果摘要：</label>
													<textarea class="form-inline form-control"></textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(show, 'edit', 1)">取消</button>
													<button type="submit" class="btn btn-submit" @click="listEdit(show, 'edit', 1)">確認</button>
												</div>
											</div>
											</transition>
											<transition name="fade">
												<ul class="lead-list" v-show="show[1].info">
													<li><label>成果摘要</label><span>臺灣歷經九二一大地震後的漫長修復過程，倒塌的房屋已經重建，十二年來，每每歷經震難周年的日子，便會有創作者再回憶起當時的天搖地動，文學紀錄的陸續出現，無論是在情感上、實情上，都有別於歷史的冰冷記載，闊別集體的傷痛記憶後，回頭看這累積成塔的文學作品，有別於一般個人生命劇變的文學創作，而有著族群受災的記憶，豐富的紀錄顯現出一個議題：是否文學本身具有療癒本文透過文本分析法與訪談法，結合文學與心理學研究，以文本出發，探討在九二一大地震中，敘事行為產生心理治療的功效性，並著重於文學作品本身的心理價值，嘗試確立災難文學產生的背景與原因。</span></li>
												</ul>
											</transition>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</section>
					<section class="page-section">
						<div id="works" class="section-title">
							<h3>作品</h3>
							<div class="section-title-right">
								<a class="btn btn-edit" @click="listEdit(worksAdd, 'add')">新增作品</a>
							</div>
						</div>
						<div class="section-content">
							<transition name="fade">
							<div class="form-wrap form-required" v-show="worksAdd.isActive">
								<div class="form-required text-blue">＊ 為必填</div>
								<div class="form-group">
									<label class="form-label form-label-required">學期：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label-required">作品名稱：</label>
									<input type="text" class="form-inline form-control xs" value="">
								</div>
								<div class="form-group">
									<label class="form-label form-label">成果摘要：</label>
									<textarea class="form-inline form-control"></textarea>
								</div>
								<div class="form-offset form-button">
									<button type="clear" class="btn" @click="listEdit(worksAdd, 'add')">取消</button>
									<button type="submit" class="btn btn-submit" @click="listEdit(worksAdd, 'add')">確認</button>
								</div>
							</div>
							</transition>
							<table class="table js-table">
								<thead>
									<tr>
										<th class="th th-arrow"></th>
										<th class="th">學期</th>
										<th class="th">作品名稱</th>
										<th class="th"></th>
									</tr>
								</thead>
								<tbody>
									<tr class="js-drop" :class="{'is-active': works[1].info}" @click="clickDetail(works, 1)">
										<td class="td-arrow align-center"><i class="material-icons" :class="works[1].info == true ? 'is-active' : ''">keyboard_arrow_down</i>
										<td data-th="學期">106</td>
										<td data-th="作品名稱">範例作品名稱</td>
										<td data-th="功能" class="td-features">
											<a class="btn-icon" :class="works[1].edit == true ? 'is-active' : ''" @click.stop="listEdit(works, 'edit', 1)"><i class="material-icons">mode_edit</i><span>edit</span></a>
											<a class="btn-icon" @click.stop><i class="material-icons">close</i><span>delete</span></a>
										</td>
									</tr>
									<tr class="js-expand">
										<td colspan="6" class="expand">
											<transition name="fade">
											<div class="form-wrap form-required" v-show="works[1].isActive">
												<div class="form-required text-blue">＊ 為必填</div>
												<div class="form-group">
													<label class="form-label form-label-required">學期：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label-required">作品名稱：</label>
													<input type="text" class="form-inline form-control xs" value="">
												</div>
												<div class="form-group">
													<label class="form-label form-label">成果摘要：</label>
													<textarea class="form-inline form-control"></textarea>
												</div>
												<div class="form-offset form-button">
													<button type="clear" class="btn" @click="listEdit(works, 'edit', 1)">取消</button>
													<button type="submit" class="btn btn-submit" @click="listEdit(works, 'edit', 1)">確認</button>
												</div>
											</div>
											</transition>
											<transition name="fade">
												<ul class="lead-list" v-show="works[1].info">
													<li><label>成果摘要</label><span>臺灣歷經九二一大地震後的漫長修復過程，倒塌的房屋已經重建，十二年來，每每歷經震難周年的日子，便會有創作者再回憶起當時的天搖地動，文學紀錄的陸續出現，無論是在情感上、實情上，都有別於歷史的冰冷記載，闊別集體的傷痛記憶後，回頭看這累積成塔的文學作品，有別於一般個人生命劇變的文學創作，而有著族群受災的記憶，豐富的紀錄顯現出一個議題：是否文學本身具有療癒本文透過文本分析法與訪談法，結合文學與心理學研究，以文本出發，探討在九二一大地震中，敘事行為產生心理治療的功效性，並著重於文學作品本身的心理價值，嘗試確立災難文學產生的背景與原因。</span></li>
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

<script>
var container = new Vue({
    el: '#page-container',
    data: {
    	pageTag: {
    		'book': false,
    		'study': false,
    		'paper': false,
    		'published': false,
    		'patent': false,
    		'technology': false,
    		'service': false,
    		'show': false,
    		'works': false,
    	},
    	paperAdd: {
    		isActive: false,
    	},
    	paper: [
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
    	bookAdd: {
    		isActive: false,
    	},
    	book: [
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
    	studyAdd: {
    		isActive: false,
    	},
    	study: [
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
    	publishedAdd: {
    		isActive: false,
    	},
    	published: [
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
    	patentAdd: {
    		isActive: false,
    	},
    	patent: [
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
    	technologyAdd: {
    		isActive: false,
    	},
    	technology: [
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
    	serviceAdd: {
    		isActive: false,
    	},
    	service: [
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
    	showAdd: {
    		isActive: false,
    	},
    	show: [
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
    	worksAdd: {
    		isActive: false,
    	},
    	works: [
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
    },
    methods: {
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
    	clickDetail: function(target, key) {
    		target[key].info = ! target[key].info;
    		target[key].edit = false;
    		target[key].add = false;
    	},
    	listEdit: function(target, type, key) {
    		if (type == 'add') {
    			target.isActive = ! target.isActive;
    		} else if  (type == 'edit') {
	    		target[key].isActive = ! target[key].isActive;
	    		target[key].edit = ! target[key].edit;
	    		target[key].add = false;
	    		target[key].info = false;
    		}
    	}
    }
});
</script>
@stop







