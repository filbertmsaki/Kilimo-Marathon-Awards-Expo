@php($title = 'Kilimo Marathon Registration ')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    @if (isMarathonActive())
        <x-web.event.marathon-registration-component />
    @endif
</x-web.layout.app-layout>
