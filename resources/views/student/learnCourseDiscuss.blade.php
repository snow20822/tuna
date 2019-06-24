@extends('layouts.student.app')
@section('content')
<!-- container -->
<div id="page-container" v-cloak>
	<div id="page-body">
		<div class="page-row clearfix">
			<div class="page-slide">
				<h1 class="page-title" title="title">進階網球</h1>
				<div class="mem-infor clearfix">
					@include('layouts.student.user-info')
				</div>
				<div class="page-tag">
					<a class="is-active" class="btn tag-link">討論串</a>
				</div>
			</div>
			<div class="page-content">
					<div class="page-article">
						<div class="page-section">
							<div class="section-title">
								<h3>課程討論 / 討論串名稱</h3>
							</div>
							<div class="section-content">
								<div class="message-content">
									<div class="message-title">討論串名稱</div>
									<div class="message-date">2017/8/15 16:24</div>
									<div class="message-list">
										<div class="message-item">
											<div class="message-item-left">
												<img  class="message-item-img" src="{{ asset('image/not-use/teacher.jpg') }}">
											</div>
											<div class="message-item-body">
												<div class="message-item-name">
													Quni Jhuang
													<small class="message-item-data">2017/8/15 16:24</small>
												</div>
												<p class="message-item-content">
													Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
												</p>
											</div>
										</div>
										<div class="message-item">
											<div class="message-item-left">
												<img  class="message-item-img" src="{{ asset('image/not-use/user.jpg') }}">
											</div>
											<div class="message-item-body">
												<div class="message-item-name">
													Quni Jhuang
													<small class="message-item-data">2017/8/15 16:24</small>
												</div>
												<p class="message-item-content">
													Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
												</p>
											</div>
										</div>
									</div>
								</div>
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
    	infoData: {},
    },
    mounted: function () {
    	//init data
    	//this.initData();
    },
    methods: {
    	initData: function() {
    		header.toggleLoading();
	        $.ajax({
	            url: '',
	            type: "get",
	            success: function(response) {
	            	container.infoData = response.infoData;
	            	header.toggleLoading();
	            }
	        });
    	},
    }
})
</script>
@stop





