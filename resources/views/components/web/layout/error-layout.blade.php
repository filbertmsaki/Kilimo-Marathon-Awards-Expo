<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-web.layout.head-component />

<body class="theme-primary">
    {{ $slot }}
    <x-web.layout.scripts-component />
</body>

</html>
