<section class="py-10">
    <div class="container">
        <div class="box">
            <div class="box-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <form class="contact-form" action="{{ route('web.event.expo.store') }}" method="POST">
                            @csrf
                            <div class="text-start mb-30">
                                <h2>Kilimo Expo Registration</h2>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-select select2 entry" name="entry" required>
                                            <option value="">-- Expo Entry--</option>
                                            <option value="1"
                                                @if (old('entry') == '1') selected @endif>Individual
                                            </option>
                                            <option value="2"
                                                @if (old('entry') == '2') selected @endif>
                                                Company
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-select select2" name="phonecode" required>
                                            <option value="">-- Select Country--</option>
                                            <option value="254" @if (old('phonecode') == '254') selected @endif>Kenya
                                            </option>
                                            <option value="255" @if (old('phonecode') == '255') selected @endif>
                                                Tanzania
                                            </option>
                                            <option value="256" @if (old('phonecode') == '256') selected @endif>Uganda
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" id="company_nameDiv">
                                        <input type="text" name="company_name"  id="company_name" value="{{ old('company_name') }}"
                                            class="form-control" placeholder="Company/ Business Name " required>
                                        @if ($errors->has('company_name'))
                                            <span class="text-danger">{{ $errors->first('company_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="service_name" value="{{ old('service_name') }}"
                                            class="form-control" placeholder="Business / Service you provide"
                                            required>
                                        @if ($errors->has('service_name'))
                                            <span class="text-danger">{{ $errors->first('service_name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4" id="company_phoneDiv" style="display: none">
                                    <div class="form-group">
                                        <input type="tel" name="company_phone" id="company_phone"
                                            value="{{ old('company_phone') }}" class="form-control"
                                            placeholder="Company Phone" >
                                        @if ($errors->has('company_phone'))
                                            <span class="text-danger">{{ $errors->first('company_phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4" id="company_emailDiv" style="display: none">
                                    <div class="form-group">
                                        <input type="tel" name="company_email" id="company_email"
                                            value="{{ old('company_email') }}" class="form-control"
                                            placeholder="Company Email" >
                                        @if ($errors->has('company_email'))
                                            <span class="text-danger">{{ $errors->first('company_email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="contact_person_name" value="{{ old('contact_person_name') }}"
                                            class="form-control" placeholder="Contact Person Name" required>
                                        @if ($errors->has('contact_person_name'))
                                            <span class="text-danger">{{ $errors->first('contact_person_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="tel" name="contact_person_phone" value="{{ old('contact_person_phone') }}"
                                            class="form-control" placeholder="Contact Person Phone" required>
                                        @if ($errors->has('contact_person_phone'))
                                            <span class="text-danger">{{ $errors->first('contact_person_phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="email" name="contact_person_email" value="{{ old('contact_person_email') }}"
                                            class="form-control" placeholder="Contact Person email" >
                                        @if ($errors->has('contact_person_email'))
                                            <span class="text-danger">{{ $errors->first('contact_person_email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="address" value="{{ old('address') }}"
                                            class="form-control" placeholder="Address Location" >
                                        @if ($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <textarea name="company_details" value="{{ old('company_details') }}" rows="5" class="form-control" required
                                            placeholder="Short description about your company, business or service" required></textarea>
                                        @if ($errors->has('company_details'))
                                            <span class="text-danger">{{ $errors->first('company_details') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
