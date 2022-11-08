<x-admin.layout.app-layout>
    @section('title', 'Site Settings')
    @section('pagename', 'Site Settings')
    @section('css')
    @endsection
    @section('script')

    @endsection
    <section class="content" style="margin-bottom: 20px;">
        <form method="POST" action="{{ route('admin.setting.site.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="general_settings_id" name="general_settings_id"
                value="{{ $site_settings->id ?? '' }}">

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Site Identity</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="site_name">Site Name</label>
                                <input type="text" id="site_name" name="site_name" class="form-control"
                                    value="{{ $site_settings->site_name ?? '' }}">
                                @if ($errors->has('site_name'))
                                    <span class="text-danger">{{ $errors->first('site_name') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="site_tagline">Site Tagline</label>
                                <textarea id="site_tagline" class="form-control" name="site_tagline" rows="4">{{ $site_settings->site_tagline ?? '' }}</textarea>
                                @if ($errors->has('site_tagline'))
                                    <span class="text-danger">{{ $errors->first('site_tagline') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="site_url">Site Url</label>
                                <input type="text" id="site_url" name="site_url" class="form-control"
                                    value="{{ $site_settings->site_url ?? '' }} ">
                                @if ($errors->has('site_url'))
                                    <span class="text-danger">{{ $errors->first('site_url') }}</span>
                                @endif
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Site Image</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="site_logo">Site Logo</label>

                                        <div class="" style="margin-bottom: 10px;">
                                            <img class="img-fluid" width="100"
                                                src="{{ asset($site_settings->site_logo??'images/logo.png' ) }}"
                                                alt="Site_logo">
                                        </div>

                                <input type="file" id="site_logo" name="site_logo" class="form-control">
                                @if ($errors->has('site_logo'))
                                    <span class="text-danger">{{ $errors->first('site_logo') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="site_icon">Site Icon <i style="font-size: 12px;"> Site Icons should be
                                        square
                                        and at least 512 × 512 pixels.</i></label>


                                <div class="" style="margin-bottom: 10px;">
                                    <img class="img-fluid" width="100"
                                        src="{{ asset($site_settings->site_icon??'images/logo.png'  ) }}" alt="Site_logo">
                                </div>
                                <input type="file" id="site_icon" name="site_icon" class="form-control">
                                @if ($errors->has('site_icon'))
                                    <span class="text-danger">{{ $errors->first('site_icon') }}</span>
                                @endif
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- /.card -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <input type="submit" value="Save Changes" class="btn btn-success float-right">
                </div>
            </div>
        </form>
    </section>

</x-admin.layout.app-layout>
