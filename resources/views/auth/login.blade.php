 <x-guest-layout>
     <div class="container-fluid" id="logPage">

        <form method="post" action="{{route('login')}}" class="loginForm">
            @csrf
            <img src="/ksn/images/logo2.png" class="logo">
            <a href="/" class="gotoHome">首頁HOME</a>
            <div class="mb-3">
                <label for="username" class="form-label" >帳號</label>
                <input type="text" name="username" placeholder="請輸入帳號..." class="bg-transparent" id="username" :value="old('username')" autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">密碼</label>
                <input type="password" name="password" placeholder="請輸入密碼..." class="bg-transparent" id="password">
            </div>
            <x-jet-validation-errors class="mb-4 text-danger" />
            <button type="submit" class="loginBtn" style="background:#A1C195;color:#fff;border:none">登入</button>
            <a href="/register" class="" style="color:#aaa">還沒有帳號嗎？點擊註冊</a>
        </form>
    @include('livewire.layouts.alert')
</x-guest-layout>

