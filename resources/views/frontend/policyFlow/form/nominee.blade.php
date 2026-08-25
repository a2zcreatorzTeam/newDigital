<div id="nominee" role="tabpanel" aria-labelledby="basic_Details-tab" class="tab-pane fade">
    <div class="container">
        <div class="row">
            <h3 class="col-12 ib-form-subheading">{{ policy_label('nominee') }}</h3>

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('nominee_information') }}</h5>
                    </div>
                    <div class="row">
                        <!-- (A) Name of Nominee -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>{{ policy_label('nominee_name') }}</label>
                                        <div class="jbl-field">
                                            <input type="text" name="nominee_name" class="form-control jbl-dynamic-input" id="nominee_name" placeholder="Enter nominee name / نامزد فرد کا نام" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- (B) C.N.I.C. / B-Form No -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>{{ policy_label('nominee_cnic') }}</label>
                                        <div class="jbl-field">
                                            <input type="text" name="nominee_cnic" class="form-control jbl-dynamic-input" id="nominee_cnic" placeholder="42101-1234567-1" maxlength="15" inputmode="numeric" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- (C) Age -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>{{ policy_label('age') }}</label>
                                        <div class="jbl-field">
                                            <input type="number" name="nominee_age" class="form-control jbl-dynamic-input" id="nominee_age" min="0" max="120" placeholder="Enter age / عمر درج کریں" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- (D) Relationship with you -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3">
                            <div>
                                <div>
                                    <div>
                                        <label>{{ policy_label('relationship_with_you') }}</label>
                                        <div class="jbl-field">
                                            <input type="text" name="nominee_relationship" class="form-control jbl-dynamic-input" id="nominee_relationship" placeholder="Enter relationship / رشتہ درج کریں" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- If Nominee is Minor (Appointee Section) -->
            <div class="col-12">
                <div class="policy-fieldset js-appointee-section" id="appointee_section" style="display:none;">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('appointee_details') }}</h5>
                    </div>
                    <div class="row">
                        <div class="col-12 px-0 px-sm-3 mb-2">
                            <small class="text-muted fw-bold">If nominee is minor an Appointee under Section 72 must be Designated (اگر نامزد وارث نابالغ ہے تو سرپرست کی نامزدگی لازمی ہے)</small>
                        </div>

                        <!-- (E) Appointee's Name -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3 js-appointee-wrap">
                            <div>
                                <div>
                                    <div>
                                        <label>{{ policy_label('appointee_name') }}<span class="requi">*</span></label>
                                        <div class="jbl-field">
                                            <input type="text" name="appointee_name" class="form-control jbl-dynamic-input" id="appointee_name" placeholder="Enter appointee name / سرپرست کا نام">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- (F) Appointee's Relationship with nominee -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3 js-appointee-wrap">
                            <div>
                                <div>
                                    <div>
                                        <label>{{ policy_label('appointee_relationship') }}<span class="requi">*</span></label>
                                        <div class="jbl-field">
                                            <input type="text" name="appointee_relationship" class="form-control jbl-dynamic-input" id="appointee_relationship" placeholder="Enter relationship / سرپرست سے رشتہ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- (H) Appointee's C.N.I.C. No -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3 js-appointee-wrap">
                            <div>
                                <div>
                                    <div>
                                        <label>{{ policy_label('appointee_cnic') }}<span class="requi">*</span></label>
                                        <div class="jbl-field">
                                            <input type="text" name="appointee_cnic" class="form-control jbl-dynamic-input" id="appointee_cnic" placeholder="42101-1234567-1" maxlength="15" inputmode="numeric" pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Appointee Mobile -->
                        <div class="col-md-6 px-0 px-sm-3 mb-3 js-appointee-wrap">
                            <div>
                                <div>
                                    <div>
                                        <label>{{ policy_label('appointee_mobile') }}<span class="requi">*</span></label>
                                        <div class="jbl-field">
                                            <input type="text" name="appointee_mobile" class="form-control jbl-dynamic-input" id="appointee_mobile" placeholder="0300-1234567" maxlength="12" inputmode="numeric" pattern="03[0-9]{2}-[0-9]{7}">
                                        </div>
                                    </div>
                                </div>
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
