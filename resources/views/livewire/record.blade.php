<div class="recordModal" id="recordModal">
    <div class="content">
        <div class="header"><p>紀錄</p><span class="text-danger" style="font-size: 15px" >(重新整理以查看最新紀錄)</span><i class="fas fa-times" id="closeRecordModalBtn"></i> </div>
        <div class="list" id="recordModalList">
            <div class="betitem title">
                <p>期號</p>
                <p>下注列表</p>
                <p>總下注金額</p>
                <p>注量</p>
                <p>結果</p>
                <p>時間</p>
           </div>
           @foreach ($betlist as $betitem)
           @php
              $final = intval($betitem->final) - intval($betitem->money);
              $ranks = json_decode($betitem->bet_arr);

           @endphp
           <div class="betitem">
                <p>{{$betitem->bet_number}}</p>
                <p>
                    @foreach ($ranks as $rank)
                        {{$rank->rank}}({{$rank->content}})- <span class="text-warning">${{$rank->money}}</span> <br />
                    @endforeach
                    
                </p>
                <p>{{$betitem->money}}</p>
                <p>{{$betitem->chips}}</p>
                <p style=" color:@if($final>0) green @else red @endif "> {{$final}} </p>
                <p>{{$betitem->created_at}}</p>
            </div>
           @endforeach
        </div>
    </div>
</div>