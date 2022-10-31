<x-admin.layout.app-layout>
    @section('title', 'Marathon Settings')
    @section('pagename', 'Marathon Settings')
    @section('css')

    @endsection
    @section('script')

    @endsection

    <section class="content" style="margin-bottom: 20px;">
        <form method="POST" action="{{ route('admin.award.setting.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="general_settings_id" name="general_settings_id"
                value="@if ($settings !== null) {{ $settings->id }} @endif">

            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Kilimo Awards Nominees Registration </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="awards_registration">Registration Period</label>
                                <select class="select2 form-control" id="awards_registration" name="awards_registration"
                                    style="width: 100%;">
                                    @if ($settings->awards_registration == '1')
                                        <option value="{{ $settings->awards_registration }}" selected>
                                            Active</option>
                                        <option value="0">END</option>
                                    @elseif ($settings->awards_registration == '0')
                                        <option value="1">Active</option>
                                        <option value="{{ $settings->awards_registration }}" selected>END
                                        </option>
                                    @endif

                                </select>
                                @if ($errors->has('awards_registration'))
                                    <span class="text-danger">{{ $errors->first('awards_registration') }}</span>
                                @endif
                            </div>
                            <!-- Date and time -->
                            <script>
                                $(function() {
                                    $("#datePicker").datetimepicker({
                                        format: 'DD-MM-YYYY HH:mm A',
                                        defaultDate: new Date(),
                                    })
                                });
                            </script>
                            <div class="form-group">
                                <label>Registration End On </label>
                                <div class="input-group ">
                                    <input type="datetime-local" class="form-control " name="awards_registration_time_remain"
                                    value="{{ date('Y-m-d H:i', strtotime($settings->awards_registration_time_remain))  }}"/>

                                    @if ($errors->has('awards_registration_time_remain '))
                                        <span
                                            class="text-danger">{{ $errors->first('awards_registration_time_remain ') }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.form group -->

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Kilimo Awards Voting </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="vote">Voting Period</label>
                                <select class="select2 form-control" id="vote" name="vote" style="width: 100%;">
                                    @if ($settings->vote == '1')
                                        <option value="{{ $settings->vote }}" selected>Active</option>
                                        <option value="0">END</option>
                                    @elseif ($settings->vote == '0')
                                        <option value="1">Active</option>
                                        <option value="{{ $settings->vote }}" selected>END</option>
                                    @endif

                                </select>
                                @if ($errors->has('vote'))
                                    <span class="text-danger">{{ $errors->first('vote') }}</span>
                                @endif
                            </div>
                            <!-- Date and time -->
                            <div class="form-group">
                                <label>Voting End On</label>
                                <div class="input-group ">
                                    <input type="datetime-local" class="form-control"
                                        name="vote_time_remain"
                                        value="{{ date('Y-m-d H:i', strtotime($settings->vote_time_remain))  }}" />

                                    @if ($errors->has('vote_time_remain '))
                                        <span class="text-danger">{{ $errors->first('vote_time_remain ') }}</span>
                                    @endif
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
