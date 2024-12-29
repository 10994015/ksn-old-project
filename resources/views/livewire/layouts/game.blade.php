<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.8, maximum-scale=0.8, user-scalable=no" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name', "KSN電商")}}</title>
    <link rel="stylesheet" href="/scss/app.css">
    <link rel="stylesheet" href="/css/style4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Ubuntu:ital,wght@1,300&family=Wallpoet&display=swap" rel="stylesheet">
    @livewireStyles
    <style>
        @media screen and (max-width:1000px){
            body, html{
                max-width: 100%;
                min-width: 100%;
                height: 100%;
                max-width: 100vh;
                overflow-x: hidden;
                overflow-y: scroll;
            }
        }
    </style>
</head>
<body>

    <main>
        {{$slot}}
    </main>


    @livewireScripts
    <script src="/js/app.js"></script>
    <script src="/js/airplane.js?version=<?php echo time(); ?>"></script>
    <script src="/js/money.js"></script>
    @stack('scripts')
</body>
</html>
