@php($title = 'Kilimo Award Voting')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">Kilimo Award Categories </h2>
                    <hr>
                </div>
            </div>
            <div class="row div-list">
                @foreach ($nominees as $nominee)
                    <div class="col-md-3 col-6 div-list-item">
                        <div class="box text-center">
                            <div class="box-body p-1">
                                <span class="icon-Group text-primary fs-40"><i class="me-10 mdi mdi-trophy-award"
                                        aria-hidden="true"></i>
                                </span>
                                <div class="fw-500  fs-16 mb-5">{{ $nominee->awardcategory->name }}</div>
                                <div class="fw-400 text-fade fs-16 mb-2 mt-5">({{ $nominee->total_nominee }}) Nominee
                                </div>
                            </div>
                            @if (isVoteActive())
                                <a href="{{ route('web.event.vote.show', $nominee->awardcategory->slug) }}"
                                    class="b-0 waves-effect waves-light btn btn-primary btn-sm rounded-0">Vote Now</a>
                            @endif

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
