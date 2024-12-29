<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, minimum-scale=1.0, maximum-scale=3.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name', 'KSN電商')}}</title>
    <link rel="stylesheet" href="/scss/app.css">
    <link rel="stylesheet" href="/css/style4.css">
    @livewireStyles
</head>
<body>
    {{-- @include('livewire.layouts.header') --}}
    <main>
        {{$slot}}
    </main>

    {{-- @include('livewire.layouts.footer') --}}
    @livewireScripts
    <script src="/js/app.js"></script>
</body>
</html>
