@extends('layouts.student.app')
@section('content')
<!-- container -->
<div id="page-container">
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">預警與輔導</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
				<div class="page-tag">
					<a href="#" class="btn tag-link is-active">成績不及格</a>
					<a href="#" class="btn tag-link">輔導記錄</a>
				</div>
			</div>
				<div class="page-content">
					<div class="page-article">
						<div class="page-section">
							<div class="section-title">
								<h3>成績不及格</h3>
							</div>
							<div class="section-content">
								<div class="section-feature">
									<div class="form-group">
										<select class="form-inline form-control xs">
											<option value="">98學年度</option>
											<option value="">97學年度</option>
											<option value="">96學年度</option>
										</select>
									</div>
								</div>
								<table class="table list-table">
									<thead>
										<tr>
											<th class="th" width="15%">學期</th>
											<th class="th">選課代號</th>
											<th class="th">課程名稱</th>
											<th class="th">預警</th>
											<th class="th">預警原因</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td data-th="學期">98學年度</td>
											<td data-th="選課代號">1468</td>
											<td data-th="課程名稱">會計學</td>
											<td data-th="預警">未設定</td>
											<td data-th="預警原因">授課教師尚未送出全班預警名單</td>
										</tr>
									</tbody>
								</table>
								<div class="section-footer">
									<ul>
										<li>本學期修習學分數:15</li>
										<li>目前預警學分數:0</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="page-section">
							<div class="section-title">
								<h3>輔導記錄</h3>
							</div>
							<div class="section-content">
								<div class="section-feature">
									<div class="form-group">
										<select class="form-inline form-control">
											<option value="">98學年度</option>
											<option value="">97學年度</option>
											<option value="">96學年度</option>
										</select>
									</div>
								</div>
								<table class="table list-table">
									<thead>
										<tr>
											<th class="th" width="15%">學期</th>
											<th class="th">導師姓名</th>
											<th class="th">會談時間</th>
											<th class="th">會談類別</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td data-th="學期">98學年度</td>
											<td data-th="導師姓名">導師姓名</td>
											<td data-th="會談時間">	2006/6/12</td>
											<td data-th="會談類別">二次二分之一不及格</td>
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
@stop






