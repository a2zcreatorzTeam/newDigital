<div id="documents" role="tabpanel" aria-labelledby="basic_Details-tab" class="tab-pane fade">
    <div class="container">
        <div class="row">
            <h3 class="col-12 ib-form-subheading">Documents</h3>

            <!-- Existing Required Documents Upload Section (unchanged) -->
            <div class="row">
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
            </div>

            {{-- Medical Documents (new) --}}
            <div class="col-12 mt-4">
                <div class="doc-extra-panel">
                    <h4 class="doc-extra-title">Medical Documents</h4>
                    <p class="doc-extra-subtitle">Upload all relevant medical documents.</p>

                    <div class="row" id="medical_docs_fixed">
                        <div class="col-md-6 mb-3">
                            <div class="doc-upload-row" data-doc-row>
                                <label>Referred / OPD Letter / Slip / Card</label>
                                <div class="doc-upload-controls">
                                    <input type="file" name="medical_doc_referred_opd" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                                    <span class="doc-file-name">No file chosen</span>
                                    <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                                    <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="doc-upload-row" data-doc-row>
                                <label>Previous OPD Card / Slip / Document</label>
                                <div class="doc-upload-controls">
                                    <input type="file" name="medical_doc_previous_opd" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                                    <span class="doc-file-name">No file chosen</span>
                                    <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                                    <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="doc-upload-row" data-doc-row>
                                <label>Summary / Discharge / Operation / Lab Reports / Any others</label>
                                <div class="doc-upload-controls">
                                    <input type="file" name="medical_doc_summary_reports" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                                    <span class="doc-file-name">No file chosen</span>
                                    <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                                    <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="doc-upload-row" data-doc-row>
                                <label>Present / Brief History / Investigations / Picture (If any)</label>
                                <div class="doc-upload-controls">
                                    <input type="file" name="medical_doc_present_history" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                                    <span class="doc-file-name">No file chosen</span>
                                    <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                                    <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="doc-upload-row" data-doc-row>
                                <label>Death / MLC / Postmortem / Police / Medico Legal</label>
                                <div class="doc-upload-controls">
                                    <input type="file" name="medical_doc_death_mlc" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                                    <span class="doc-file-name">No file chosen</span>
                                    <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                                    <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="doc-upload-row" data-doc-row>
                                <label>Medicolegal / Legal / FIR / Panchanama / Inquest / Others</label>
                                <div class="doc-upload-controls">
                                    <input type="file" name="medical_doc_medicolegal" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                                    <span class="doc-file-name">No file chosen</span>
                                    <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                                    <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="medical_docs_extra"></div>

                    <div class="text-center mt-2 mb-2">
                        <button type="button" class="doc-add-more-btn" id="add_medical_doc_btn">+ Add More Medical Document</button>
                    </div>
                </div>
            </div>

            {{-- Other Documents (new) --}}
            <div class="col-12 mt-4">
                <div class="doc-extra-panel">
                    <h4 class="doc-extra-title">Other Documents</h4>
                    <p class="doc-extra-subtitle">Upload any other supporting documents.</p>

                    <div id="other_docs_list">
                        <div class="doc-upload-row mb-3" data-doc-row>
                            <label>Other Document 1</label>
                            <div class="doc-upload-controls">
                                <input type="hidden" name="other_doc_labels[]" value="Other Document 1">
                                <input type="file" name="other_docs[]" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                                <span class="doc-file-name">No file chosen</span>
                                <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                                <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="doc-upload-row mb-3" data-doc-row>
                            <label>Other Document 2</label>
                            <div class="doc-upload-controls">
                                <input type="hidden" name="other_doc_labels[]" value="Other Document 2">
                                <input type="file" name="other_docs[]" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                                <span class="doc-file-name">No file chosen</span>
                                <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                                <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="doc-upload-row mb-3" data-doc-row>
                            <label>Other Document 3</label>
                            <div class="doc-upload-controls">
                                <input type="hidden" name="other_doc_labels[]" value="Other Document 3">
                                <input type="file" name="other_docs[]" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                                <span class="doc-file-name">No file chosen</span>
                                <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                                <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="doc-upload-row mb-3" data-doc-row>
                            <label>Other Document 4</label>
                            <div class="doc-upload-controls">
                                <input type="hidden" name="other_doc_labels[]" value="Other Document 4">
                                <input type="file" name="other_docs[]" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                                <span class="doc-file-name">No file chosen</span>
                                <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                                <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-2 mb-2">
                        <button type="button" class="doc-add-more-btn" id="add_other_doc_btn">+ Add More Other Document</button>
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

<style>
    #documents .doc-extra-panel {
        border: 1px solid #d9e2ec;
        border-radius: 0.75rem;
        background: #fff;
        padding: 1.1rem 1.15rem 0.85rem;
        box-shadow: 0 4px 14px rgba(31, 147, 209, 0.05);
    }

    #documents .doc-extra-title {
        margin: 0;
        color: #1f93d1;
        font-size: 1.15rem;
        font-weight: 600;
    }

    #documents .doc-extra-subtitle {
        margin: 0.25rem 0 1rem;
        color: #6b7c88;
        font-size: 0.875rem;
    }

    #documents .doc-upload-row label {
        display: block;
        color: #1f93d1;
        font-weight: 500;
        margin-bottom: 0.4rem;
    }

    #documents .doc-upload-controls {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        flex-wrap: wrap;
    }

    #documents .doc-upload-controls .form-control {
        max-width: 240px;
    }

    #documents .doc-file-name {
        color: #5a6b78;
        font-size: 0.85rem;
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    #documents .doc-file-ok {
        color: #28a745;
        font-size: 1.1rem;
    }

    #documents .doc-file-clear {
        border: none;
        background: transparent;
        color: #de6244;
        cursor: pointer;
        font-size: 1rem;
        padding: 0;
    }

    #documents .doc-add-more-btn {
        border: 1px solid #28a745;
        background: #fff;
        color: #28a745;
        border-radius: 0.5rem;
        padding: 0.45rem 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    #documents .doc-add-more-btn:hover {
        background: #28a745;
        color: #fff;
    }
</style>

@push('js')
<script>
    $(document).ready(function() {
        function refreshDocRow($row) {
            let input = $row.find('.doc-file-input')[0];
            let hasFile = input && input.files && input.files.length > 0;
            let name = hasFile ? input.files[0].name : 'No file chosen';
            $row.find('.doc-file-name').text(name);
            $row.find('.doc-file-ok').toggleClass('d-none', !hasFile);
            $row.find('.doc-file-clear').toggleClass('d-none', !hasFile);
        }

        $(document).on('change', '#documents .doc-file-input', function() {
            refreshDocRow($(this).closest('[data-doc-row]'));
        });

        $(document).on('click', '#documents .doc-file-clear', function() {
            let $row = $(this).closest('[data-doc-row]');
            let $input = $row.find('.doc-file-input');
            $input.val('');
            refreshDocRow($row);
        });

        let medicalExtraCount = 0;
        $('#add_medical_doc_btn').on('click', function() {
            medicalExtraCount++;
            let label = 'Additional Medical Document ' + medicalExtraCount;
            $('#medical_docs_extra').append(`
                <div class="col-md-6 mb-3 medical-extra-item">
                    <div class="doc-upload-row" data-doc-row>
                        <label>${label}</label>
                        <div class="doc-upload-controls">
                            <input type="hidden" name="medical_extra_labels[]" value="${label}">
                            <input type="file" name="medical_extra_docs[]" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                            <span class="doc-file-name">No file chosen</span>
                            <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                            <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                            <button type="button" class="doc-file-clear remove-extra-doc" title="Remove row"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
            `);
        });

        let otherDocCount = 4;
        $('#add_other_doc_btn').on('click', function() {
            otherDocCount++;
            let label = 'Other Document ' + otherDocCount;
            $('#other_docs_list').append(`
                <div class="doc-upload-row mb-3 other-extra-item" data-doc-row>
                    <label>${label}</label>
                    <div class="doc-upload-controls">
                        <input type="hidden" name="other_doc_labels[]" value="${label}">
                        <input type="file" name="other_docs[]" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                        <span class="doc-file-name">No file chosen</span>
                        <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                        <button type="button" class="doc-file-clear d-none" title="Remove"><i class="fas fa-trash"></i></button>
                        <button type="button" class="doc-file-clear remove-extra-doc" title="Remove row"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            `);
        });

        $(document).on('click', '#documents .remove-extra-doc', function() {
            $(this).closest('.medical-extra-item, .other-extra-item').remove();
        });
    });
</script>
@endpush
