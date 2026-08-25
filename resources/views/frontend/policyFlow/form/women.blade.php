<div id="women" role="tabpanel" aria-labelledby="basic_Details-tab" class="tab-pane fade">
    <div class="container">
        <div class="row">
            <h3 class="col-12 ib-form-subheading">{{ policy_label('female_section') }}</h3>

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('female_health') }}</h5>
                    </div>
                    <div class="row">
                        <!-- 12. (I) Date of last delivery -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>12. (I) {{ policy_label('date_of_last_delivery') }}</label>
                                        <div class="jbl-field">
                                            <input type="date" name="date_of_last_delivery" class="form-control jbl-dynamic-input" id="date_of_last_delivery">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 12. (II) Date (s) of any miscarriages (s) -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>(II) {{ policy_label('miscarriage_dates') }}</label>
                                        <div class="jbl-field" id="miscarriage_dates_list">
                                            <div class="miscarriage-date-row d-flex align-items-center mb-2" style="gap:8px;">
                                                <input type="date" name="miscarriage_dates[]" class="form-control jbl-dynamic-input miscarriage-date-input">
                                                <button type="button" class="btn btn-sm btn-primary miscarriage-date-add" title="Add date">+</button>
                                                <button type="button" class="btn btn-sm btn-secondary miscarriage-date-remove" title="Remove date" disabled>-</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 12. (III) Are you pregnant -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>(III) {{ policy_label('are_you_pregnant') }}</label>
                                        <div class="jbl-field">
                                            <select name="is_pregnant" class="form-control jbl-dynamic-input" id="is_pregnant">
                                                <option value="">Select Option</option>
                                                <option value="Yes">Yes (جی ہاں)</option>
                                                <option value="No">No (نہیں۔)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 12. (IV) Date (s) of any caesarean (give reason) -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>(IV) {{ policy_label('caesarean_details') }}</label>
                                        <div class="jbl-field">
                                            <input type="text" name="caesarean_details" class="form-control jbl-dynamic-input" id="caesarean_details" placeholder="Date and reason / تاریخ اور وجہ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 12. (V) Date of L.M.P. -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>(V) {{ policy_label('lmp_date') }}</label>
                                        <div class="jbl-field">
                                            <input type="date" name="lmp_date" class="form-control jbl-dynamic-input" id="lmp_date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 12. (VI) Any history of female disease? -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>(VI) {{ policy_label('female_disease_history') }}</label>
                                        <div class="jbl-field">
                                            <select name="female_disease_history" class="form-control jbl-dynamic-input" id="female_disease_history">
                                                <option value="">Select Option</option>
                                                <option value="Yes">Yes (جی ہاں)</option>
                                                <option value="No">No (نہیں۔)</option>
                                            </select>
                                        </div>
                                        <div class="jbl-field js-female-disease-wrap mt-2" style="display:none;">
                                            <label>{{ policy_label('female_disease') }}</label>
                                            <select name="female_disease_name" class="form-control jbl-dynamic-input" id="female_disease_name">
                                                <option value="">Select disease</option>
                                                @foreach(\App\Support\FemaleDiseases::options() as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="jbl-field js-female-disease-wrap mt-2" style="display:none;">
                                            <label>{{ policy_label('description') }}</label>
                                            <input type="text" name="female_disease_details" class="form-control jbl-dynamic-input" id="female_disease_details" maxlength="500" placeholder="Enter description / تفصیل درج کریں">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('income_qualification') }}</h5>
                    </div>
                    <div class="row">
                        <!-- 13. State approximate monthly income: (A) Your self -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>13. {{ policy_label('self_monthly_income') }}</label>
                                        <div class="jbl-field">
                                            <input type="number" step="0.01" name="self_monthly_income" class="form-control jbl-dynamic-input" id="self_monthly_income" placeholder="Rs.">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 13. State approximate monthly income: (B) Your husband's -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>(B) {{ policy_label('husband_monthly_income') }}</label>
                                        <div class="jbl-field">
                                            <input type="number" step="0.01" name="husband_monthly_income" class="form-control jbl-dynamic-input" id="husband_monthly_income" placeholder="Rs.">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 13. (C) Qualification -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>(C) {{ policy_label('qualification') }}</label>
                                        <div class="jbl-field">
                                            <input type="text" name="qualification" class="form-control jbl-dynamic-input" id="qualification" placeholder="Qualification">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 13. (D) Do you pay Income Tax/Land Revenue -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>(D) {{ policy_label('pays_tax_land_revenue') }}</label>
                                        <div class="jbl-field">
                                            <select name="pays_tax_land_revenue" class="form-control jbl-dynamic-input" id="pays_tax_land_revenue">
                                                <option value="">Select Option</option>
                                                <option value="Yes">Yes (جی ہاں)</option>
                                                <option value="No">No (نہیں۔)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('husband_insurance') }}</h5>
                    </div>
                    <div class="row">
                        <!-- Husband Insurance Table Fields (Row 1) -->
                        <div class="col-md-4 px-0 px-sm-3 mb-2">
                            <div class="jbl-field">
                                <input type="text" name="husband_policy_no" class="form-control jbl-dynamic-input" placeholder="Policy No (پالیسی نمبر)">
                            </div>
                        </div>
                        <div class="col-md-4 px-0 px-sm-3 mb-2">
                            <div class="jbl-field">
                                <input type="text" name="husband_zone_company" class="form-control jbl-dynamic-input" placeholder="Zone/Company (زون / کمپنی)">
                            </div>
                        </div>
                        <div class="col-md-4 px-0 px-sm-3 mb-2">
                            <div class="jbl-field">
                                <input type="number" step="0.01" name="husband_sum_assured" class="form-control jbl-dynamic-input" placeholder="Sum Assured (زرِ بیمہ)">
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
</div>
@push('js')

@endpush
