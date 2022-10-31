@php($title = 'Kilimo Award Category')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-50">
        <div class="container">
                    <div class="box">
                        <div class="box-body">
                            <h4 class="box-title mb-0 fw-500">{{ $category->name }}</h4>
                            <hr>
                            <div class="list-style">
                                {!! $category->description !!}
                            </div>
                            @if (isAwardActive())

                            <div class="card-footer py-2  justify-content-start d-flex align-items-center">
                                <div class="entry-button">
                                    <a href="{{ route('web.event.award.registration') }}" class="btn btn-primary btn-sm">Register As Nominee</a>
                                </div>
                            </div>
                            @endif
                        </div>
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
