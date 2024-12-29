<div id="certified">
    <div class="use" >
        <div class="title">
            <h2>實名驗證</h2>
        </div>        
        <div class="btnList">
            <button id="btn1" value="1" onclick="window.location.href='/certified'">身分證驗證</button>
            <button id="btn2" value="2" onclick="window.location.href='/certifiedPassbook'">銀行戶頭驗證</button>
        </div>
        @if(session()->has('card-success'))
            <div class="alert alert-success"> {{session('card-success')}} </div>
        @endif
        @if(!$data_passbook_verify)
            @if($toBeVerified == 0)
            <form class="content" id="content2" wire:submit.prevent='uploadPassbook'>
                <div class="upload-content">
                    <label for="passbook-cover">
                        @if($passbookCover)
                        <img src="{{$passbookCover->temporaryUrl()}}" alt="">
                        @else
                        <i wire:loading.remove class="fa-solid fa-cloud-arrow-up"></i>
                        <p wire:loading.remove>存摺封面(點擊上傳)</p>
                        @endif
                        <div class="loading" wire:loading wire:target='passbookCover'><img src="/images/loading.gif" width="30" alt=""></div>
                        <input type="file" hidden id="passbook-cover" wire:model="passbookCover">
                    </label>
                    <div class="step2">
                        <div class="item">
                            <p>1.使用銀行</p>
                            <select name="" class="form-control bg-transparent" id="" wire:model="bank">
                                <option value=""  selected>請選擇銀行</option>
                                @foreach ($openBank as $bank)
                                <option value="{{$bank['id']}}{{$bank['name']}}">{{$bank['id']}} {{$bank['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="item">
                            <p>2.銀行分行</p>
                            <input type="text" class="form-control bg-transparent" wire:model="bankBranches">
                        </div>
                        <div class="item">
                            <p>3.存摺戶名</p>
                            <input type="text" class="form-control bg-transparent" wire:model="passbookAccountName">
                        </div>
                        <div class="item">
                            <p>4.存摺帳號</p>
                            <input type="text" class="form-control bg-transparent" wire:model="passbookAccount">
                        </div>
                    </div>
                </div>
                <div class="comment">
                    <p>*無摺會員請使用「網銀截圖」,截圖中須包含「姓名」、「銀行」、「帳號」、「分行」</p>
                    <p>*無摺會員在身分證(正面)需上傳身分證正面已及提款卡合照·</p>
                </div>
                @error('passbookCover') <span class="text-danger">{{$message}}</span> @enderror
                @error('bank') <span class="text-danger">{{$message}}</span> @enderror
                @error('passbookAccountName') <span class="text-danger">{{$message}}</span> @enderror
                @error('passbookAccount') <span class="text-danger">{{$message}}</span> @enderror
                <button class="btn btn-warning upload" type="submit">上傳</button>
            </form>
            @endif
        @else
            <div class="alert alert-success mt-5"> 上傳成功。 </div>
        @endif
       
        
    </div>
</div>
@push('scripts')
    <script>
    </script>   
@endpush