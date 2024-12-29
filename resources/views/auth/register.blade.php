<x-guest-layout>
    @php
        $r_number = NULL;
        if(isset(request()->rn)){
            $r_number = request()->rn;
        }
    @endphp
    <div class="container-fluid" id="logPage">

        <form method="post" action="{{route('register')}}" class="registerForm">
            @csrf
            <img src="/ksn/images/logo2.png" class="logo">
            <a href="/" class="gotoHome">首頁HOME</a>
            <div class="mb-3">
                <label for="username" class="form-label " >帳號</label>
                <input type="text" name="username" placeholder="帳號需為4至10碼" class="  bg-transparent" id="username"  value="{{old('username', request()->get('username'))}}" />
            </div>
            <div class="mb-3">
                <label for="name" class="form-label " >姓名</label>
                <input type="text" name="name" placeholder="請輸入姓名..." class="  bg-transparent" id="name" value="{{old('name')}}" />
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label " >手機號碼</label>
                <input type="text" name="phone" placeholder="請輸入手機號碼(格式09xxxxxxxxx)" class="  bg-transparent" id="phone" value="{{old('phone')}}" />
                <small class="text-danger" style="margin:0">請使用真實手機，任務接取皆須手機認證</small>
            </div>
            {{-- <div class="mb-3">
                <label for="email" class="form-label" >電子郵件</label>
                <input type="email" name="email" placeholder="請輸入電子郵件" class="bg-transparent" id="email" value="{{old('email')}}" />
            </div>
            <div class="mb-3">
                <label for="email_verify" class="form-label " >電子郵件驗證</label>
                <button type="button" class="btn btn-primary" id='sendCodeBtnemail' style="margin:0 0 8px">發送驗證碼</button>
                <p class="text-black-50" id="waitText" >等待60秒重新發送</p>
                <input type="text" name="email_verify" placeholder="請輸入驗證碼..." class="bg-transparent" id="email_verify" value="{{old('email_verify')}}" />
            </div> --}}
            {{-- <div class="mb-3">
                <label for="phone" class="form-label" >手機驗證</label>
                <button type="button" class="btn btn-primary" id='sendCodeBtn' style="margin:0 0 8px">發送驗證碼</button>
                <p class="text-black-50" id="waitText" >等待60秒重新發送</p>
                <input type="text" name="phone_verify" placeholder="請輸入驗證碼..." class="bg-transparent" id="phone_verify" value="{{old('phone_verify')}}" />
            </div> --}}
            <div class="mb-3">
                <label for="password" class="form-label ">密碼</label>
                <input type="password" name="password" placeholder="密碼需為6至20碼..." class="  bg-transparent" id="password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label ">再次確認密碼</label>
                <input type="password" name="password_confirmation" placeholder="再次確認密碼..." class="  bg-transparent" id="password_confirmation">
            </div>
            <div class="mb-3">
                <label for="captcha" class="form-label ">請輸入驗證碼</label>
                <div class="d-flex">
                    <span class="mr-2 d-block" id="captcha">{!! captcha_img('flat') !!}</span>
                    <button class="btn btn-danger  ml-2" type="button" id="reloadCaptcha">&#x21bb;</button>
                    <input type="text" name="captcha" placeholder="請輸入驗證碼..." class="  bg-transparent" id="captcha">
                </div>
            </div>
            <x-jet-validation-errors class="mb-4 text-danger" />
            <input type="hidden" value="{{$r_number}}" name="r_number">
            <input type="hidden" name="randId" id="randId" value="{{old('randId')}}">
            <button type="submit" class=" mt-3 registerBtn" style="background:#A1C195;color:#fff;border:none">註冊</button>
            <a href="/login" class="" style="color:#aaa">已經有帳號了嗎？前往登入</a>
        </form>
        <div class="left">
        </div>
    @include('livewire.layouts.alert')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.4/axios.min.js" integrity="sha512-LUKzDoJKOLqnxGWWIBM4lzRBlxcva2ZTztO8bTcWPmDSpkErWx0bSP4pdsjNH8kiHAUPaT06UXcb+vOEZH+HpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        const name = document.getElementById('name')
        const phone = document.getElementById('phone')
        const randId = document.getElementById('randId')
        const captcha = document.getElementById('captcha')


        reloadCaptcha.addEventListener('click', ()=>{
            axios.get('/reload-captcha').then(res=>{
                captcha.innerHTML = res.data.captcha;
            })
        })

        // sendCodeBtnemail.addEventListener('click' , ()=>{
        //     // if(email.value == ""){
        //     //     alert('請輸入電子郵件');
        //     //     return;
        //     // }
        //     axios.post("/api/sendEmailCode", {"email":email.value, 'name':name.value}).then((res) => {
        //         console.log(res.data);
        //         let sec = 60;
        //         let timer = null;
        //         // waitText.style.display = "block"
        //         sendCodeBtn.disabled = true;
        //         // randId.value = res.data.randid;
        //         timer = setInterval(() => {
        //             sec--;
        //             waitText.innerHTML = `等待${sec}秒重新發送`;
        //             if(sec==0){
        //                 sendCodeBtn.disabled = false;
        //                 waitText.style.display = "none"
        //                 clearInterval(timer);
        //             }
        //         }, 1000);
        //     })
        // })


        sendCodeBtn.addEventListener('click', ()=>{
                if(phone.value == "") return alert('請輸入手機！');
                if(phone.value.length != 10) return alert('手機須為十碼');
                axios.post("/api/sendPhoneCode", {"phone":phone.value}).then((res) => {
                    let sec = 60;
                    let timer = null;
                    waitText.style.display = "block"
                    sendCodeBtn.disabled = true;
                    randId.value = res.data.randid;
                    timer = setInterval(() => {
                        sec--;
                        waitText.innerHTML = `等待${sec}秒重新發送`;
                        if(sec==1){
                            sendCodeBtn.disabled = false;
                            waitText.style.display = "none"
                            clearInterval(timer);
                        }
                    }, 1000);
                }).catch((err) => {
                    console.error(err);
                });
        })

    </script>
</x-guest-layout>
