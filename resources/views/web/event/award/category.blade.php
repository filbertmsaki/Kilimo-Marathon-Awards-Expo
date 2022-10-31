@php($title = 'Kilimo Award Category')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-50">
        <div class="container">
            <div class="box bg-light">
                <div class="box-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-grid" role="tabpanel"
                            aria-labelledby="pills-grid-tab">
                            <div class="row list">
                                @foreach ($categories as $item)
                                    <div class="col-md-3 col-6 list-item">
                                        <div class="box text-center shadow-sm">
                                            <div class="box-body p-1">
                                                <span class="icon-Group text-primary fs-40"><i
                                                        class="me-10 mdi mdi-trophy-award" aria-hidden="true"></i>
                                                </span>
                                                <div class="fw-500  fs-16 mb-5">{{ $item->name }}</div>
                                                {{-- <div class="fw-400 text-fade fs-16 mb-2 mt-5">({{ $nominee->total_nominee }}) Nominee
                                            </div> --}}
                                            </div>
                                            <a href="{{ route('web.event.award.category.show', $item->slug) }}"
                                                class="b-0 waves-effect waves-light btn btn-primary btn-sm rounded-0">View
                                                Category</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div aria-label="Page navigation example">
                        {!! $categories->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
