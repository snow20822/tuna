<!DOCTYPE html>
<html>
    <head>
        <title>tnnua</title>

        <meta charset="utf-8">
        <meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1" media="(device-height: 568px)">
        <meta content="telephone=no" name="format-detection" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="email=no" name="format-detection" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="HandheldFriendly" content="True">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- Style Sheets -->
        <link rel="stylesheet" href="{{ asset('css/style.css?v=1.1') }}" />
        <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/loading.css') }}" />
        <!-- js -->
        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/bluebird.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('js/vue.min.js') }}"></script>
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <![endif]-->
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

<div id="mainBody" class="first zh-tw" v-cloak>
    <div :class="notLoading">
       <div class="loader"></div>
    </div>
    <div id="page-header">
        <div class="page-row">
            <a href="#" class="logo first-logo" title="台南藝術大學"></a>
        </div>
        <div class="page-nav">
            <a href="#" class="page-btn-nav js-drop" @click="needLogin"><img src="{{ asset('image/icon_nav.svg') }}" alt="選單按鈕"></a>
            <a href="#" class="page-btn-home"><img src="{{ asset('image/icon_home.svg') }}" alt="回首頁"></a>
        </div>
    </div>
    <div id="page-container">
        <div id="page-body">
            <div class="first-bg">
                <div class="first-wrap">
                    <div class="news-wrap">
                        <div class="news-inner">
                            <div class="news-title">最新公告</div>
                            <ul class="news-list">
                                <a href="#" class="news-list-link">
                                    <span class="news-list-title">017/05/09</span>
                                    <span class="news-list-content">【 行政 】 教務處教學資源中心辦理本學期「教師專業成長活動」第2場次，敬邀校內</span>
                                </a>
                                <a href="#" class="news-list-link">
                                    <span class="news-list-title">017/05/09</span>
                                    <span class="news-list-content">【 行政 】 教務處教學資源中心辦理本學期「教師專業成長活動」第2場次，敬邀校內</span>
                                </a>
                                <a href="#" class="news-list-link">
                                    <span class="news-list-title">017/05/09</span>
                                    <span class="news-list-content">【 行政 】 教務處教學資源中心辦理本學期「教師專業成長活動」第2場次，敬邀校內</span>
                                </a>
                            </ul>
                        </div>
                    </div>
                    <div class="login-wrap">
                        <div class="login-inner">
                            <div class="login-title">SIGN IN</div>
                            <div class="login-form">
                                <div class="login-form-group">
                                    <input type="text" class="form-control" placeholder="帳號" v-model="userPost.username">
                                </div>
                                <div class="login-form-group">
                                    <input type="password" class="form-control" placeholder="密碼" v-model="userPost.password">
                                </div>
                                <div class="login-form-group login-form-code">
                                    <input type="text" class="form-control input-code" placeholder="驗證碼" v-model="userPost.captcha">
                                    <div class="code">
                                        <img :src="captchaSrc" alt="captcha" @click="changeCaptcha()">
                                    </div>
                                </div>
                                <div class="login-form-group forget-group">
                                    <a href=""><i class="material-icons">help</i> 忘記密碼</a>
                                    <div class="changeIdentity-group">
                                        <input id="toggle" type="checkbox" v-model="userPost.type" value="true">
                                        <label for="toggle"></label>
                                    </div>
                                </div>
                                <div class="login-form-group login-form-button">
                                    <button type="button" class="login-submit" @click="loginTo">登入</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="first-copyright">
                    <div class="copyright">
                        Copyright © Tainan National University of the Arts
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
var vuejs = new Vue({
    el: '#mainBody',
    data: {
        menu: false,
        userPost: {
            username: "",
            password: "",
            captcha: "",
            type: false,
        },
        captchaSrc: "{{ captcha_src() }}",
        notLoading: {
            loaded: false,
            "page-loading-overlay": true,
        },
    },
    mounted: function () {
        this.notLoading.loaded = true;
    },
    methods: {
        toggleMenu: function() {
            this.menu = ! this.menu;
        },
        changeCaptcha: function() {
            this.captchaSrc = '/captcha/default?' + Math.random();
        },
        needLogin: function() {
            swal({
                title: "OOPS..",
                text: '請先登入',
                type: "error"
            }).then(function () {
            });
        },
        loginTo: function() {
            this.doLogin();
        },
        doLogin: function() {
            $.ajax({
                url: 'login/authAuto',
                data: this.userPost,
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res){
                    location.href = res.url;
                }
            });
        }
    }
})
</script>






