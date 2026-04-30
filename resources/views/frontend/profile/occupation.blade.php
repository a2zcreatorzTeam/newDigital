 <form action="#" method="POST">
                @csrf
                <h2 class="profile-section-title">Occupation & Income</h2>
                <div class="box-form-login">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Is Employment? ((کام/پیشہ کی نوعیت (مکمل تفصیلات کے ساتھ)*</label>
                                <select class="form-control account" name="is_employment">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- Is Businessman? -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Is Businessman? ((کیا کاروبار ہے؟ (مکمل تفصیلات کے ساتھ)*</label>
                                <select class="form-control account" name="is_businessman">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- If holding Land? -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>If holding Land? ((کیا زراعتی زمین ہے؟ (مکمل تفصیلات کے ساتھ)*</label>
                                <select class="form-control account" name="holding_land">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- Monthly Income -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>What is your average monthly income from all sources? (آپ کی تمام ذرائع سے حاصل کردہ ماہانہ آمدنی کیا ہے؟)*</label>
                                <input type="number" class="form-control account" name="monthly_income" placeholder="Rs.">
                            </div>
                        </div>

                        <!-- Defence / Airline Crew -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>If Defence or Ex-Defence Personal, commercial Airline Flight Crew or plant protection pilot? (کیا آپ فوجی/سابقہ فوجی، عملہ شہری ہوا بازی/تحفظ فصل کے ہوا باز ہیں؟)*</label>
                                <select class="form-control account" name="defence_airline_crew">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- Discharged on Medical Grounds -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Have you ever been discharged on medical grounds from service / employeement? (کیا آپ کبھی طبی اسباب کی وجہ سے ملازمت/خدمات سے برخاست کئے گئے ہیں؟)*</label>
                                <select class="form-control account" name="medical_discharge">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- Hazardous Occupation -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Are you presently engaged or intent to engage in any hazardous occupation or pastime? (کیا آپ فی الوقت کسی پر خطر پیشے یا مشغلے سے وابستہ ہیں یا آئندہ وابستہ ہونے کا ارادہ ہے؟)*</label>
                                <select class="form-control account" name="hazardous_occupation">
                                    <option value="">Select Option</option>
                                </select>
                            </div>
                        </div>

                        <!-- Comments Section -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Please Enter Your Comments (If any)? (براہ کرم اپنی رائے درج کریں (اگر کوئی ہو)*</label>
                                <textarea class="form-control account" name="comments" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="update-btn-container">
                        <button type="submit" class="btn-update">Update Occupation</button>
                    </div>
                </div>
            </form>