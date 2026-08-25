<style>
    /* Scoped Family History UI — dashboard only */
    #family_history.family-history-section {
        --fh-blue: #1f93d1;
        --fh-blue-soft: #e8f4fb;
        --fh-blue-border: #cfe6f4;
        --fh-text: #3d4f5c;
        --fh-muted: #6b7c88;
        --fh-card: #ffffff;
        --fh-danger: #de6244;
    }

    #family_history .fh-intro {
        margin: 0 0 1.25rem;
        color: var(--fh-muted);
        font-size: 0.9375rem;
        line-height: 1.5;
    }

    #family_history .fh-member-card {
        width: 100%;
        background: var(--fh-card);
        border: 1px solid var(--fh-blue-border);
        border-radius: 1rem;
        padding: 1.15rem 1.15rem 0.65rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 8px 20px rgba(31, 147, 209, 0.06);
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }

    #family_history .fh-member-card:hover {
        border-color: rgba(31, 147, 209, 0.45);
        box-shadow: 0 10px 24px rgba(31, 147, 209, 0.1);
    }

    #family_history .fh-member-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px dashed var(--fh-blue-border);
    }

    #family_history .fh-member-title {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        margin: 0;
        color: var(--fh-blue) !important;
        font-size: 1.05rem !important;
        font-weight: 600;
    }

    #family_history .fh-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
        height: 2rem;
        padding: 0 0.55rem;
        border-radius: 999px;
        background: var(--fh-blue-soft);
        color: var(--fh-blue);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.02em;
    }

    #family_history .fh-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 0.85rem;
    }

    #family_history .fh-section-head .ib-form-subheading-second {
        margin: 0;
        color: var(--fh-blue) !important;
    }

    #family_history .fh-add-btn {
        border: 1px solid var(--fh-blue) !important;
        background: transparent !important;
        color: var(--fh-blue) !important;
        border-radius: 0.625rem !important;
        padding: 0.4rem 0.9rem !important;
        font-size: 0.8125rem !important;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    #family_history .fh-add-btn:hover {
        background: var(--fh-blue) !important;
        color: #fff !important;
    }

    #family_history .fh-death-fields {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        margin-bottom: 0.75rem;
        padding: 0.85rem 0.85rem 0.15rem;
        border-radius: 0.75rem;
        background: linear-gradient(180deg, #f7fbfe 0%, #eef6fb 100%);
        border: 1px solid var(--fh-blue-border);
    }

    #family_history .fh-death-fields.is-visible {
        display: flex;
        flex-wrap: wrap;
        animation: fhFadeIn 0.25s ease;
    }

    #family_history .fh-death-label {
        width: 100%;
        margin: 0 0 0.65rem;
        color: var(--fh-blue);
        font-size: 0.8125rem;
        font-weight: 600;
    }

    #family_history .fh-empty-hint {
        width: 100%;
        padding: 0.9rem 1rem;
        margin-bottom: 0.75rem;
        border-radius: 0.75rem;
        border: 1px dashed var(--fh-blue-border);
        background: var(--fh-blue-soft);
        color: var(--fh-muted);
        font-size: 0.875rem;
    }

    #family_history .dynamic-row.fh-member-card {
        position: relative;
        margin-left: 0;
        margin-right: 0;
    }

    #family_history button.remove-member {
        padding: 0.35rem 0.85rem;
        background: var(--fh-danger);
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        margin-bottom: 0.75rem !important;
        transition: opacity 0.2s ease;
    }

    #family_history button.remove-member:hover {
        opacity: 0.9;
    }

    #family_history label {
        color: var(--fh-blue);
        font-weight: 500;
    }

    @keyframes fhFadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 575.98px) {
        #family_history .fh-member-card {
            padding: 1rem 0.85rem 0.5rem;
        }
    }
</style>

<div id="family_history" role="tabpanel" aria-labelledby="nav-family-history-tab" class="tab-pane fade family-history-section">
    <div class="container">
        <div class="row">
            <h3 class="col-12 ib-form-subheading mb-2">{{ policy_label('family_history') }}</h3>
            <p class="col-12 fh-intro">Share health details for close family members. If a member is not alive, death details will appear after you select No.</p>

            {{-- Father --}}
            <div class="col-12">
                <div class="fh-member-card" data-member-block="father">
                    <div class="fh-member-head">
                        <h5 class="fh-member-title ib-form-subheading-second">
                            <span class="fh-badge">F</span>
                            {{ policy_label('father') }}
                        </h5>
                    </div>
                    <input type="hidden" name="memner_flag" value="father">
                    <div class="row">
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>{{ policy_label('age') }}<span class="requi">*</span></label>
                            <input type="text" name="father_age" required class="form-control">
                        </div>
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>{{ policy_label('state_of_health') }}<span class="requi">*</span></label>
                            <input type="text" name="father_health" required class="form-control">
                        </div>
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>{{ policy_label('is_member_alive') }}<span class="requi">*</span></label>
                            <select name="father_is_alive" class="form-control fh-is-alive" required>
                                <option value="">Select Option</option>
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="fh-death-fields row mx-0">
                            <div class="fh-death-label">Deceased details</div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>{{ policy_label('year_of_death') }}<span class="requi">*</span></label>
                                <input type="number"
                                    name="father_year_of_death"
                                    class="form-control fh-death-input"
                                    placeholder="YYYY"
                                    min="1920"
                                    max="{{ date('Y') }}"
                                    step="1"
                                    onkeypress="if(this.value.length==4) return false;">
                            </div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>{{ policy_label('age_of_death') }}<span class="requi">*</span></label>
                                <input type="number" name="father_age_of_death" class="form-control fh-death-input">
                            </div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>{{ policy_label('cause_of_death') }}<span class="requi">*</span></label>
                                <textarea name="father_cause_of_death" class="form-control fh-death-input" rows="3" placeholder="Enter cause of death details..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mother --}}
            <div class="col-12">
                <div class="fh-member-card" data-member-block="mother">
                    <div class="fh-member-head">
                        <h5 class="fh-member-title ib-form-subheading-second">
                            <span class="fh-badge">M</span>
                            {{ policy_label('mother') }}
                        </h5>
                    </div>
                    <input type="hidden" name="memner_flag" value="mother">
                    <div class="row">
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>{{ policy_label('age') }}<span class="requi">*</span></label>
                            <input type="text" name="mother_age" required class="form-control">
                        </div>
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>{{ policy_label('state_of_health') }}<span class="requi">*</span></label>
                            <input type="text" name="mother_health" required class="form-control">
                        </div>
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>{{ policy_label('is_member_alive') }}<span class="requi">*</span></label>
                            <select name="mother_is_alive" class="form-control fh-is-alive" required>
                                <option value="">Select Option</option>
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="fh-death-fields row mx-0">
                            <div class="fh-death-label">Deceased details</div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>{{ policy_label('year_of_death') }}<span class="requi">*</span></label>
                                <input type="number"
                                    name="mother_year_of_death"
                                    class="form-control fh-death-input"
                                    placeholder="YYYY"
                                    min="1920"
                                    max="{{ date('Y') }}"
                                    step="1"
                                    onkeypress="if(this.value.length==4) return false;">
                            </div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>{{ policy_label('age_of_death') }}<span class="requi">*</span></label>
                                <input type="number" name="mother_age_of_death" class="form-control fh-death-input">
                            </div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>{{ policy_label('cause_of_death') }}<span class="requi">*</span></label>
                                <textarea name="mother_cause_of_death" class="form-control fh-death-input" rows="3" placeholder="Enter cause of death details..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Spouse --}}
            <div class="col-12">
                <div class="fh-member-card" data-member-block="spouse">
                    <div class="fh-member-head">
                        <h5 class="fh-member-title ib-form-subheading-second">
                            <span class="fh-badge">SP</span>
                            {{ policy_label('spouse') }}
                        </h5>
                    </div>
                    <input type="hidden" name="memner_flag" value="spouse">
                    <div class="row">
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>{{ policy_label('age') }}</label>
                            <input type="text" name="spouse_age" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>{{ policy_label('state_of_health') }}</label>
                            <input type="text" name="spouse_health" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>{{ policy_label('is_member_alive') }}</label>
                            <select name="spouse_is_alive" class="form-control fh-is-alive">
                                <option value="">Select Option</option>
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="fh-death-fields row mx-0">
                            <div class="fh-death-label">Deceased details</div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>{{ policy_label('year_of_death') }}<span class="requi">*</span></label>
                                <input type="number"
                                    name="spouse_year_of_death"
                                    class="form-control fh-death-input"
                                    placeholder="YYYY"
                                    min="1920"
                                    max="{{ date('Y') }}"
                                    step="1"
                                    onkeypress="if(this.value.length==4) return false;">
                            </div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>{{ policy_label('age_of_death') }}<span class="requi">*</span></label>
                                <input type="number" name="spouse_age_of_death" class="form-control fh-death-input">
                            </div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>{{ policy_label('cause_of_death') }}<span class="requi">*</span></label>
                                <textarea name="spouse_cause_of_death" class="form-control fh-death-input" rows="3" placeholder="Enter cause of death details..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Brothers --}}
            <div class="col-12">
                <div class="fh-section-head">
                    <h5 class="ib-form-subheading-second mb-0">
                        <span class="fh-badge">B</span> {{ policy_label('brothers') }}
                    </h5>
                    <button type="button" class="btn btn-sm fh-add-btn add-member" data-type="brother">+ Add Brother</button>
                </div>
                <div id="brothers_container" class="row px-0 mx-0"></div>
                <div class="fh-empty-hint" id="brothers_empty_hint">No brother details added yet. Click “Add Brother” if applicable.</div>
            </div>

            {{-- Sisters --}}
            <div class="col-12 mt-2">
                <div class="fh-section-head">
                    <h5 class="ib-form-subheading-second mb-0">
                        <span class="fh-badge">S</span> {{ policy_label('sisters') }}
                    </h5>
                    <button type="button" class="btn btn-sm fh-add-btn add-member" data-type="sister">+ Add Sister</button>
                </div>
                <div id="sisters_container" class="row px-0 mx-0"></div>
                <div class="fh-empty-hint" id="sisters_empty_hint">No sister details added yet. Click “Add Sister” if applicable.</div>
            </div>

            {{-- Sons --}}
            <div class="col-12 mt-2">
                <div class="fh-section-head">
                    <h5 class="ib-form-subheading-second mb-0">
                        <span class="fh-badge">SO</span> {{ policy_label('sons') }}
                    </h5>
                    <button type="button" class="btn btn-sm fh-add-btn add-member" data-type="son">+ Add Son</button>
                </div>
                <div id="sons_container" class="row px-0 mx-0"></div>
                <div class="fh-empty-hint" id="sons_empty_hint">No son details added yet. Click “Add Son” if applicable.</div>
            </div>

            {{-- Daughters --}}
            <div class="col-12 mt-2">
                <div class="fh-section-head">
                    <h5 class="ib-form-subheading-second mb-0">
                        <span class="fh-badge">D</span> {{ policy_label('daughters') }}
                    </h5>
                    <button type="button" class="btn btn-sm fh-add-btn add-member" data-type="daughter">+ Add Daughter</button>
                </div>
                <div id="daughters_container" class="row px-0 mx-0"></div>
                <div class="fh-empty-hint" id="daughters_empty_hint">No daughter details added yet. Click “Add Daughter” if applicable.</div>
            </div>

        </div>
        <div class="col-12 d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-secondary ib-prev-btn">Previous</button>
            <button type="button" class="btn btn-primary ib-next-btn">Next</button>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function() {
        const currentYear = {{ date('Y') }};

        function toggleDeathFields($block) {
            let $select = $block.find('.fh-is-alive').first();
            let $death = $block.find('.fh-death-fields').first();
            let isDeceased = ($select.val() || '') === 'No';

            if (isDeceased) {
                $death.addClass('is-visible');
                $death.find('.fh-death-input').prop('required', true).prop('disabled', false);
            } else {
                $death.removeClass('is-visible');
                // Keep fields enabled so array indexes stay aligned on submit
                $death.find('.fh-death-input').prop('required', false).prop('disabled', false).val('');
            }
        }

        function updateEmptyHints() {
            ['brother', 'sister', 'son', 'daughter'].forEach(function(type) {
                let hasRows = $(`#${type}s_container .dynamic-row`).length > 0;
                $(`#${type}s_empty_hint`).toggle(!hasRows);
            });
        }

        function createMemberRow(type, labelPrefix, ageLabel) {
            return `
            <div class="col-12">
                <div class="fh-member-card dynamic-row" data-member-block="${type}">
                    <div class="fh-member-head">
                        <h5 class="fh-member-title ib-form-subheading-second">
                            <span class="fh-badge">${labelPrefix.charAt(0)}</span>
                            ${labelPrefix}
                        </h5>
                        <button type="button" class="remove-member" title="Remove">Remove</button>
                    </div>
                    <input type="hidden" name="memner_flag[]" value="${type}">
                    <div class="row">
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>${ageLabel}<span class="requi">*</span></label>
                            <input type="text" name="${type}_age[]" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>State Of Health (صحت کی حالت)<span class="requi">*</span></label>
                            <input type="text" name="${type}_health[]" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3 px-sm-3">
                            <label>Is the member alive? (کیا رکن زندہ ہے؟)<span class="requi">*</span></label>
                            <select name="${type}_is_alive[]" class="form-control fh-is-alive" required>
                                <option value="">Select Option</option>
                                <option value="Yes" selected>Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="fh-death-fields row mx-0">
                            <div class="fh-death-label">Deceased details</div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>Year Of Death (وفات کا سال)<span class="requi">*</span></label>
                                <input type="number"
                                    name="${type}_year_of_death[]"
                                    class="form-control fh-death-input"
                                    placeholder="YYYY"
                                    min="1920"
                                    max="${currentYear}"
                                    step="1"
                                    onkeypress="if(this.value.length==4) return false;">
                            </div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>Age Of Death (وفات کی عمر)<span class="requi">*</span></label>
                                <input type="number" name="${type}_age_of_death[]" class="form-control fh-death-input">
                            </div>
                            <div class="col-md-4 mb-3 px-sm-3">
                                <label>Cause Of Death (وفات کی وجہ)<span class="requi">*</span></label>
                                <textarea name="${type}_cause_of_death[]" class="form-control fh-death-input" rows="3" placeholder="Enter cause of death details..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            `;
        }

        const templates = {
            brother: () => createMemberRow('brother', 'Brother (بھائی)', 'Brother Age (بھائی کی عمر)'),
            sister: () => createMemberRow('sister', 'Sister (بہن)', 'Sister Age (بہن کی عمر)'),
            son: () => createMemberRow('son', 'Son (بیٹا)', 'Son Age (بیٹے کی عمر)'),
            daughter: () => createMemberRow('daughter', 'Daughter (بیٹی)', 'Daughter Age (بیٹی کی عمر)')
        };

        // Initial state for father/mother
        $('#family_history [data-member-block]').each(function() {
            toggleDeathFields($(this));
        });
        updateEmptyHints();

        $(document).on('change', '#family_history .fh-is-alive', function() {
            toggleDeathFields($(this).closest('[data-member-block]'));
        });

        $('.add-member').on('click', function() {
            let type = $(this).data('type');
            if (templates[type]) {
                let $row = $(templates[type]());
                $(`#${type}s_container`).append($row);
                toggleDeathFields($row.find('[data-member-block]'));
                updateEmptyHints();
            }
        });

        $(document).on('click', '#family_history .remove-member', function() {
            $(this).closest('.col-12').remove();
            updateEmptyHints();
        });

        // Ensure disabled death fields are not required / not submitted with stale values
        $(document).on('click', '#user_details_submited', function() {
            $('#family_history [data-member-block]').each(function() {
                toggleDeathFields($(this));
            });
        });
    });
</script>
@endpush
