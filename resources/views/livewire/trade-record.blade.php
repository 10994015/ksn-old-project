<div id="tradeRecord">
    <style>
        nav svg{
            height: 20px;
        }
        nav .hidden{
            display: block;
        }
    </style>
    @include('livewire.layouts.memberCentreNav')
    <div class="info mb-4">
    <table class="table table-bordered table-hover mt-2">
        <thead class="">
          <tr>
            <th scope="col">訂單日期</th>
            <th scope="col">交易平台</th>
            <th scope="col">儲值金額</th>
          </tr>
        </thead>

            <tbody>
                @php $status = ['-2'=>'取消','-1'=>'交易失敗', '0'=>'待審核', '1'=>'交易成功']; @endphp
                @foreach ($stores as $store)
                <tr>
                    <th>{{date('Y-m-d', strtotime($store->created_at))}}</th>
                    <th>KSN</th>
                    <td class="text-success">{{$store->money}}</td>
                </tr>
                @endforeach


            </tbody>

      </table>
    </div>
    {{$stores->links()}}


</div>
