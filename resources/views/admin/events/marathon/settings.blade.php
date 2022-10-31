<x-admin.layout.app-layout>
    @section('title', 'Marathon Settings')
    @section('pagename', 'Marathon Settings')
    @section('css')
      
    @endsection
    @section('script')

    @endsection

    <section class="content" style="margin-bottom: 20px;">
        <form method="POST" action="{{ route('admin.marathon.setting.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="general_settings_id" name="general_settings_id"
                value="@if ($marathon_settings !== null) {{ $marathon_settings->first()->id }} @endif">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Marathon Registration </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="marathon_registration">Registration Period</label>
                                        <select class="form-control select2" id="marathon_registration" name="marathon_registration"
                                            style="width: 100%;">
                                            @if ($marathon_settings->first()->marathon_registration == '1')
                                                <option value="{{ $marathon_settings->first()->marathon_registration }}" selected>
                                                    Active</option>
                                                <option value="0">END</option>
                                            @elseif ($marathon_settings->first()->marathon_registration == '0')
                                                <option value="1">Active</option>
                                                <option value="{{ $marathon_settings->first()->marathon_registration }}" selected>
                                                    END</option>
                                            @endif

                                        </select>
                                        @if ($errors->has('marathon_registration'))
                                            <span class="text-danger">{{ $errors->first('marathon_registration') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                      <!-- Date and time -->
                            <div class="form-group">
                                <label>Registration End On</label>
                                <div class="input-group date" id="datetime" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        name="marathon_registration_time_remain" data-target="#datetime"
                                        value="<?php echo $marathon_settings->first()->marathon_registration_time_remain; ?>" />
                                    <div class="input-group-append" data-target="#datetime"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    @if ($errors->has('marathon_registration_time_remain'))
                                        <span
                                            class="text-danger">{{ $errors->first('marathon_registration_time_remain') }}</span>
                                    @endif
                                </div>
                            </div>
                                </div>
                            </div>


                            <!-- /.form group -->

                        </div>
                        <!-- /.card-body -->
                    </div>
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
