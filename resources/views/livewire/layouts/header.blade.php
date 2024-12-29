<header id="header">

    <div class="left">
        <a href="/" class="logo"><img src="/ksn/images/logo2.png" alt=""></a>
        <nav id="nav">
            <i class="fas fa-times" id="closeMenu"></i>
            <a href="/">首頁</a>
            <a href="/homeoem">代工</a>
            <a href="/ticketOrder">代購</a>
            <a href="/foods">食品</a>
            <a href="/ticketOrder">展覽</a>
            {{-- @if(Auth::check())
            <a href="/airplane">線上遊戲</a>
            @else
            <a href="javascript:;" onclick="notloginFn()">線上遊戲</a>
            @endif --}}
            <a href="javascript:;" id="onlineGameBtn">
                彩票
                <div class="gameNav" id="gameNav">
                    <strong class="">
                        <img src="/images/game01.png" />
                        <p>瘋狂保齡球</p>
                        <div class="disabled">維護中</div>
                    </strong>
                    @if(Auth::check())
                        @if(DB::table('store_point_record')->where('member_id', Auth::id())->count() <= 0)
                            @if(DB::table('gamestatus')->where('gamenumber', 23)->first()->maintenance == 1)
                            <strong>
                                <img src="/images/game02.png" />
                                <p>急速飛機</p>
                                <div class="disabled">維護中</div>
                            </strong>
                            @else
                            <strong onclick="alert('會員金額不足尚未啟動，請先儲值')">
                                <img src="/images/game02.png" />
                                <p>急速飛機</p>
                            </strong>
                            @endif
                        @else
                            @if(DB::table('gamestatus')->where('gamenumber', 23)->first()->maintenance == 1)
                            <strong>
                                <img src="/images/game02.png" />
                                <p>急速飛機</p>
                                <div class="disabled">維護中</div>
                            </strong>
                            @else
                                @if(Auth::user()->money > 0 )
                                <strong onclick="window.location.href='/airplane'">
                                    <img src="/images/game02.png" />
                                    <p>急速飛機</p>
                                </strong>
                                @else
                                <strong onclick="alert('訂單已滿')">
                                    <img src="/images/game02.png" />
                                    <p>急速飛機</p>
                                </strong>
                                @endif
                            @endif
                        @endif
                    @else
                        @if(DB::table('gamestatus')->where('gamenumber', 23)->first()->maintenance == 1)
                        <strong>
                            <img src="/images/game02.png" />
                            <p>急速飛機</p>
                            <div class="disabled">維護中</div>
                        </strong>
                        @else
                        <strong onclick="notloginFn()">
                            <img src="/images/game02.png" />
                            <p>急速飛機</p>
                        </strong>
                        @endif
                    @endif
                    <strong>
                        <img src="/images/game03.png" />
                        <p>急速賽狗</p>
                        <div class="disabled">維護中</div>
                    </strong>
                </div>
            </a>
            <a href="/history">企業歷史</a>
            <a href="/about">關於我們</a>
            @if(Auth::check())
            <a href="/contact">聯絡我們</a>
            <a href="/memberCentre">會員中心</a>
            @else
            <a href="javascript:;" onclick="notloginFn()">聯絡我們</a>
            @endif
        </nav>
    </div>
    <div class="right">
        @if(!Auth::check())
        <a class="user" href="/login">
            <i class="fa-solid fa-user"></i>登入
        </a>
        @else
        <div class="isLoginDiv">
            <div  id="isLogin"><i class="fa-solid fa-user"></i>{{Auth::user()->name}}</div>
            <div id="hiddenMenu">
                <div class="hiddenMenuTitle">{{Auth::user()->name}}</div>
                <a href="/memberCentre" class="list">會員中心</a>
                <div class="list">
                    @if(Auth::user()->point_lock)
                    <span class="text-danger">已鎖定</span>
                    @else
                    餘額: ${{Auth::user()->money}}
                    @endif
                </div>
                <form action="/logout" method="post" id="logout" class="list" style="margin:0;border:none">
                    @csrf
                    <a href="javascript:;" onclick="logout.submit()" class="logout list" style="border:none;padding: 0;margin:0;">登出</a>
                </form>
            </div>
        </div>



        {{-- <div> 歡迎 {{Auth::user()->username}} ~您的餘額還有 <span>{{Auth::user()->money}}</span></div>
        <div class="md">餘額<span>{{Auth::user()->money}}</span></div>
        <form action="/logout" method="post" id="logout">
            @csrf
            <a href="javascript:;" onclick="logout.submit()" class="logout">登出</a>
        </form> --}}
        @endif
        <i class="fas fa-bars" id="openMenu"></i>
    </div>
    <script>

        let isOpen = false;

        const notloginFn = ()=>{
            Swal.fire({
                icon: 'error',
                title: '請先登入！',
                text: '您無權限進入，請先登入！',
                footer: '<a href="/register">沒有帳號嗎？點擊註冊</a>',
                confirmButtonText: '前往登入',
                confirmButtonColor: '#3085d6',


            }).then(result=>{
                if(result.isConfirmed){
                    window.location.href="/login";
                }
            })
        };
    openMenu.addEventListener('click', ()=>{
        nav.style.top = "0"
    })
    closeMenu.addEventListener('click', ()=>{
        nav.style.top = "-100vh"
    })



    isLogin.addEventListener('click', ()=>{
        isOpen = !isOpen;
        if(isOpen){
            hiddenMenu.style.display = "block";
        }else{
            hiddenMenu.style.display = "none";
        }
    })


    </script>
</header>
