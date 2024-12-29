<div id="home">
    <div class="banner">
        <img src="/ksn/images/banner.jpg" alt="">
    </div>
    <div class="foundry">
        <div class="left">
            @foreach ($foundrys as $foundry)
            <a href="javascript:;" class="btn">
                <p>{{$foundry}}</p>
                <img src="/images/Lovepik.png">
            </a>
            @endforeach
        </div>
        <div class="right">
            <img src="/images/11.png" alt="">
        </div>
    </div>
    <div class="step">
    </div>
    <div class="benefit">
        <img src="/images/16.jpg" alt="">
    </div>
    @include('livewire.layouts.footer')
   @include('livewire.layouts.alert')
</div>
