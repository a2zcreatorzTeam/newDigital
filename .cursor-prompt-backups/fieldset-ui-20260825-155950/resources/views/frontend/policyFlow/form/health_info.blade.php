<div id="health_info" role="tabpanel" aria-labelledby="health_info-tab" class="tab-pane fade">
    <div class="w-75 mx-auto pt-5">
        <div class="row">

            @include('frontend.partials.health_measurements', [
                'health' => $user->health ?? null,
                'fieldClass' => 'form-control jbl-dynamic-input',
                'selectClass' => 'form-control jbl-dynamic-input',
                'colClass' => 'col-md-6 px-0 px-sm-3 mb-3',
                'bilingualLabels' => true,
            ])

            <!-- Daily Consumption -->
            <div class="col-md-12 px-0 px-sm-3 mb-3">
                <label>
                    {{ policy_label('daily_consumption') }}
                    <span class="requi">*</span>
                </label>
                <input type="text"
                    name="daily_consumption"
                    class="form-control jbl-dynamic-input"
                    value="{{ $user->health->daily_consumption ?? '' }}"
                    placeholder="e.g. Tobacco, Pan/Niswar, Alcohol, Drugs"
                    required>
            </div>
            <!-- Physical Impairments -->
            <div class="col-md-6 px-0 px-sm-3 mb-3">
                <label>
                    {{ policy_label('physical_impairments') }}
                    <span class="requi">*</span>
                </label>
                <input type="text"
                    name="physical_impairments"
                    class="form-control jbl-dynamic-input"
                    value="{{ $user->health->physical_impairments ?? '' }}"
                    placeholder="e.g. Defective eyesight, hearing loss, etc."
                    required>
            </div>
            <!-- Last Illness or Injury -->
            <div class="col-md-6 px-0 px-sm-3 mb-3">
                <label>
                    {{ policy_label('last_illness_injury') }}
                    <span class="requi">*</span>
                </label>
                <input type="text"
                    name="last_illness_injury"
                    class="form-control jbl-dynamic-input"
                    value="{{ $user->health->last_illness_injury ?? '' }}"
                    placeholder="State dates and describe illness or injury"
                    required>
            </div>

            <!-- Medical Investigations -->
            <div class="col-md-12 px-0 px-sm-3 mb-3">
                <label>
                    {{ policy_label('medical_investigations') }}
                    <span class="requi">*</span>
                </label>
                <input type="text"
                    name="medical_investigations"
                    class="form-control jbl-dynamic-input"
                    value="{{ $user->health->medical_investigations ?? '' }}"
                    placeholder="State dates and result of blood, urine, X-ray, ECGs, etc."
                    required>
            </div>

            <!-- Medical History / Conditions -->
            <div class="col-md-12 px-0 px-sm-3 mb-3">
                <label>
                    {{ policy_label('medical_history') }}
                    <span class="requi">*</span>
                </label>
                <textarea
                    name="medical_history"
                    class="form-control jbl-dynamic-input"
                    rows="5"
                    placeholder="Do you now or have you had any of these diseases? If so specify with dates"
                    required>{{ $user->health->medical_history ?? '' }}</textarea>
            </div>


            <!-- CAPTCHA -->
            <div class="col-md-12 px-0 px-sm-3 mb-4">

                <label class="fw-bold text-dark mb-2">
                    {{ policy_label('captcha') }}
                    <span class="requi">*</span>
                </label>

                <div class="card shadow-sm border-0" style="background:#f8f9fa;border-left:4px solid #0d6efd !important;">

                    <div class="card-body">

                        <div class="row align-items-center">

                            <div class="col-md-3 mb-2">

                                <div id="captcha-code"
                                    class="bg-dark text-white rounded text-center py-2 fw-bold"
                                    style="
                            font-size:28px;
                            letter-spacing:8px;
                            user-select:none;
                            font-family:monospace;
                        ">
                                </div>

                            </div>

                            <div class="col-md-3 mb-2">

                                <input type="text"
                                    id="captcha-answer"
                                    class="form-control"
                                    placeholder="Enter Code"
                                    autocomplete="off">

                            </div>

                            <div class="col-md-2 mb-2">

                                <button type="button"
                                    id="refresh-captcha"
                                    class="btn btn-outline-secondary w-100">

                                    <i class="fas fa-sync-alt"></i>

                                </button>

                            </div>

                            <div class="col-md-4">

                                <span id="captcha-success"
                                    class="text-success fw-bold d-none">
                                    <i class="fas fa-check-circle"></i>
                                    Verified
                                </span>

                                <span id="captcha-error"
                                    class="text-danger fw-bold d-none">
                                    <i class="fas fa-times-circle"></i>
                                    Invalid Code
                                </span>

                            </div>

                        </div>
                        <div class="col-12 d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary ib-prev-btn">Previous</button>
                        </div>

                        <small class="text-muted">
                            Please enter the verification code exactly as shown above.
                        </small>

                    </div>

                </div>

            </div>

            <!-- Submit -->
            <div class="col-md-12 px-0 px-sm-3">
                <input
                    type="button"
                    id="user_details_submited"
                    class="action-button"
                    value="Review Application"
                    disabled>
            </div>

        </div>
    </div>
</div>
