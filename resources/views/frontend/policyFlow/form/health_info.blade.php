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

            <div class="col-md-12 px-0 px-sm-3 mb-4">
                <label>Reason of Increase Weight<span class="requi">*</span></label>
                <textarea name="weight_increase_reason" required class="form-control jbl-dynamic-input" rows="3">{{ $user->health->weight_increase_reason ?? '' }}</textarea>
            </div>

            <div class="col-md-12 px-0 px-sm-3 mb-4">
                <label class="fw-bold text-dark mb-2">Security Verification (سیکیورٹی تصدیق)<span class="requi">*</span></label>
                <div class="card shadow-sm border-0" style="background-color: #f8f9fa; border-left: 4px solid #6c757d !important;">
                    <div class="card-body p-3">
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <div class="bg-white px-3 py-2 rounded border shadow-sm fw-bold text-secondary" 
                                 id="captcha-question" 
                                 style="font-size: 1.1rem; user-select: none; min-width: 160px; text-align: center; letter-spacing: 1px;">
                            </div>
                            
                            <div style="flex: 1; min-width: 150px; max-width: 200px;">
                                <input type="number" id="captcha-answer" class="form-control form-control-lg text-center fw-bold" placeholder="?" required />
                            </div>
                            
                            <div class="d-flex align-items-center">
                                <span id="captcha-success" class="text-success d-none fw-bold animation-fade">
                                    <i class="fas fa-check-circle me-1"></i> Correct Answer!
                                </span>
                                <span id="captcha-error" class="text-danger d-none fw-bold animation-fade">
                                    <i class="fas fa-times-circle me-1"></i> Incorrect answer, try again.
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 px-0 px-sm-3">
                <input type="button" class="action-button" id='user_details_submited' value="Submitted" disabled />
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let num1, num2, correctAnswer;
    const questionElement = document.getElementById("captcha-question");
    const answerInput = document.getElementById("captcha-answer");
    const errorElement = document.getElementById("captcha-error");
    const successElement = document.getElementById("captcha-success");
    const submitBtn = document.getElementById("user_details_submited");

    // Function to generate a new math query
    function generateCaptcha() {
        num1 = Math.floor(Math.random() * 10) + 1; 
        num2 = Math.floor(Math.random() * 10) + 1; 
        correctAnswer = num1 + num2;
        questionElement.textContent = `${num1} + ${num2} =`;
        answerInput.value = ""; 
        errorElement.classList.add("d-none");
        successElement.classList.add("d-none");
        submitBtn.disabled = true; 
        
        // Reset border styling
        answerInput.style.borderColor = "#ced4da";
    }

    // Initialize CAPTCHA on page load
    generateCaptcha();

    // Listen to real-time keystrokes inside the captcha input field
    answerInput.addEventListener("input", function () {
        const userAnswer = parseInt(answerInput.value, 10);

        // Check if field is empty
        if (answerInput.value.trim() === "") {
            errorElement.classList.add("d-none");
            successElement.classList.add("d-none");
            submitBtn.disabled = true;
            answerInput.style.borderColor = "#ced4da";
            return;
        }

        if (userAnswer === correctAnswer) {
            // Correct logic
            errorElement.classList.add("d-none");
            successElement.classList.remove("d-none");
            submitBtn.disabled = false; 
            answerInput.style.borderColor = "#28a745"; // Green Border
        } else {
            // Wrong logic (as they type)
            successElement.classList.add("d-none");
            errorElement.classList.remove("d-none");
            submitBtn.disabled = true; 
            answerInput.style.borderColor = "#dc3545"; // Red Border
        }
    });

    submitBtn.addEventListener("click", function () {
        if (!submitBtn.disabled) {
            // Your form submission logic goes here
        }
    });
});
</script>