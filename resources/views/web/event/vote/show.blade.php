@php($title = 'Kilimo Award Voting')
@php($award_nominees = $nominees)
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    <section class="py-50">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center text-primary">{{ $category->name }}</h2>
                    <hr>
                </div>
            </div>
            <div class="row list">
                @foreach ($award_nominees as $nominee)
                    <div class="col-md-3 col-6 list-item">
                        <div class="box text-center">
                            <div class="box-body p-1">
                                <span class="icon-Group text-primary fs-40"><i class="me-10 mdi mdi-trophy-award"
                                        aria-hidden="true"></i>
                                </span>
                                <div class="fw-500  fs-18 mb-5">{{ ucwords(strtolower($nominee->data_name)) }}</div>
                                <div class="fw-400 text-fade fs-16 mb-2 mt-5"> {!! $share !!}</div>

                            </div>
                            <a href="javascript:void(0)"
                                class="b-0 waves-effect waves-light btn btn-primary btn-sm rounded-0" id="vote-btn"
                                data-id="{{ $nominee }}">Vote</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @section('script')
        <script>
            $(document).ready(function() {
                $('body').on('click', '#vote-btn', function() {
                    var data = $(this).data('id');
                    var id = data.data_id;
                    var url = "{{ route('web.event.vote.store') }}";
                    if (isJSON(data)) {
                        $.ajax({
                            type: "post",
                            url: url,
                            data: {
                                _token: "{{ csrf_token() }}",
                                nominee: id,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data.success) {
                                    console.log(data);
                                    toastr.options = {
                                        "closeButton": true,
                                        "progressBar": true,
                                        "positionClass": "toast-top-right"
                                    }
                                    toastr.success(data.success);
                                } else {
                                    console.log(data);
                                    toastr.options = {
                                        "closeButton": true,
                                        "progressBar": true,
                                        "positionClass": "toast-top-right"
                                    }
                                    toastr.error(data.error);
                                }

                            },
                            error: function(data) {

                            }
                        });
                    }

                });
            });
        </script>
    @endsection
</x-web.layout.app-layout>
