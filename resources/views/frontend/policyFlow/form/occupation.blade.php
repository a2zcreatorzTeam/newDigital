<div id="occupation" role="tabpanel" aria-labelledby="occupation-tab" class="tab-pane fade">
    <div class="w-75 mx-auto pt-5">
        <div class="row">
            @php
                $empFlag = $user->occupation->is_emaployemnt ?? '';
                $bizFlag = $user->occupation->is_business ?? '';
                if ($empFlag === 'Yes' && $bizFlag === 'Yes') {
                    $occupationType = 'Both';
                } elseif ($empFlag === 'Yes') {
                    $occupationType = 'Employment';
                } elseif ($bizFlag === 'Yes') {
                    $occupationType = 'Businessman';
                } else {
                    $occupationType = '';
                }
            @endphp

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('occupation') }}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-12 px-0 px-sm-3">
                            <label>{{ policy_label('occupation_type') }}<span class="requi">*</span></label>
                            <select id="occupation_type" required class="form-control jbl-dynamic-input">
                                <option value="">Select Option</option>
                                <option value="Employment" {{ $occupationType === 'Employment' ? 'selected' : '' }}>Employment</option>
                                <option value="Businessman" {{ $occupationType === 'Businessman' ? 'selected' : '' }}>Businessman</option>
                                <option value="Both" {{ $occupationType === 'Both' ? 'selected' : '' }}>Both</option>
                            </select>
                            <input type="hidden" name="is_emaployemnt" id="is_emaployemnt" value="{{ $empFlag }}">
                            <input type="hidden" name="is_business" id="is_business" value="{{ $bizFlag }}">
                        </div>
                        <div class="col-12">
                            <div id="employment_fields" class="row"></div>
                        </div>
                        <div class="col-12">
                            <div id="business_fields" class="row"></div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $filerStatus = old('filer_status', $user->occupation->filer_status ?? '');
                $ntnNumber = old('ntn_number', $user->occupation->ntn_number ?? '');
            @endphp

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('tax_and_income') }}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('filer_status') }}<span class="requi">*</span></label>
                            <select name="filer_status" class="form-control jbl-dynamic-input" required>
                                <option value="">Select Option</option>
                                <option value="Filer" {{ $filerStatus === 'Filer' ? 'selected' : '' }}>Filer</option>
                                <option value="Non-Filer" {{ $filerStatus === 'Non-Filer' ? 'selected' : '' }}>Non-Filer</option>
                            </select>
                        </div>
                        <div class="col-md-6 px-0 px-sm-3 js-ntn-wrap">
                            <label>{{ policy_label('ntn_number') }}<span class="requi">*</span></label>
                            <input type="text"
                                name="ntn_number"
                                value="{{ $ntnNumber }}"
                                class="form-control jbl-dynamic-input"
                                maxlength="20"
                                placeholder="Enter NTN Number">
                        </div>

                        <div class="col-md-12 px-0 px-sm-3">
                            <label>{{ policy_label('holding_land') }}<span class="requi">*</span></label>
                            <select name="is_holding_land" required class="form-control jbl-dynamic-input" required>
                                <option value="">Select Option</option>
                                <option value="Yes" {{ ($user->occupation->is_holding_land ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ ($user->occupation->is_holding_land ?? '') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div id="land_fields" class="row"></div>
                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('average_monthly_income_q') }}<span class="requi">*</span></label>
                            <input type="number"
                                name="avaerage_monthly_income"
                                value="{{$user->occupation->avaerage_monthly_income ?? ''}}"
                                class="form-control jbl-dynamic-input"
                                placeholder="Rs." required>
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('ex_defence') }}<span class="requi">*</span></label>
                            <select name="ex_defence_personal" class="form-control jbl-dynamic-input" required>
                                <option value="">Select Option</option>
                                <option value="Yes" {{ ($user->occupation->ex_defence_personal ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ ($user->occupation->ex_defence_personal ?? '') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('discharged_medical') }}<span class="requi">*</span></label>
                            <select name="discharged_on_medical" class="form-control jbl-dynamic-input" required>
                                <option value="">Select Option</option>
                                <option value="Yes" {{ ($user->occupation->discharged_on_medical ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ ($user->occupation->discharged_on_medical ?? '') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('hazardous_occupation') }}<span class="requi">*</span></label>
                            <select name="hazardous_occupation" class="form-control jbl-dynamic-input" required>
                                <option value="">Select Option</option>
                                <option value="Yes" {{ ($user->occupation->hazardous_occupation ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ ($user->occupation->hazardous_occupation ?? '') == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <label>{{ policy_label('comments') }}</label>
                            <textarea name="comment" class="form-control jbl-dynamic-input" rows="2">{{ $user->occupation->comment ?? '' }}</textarea>
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
