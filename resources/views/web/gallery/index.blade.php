@php($title = 'Gallery')
@php($page_galleries = $galleries)
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
@section('css')
<style>

    .image-block {
        border: 3px solid white;
        background-color: black;
        padding: 0px;
        margin: 0px;
        height: 200px;
        text-align: center;
        vertical-align: bottom;
    }

    .image-block>p {
        width: 100%;
        height: 100%;
        font-weight: normal;
        font-size: 19px;
        padding-top: 150px;
        background-color: rgba(3, 3, 3, 0.0);
        color: rgba(6, 6, 6, 0.0);
    }

    .image-block:hover>p {
        background-color: rgba(3, 3, 3, 0.5);
        color: white;
    }
</style>
@endsection
    <section class="py-10">
        <div class="container">
            <div class="box">
                <div class="box-body">
                    <div class="container-fluid">
                        <div class="row">
                            @foreach ($page_galleries as $item)
                                <div class="image-block col-sm-4"
                                    style="background: url({{ asset($item->image_url) }}) no-repeat center top;background-size:cover;">
                                    <p>{{ $item->title }} </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
