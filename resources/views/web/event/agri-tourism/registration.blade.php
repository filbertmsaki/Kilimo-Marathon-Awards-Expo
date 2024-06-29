@php($title = 'Agri-Tourism')
<x-web.layout.app-layout :isPagetitle="true" :pageTitle="$title">
    @push('scripts')
        <script>
            document.getElementById('agree_checkbox').addEventListener('change', function() {
                document.getElementById('submit_button').disabled = !this.checked;
            });
        </script>
    @endpush
    <section class="py-10">
        <div class="container">
            <div class="box">
                <div class="box-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <form class="contact-form" action="{{ route('web.event.agri-tourism.store') }}" method="POST">
                                @csrf
                                <div class="text-start mb-30">
                                    <h2>Agri-Tourism Registration</h2>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group" id="full_nameDiv">
                                            <label for="full_name">Full Name</label>
                                            <input type="text" name="full_name" id="full_name"
                                                value="{{ old('full_name') }}" class="form-control"
                                                placeholder="Full Name" required>
                                            @if ($errors->has('full_name'))
                                                <span class="text-danger">{{ $errors->first('full_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                                class="form-control" placeholder="Phone Number" required>
                                            @if ($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="emailDiv">
                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" name="email" id="email"
                                                value="{{ old('email') }}" class="form-control"
                                                placeholder="Email Address">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="ageDiv">
                                        <div class="form-group">
                                            <label for="age">Age</label>
                                            <input type="number" name="age" id="age"
                                                value="{{ old('age') }}" class="form-control" placeholder="Age">
                                            @if ($errors->has('age'))
                                                <span class="text-danger">{{ $errors->first('age') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gender">Gender</label>
                                            <select class="form-select select2 gender" name="gender" required>
                                                <option value="">-- Select gender --</option>
                                                @foreach (GenderEnum::cases() as $item)
                                                    <option value="{{ $item->value }}"
                                                        @if (old('gender') == $item->value ) selected @endif>{{ $item->description() }}</option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="addressDiv">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" name="address" id="address"
                                                value="{{ old('address') }}" class="form-control" placeholder="Address">
                                            @if ($errors->has('address'))
                                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="activities">Interested Activities</label>
                                            <select class="form-select select2 activities" name="activities[]" multiple
                                                required>
                                                <option value="">Select Interested Activities</option>
                                                @foreach (InterestedActivitiesEnum::cases() as $item)
                                                <option value="{{ $item->value }}"
                                                @if (old('activities') && in_array($item->value, old('activities'))) selected @endif>{{ $item->description() }}
                                            </option>
                                                @endforeach


                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emergency_contact">Emergency Contact Name</label>
                                            <input type="text" name="emergency_contact" id="emergency_contact"
                                                value="{{ old('emergency_contact') }}" class="form-control"
                                                placeholder="Emergency Contact Name" required>
                                            @if ($errors->has('emergency_contact'))
                                                <span
                                                    class="text-danger">{{ $errors->first('emergency_contact') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="emergency_phone">Emergency Contact Phone</label>
                                            <input type="tel" name="emergency_phone" id="emergency_phone"
                                                value="{{ old('emergency_phone') }}" class="form-control"
                                                placeholder="Emergency Contact Phone" required>
                                            @if ($errors->has('emergency_phone'))
                                                <span
                                                    class="text-danger">{{ $errors->first('emergency_phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="additional_info">Additional Information</label>
                                            <textarea class="form-control" id="additional_info" name="additional_info" rows="4"
                                                placeholder="Additional Information">{{ old('additional_info') }}</textarea>
                                            @if ($errors->has('additional_info'))
                                                <span
                                                    class="text-danger">{{ $errors->first('additional_info') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-check form-check-inline mb-2">
                                            <input class="form-check-input" type="checkbox" id="agree_checkbox"
                                                name="agree_checkbox">
                                            <label class="form-check-label" for="agree_checkbox">By checking this box,
                                                you agree to pay the agri-tourism registration fee of TZS
                                                100,000 and proceed with the registration process.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary" id="submit_button"
                                            disabled>Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-web.layout.app-layout>
