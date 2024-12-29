<div id="certified">
    <div class="use" >
        <div class="title">
            <h2>實名驗證</h2>
        </div>        
        <div class="btnList">
            <button id="btn1" value="1" onclick="window.location.href='/certified'">身分證驗證</button>
            <button id="btn2" value="2" onclick="window.location.href='/certifiedPassbook'">銀行戶頭驗證</button>
        </div>
        @if(session()->has('card-success') )
            <div class="alert alert-success"> {{session('card-success')}} </div>
        @endif
        @if(!$data_auth_verify)
            @if($toBeVerified==0 )
            <form class="content" id="content1" wire:submit.prevent='uploadNumberId'>
                <div class="upload-content">
                    <label for="card-front">
                        @if($cardFront)
                        <img src="{{$cardFront->temporaryUrl()}}" alt="">
                        @else
                        <i class="fa-solid fa-cloud-arrow-up" wire:loading.remove wire:target='cardFront'></i>
                        <p wire:loading.remove wire:target='cardFront'>身分證正面(點擊上傳)</p>
                        @endif
                        <div class="loading" wire:loading wire:target='cardFront'><img src="/images/loading.gif" width="30" alt=""></div>
                        <input type="file" hidden id="card-front" wire:model="cardFront">
                        
                    </label>
                    <label for="card-back">
                        @if($cardBack)
                        <img src="{{$cardBack->temporaryUrl()}}" alt="">
                        @else
                        <i class="fa-solid fa-cloud-arrow-up" wire:loading.remove wire:target='cardBack'></i>
                        <p wire:loading.remove wire:target='cardBack'>身分證背面(點擊上傳)</p>
                        @endif
                        <div class="loading" wire:loading wire:target='cardBack'><img src="/images/loading.gif" width="30" alt=""></div>
                        <input type="file" hidden id="card-back" wire:model="cardBack">
                    </label>
                    <div>
                        <p>2.填寫您的身分證字號</p>
                        <input type="text" class="form-control bg-transparent" wire:model="numberId">
                        <span >
                            起首為一個大寫英文字母與接續九個阿拉伯數字
                        </span>
                    </div>
                </div>
                <div class="comment">
                    <p>*無摺會員請使用「網銀截圖」,截圖中須包含「姓名」、「銀行」、「帳號」、「分行」</p>
                    <p>*無摺會員在身分證(正面)需上傳身分證正面已及提款卡合照·</p>
                </div>
                @error('cardFront') <span class="text-danger">{{$message}}</span> @enderror
                @error('cardBack') <span class="text-danger">{{$message}}</span> @enderror
                @error('numberId') <span class="text-danger">{{$message}}</span> @enderror
                <button class="btn btn-warning upload" type="submit">
                    <div wire:loading wire:target='uploadNumberId' wire:key='uploadNumberId'> <i class="fa-solid fa-spinner"></i> </div>
                    上傳
                </button>
            </form>
            @endif
        @else
            <div class="alert alert-success mt-5"> 上傳成功。</div>
        @endif
    </div>
</div>
@push('scripts')
    
@endpush