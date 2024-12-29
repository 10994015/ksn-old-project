<div id="memberCentre">
    @include('livewire.layouts.memberCentreNav')

    <div class="memberinfo">
        <div class="title">
            <ul>
                <li>
                    <p>登入帳號</p>
                    <p>{{$username}}</p>
                </li>
                <li>
                    <p>姓名</p>
                    <p>{{$name}}</p>
                </li>
                <li>
                    <p>手機號碼</p>
                    <p>{{$phone}}</p>
                </li>
                <li>
                    <p>手機驗證</p>
                    @if($phone_verification == 1) 
                    <p class="text-success">已完成</p>
                    @else
                    <p class="text-danger">尚未驗證<a href="/phoneVerification" style="margin-left:10px" class="btn btn-danger">前往驗證</a></p>
                    @endif
                </li>
                {{-- <li>
                    <p>實名驗證</p>
                    @if($data_auth==1)
                    <p class="text-success">已完成</p>
                    @else
                    <p class="text-danger">尚未驗證<a href="/certified" class="btn btn-danger" style="margin-left:10px">前往驗證</a></p>
                    @endif
                </li> --}}
            </ul>
            <div class="money">
                <h3 class="border-bottom border-dark">
                    處理中的資金<br>
                    <span>$ <strong class="thousandths">{{$handle_money}}</strong></span>

                </h3>
                <h3>電子錢包<br>
                    @if($is_lock)
                    <span class="text-danger" style="font-size:18px">您的錢包已被鎖定<br>請與客服聯繫</span>
                    @else
                    <span id="myMoney"  style="display:none">$<strong class="thousandths">{{$money}}</strong></span>
                    <span id="hiddenText" >*****</span>
                    @endif
                </h3>
                <a href="javascript:;" id="hiddenMoney" ><i class="fa-solid fa-eye" style="margin-right:5px"></i>顯示餘額</a>
            </div>
        </div>
    </div>
   
    <div class="tradingCenter">
        <h5>交易中心</h5>
        <div class="trading">
            <a href="/airplane">
                <img src="/images/1677333699016.jpg" alt="">
            </a>
            <a href="javascript:;">
                <img src="/images/1677333730082.jpg" alt="">
            </a>
            <a href="javascript:;">
                <img src="/images/1677333722351.jpg" alt="">
            </a>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        let isBlock = false;
        hiddenMoney.addEventListener('click', ()=>{
            isBlock = !isBlock;
            if(isBlock){
                myMoney.style.display = "block"
                hiddenText.style.display = "none"
                hiddenMoney.innerHTML = `<i class="fa-sharp fa-solid fa-eye-slash" style="margin-right:5px"></i>隱藏餘額`;
            }else{
                myMoney.style.display = "none"
                hiddenText.style.display = "block"
                hiddenMoney.innerHTML = `<i class="fa-solid fa-eye" style="margin-right:5px"></i>顯示餘額`;
            }
        })
    </script>
@endpush