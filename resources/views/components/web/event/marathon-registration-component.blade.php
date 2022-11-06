<section class="py-10">
    <div class="container">
        <div class="box">
            <div class="box-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <form class="contact-form" action="{{ route('web.event.marathon.store') }}" method="POST">
                            @csrf
                            <div class="text-start mb-30 text-center">
                                <h2>Marathon Registration Form</h2>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="first_name" value="{{ old('first_name') }}"
                                            class="form-control" placeholder="First Name" required>
                                        @if ($errors->has('first_name'))
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="last_name" value="{{ old('last_name') }}"
                                            class="form-control" placeholder="Last Name" required>
                                        @if ($errors->has('last_name'))
                                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-select select2" name="gender">
                                            <option value="">-- Select Gender--</option>
                                            <option value="F" @if (old('gender') == 'F') selected @endif>
                                                Female
                                            </option>
                                            <option value="M" @if (old('gender') == 'M') selected @endif>
                                                Male
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="number" name="age" value="{{ old('age') }}"
                                            class="form-control" placeholder="Age" min="5" max="100">
                                        @if ($errors->has('age'))
                                            <span class="text-danger">{{ $errors->first('age') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-select select2" name="phonecode" required>
                                            <option value="">-- Select Country--</option>
                                            <option value="254" @if (old('phonecode') == '254') selected @endif>
                                                Kenya
                                            </option>
                                            <option value="255" @if (old('phonecode') == '255') selected @endif>
                                                Tanzania
                                            </option>
                                            <option value="256" @if (old('phonecode') == '256') selected @endif>
                                                Uganda
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="tel" name="phone" value="{{ old('phone') }}"
                                            class="form-control" placeholder="Phone Number" required>
                                        @if ($errors->has('phone'))
                                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-control" placeholder="Email Address">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-select select2" name="event" required>
                                            <option value="">-- Select Event --</option>
                                            <option value="5" @if (old('event') == '5') selected @endif>5
                                                Km
                                            </option>
                                            <option value="10" @if (old('event') == '10') selected @endif>
                                                10 Km
                                            </option>
                                            <option value="21" @if (old('event') == '21') selected @endif>
                                                21 Km
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-select select2" name="t_shirt_size">
                                            <option value="">-- T-Shirt Size --</option>
                                            <option value="S" @if (old('t_shirt_size') == 'S') selected @endif>S
                                                Size
                                            </option>
                                            <option value="M" @if (old('t_shirt_size') == 'M') selected @endif>
                                                M Size
                                            </option>
                                            <option value="L" @if (old('t_shirt_size') == 'L') selected @endif>
                                                L Size
                                            </option>
                                            <option value="XL" @if (old('t_shirt_size') == 'XL') selected @endif>
                                                XL
                                            </option>
                                            <option value="XXL" @if (old('t_shirt_size') == 'XXL') selected @endif>
                                                XXL
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="address" value="{{ old('address') }}"
                                            class="form-control" placeholder="Street Address">
                                        @if ($errors->has('address'))
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        @endif
                                    </div>
                                </div>
                                @if (isMarathonActive())
                                    <div class="col-lg-12">
                                        <div class="btn-group">
                                            <button type="submit" name="payment" value="online"
                                                class="btn btn-primary">Register & Pay
                                                Online</button>
                                            {{-- <button type="submit" name="payment" value="lipa_number"
                                                class="btn btn-warning">Register & Pay Via Lipa
                                                Number</button> --}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
