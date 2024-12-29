<div id="withdrawMoneyDetailed">
    @include('livewire.layouts.memberCentreNav')
    <h2>轉移資產詳細記錄</h2>
    <div class="info mt-2">
        <table class="table table-bordered table-hover mt-2">
            <tbody>
                <tr>
                    <td>交易平台</td>
                    <td>KSN</td>
                </tr>
                <tr>
                    <td>會員帳號</td>
                    <td>{{Auth::user()->username}}</td>
                </tr>
                <tr>
                    <td>訂單編號</td>
                    <td>{{$order_number}}</td>
                </tr>
                <tr>
                    <td>轉移金額</td>
                    <td>{{$money}}</td>
                </tr>
                <tr>
                    <td>幣別</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>交易狀態</td>
                    <td><span class="@if($status<=0) text-danger @else text-success @endif">{{$statusText}}</span></td>
                </tr>
                <tr>
                    <td>備註</td>
                    <td>{{$warning}}</td>
                </tr>
            </tbody>
          </table>
    </div>
    <a href="javascript:;" class="btn btn-success mt-4" onclick="window.history.back()">回上一頁</a>
</div>
