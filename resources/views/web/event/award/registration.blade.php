@php($title = 'Mkulima Awards Registration')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    @if (isAwardActive())
   <x-web.event.award-registration-component />
   @endif
</x-web.layout.app-layout>
