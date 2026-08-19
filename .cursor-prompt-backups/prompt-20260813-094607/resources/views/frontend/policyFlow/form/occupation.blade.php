<div id="occupation" role="tabpanel" aria-labelledby="occupation-tab" class="tab-pane fade">
    <div class="w-75 mx-auto pt-5">
        <div class="row">
            <div class="col-md-12 px-0 px-sm-3">
                <label>Is Employment? (کام/پیشہ کی نوعیت (مکمل تفصیلات کے ساتھ))<span class="requi">*</span></label>
                <select name="is_emaployemnt" id="is_emaployemnt" required class="form-control jbl-dynamic-input" required>
                    <option value="">Select Option</option>
                    <option value="Yes" {{ ($user->occupation->is_emaployemnt ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ ($user->occupation->is_emaployemnt ?? '') == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="col-12">
                <div id="employment_fields" class="row"></div>
            </div>
            <div class="col-md-12 px-0 px-sm-3">
                <label>Is Businessman? (کیا کاروبار ہے؟ (مکمل تفصیلات کے ساتھ))<span class="requi">*</span></label>
                <select name="is_business" required class="form-control jbl-dynamic-input" required>
                    <option value="">Select Option</option>
                    <option value="Yes" {{ ($user->occupation->is_business ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ ($user->occupation->is_business ?? '') == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="col-12">
                <div id="business_fields" class="row"></div>
            </div>

            <div class="col-md-12 px-0 px-sm-3">
                <label>If holding Land? (کیا زراعتی زمین ہے؟ (مکمل تفصیلات کے ساتھ))<span class="requi">*</span></label>
                <select name="is_holding_land" required class="form-control jbl-dynamic-input" required>
                    <option value="">Select Option</option>
                    <option value="Yes" {{ ($user->occupation->is_holding_land ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ ($user->occupation->is_holding_land ?? '') == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div id="land_fields" class="row"></div>
            <div class="col-md-6 px-0 px-sm-3">
                <label>What is your average monthly income from all sources? (آپ کی تمام ذرائع سے حاصل کردہ ماہانہ آمدنی کیا ہے؟)<span class="requi">*</span></label>
                <input type="number"
                    name="avaerage_monthly_income"
                    value="{{$user->occupation->avaerage_monthly_income ?? ''}}"
                    class="form-control jbl-dynamic-input"
                    placeholder="Rs." required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>If Defence or Ex-Defence Personal, commercial Airline Flight Crew or plant protection pilot?<span class="requi">*</span></label>
                <select name="ex_defence_personal" class="form-control jbl-dynamic-input" required>
                    <option value="">Select Option</option>
                    <option value="Yes" {{ ($user->occupation->ex_defence_personal ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ ($user->occupation->ex_defence_personal ?? '') == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Have you ever been discharged on medical grounds?<span class="requi">*</span></label>
                <select name="discharged_on_medical" class="form-control jbl-dynamic-input" required>
                    <option value="">Select Option</option>
                    <option value="Yes" {{ ($user->occupation->discharged_on_medical ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ ($user->occupation->discharged_on_medical ?? '') == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Are you engaged in hazardous occupation?<span class="requi">*</span></label>
                <select name="hazardous_occupation" class="form-control jbl-dynamic-input" required>
                    <option value="">Select Option</option>
                    <option value="Yes" {{ ($user->occupation->hazardous_occupation ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    <option value="No" {{ ($user->occupation->hazardous_occupation ?? '') == 'No' ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Please Enter Your Comments (If any)?</label>
                <textarea name="comment" class="form-control jbl-dynamic-input" rows="2">{{ $user->occupation->comment ?? '' }}</textarea>
            </div>

        </div>
           <div class="col-12 d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-secondary ib-prev-btn">Previous</button>
            <button type="button" class="btn btn-primary ib-next-btn">Next</button>
        </div>
    </div>
</div>