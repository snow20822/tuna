<!DOCTYPE html>
<html>
    <head>
        <title>tnnua</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1" media="(device-height: 568px)">
        <meta content="telephone=no" name="format-detection" />
        <meta content="email=no" name="format-detection" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="HandheldFriendly" content="True">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- Style Sheets -->
        <link rel="stylesheet" href="{{ asset('css/style.css?v=0.2') }}" />
        <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/loading.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/datepicker.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/lightgallery.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/validationEngine.jquery.css') }}" />
        <!-- js -->
        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/bluebird.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('js/vue.min.js') }}"></script>
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <![endif]-->
        <!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->
        <script src="{{ asset('js/jquery.mousewheel.min.js') }}"></script>
        <script src="{{ asset('js/lightgallery.min.js') }}"></script>
        <!-- lightgallery plugins -->
        <script src="{{ asset('js/lg-thumbnail.min.js') }}"></script>
        <script src="{{ asset('js/lg-fullscreen.min.js') }}"></script>
        <script src="{{ asset('js/datepicker.js') }}"></script>
        <script src="{{ asset('js/jquery.validationEngine-zh_CN.js') }}"></script>
        <script src="{{ asset('js/jquery.validationEngine.js') }}"></script>
        <script type="text/javascript">
        $(function() {
            $('.datepicker').datepicker({
                format: 'YYYY-mm-dd',
                autoHide: true
            });
            $('.validate').validationEngine();
        });
        </script>
        <style>
            [v-cloak] {
              display: none;
            }
            .fade-enter-active, .fade-leave-active {
                transition: opacity .5s
            }
            .fade-leave-active {
                transition: opacity .2s
            }
            .fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
                opacity: 0;
            }
        </style>
    </head>
<body>
<div id="mainBody" class="first zh-tw">
    <div id="page-header">
    <div class="alert" :class="{'is-active': alert.show, 'error': alert.error}">
            <div id="alert-container">
                <span>@{{ alert.msg }}</span>
            </div>
        </div>
        <div :class="notLoading">
           <div class="loader"></div>
        </div>
        <div class="page-row">
            <a href="{{ url('/teacher/resume') }}" class="logo" title="台南藝術大學"></a>
        </div>
        <div class="page-nav">
            <a href="#" class="page-btn-nav js-drop" @click="toggleMenu"><img src="{{ asset('image/icon_nav.svg') }}" alt="選單按鈕"></a>
            <transition name="fade">
                <ul class="mainnav js-expand" style="display:none" v-show="menu">
                    <li class="is-active"><a href="{{ url('/teacher/resume') }}">基本資料</a></li>
                    <li><a href="{{ url('/teacher/research') }}">研究成果</a></li>
                    <li><a href="{{ url('/teacher/syllabus') }}">教學成果</a></li>
                    <li><a href="{{ url('/teacher/activityRecord') }}">活動與輔導</a></li>
                    <li><a href="#">教師評鑑</a></li>
                    <li><a href="{{ url('/') }}">登出</a></li>
                </ul>
            </transition>
            <a href="{{ url('/teacher/resume') }}" class="page-btn-home"><img src="{{ asset('image/icon_home.svg') }}" alt="回首頁"></a>
        </div>
    </div>
    <script type="text/javascript">
    var header = new Vue({
        el: '#page-header',
        data: {
            menu: false,
            notLoading: {
                loaded: true,
                "page-loading-overlay": true,
            },
            alert: {
                show: false,
                error: false,
                msg: '修改成功!',
            }
        },
        mounted: function () {
        },
        methods: {
            toggleMenu: function() {
                this.menu = ! this.menu;
            },
            toggleLoading: function() {
                this.notLoading.loaded = ! this.notLoading.loaded;
            },
        }
    });
    </script>
    @yield('content')
    <div id="page-footer">
        <div class="copyright">
            /  Copyright © Tainan National University of the Arts
        </div>
    </div>
</div>
</body>
</html>
<script>
//捲動特效
$(function(){
    // 先取得 #pageTag 及其 top 值
    var $pageTag = $('.page-tag'),
        _top = $pageTag.offset().top;

    // 當網頁捲軸捲動時
    var $win = $(window).scroll(function(){
        var nowTop = $(this).scrollTop();

        // 如果現在的 scrollTop 大於原本 #pageTag 的 top 時
        if ($win.scrollTop() > _top){
            // 如果 $pageTag 的座標系統不是 fixed 的話
            if ($pageTag.css('position')!='fixed'){
                // 設定 #pageTag 的座標系統為 fixed
                $pageTag.addClass('fixed');
            }
        } else {
            // 還原 #pageTag 的座標系統為 inherit
            $pageTag.removeClass('fixed');
        }

        //顯示 top
        if (nowTop > 400) {
            if ($("#gotop").css('display') === 'none') {
                $('#gotop').show();
            }
        } else {
            $('#gotop').hide();
        }
    });
});
</script>







