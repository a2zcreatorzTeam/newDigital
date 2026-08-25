<div id="documents" role="tabpanel" aria-labelledby="basic_Details-tab" class="tab-pane fade">
    <div class="container">
        <div class="row">
            <h3 class="col-12 ib-form-subheading">{{ policy_label('documents') }}</h3>

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('required_documents') }}</h5>
                    </div>
                    <div class="row">
                <div class="col-md-6 px-0 px-sm-3 mb-3">
                    <div>
                        <div>
                            <div>
                                <label>{{ policy_label('proposer_cnic_front') }}<span class="text text-danger">*</span></label>
                                <div class="jbl-field">
                                    <input type="file" name="proposer_cnic_front" class="form-control jbl-dynamic-input" id="proposer_cnic_front" accept="image/*,.pdf" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 px-0 px-sm-3 mb-3">
                    <div>
                        <div>
                            <div>
                                <label>{{ policy_label('proposer_cnic_back') }}<span class="text text-danger">*</span></label>
                                <div class="jbl-field">
                                    <input type="file" name="proposer_cnic_back" class="form-control jbl-dynamic-input" id="proposer_cnic_back" accept="image/*,.pdf" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 px-0 px-sm-3 mb-3 js-life-proposed-doc-wrap" id="life_proposed_document_wrap" style="display:none;">
                    <div>
                        <div>
                            <div>
                                <label><span class="js-life-proposed-doc-label">{{ policy_label('life_proposed_document') }}</span><span class="text text-danger">*</span></label>
                                <div class="jbl-field">
                                    <input type="file" name="life_proposed_document" class="form-control jbl-dynamic-input" id="life_proposed_document" accept="image/*,.pdf">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 px-0 px-sm-3 mb-3">
                    <div>
                        <div>
                            <div>
                                <label>{{ policy_label('nominee_document') }}<span class="text text-danger">*</span></label>
                                <div class="jbl-field">
                                    <input type="file" name="nominee_document" class="form-control jbl-dynamic-input" id="nominee_document" accept="image/*,.pdf" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 px-0 px-sm-3 mb-3">
                    <div>
                        <div>
                            <div>
                                <label>{{ policy_label('proposer_photo') }}<span class="text text-danger">*</span></label>
                                <div class="jbl-field">
                                    <input type="file" name="proposer_photo" class="form-control jbl-dynamic-input" id="proposer_photo" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 px-0 px-sm-3 mb-3">
                    <div>
                        <div>
                            <div>
                                <label>{{ policy_label('income_proof') }}</label>
                                <div class="jbl-field">
                                    <input type="file" name="income_proof" class="form-control jbl-dynamic-input" id="income_proof" accept="image/*,.pdf">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>

            {{-- Medical Documents (new) --}}
            <div class="col-12 mt-1">
                <div class="policy-fieldset doc-extra-panel">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title doc-extra-title">{{ policy_label('medical_documents') }}</h5>
                    </div>
                    <p class="doc-extra-subtitle">Upload all relevant medical documents.</p>

                    <div class="row" id="medical_docs_fixed">
                        <div class="col-md-6 mb-3">
                            <div class="doc-upload-row" data-doc-row>
                                <label>{{ policy_label('referred_opd') }}</label>
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
                                <label>{{ policy_label('previous_opd') }}</label>
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
                                <label>{{ policy_label('summary_discharge') }}</label>
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
                                <label>{{ policy_label('present_history') }}</label>
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
                                <label>{{ policy_label('death_mlc') }}</label>
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
                                <label>{{ policy_label('medicolegal') }}</label>
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
            <div class="col-12 mt-1">
                <div class="policy-fieldset doc-extra-panel">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title doc-extra-title">{{ policy_label('other_documents') }}</h5>
                    </div>
                    <p class="doc-extra-subtitle">Upload any other supporting documents.</p>

                    <div id="other_docs_list">
                        <div class="doc-upload-row mb-3 other-doc-item" data-doc-row data-other-index="1">
                            <label for="other_doc_1">{{ policy_label('other_document') }} 1</label>
                            <div class="doc-upload-controls">
                                <input type="hidden" name="other_doc_labels[]" value="{{ policy_label('other_document') }} 1">
                                <input type="file" name="other_docs[]" id="other_doc_1" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                                <span class="doc-file-name">No file chosen</span>
                                <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                                <button type="button" class="doc-file-clear d-none" title="Clear file"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-2 mb-2">
                        <button type="button" class="doc-add-more-btn" id="add_other_doc_btn">+ Add More Document</button>
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
        /* Uses shared .policy-fieldset chrome; keep light accents only */
        box-shadow: none;
    }

    #documents .doc-extra-title {
        color: #2f3b4a;
        font-size: 1.05rem;
        font-weight: 600;
    }

    #documents .doc-extra-subtitle {
        margin: 0 0 1rem;
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

    #documents .doc-add-more-btn:hover:not(:disabled) {
        background: #28a745;
        color: #fff;
    }

    #documents .doc-add-more-btn:disabled {
        opacity: 0.55;
        cursor: not-allowed;
    }

    #documents .doc-remove-row {
        border: none;
        background: transparent;
        color: #de6244;
        cursor: pointer;
        font-size: 1rem;
        padding: 0;
    }
</style>

@push('js')
<script>
    $(document).ready(function() {
        const MAX_MEDICAL_EXTRA = 5;
        const MAX_OTHER_DOCS = 5;
        const ADDITIONAL_MEDICAL_LABEL = 'Additional Medical Document (اضافی طبی دستاویز)';
        const OTHER_DOCUMENT_LABEL = 'Other Document (دیگر دستاویز)';

        function refreshDocRow($row) {
            let input = $row.find('.doc-file-input')[0];
            let hasFile = input && input.files && input.files.length > 0;
            let name = hasFile ? input.files[0].name : 'No file chosen';
            $row.find('.doc-file-name').text(name);
            $row.find('.doc-file-ok').toggleClass('d-none', !hasFile);
            $row.find('.doc-file-clear').toggleClass('d-none', !hasFile);
        }

        function syncMedicalExtraLimits() {
            let $items = $('#medical_docs_extra .medical-extra-item');
            $items.each(function(index) {
                let n = index + 1;
                let label = ADDITIONAL_MEDICAL_LABEL + ' ' + n;
                let id = 'medical_extra_doc_' + n;
                $(this).find('label').first().attr('for', id).text(label);
                $(this).find('input[name="medical_extra_labels[]"]').val(label);
                $(this).find('.doc-file-input').attr('id', id);
            });
            let atMax = $items.length >= MAX_MEDICAL_EXTRA;
            $('#add_medical_doc_btn').prop('disabled', atMax).toggleClass('d-none', atMax);
        }

        function syncOtherDocLimits() {
            let $items = $('#other_docs_list .other-doc-item');
            $items.each(function(index) {
                let n = index + 1;
                let label = OTHER_DOCUMENT_LABEL + ' ' + n;
                let id = 'other_doc_' + n;
                $(this).attr('data-other-index', n);
                $(this).find('label').first().attr('for', id).text(label);
                $(this).find('input[name="other_doc_labels[]"]').val(label);
                $(this).find('.doc-file-input').attr('id', id);
                // Only dynamically added fields (2+) can be removed as a row
                $(this).find('.doc-remove-row').toggle(n > 1);
            });
            let atMax = $items.length >= MAX_OTHER_DOCS;
            $('#add_other_doc_btn').prop('disabled', atMax).toggleClass('d-none', atMax);
        }

        $(document).on('change', '#documents .doc-file-input', function() {
            refreshDocRow($(this).closest('[data-doc-row]'));
        });

        $(document).on('click', '#documents .doc-file-clear', function() {
            let $row = $(this).closest('[data-doc-row]');
            $row.find('.doc-file-input').val('');
            refreshDocRow($row);
        });

        $('#add_medical_doc_btn').on('click', function() {
            if ($('#medical_docs_extra .medical-extra-item').length >= MAX_MEDICAL_EXTRA) {
                return;
            }
            let n = $('#medical_docs_extra .medical-extra-item').length + 1;
            let label = ADDITIONAL_MEDICAL_LABEL + ' ' + n;
            let id = 'medical_extra_doc_' + n;
            $('#medical_docs_extra').append(`
                <div class="col-md-6 mb-3 medical-extra-item">
                    <div class="doc-upload-row" data-doc-row>
                        <label for="${id}">${label}</label>
                        <div class="doc-upload-controls">
                            <input type="hidden" name="medical_extra_labels[]" value="${label}">
                            <input type="file" name="medical_extra_docs[]" id="${id}" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                            <span class="doc-file-name">No file chosen</span>
                            <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                            <button type="button" class="doc-file-clear d-none" title="Clear file"><i class="fas fa-trash"></i></button>
                            <button type="button" class="doc-remove-row" title="Remove field"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
            `);
            syncMedicalExtraLimits();
        });

        $('#add_other_doc_btn').on('click', function() {
            if ($('#other_docs_list .other-doc-item').length >= MAX_OTHER_DOCS) {
                return;
            }
            let n = $('#other_docs_list .other-doc-item').length + 1;
            let label = OTHER_DOCUMENT_LABEL + ' ' + n;
            let id = 'other_doc_' + n;
            $('#other_docs_list').append(`
                <div class="doc-upload-row mb-3 other-doc-item" data-doc-row data-other-index="${n}">
                    <label for="${id}">${label}</label>
                    <div class="doc-upload-controls">
                        <input type="hidden" name="other_doc_labels[]" value="${label}">
                        <input type="file" name="other_docs[]" id="${id}" class="form-control jbl-dynamic-input doc-file-input" accept="image/*,.pdf">
                        <span class="doc-file-name">No file chosen</span>
                        <span class="doc-file-ok d-none"><i class="fas fa-check-circle"></i></span>
                        <button type="button" class="doc-file-clear d-none" title="Clear file"><i class="fas fa-trash"></i></button>
                        <button type="button" class="doc-remove-row" title="Remove field"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            `);
            syncOtherDocLimits();
        });

        $(document).on('click', '#documents .doc-remove-row', function() {
            let $medical = $(this).closest('.medical-extra-item');
            let $other = $(this).closest('.other-doc-item');
            if ($medical.length) {
                $medical.remove();
                syncMedicalExtraLimits();
            } else if ($other.length && !$other.is(':first-child')) {
                $other.remove();
                syncOtherDocLimits();
            }
        });

        syncMedicalExtraLimits();
        syncOtherDocLimits();
    });
</script>
@endpush
