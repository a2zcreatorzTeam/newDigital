<div id="documents" role="tabpanel" aria-labelledby="basic_Details-tab" class="tab-pane fade">
    <div class="container">
        <div class="row">
            <h3 class="col-12 ib-form-subheading">Documents</h3>
            <!-- Required Documents Upload Section -->
            <div class="row">
                <!-- 1. Proposer CNIC Front -->
                <div class="col-md-6 px-0 px-sm-3 mb-3">
                    <div>
                        <div>
                            <div>
                                <label>Proposer CNIC Front / شناختی کارڈ (فرنٹ)<span class="text text-danger">*</span></label>
                                <div class="jbl-field">
                                    <input type="file" name="proposer_cnic_front" class="form-control jbl-dynamic-input" id="proposer_cnic_front" accept="image/*,.pdf">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Proposer CNIC Back -->
                <div class="col-md-6 px-0 px-sm-3 mb-3">
                    <div>
                        <div>
                            <div>
                                <label>Proposer CNIC Back / شناختی کارڈ (بیک)<span class="text text-danger">*</span></label>
                                <div class="jbl-field">
                                    <input type="file" name="proposer_cnic_back" class="form-control jbl-dynamic-input" id="proposer_cnic_back" accept="image/*,.pdf">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Nominee CNIC / B-Form -->
                <div class="col-md-6 px-0 px-sm-3 mb-3">
                    <div>
                        <div>
                            <div>
                                <label>Nominee CNIC / B-Form Copy / نامزد فرد کا شناختی کارڈ/بی فارم<span class="text text-danger">*</span></label>
                                <div class="jbl-field">
                                    <input type="file" name="nominee_document" class="form-control jbl-dynamic-input" id="nominee_document" accept="image/*,.pdf">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Passport Size Photograph -->
                <div class="col-md-6 px-0 px-sm-3 mb-3">
                    <div>
                        <div>
                            <div>
                                <label>Passport Size Photograph / پاسپورٹ سائز تصویر<span class="text text-danger">*</span></label>
                                <div class="jbl-field">
                                    <input type="file" name="proposer_photo" class="form-control jbl-dynamic-input" id="proposer_photo" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. Proof of Income (Salary Slip / Bank Statement) -->
                <div class="col-md-6 px-0 px-sm-3 mb-3">
                    <div>
                        <div>
                            <div>
                                <label>Proof of Income / Income Proof (آمدنی کا ثبوت / بینک سٹیٹمنٹ)</label>
                                <div class="jbl-field">
                                    <input type="file" name="income_proof" class="form-control jbl-dynamic-input" id="income_proof" accept="image/*,.pdf">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Medical Reports / Health Examination (Optional/If Applicable) -->
                <div class="col-md-6 px-0 px-sm-3 mb-3">
                    <div>
                        <div>
                            <div>
                                <label>Medical Reports (If Any) / میڈیکل رپورٹس (اگر کوئی ہوں)</label>
                                <div class="jbl-field">
                                    <input type="file" name="medical_reports" class="form-control jbl-dynamic-input" id="medical_reports" accept="image/*,.pdf" multiple>
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