<div id="health_info" role="tabpanel" aria-labelledby="health_info-tab" class="tab-pane fade">
    <div class="w-75 mx-auto pt-5">
        <div class="row">

            <div class="col-md-6 px-0 px-sm-3">
                <label>Height (In cm) (قد سینٹی میٹر میں)<span class="requi">*</span></label>
                <input type="number" name="height_cm" class="form-control jbl-dynamic-input"
                    value="{{ $user->health->height_cm ?? '' }}" required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Height (In Feet)<span class="requi">*</span></label>
                <input type="number" name="height_ft" class="form-control jbl-dynamic-input"
                    value="{{ $user->health->height_ft ?? '' }}" required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Weight (In Kg) (وزن کلوگرام میں)<span class="requi">*</span></label>
                <input type="number" name="weight_kg" class="form-control jbl-dynamic-input"
                    value="{{ $user->health->weight_kg ?? '' }}" required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Chest Insp (In cm)<span class="requi">*</span></label>
                <input type="number" name="chest_insp_cm" class="form-control jbl-dynamic-input"
                    value="{{ $user->health->chest_insp_cm ?? '' }}" required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Chest Insp (In Inches)<span class="requi">*</span></label>
                <input type="number" name="chest_insp_inches" class="form-control jbl-dynamic-input"
                    value="{{ $user->health->chest_insp_inches ?? '' }}" required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Chest Exp (In cm)<span class="requi">*</span></label>
                <input type="number" name="chest_exp_cm" class="form-control jbl-dynamic-input"
                    value="{{ $user->health->chest_exp_cm ?? '' }}" required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Chest Exp (In Inches)<span class="requi">*</span></label>
                <input type="number" name="chest_exp_inches" class="form-control jbl-dynamic-input"
                    value="{{ $user->health->chest_exp_inches ?? '' }}" required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Abdomen (In cm)<span class="requi">*</span></label>
                <input type="number" name="abdomen_cm" class="form-control jbl-dynamic-input"
                    value="{{ $user->health->abdomen_cm ?? '' }}" required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Abdomen (In Inches)<span class="requi">*</span></label>
                <input type="number" name="abdomen_inches" class="form-control jbl-dynamic-input"
                    value="{{ $user->health->abdomen_inches ?? '' }}" required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Weight Loss (In Kg)<span class="requi">*</span></label>
                <input type="number" name="weight_loss_kg" class="form-control jbl-dynamic-input"
                    value="{{ $user->health->weight_loss_kg ?? '' }}" required>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <label>Weight Gain (In Kg)<span class="requi">*</span></label>
                <input type="number" name="weight_gain_kg" class="form-control jbl-dynamic-input"
                    value="{{ $user->health->weight_gain_kg ?? '' }}" required>
            </div>

            <div class="col-md-12 px-0 px-sm-3">
                <label>Reason of Increase Weight<span class="requi">*</span></label>
                <textarea name="weight_increase_reason" required class="form-control jbl-dynamic-input" rows="3">{{ $user->health->weight_increase_reason ?? '' }}</textarea>
            </div>
            <input type="button" class="action-button" id='user_details_submited' value="Submited" />

        </div>
    </div>
</div>