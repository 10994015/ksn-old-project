<div id="withdraw-money">
    <style>
        nav svg{
            height: 20px;
        }
        nav .hidden{
            display: block;
        }
    </style>
    @include('livewire.layouts.memberCentreNav')

    <h2>提領現金</h2>
    <form class="info mt-2 mb-2" id="form" wire:submit.prevent='outMoneyFn'>
        <div id='loading' wire:loading wire:target="outMoneyFn">loading...</div>
        @if(session()->has('message'))
            <div class="alert alert-success"> {{session('message')}} </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger"> {{session('error')}} </div>
        @endif
        <label for="">
            銀行帳戶
            <select wire:model="bankAccount" class="form-control">
                <option value="{{$bankAccount}}">{{$bankAccount}}</option>
            </select>
        </label>
        <label for="">
            轉移資金
            <input type="number" class="form-control" id="outMoney" wire:model="outMoney" placeholder="請輸入點數...">
        </label>
        <label for="">
            可用餘額
            <input type="number" class="form-control" id="myMoney" wire:model="myMoney" disabled>
        </label>
        <label for="">
            提領密碼
            <input type="password" class="form-control" id="moneyCode" wire:model="moneyCode" />
        </label>
        <a href="javascript:;" class="btn  " id="outBtn">提領</a>
        <img src="/images/war.png" />
        <p class="text-danger">
            為配合銀行信託流程,<br>
            若您於銀行換綁期間進行操作<br>
            可能導致失敗喔!
        </p>
        <input type="submit"id="send" hidden />
        <h3 class="mt-5">資產轉移紀錄</h3>
        <table class="table table-bordered table-hover mt-2">
            <thead class="" >
              <tr>
                <th scope="col">交易平台</th>
                <th scope="col">訂單編號</th>
                <th scope="col">轉出資金</th>
                <th scope="col">操作時間</th>
                <th scope="col">狀態</th>
                <th scope="col">詳細</th>
              </tr>
            </thead>
            <tbody>
                @php $status = ['-2'=>'取消','-1'=>'交易失敗', '0'=>'待審核', '1'=>'交易成功']; @endphp
                @foreach ($withdraw as $item)
                <tr>
                    <th>{{$item->platform}}</th>
                    <th>{{$item->order_number}}</th>
                    <td>{{$item->money}}</td>
                    <td>{{$item->created_at}}</td>
                    <td>{{$status[$item->status]}}</td>
                    <td><a href="/withdrawMoneyDetailed/{{$item->id}}" class="btn btn-danger">詳細</a></td>
                  </tr>
                @endforeach

            </tbody>
          </table>
    </form>
    {{$withdraw->links()}}
</div>

@push('scripts')
    <script>
        const resetLoading = ()=> {

        }
        outBtn.addEventListener('click', ()=>{
            if(outMoney.value == ""){
                alert('請輸入餘額！')
                return;
            }
            if(outMoney.value < 500 ){
                alert('提領金額最低為500！')
                return;
            }
            if(Number(outMoney.value) > Number(myMoney.value)){
                alert('餘額不足！')
                return;
            }
            if(confirm('確定轉出嗎？')){

                send.click();
            }
        });
    </script>
@endpush
