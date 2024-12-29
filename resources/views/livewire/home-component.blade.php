<div id="home-component" x-data="{
    adOpen:true,
}">
{{-- @if(true)
    <div class="ad" id="ad" x-show="adOpen">
        <div class="content">
            <h3>
                最新消息
                <i class="fas fa-times" x-on:click="adOpen = false"></i>
            </h3>
            <p>
                系統維護公告:為維護各位玩家遊玩品質<br />
                系統將8/2 00:00~8/3 24:00 將進行系統週期性維護<br />
                感謝各位玩家支持
            </p>
        </div>
    </div>
@endif --}}
    <div class="banner">
        <div class="responsive">
            <div>
                <div class="block">
                    <div class="title">KSN國際企業電商徵才</div>
                    @guest
                    <div class="btns">
                        <a href="/login">加入<br>公司</a>
                        <a href="/register">立即<br>註冊</a>
                    </div>
                    @endguest
                </div>
                <img src="/ksn/images/banner.png" alt="" />
            </div>
        </div>
    </div>
    <div class="service">
        <div class="block">
            <div class="title">KSN國際企業電商徵才</div>
            <p>了解自己所長，朝向目標邁進</p>
            <div class="btns">
                <a href="/history">企業歷史</a>
                <a href="/about">關於我們</a>
                @if(Auth::check())
                <a href="/contact">聯絡我們</a>
                @else
                <a href="javascript:;" onclick="notloginFn()">聯絡我們</a>
                @endif
            </div>

        </div>
    </div>
</div>

@push('scripts')
    <script>
        const btnList = document.getElementById('btnList')
        const viewImg = document.getElementById('viewImg')
        const toggleViewImg = (e)=>{
            console.log();
            viewImg.src = "/images/" + e.target.value + ".png"
        }
        for(let i=0;i<btnList.querySelectorAll('.btnItem').length;i++){
            btnList.querySelectorAll('.btnItem')[i].addEventListener('mouseover', toggleViewImg);
        }
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
    </script>
@endpush
