<div id="basic_Details" role="tabpanel" aria-labelledby="basic_Details-tab" class="tab-pane fade">
    <div class="container">
        <div class="row">
            <h3 class="col-12 ib-form-subheading">{{ policy_label('basic_details') }}</h3>

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('personal_information') }}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('life_purposer_full_name') }}<span class="requi">*</span></label>
                            <input required type="text" value="{{ old('life_proposed_full_name', $user->basicDetail?->life_proposed_full_name ?: ($user->name ?? '')) }}" name="life_proposed_full_name" class="form-control account">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('mobile_number_personal') }}<span class="requi">*</span></label>
                            <input required type="text" value="{{ old('mobile_number', $user->basicDetail?->mobile_number ?: ($user->phone_no ?? '')) }}" name="mobile_number" class="form-control account" placeholder="0321-6905568">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('cnic') }}<span class="requi">*</span></label>
                            <input required type="text" value="{{ old('cnic_number', $user->basicDetail?->cnic_number ?: ($user->cnic ?? '')) }}" name="cnic_number" id="cnic_number" class="form-control account">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('cnic_issue_date') }}<span class="requi">*</span></label>
                            <input required type="date" value="{{$user->basicDetail->cnic_issue_date ?? ''}}" name="cnic_issue_date" class="form-control account">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('cnic_expiry_date') }}<span class="requi">*</span></label>
                            <input required type="date" value="{{$user->basicDetail->cnic_expiry_date ?? ''}}" name="cnic_expiry_date" class="form-control account">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('date_of_birth') }}<span class="requi">*</span></label>
                            <input required type="date" id="date_of_birth" value="{{$user->basicDetail->date_of_birth ?? ''}}" name="date_of_birth" class="form-control account" max="{{ now('Asia/Karachi')->subYears(18)->toDateString() }}">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            @php
                                $selectedBirthCityId = old(
                                    'birth_place_city_id',
                                    $user->basicDetail->birth_place_city_id
                                        ?? optional(($cities ?? collect())->first(
                                            fn ($c) => strcasecmp($c->name, (string) ($user->basicDetail->birth_placed ?? '')) === 0
                                        ))->id
                                );
                            @endphp
                            @include('frontend.partials.birth_place_select', [
                                'cities' => $cities ?? collect(),
                                'selectedBirthCityId' => $selectedBirthCityId,
                                'birthPlaceRequired' => true,
                                'birthPlaceClass' => 'form-control account',
                                'birthPlaceLabel' => policy_label('place_of_birth'),
                            ])
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('age_nearest_birthdate') }}<span class="requi">*</span></label>
                            <input required type="text" id="age_birth" value="{{$user->basicDetail->age_nearest_date ?? ''}}" name="age_nearest_date" class="form-control account" readonly>
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('gender') }}<span class="requi">*</span></label>
                            <select name="gender" id="gender" required class="form-control">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ ($user->basicDetail->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ ($user->basicDetail->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ ($user->basicDetail->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('marital_status') }}<span class="requi">*</span></label>
                            <select name="marital_status" id="marital_status" required class="form-control">
                                <option value="">Select Marital Status</option>
                                <option value="Married" {{ ($user->basicDetail->marital_status ?? '') == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Unmarried" {{ ($user->basicDetail->marital_status ?? '') == 'Unmarried' ? 'selected' : '' }}>Unmarried</option>
                            </select>
                        </div>

                        <div class="col-md-6 px-0 px-sm-3" id="wife_name_wrap" style="display: none;">
                            <label>{{ policy_label('wife_name') }}<span class="requi">*</span></label>
                            <input type="text" id="wife_name" value="{{ $user->basicDetail->wife_name ?? '' }}" name="wife_name" class="form-control account">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3" id="husband_name_wrap" style="display: none;">
                            <label>{{ policy_label('husband_name') }}<span class="requi">*</span></label>
                            <input type="text" id="husband_name" value="{{ $user->basicDetail->husband_name ?? '' }}" name="husband_name" class="form-control account">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('mother_maiden_name') }}<span class="requi">*</span></label>
                            <input required type="text" value="{{ $user->basicDetail->mother_maiden_name ?? '' }}" name="mother_maiden_name" class="form-control account">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('father_name_of_life_proposed') }}<span class="requi">*</span></label>
                            <input required type="text" value="{{ $user->basicDetail->father_name ?? '' }}" name="father_name" class="form-control account">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('religion') }}<span class="requi">*</span></label>
                            <input required type="text" value="{{ $user->basicDetail->religion ?? '' }}" name="religion" class="form-control account">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('email_address') }}<span class="requi">*</span></label>
                            <input required type="email" value="{{ old('user_email', $user->basicDetail?->email ?: ($user->email ?? '')) }}" name="user_email" class="form-control account">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('contact_and_residence') }}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('phone_office') }}</label>
                            <input type="text" value="{{ $user->basicDetail->phone_number_office ?? '' }}" name="phone_number_office" class="form-control account">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('phone_residential') }}</label>
                            <input type="text" value="{{ $user->basicDetail->phone_number_residente ?? '' }}" name="phone_number_residente" class="form-control account">
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            @include('frontend.partials.country_select', [
                                'countries' => $countries ?? collect(),
                                'fieldName' => 'country_of_residence_id',
                                'countrySelectId' => 'country_of_residence_id',
                                'selectedCountryId' => old('country_of_residence_id', $user->basicDetail?->country_of_residence_id ?: ($user->country_of_residence_id ?? null)),
                                'countryRequired' => true,
                                'countrySelectClass' => 'form-control account',
                                'countryLabel' => policy_label('country_of_residence'),
                            ])
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('current_address') }}<span class="requi">*</span></label>
                            <textarea required name="current_address" class="form-control account" rows="2" minlength="5">{{ old('current_address', $user->basicDetail?->current_address ?: ($user->current_address ?? '')) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('dual_nationality_details') }}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('is_dual_national') }}<span class="requi">*</span></label>
                            <select required name="is_client_dual_national" id="is_client_dual_national" class="form-control">
                                <option value="">Select Option</option>
                                <option value="Yes" {{ ($user->basicDetail->is_client_dual_national ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ ($user->basicDetail->is_client_dual_national ?? '') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="col-md-6 px-0 px-sm-3">
                            @include('frontend.partials.country_select', [
                                'countries' => $countries ?? collect(),
                                'fieldName' => 'primary_nationality_country_id',
                                'countrySelectId' => 'primary_nationality_country_id',
                                'selectedCountryId' => $user->basicDetail->primary_nationality_country_id ?? null,
                                'selectedCountryName' => $user->basicDetail->primary_nationality ?? null,
                                'selectedNameField' => 'primary_nationality',
                                'countryRequired' => false,
                                'countrySelectClass' => 'form-control account',
                                'countryLabel' => policy_label('primary_nationality'),
                            ])
                        </div>
                        <div class="col-md-6 px-0 px-sm-3">
                            @include('frontend.partials.country_select', [
                                'countries' => $countries ?? collect(),
                                'fieldName' => 'dual_nationality_country_id',
                                'countrySelectId' => 'dual_nationality_country_id',
                                'selectedCountryId' => $user->basicDetail->dual_nationality_country_id ?? null,
                                'selectedCountryName' => $user->basicDetail->dual_nationality_country ?? null,
                                'selectedNameField' => 'dual_nationality_country',
                                'countryRequired' => false,
                                'countrySelectClass' => 'form-control account',
                                'countryLabel' => policy_label('dual_nationality_country'),
                            ])
                        </div>
                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('tax_tin_number') }}<span class="requi">*</span></label>
                            <input type="text" value="{{ $user->basicDetail->dual_tax_tin_number ?? '' }}" name="dual_tax_tin_number" class="form-control account">
                        </div>
                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('dual_mobile_number') }}<span class="requi">*</span></label>
                            <input type="text" value="{{ $user->basicDetail->dual_mobile_number ?? '' }}" name="dual_mobile_number" class="form-control account">
                        </div>
                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('dual_address') }}<span class="requi">*</span></label>
                            <textarea name="dual_address" class="form-control account" rows="2">{{ $user->basicDetail->dual_address ?? '' }}</textarea>
                        </div>
                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('passport_number') }}<span class="requi">*</span></label>
                            <input type="text" value="{{ $user->basicDetail->dual_passport_number ?? '' }}" name="dual_passport_number" class="form-control account">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('life_proposed_details') }}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-12 px-0 px-sm-3">
                            <label>{{ policy_label('is_same_person') }}<span class="requi">*</span></label>
                            @php $isSamePerson = old('is_same_person', $user->basicDetail?->is_same_person ?: 'Yes'); @endphp
                            <select required name="is_same_person" class="form-control" id="is_same_person">
                                <option value="Yes" {{ $isSamePerson === 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ $isSamePerson === 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div id="same_person_fields" class="col-12 px-0" @if($isSamePerson !== 'No') style="display:none;" @endif>
                            @include('frontend.partials.life_proposed_fields', [
                                'variant' => 'form',
                                'lp' => \App\Support\LifeProposedProfile::values($user->basicDetail ?? null),
                                'cities' => $cities ?? collect(),
                                'countries' => $countries ?? collect(),
                            ])
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-secondary ib-prev-btn">Previous</button>
            <button type="button" class="btn btn-primary ib-next-btn">Next</button>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {




        $('input[name="cnic_number"]').on('input', function() {
            let val = $(this).val().replace(/\D/g, '');
            let newVal = '';

            if (val.length > 0) {
                newVal += val.substr(0, 5);
            }
            if (val.length > 5) {
                newVal += '-' + val.substr(5, 7);
            }
            if (val.length > 12) {
                newVal += '-' + val.substr(12, 1);
            }

            $(this).val(newVal.substring(0, 15)); // Max length 15 characters
        });
        $(document).on('input', 'input[name="life_proposed_cnic"]', function() {
            var dob = $('input[name="life_proposed_dob"]').val();
            var age = (typeof window.ageNearestBirthday === 'function') ? window.ageNearestBirthday(dob) : '';
            if (age !== '' && age < 18) {
                return;
            }

            let val = $(this).val().replace(/\D/g, '');
            let newVal = '';

            if (val.length > 0) {
                newVal += val.substring(0, 5);
            }
            if (val.length > 5) {
                newVal += '-' + val.substring(5, 12);
            }
            if (val.length > 12) {
                newVal += '-' + val.substring(12, 13);
            }

            $(this).val(newVal.substring(0, 15));
        });


        $('input[name="mobile_number"]').on('input', function() {
            // Sirf digits allow karein
            let val = $(this).val().replace(/\D/g, '');
            let newVal = '';

            if (val.length > 0) {
                // Pehle 4 digits (e.g., 0321)
                newVal += val.substr(0, 4);
            }
            if (val.length > 4) {
                // Phir dash aur baki ke 7 digits
                newVal += '-' + val.substr(4, 7);
            }

            // Final value set karein (Total length 12: 4 digits + 1 dash + 7 digits)
            $(this).val(newVal.substring(0, 12));
        });

        function toggleSpouseNameFields() {
            let gender = ($('#gender').val() || '').trim();
            let marital = ($('#marital_status').val() || '').trim();

            $('#wife_name_wrap, #husband_name_wrap').hide();
            $('#wife_name, #husband_name').prop('required', false);

            if (marital === 'Married' && gender === 'Male') {
                $('#wife_name_wrap').show();
                $('#wife_name').prop('required', true);
                $('#husband_name').val('');
            } else if (marital === 'Married' && gender === 'Female') {
                $('#husband_name_wrap').show();
                $('#husband_name').prop('required', true);
                $('#wife_name').val('');
            } else {
                // Unmarried / incomplete selection — clear both spouse fields
                if (marital === 'Unmarried') {
                    $('#wife_name, #husband_name').val('');
                }
            }
        }

        $('#gender, #marital_status').on('change', toggleSpouseNameFields);
        toggleSpouseNameFields();













    });
</script>
@endpush
