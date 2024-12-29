<div class="memberCentreNav">
    <a class="" href="/memberCentre">會員中心</a>
    <a class="" href="/modifyData">修改資料</a>
    <a class="" href="/withdrawMoney">提領現金</a>
    @if(!Auth::user()->data_auth)
    <a class="" href="/certified">實名驗證</a>
    @endif
    <a class="" href="/tradeRecord">交易紀錄</a>
    <a class="btn btn-warning" href="/contact">聯繫客服</a>
</div>
