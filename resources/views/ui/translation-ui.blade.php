<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Translation ui</title>
    <link rel="stylesheet" href="{{ asset('vendor/laravel-interface-translation/style.css') }}">
    @livewireStyles
</head>
<body>
    <livewire:laravel-interface-translation.list />
    @livewireScripts
</body>
</html>
