<x-admin.layout.app-layout>
    @section('title', 'Dpo Payment Settings')
    @section('pagename', 'Dpo Payment Settings')
    @section('css')
    @endsection
    @section('script')
    @endsection
    <section class="content" style="margin-bottom: 20px;">
        <form method="POST" action="{{ route('admin.setting.payment.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="general_settings_id" name="general_settings_id"
                value="{{ $dpo_settings->slug ?? '' }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Dpo Settings</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                    title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="enable_dpo">Enable Dpo</label>
                                        <select class="form-control select2" id="enable_dpo" name="enable_dpo"
                                            style="width: 100%;">
                                            <option value="yes" @if (old('enable_dpo', $dpo_settings->enable_dpo ?? '') == 'yes') selected @endif>
                                                Yes
                                            </option>
                                            <option value="no" @if (old('enable_dpo', $dpo_settings->enable_dpo ?? '') == 'no') selected @endif>
                                                No
                                            </option>
                                        </select>
                                        @if ($errors->has('enable_dpo'))
                                            <span class="text-danger">{{ $errors->first('enable_dpo') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="dpo_sandbox">Dpo Live</label>
                                        <select class="form-control select2" id="dpo_sandbox" name="dpo_sandbox"
                                            style="width: 100%;">
                                            <option value="1" @if (old('dpo_sandbox', $dpo_settings->dpo_sandbox ?? '') == '1') selected @endif>
                                                True
                                            </option>
                                            <option value="0" @if (old('dpo_sandbox', $dpo_settings->dpo_sandbox ?? '') == '0') selected @endif>
                                                False
                                            </option>
                                        </select>
                                        @if ($errors->has('dpo_sandbox'))
                                            <span class="text-danger">{{ $errors->first('dpo_sandbox') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="dpo_base_url">Site Url</label>
                                        <input type="text" id="dpo_base_url" name="dpo_base_url" class="form-control"
                                            value="{{ $dpo_settings->dpo_base_url ?? '' }}">
                                        @if ($errors->has('dpo_base_url'))
                                            <span class="text-danger">{{ $errors->first('dpo_base_url') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="dpo_company_token">Dpo Company Token</label>
                                        <input type="text" id="dpo_company_token" name="dpo_company_token"
                                            class="form-control" value="{{ $dpo_settings->dpo_company_token ?? '' }}">
                                        @if ($errors->has('dpo_company_token'))
                                            <span class="text-danger">{{ $errors->first('dpo_company_token') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="dpo_default_currency">Dpo Default Currency</label>
                                        <input type="text" id="dpo_default_currency" name="dpo_default_currency"
                                            class="form-control"
                                            value="{{ $dpo_settings->dpo_default_currency ?? '' }}">
                                        @if ($errors->has('dpo_default_currency'))
                                            <span
                                                class="text-danger">{{ $errors->first('dpo_default_currency') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="dpo_default_country">Dpo Default Country</label>
                                        <input type="text" id="dpo_default_country" name="dpo_default_country"
                                            class="form-control"
                                            value="{{ $dpo_settings->dpo_default_country ?? '' }}">
                                        @if ($errors->has('dpo_default_country'))
                                            <span
                                                class="text-danger">{{ $errors->first('dpo_default_country') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="dpo_default_service">Dpo Default Service</label>
                                        <input type="text" id="dpo_default_service" name="dpo_default_service"
                                            class="form-control"
                                            value="{{ $dpo_settings->dpo_default_service ?? '' }}">
                                        @if ($errors->has('dpo_default_service'))
                                            <span
                                                class="text-danger">{{ $errors->first('dpo_default_service') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="dpo_default_service_description">Dpo Default Service
                                            Description</label>
                                        <input type="text" id="dpo_default_service_description"
                                            name="dpo_default_service_description" class="form-control"
                                            value="{{ $dpo_settings->dpo_default_service_description ?? '' }}">
                                        @if ($errors->has('dpo_default_service_description'))
                                            <span
                                                class="text-danger">{{ $errors->first('dpo_default_service_description') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
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
