<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name', 'KSN電商')}}</title>
    <link rel="stylesheet" href="/scss/app.css">
    <link rel="stylesheet" href="/css/style4.css">

    <link rel="stylesheet" type="text/css" href="/slick-1.6.0/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="/slick-1.6.0/slick/slick-theme.css"/>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="/slick-1.6.0/slick/slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    @livewireStyles
</head>
<body>
    @include('livewire.layouts.header')
    {{-- @include('livewire.layouts.nav') --}}
    <div class="loadingWait" id="loadingWait">
        <div class="loading">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
          </div>
    </div>
    <main>
        {{$slot}}
    </main>
    <a href="javascript:;" class="totop" id="totop" onclick="window.scrollTo(0, 0)"><i class="fa-solid fa-chevron-up"></i></a>
    @include('livewire.layouts.footer')


    @livewireScripts
    <script src="/js/app.js"></script>
    <script src="/js/money.js"></script>
    <script>
        $('.responsive').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 6000,
            dots:true
        });
        window.onload =()=>{
            loadingWait.style.display = "none";
        }
    </script>
    @stack('scripts')
</body>
</html>
