<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-web.layout.head-component />

<body class="theme-primary">
    <x-web.layout.sticky-social-media-component />
    <x-web.layout.header-component />
    <x-web.layout.page-title-component :isPagetitle="$isPagetitle" :pageTitle="$pageTitle" />
    {{ $slot }}
    <x-web.layout.footer-component />
    <x-web.layout.scripts-component />
</body>

</html>
