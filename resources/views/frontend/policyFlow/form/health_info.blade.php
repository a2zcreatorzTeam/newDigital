<div id="health_info" role="tabpanel" aria-labelledby="health_info-tab" class="tab-pane fade">
    <div class="w-75 mx-auto pt-5">
        <div class="row">

            <!-- Auto Calculation Note -->
            <div class="col-md-12 px-0 px-sm-3 mb-4">
                <div class="alert alert-primary border-start border-5 shadow-sm">
                    <h6 class="mb-2">
                        <i class="fas fa-info-circle me-2"></i>
                        Automatic Measurement Conversion
                    </h6>

                    <p class="mb-0 text-dark">
                        Please enter values in <strong>Centimeters (cm)</strong> and
                        <strong>Kilograms (kg)</strong> where applicable.
                        For measurement fields such as
                        <strong>Height</strong>,
                        <strong>Chest</strong>, and
                        <strong>Abdomen</strong>,
                        the system will automatically calculate and populate the corresponding values in
                        <strong>Feet</strong> and
                        <strong>Inches</strong>.
                        These auto-calculated fields are <strong>read-only</strong> to maintain data accuracy.
                    </p>
                </div>
            </div>

            <!-- Height -->
            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Height (In cm) (قد سینٹی میٹر میں)
                    <span class="requi">*</span>
                </label>
                <input type="number"
                    step="0.01"
                    id="height_cm"
                    name="height_cm"
                    class="form-control jbl-dynamic-input"
                    value="{{ $user->health->height_cm ?? '' }}"
                    required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Height (In Feet)
                    <span class="requi">*</span>
                </label>
                <input type="text"
                    id="height_ft"
                    name="height_ft"
                    class="form-control bg-light"
                    value="{{ $user->health->height_ft ?? '' }}"
                    readonly>
            </div>

            <!-- Weight -->
            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Weight (In Kg) (وزن کلوگرام میں)
                    <span class="requi">*</span>
                </label>
                <input type="number"
                    step="0.01"
                    name="weight_kg"
                    class="form-control jbl-dynamic-input"
                    value="{{ $user->health->weight_kg ?? '' }}"
                    required>
            </div>

            <!-- Chest Inspiration -->
            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Chest Insp (In cm)
                    <span class="requi">*</span>
                </label>
                <input type="number"
                    step="0.01"
                    id="chest_insp_cm"
                    name="chest_insp_cm"
                    class="form-control jbl-dynamic-input"
                    value="{{ $user->health->chest_insp_cm ?? '' }}"
                    required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Chest Insp (In Inches)
                    <span class="requi">*</span>
                </label>
                <input type="text"
                    id="chest_insp_inches"
                    name="chest_insp_inches"
                    class="form-control bg-light"
                    value="{{ $user->health->chest_insp_inches ?? '' }}"
                    readonly>
            </div>

            <!-- Chest Expansion -->
            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Chest Exp (In cm)
                    <span class="requi">*</span>
                </label>
                <input type="number"
                    step="0.01"
                    id="chest_exp_cm"
                    name="chest_exp_cm"
                    class="form-control jbl-dynamic-input"
                    value="{{ $user->health->chest_exp_cm ?? '' }}"
                    required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Chest Exp (In Inches)
                    <span class="requi">*</span>
                </label>
                <input type="text"
                    id="chest_exp_inches"
                    name="chest_exp_inches"
                    class="form-control bg-light"
                    value="{{ $user->health->chest_exp_inches ?? '' }}"
                    readonly>
            </div>

            <!-- Abdomen -->
            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Abdomen (In cm)
                    <span class="requi">*</span>
                </label>
                <input type="number"
                    step="0.01"
                    id="abdomen_cm"
                    name="abdomen_cm"
                    class="form-control jbl-dynamic-input"
                    value="{{ $user->health->abdomen_cm ?? '' }}"
                    required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Abdomen (In Inches)
                    <span class="requi">*</span>
                </label>
                <input type="text"
                    id="abdomen_inches"
                    name="abdomen_inches"
                    class="form-control bg-light"
                    value="{{ $user->health->abdomen_inches ?? '' }}"
                    readonly>
            </div>

            <!-- Weight Loss -->
            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Weight Loss (In Kg)
                    <span class="requi">*</span>
                </label>
                <input type="number"
                    step="0.01"
                    name="weight_loss_kg"
                    class="form-control jbl-dynamic-input"
                    value="{{ $user->health->weight_loss_kg ?? '' }}"
                    required>
            </div>

            <!-- Weight Gain -->
            <div class="col-md-6 px-0 px-sm-3">
                <label>
                    Weight Gain (In Kg)
                    <span class="requi">*</span>
                </label>
                <input type="number"
                    step="0.01"
                    name="weight_gain_kg"
                    class="form-control jbl-dynamic-input"
                    value="{{ $user->health->weight_gain_kg ?? '' }}"
                    required>
            </div>

            <!-- Weight Increase Reason -->
            <div class="col-md-12 px-0 px-sm-3 mb-4">
                <label>
                    Reason for Weight Gain or Weight Loss
                </label>
                <textarea
                    name="weight_increase_reason"
                    rows="3"
                    class="form-control jbl-dynamic-input"
                    required>{{ $user->health->weight_increase_reason ?? '' }}</textarea>
            </div>


            <!-- Daily Consumption -->
            <div class="col-md-12 px-0 px-sm-3 mb-3">
                <label>
                    State average daily consumption of Tobacco, Pan/Niswar, Alcohol, Drugs
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
                    State Physical Impairments (if any)
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
                    When did illness or injury last keep you away from work?
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
                    Medical Investigations History
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
                    Heart Disease, Diabetes, BP, TB, Jaundice, Cancer, Asthma, etc.
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
                    Captcha
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
                    value="Submitted"
                    disabled>
            </div>

        </div>
    </div>
</div>