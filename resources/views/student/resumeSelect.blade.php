@extends('layouts.student.app')
@section('content')
<!-- container -->
<div id="page-container">
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">電子化履歷</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
			</div>
			<div class="page-content">
				<div class="page-article">
					<section class="page-section">
						<div class="section-title">
							<h3>電子化履歷列表項目</h3>
							<div class="section-title-right">
								<a href="{{ url('/student/resume/preview') }}" class="btn btn-edit">預覽</a>
							</div>
						</div>
						<div class="section-content">
							<div class="form-wrap">
								<div class="form-required text-blue">請勾選欲列印的項目</div>
								<ul class="eResume-list">
									<li>
										<div class="eResume-group">
											<input id="eResume-all-1" type="checkbox" checked>
											<label for="eResume-all-1">個人簡歷 (全選)</label>
										</div>
										<ul class="eResume-list-sub">
											<li>
												<div class="eResume-group">
													<input id="eResume-1-1" type="checkbox" checked>
													<label for="eResume-1-1">自我介紹</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-1-2" type="checkbox" checked>
													<label for="eResume-1-2">學歷</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-1-3" type="checkbox" checked>
													<label for="eResume-1-3">工作經驗</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-1-4" type="checkbox" checked>
													<label for="eResume-1-4">個人網址</label>
												</div>
											</li>
										</ul>
									</li>
									<li>
										<div class="eResume-group">
											<input id="eResume-all-2" type="checkbox" checked>
											<label for="eResume-all-2">學習歷程 (全選)</label>
										</div>
										<ul class="eResume-list-sub">
											<li>
												<div class="eResume-group">
													<input id="eResume-2-1" type="checkbox" checked>
													<label for="eResume-2-1">歷年修課記錄</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-2-2" type="checkbox" checked>
													<label for="eResume-2-2">歷年請假缺曠記錄</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-2-3" type="checkbox" checked>
													<label for="eResume-2-3">服務學習</label>
												</div>
											</li>
										</ul>
									</li>
									<li>
										<div class="eResume-group">
											<input id="eResume-all-3" type="checkbox" checked>
											<label for="eResume-all-3">活動歷程 (全選)</label>
										</div>
										<ul class="eResume-list-sub">
											<li>
												<div class="eResume-group">
													<input id="eResume-3-1" type="checkbox" checked>
													<label for="eResume-3-1">活動紀錄</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-3-2" type="checkbox" checked>
													<label for="eResume-3-2">參與社團</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-3-3" type="checkbox" checked>
													<label for="eResume-3-3">幹部經歷</label>
												</div>
											</li>
										</ul>
									</li>
									<li>
										<div class="eResume-group">
											<input id="eResume-all-4" type="checkbox" checked>
											<label for="eResume-all-4">職涯歷程 (全選)</label>
										</div>
										<ul class="eResume-list-sub">
											<li>
												<div class="eResume-group">
													<input id="eResume-4-1" type="checkbox" checked>
													<label for="eResume-4-1">專業證照</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-4-2" type="checkbox" checked>
													<label for="eResume-4-2">實習經驗</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-4-3" type="checkbox" checked>
													<label for="eResume-4-3">工讀經驗</label>
												</div>
											</li>
										</ul>
									</li>
									<li>
										<div class="eResume-group">
											<input id="eResume-all-5" type="checkbox" checked>
											<label for="eResume-all-5">榮譽記錄 (全選)</label>
										</div>
										<ul class="eResume-list-sub">
											<li>
												<div class="eResume-group">
													<input id="eResume-5-1" type="checkbox" checked>
													<label for="eResume-5-1">獎學金</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-5-2" type="checkbox" checked>
													<label for="eResume-5-2">競賽獲獎</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-5-3" type="checkbox" checked>
													<label for="eResume-5-3">獎懲紀錄</label>
												</div>
											</li>
										</ul>
									</li>
									<li>
										<div class="eResume-group">
											<input id="eResume-all-6" type="checkbox" checked>
											<label for="eResume-all-6">作品專區 (全選)</label>
										</div>
										<ul class="eResume-list-sub">
											<li>
												<div class="eResume-group">
													<input id="eResume-6-1" type="checkbox" checked>
													<label for="eResume-6-1">個人作品</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-6-2" type="checkbox" checked>
													<label for="eResume-6-2">參展記錄</label>
												</div>
											</li>
											<li>
												<div class="eResume-group">
													<input id="eResume-6-3" type="checkbox" checked>
													<label for="eResume-6-3">演出記錄</label>
												</div>
											</li>
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- container end -->
@stop







