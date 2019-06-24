<!DOCTYPE html>
<html id="resumeView">
	<head>
		<meta charset="utf-8">
		<title>Tainan National University of the Arts.</title>
		<!-- Style Sheets -->
		<link rel="stylesheet" href="{{ asset('css/resume.css') }}" />

	</head>
<body>
<div id="mainBody">
	<!-- header -->
	<div id="page-header">
		<div class="page-logo">
			<img src="{{ asset('image/logo.png') }}" alt="">
		</div>
	</div>
	<!-- header end -->

	<!-- container -->
	<div id="page-container">
		<div id="page-body">
			<div class="resumeView-article">
				<div class="resumeView-section">
					<div class="resumeView-title">
						<h2>莊筱婷</h2>
						<span>女性 已婚 就讀中</span>
					</div>
					<div class="resumeView-autobiography">
						<p>【專業設計】</p>
						<p>1. 設計公司形象之視覺規範、視覺設計、以及、美術編輯等事務</p>
						<p>2. 網站視覺規劃與網頁製作，獨立完成完整網頁設計</p>
						<p>3. PHP網頁程式，建立企業互動行銷平台建置與規劃</p>
						<p>4. 具Photoshop及Illustrator美編設計能力</p>
						<p>5. 現代化RWD響應式網頁技術 支援手機版</p>
						<p></p>
						<p>【使用技術】</p>
						<p>1. PHP (超文字預處理器 Personal Home Page)</p>
						<p>2. MySQL (關聯式資料庫管理系統)</p>
						<p>3. CodeIgniter (輕量 MVC框架)</p>
						<p>4. HTML5 + CSS3 (超文件標示語言, 樣式表)</p>
						<p>5. JavaScript (網頁編輯語言,http://www.w3schools.com/js/)</p>
					</div>
					<div class="resumeView-photo">
						<img src="{{ getStudentPhotoUrl() }}" title="莊筱婷" alt="莊筱婷" class="img-circle">
					</div>
				</div>
				<div class="resumeView-section">
					<div class="resumeView-title">
						<h2>學歷</h2>
					</div>
					<div class="resumeView-content resumeView-education">
						<h3>私立修平科技大學<span class="txt-sub">(台灣)</span></h3>
						<ul class="resumeView-list w50">
							<li><label>科系名稱：</label><span>資訊管理系</span></li>
							<li><label>科系類別：</label><span>資訊管理相關</span></li>
							<li><label>學　　歷：</label><span>大學</span></li>
							<li><label>就學期間：</label><span>2008/6 - 就學中</span></li>
						</ul>
					</div>
				</div>
				<div class="resumeView-section">
					<div class="resumeView-title">
						<h2>工作經驗</h2>
					</div>
					<div class="resumeView-content resumeView-works">
						<h3>網頁開發組長／中佑集團<span class="txt-sub">(2015/03 - 仍在職)</span></h3>
						<ul class="resumeView-list">
							<li><label>職業性質：</label><span>資訊業</span></li>
							<li><label>工作內容：</label><span>網頁開發設計，負責前端或後端應用開發<br>管理相關人員專案進度、專案排程</span></li>
						</ul>
					</div>
				</div>
				<div class="resumeView-section">
					<div class="resumeView-title">
						<h2>學習歷程</h2>
					</div>
					<div class="resumeView-content">
						<h3>歷年修課紀錄</h3>
						<table class="resumeView-table">
							<thead>
								<tr>
									<th class="th">學期</th>
									<th class="th">課程名稱</th>
									<th class="th">學分數</th>
									<th class="th">成績</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td data-th="學期">98上學期</td>
									<td data-th="課程名稱">會計學</td>
									<td data-th="學分數">2</td>
									<td data-th="成績">80</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="resumeView-content">
						<h3>歷年請假缺曠紀錄</h3>
						<table class="resumeView-table">
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
								<tr>
									<td data-th="學期">98上學期</td>
									<td data-th="課程名稱">會計學</td>
									<td data-th="請假/缺曠日期">98/5/4</td>
									<td data-th="請假/缺曠時數">2</td>
									<td data-th="請假/缺曠原因">生病</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="resumeView-content">
						<h3>服務學習</h3>
						<table class="resumeView-table">
							<thead>
								<tr>
									<th class="th">學期</th>
									<th class="th">單位名稱</th>
									<th class="th">服務地點</th>
									<th class="th">起訖時間</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td data-th="學期">98上學期</td>
									<td data-th="單位名稱">教務處</td>
									<td data-th="服務地點">教務處走廊</td>
									<td data-th="起訖時間">98/5/4 8:10~9:00</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="resumeView-section">
					<div class="resumeView-title">
						<h2>活動歷程</h2>
					</div>
					<ul class="resumeView-list">
						<li><span></span></li>
					</ul>
				</div>
				<div class="resumeView-section">
					<div class="resumeView-title">
						<h2>職涯歷程</h2>
					</div>
					<ul class="resumeView-list">
						<li><span></span></li>
					</ul>
				</div>
				<div class="resumeView-section">
					<div class="resumeView-title">
						<h2>榮譽紀錄</h2>
					</div>
					<div class="resumeView-title-sub">
						<h2>獎學金</h2>
					</div>
					<div class="resumeView-content">
						<h3>獎學金名稱</h3>
						<ul class="resumeView-list">
							<li><label>學　　期：</label><span>98上學期</span></li>
							<li><label>心　　得：</label><span>心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．</span></li>
						</ul>
					</div>
					<div class="resumeView-content">
						<h3>獎學金名稱</h3>
						<ul class="resumeView-list">
							<li><label>學　　期：</label><span>98上學期</span></li>
							<li><label>心　　得：</label><span>心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．</span></li>
						</ul>
					</div>
					<div class="resumeView-title-sub">
						<h2>競賽獲獎</h2>
					</div>
					<div class="resumeView-content">
						<h3>競賽獲獎名稱</h3>
						<ul class="resumeView-list">
							<li><label>學　　期：</label><span>98上學期</span></li>
							<li><label>主辦單位：</label><span>主辦單位</span></li>
							<li><label>主辦單位：</label><span>競賽名稱</span></li>
							<li><label>地　　點：</label><span>地點</span></li>
							<li><label>活動照片：</label><span><img src="http://www.tnnua.edu.tw/ezfiles/0/1000/img/1/133606878.jpg"><img src="http://www.tnnua.edu.tw/ezfiles/0/1000/img/1/133606878.jpg"><img src="http://www.tnnua.edu.tw/ezfiles/0/1000/img/1/133606878.jpg"></span></li>
							<li><label>獎　　項：</label><span>獎項</span></li>
							<li><label>心　　得：</label><span>心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．心得內容心得內容心得內容心得內容，假設我是心得內容很多，很多心得內容．</span></li>
						</ul>
					</div>
					<div class="resumeView-title-sub">
						<h2>獎懲紀錄</h2>
					</div>
					<div class="resumeView-content">
						<h3>獎懲紀錄名稱</h3>
						<ul class="resumeView-list">
							<li><label>學　　期：</label><span>98上學期</span></li>
							<li><label>獎懲原因：</label><span>獎懲原因</span></li>
						</ul>
					</div>
				</div>
				<div class="resumeView-section">
					<div class="resumeView-title">
						<h2>作品專區</h2>
					</div>
					<ul class="resumeView-list">
						<li><span></span></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- container end -->

	<!-- footer -->
	<div id="page-footer">
		<div class="copyright">
			Copyright © Tainan National University of the Arts
		</div>
	</div>
	<!-- footer end -->
</div>
</body>
</html>







