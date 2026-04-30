  <form action="#" method="POST">
                @csrf
                <h2 class="profile-section-title">Health Information</h2>
                <div class="box-form-login">
                    <div class="row">
                        <!-- Height (In cm) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Height (In cm) (قد سینٹی میٹر میں)*</label>
                                <input type="text" class="form-control" name="height_cm">
                            </div>
                        </div>
                        <!-- Height (In Feet) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Height (In Feet)*</label>
                                <input type="text" class="form-control" name="height_feet">
                            </div>
                        </div>

                        <!-- Weight (In Kg) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Weight (In Kg) (وزن کلوگرام میں)*</label>
                                <input type="text" class="form-control" name="weight_kg">
                            </div>
                        </div>
                        <!-- Chest Insp (In cm) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Chest Insp (In cm) (سینہ پھیلانے کے ساتھ - سینٹی میٹر میں)*</label>
                                <input type="text" class="form-control" name="chest_insp_cm">
                            </div>
                        </div>

                        <!-- Chest Insp (In Inches) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Chest Insp (In Inches)*</label>
                                <input type="text" class="form-control" name="chest_insp_inches">
                            </div>
                        </div>
                        <!-- Chest Exp (In cm) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Chest Exp (In cm) (سینہ پھیلانے کے بغیر - سینٹی میٹر میں)*</label>
                                <input type="text" class="form-control" name="chest_exp_cm">
                            </div>
                        </div>

                        <!-- Chest Exp (In Inches) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Chest Exp (In Inches)*</label>
                                <input type="text" class="form-control" name="chest_exp_inches">
                            </div>
                        </div>
                        <!-- Abdomen (In cm) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Abdomen (In cm) (پیٹ - سینٹی میٹر میں)*</label>
                                <input type="text" class="form-control" name="abdomen_cm">
                            </div>
                        </div>

                        <!-- Abdomen (In Inches) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Abdomen (In Inches)*</label>
                                <input type="text" class="form-control" name="abdomen_inches">
                            </div>
                        </div>
                        <!-- Weight Loss (In Kg) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Weight Loss (In Kg) (وزن میں کمی - کلوگرام میں)*</label>
                                <input type="text" class="form-control" name="weight_loss_kg">
                            </div>
                        </div>

                        <!-- Weight Gain (In Kg) -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Weight Gain (In Kg) (وزن میں اضافہ - کلوگرام میں)*</label>
                                <input type="text" class="form-control" name="weight_gain_kg">
                            </div>
                        </div>

                        <!-- Empty column for layout balance if needed -->
                        <div class="col-6"></div>

                        <!-- Reason of Increase Weight -->
                        <div class="col-6">
                            <div class="form-group">
                                <label>Reason of Increase Weight (وزن بڑھنے کی وجہ)*</label>
                                <textarea class="form-control" name="weight_increase_reason" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="update-btn-container">
                        <button type="submit" class="btn-update">Update Health Info</button>
                    </div>
                </div>
            </form>