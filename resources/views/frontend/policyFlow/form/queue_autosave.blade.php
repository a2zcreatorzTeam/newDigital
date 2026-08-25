{{-- Policy form queue auto-save + draft restore --}}
@php
    $queueDraftPayload = !empty($draft) ? ($draft->form_payload ?? []) : [];
    $queueDraftLastTab = !empty($draft) ? ($draft->last_tab ?? null) : null;
@endphp

@push('js')
<script>
(function ($) {
    var QUEUE_TAB_LABELS = {
        '#nav-Personal_Details-tab': 'Address Details',
        '#basic_Details-tab': 'Basic Details',
        '#occupation-tab': 'Occupation',
        '#product_detail-tab': 'Product Details',
        '#family-history-tab': 'Family History',
        '#women-tab': 'Female Section',
        '#nominee-tab': 'Nominee',
        '#documents-tab': 'Documents',
        '#health_info-tab': 'Health Information'
    };

    var draftPayload = @json($queueDraftPayload);
    var draftLastTab = @json($queueDraftLastTab);
    var saveTimer = null;
    var isSavingQueue = false;
    var lastSavedHash = '';

    function getActiveTabId() {
        var $active = $('#nav-tab a.acq-nav-btn.active').first();
        return $active.length ? '#' + $active.attr('id') : '#nav-Personal_Details-tab';
    }

    function collectFormPayload() {
        var payload = {};
        var form = document.getElementById('msform');
        if (!form) return payload;

        // Temporarily enable disabled fields so values are captured
        var $disabled = $('#msform .dependent-address-field:disabled');
        $disabled.prop('disabled', false);

        var fd = new FormData(form);
        fd.forEach(function (value, key) {
            if (key === '_token') return;
            // Skip files
            if (typeof File !== 'undefined' && value instanceof File) {
                if (value.name) {
                    payload[key] = { name: value.name, size: value.size, type: value.type, queued: false };
                }
                return;
            }
            if (Object.prototype.hasOwnProperty.call(payload, key)) {
                if (!Array.isArray(payload[key])) {
                    payload[key] = [payload[key]];
                }
                payload[key].push(value);
            } else {
                payload[key] = value;
            }
        });

        $disabled.prop('disabled', true);

        // UI-only occupation type
        if ($('#occupation_type').length) {
            payload.__occupation_type = $('#occupation_type').val();
        }

        return payload;
    }

    function countFilledSections(payload) {
        var groups = {
            personal: ['permanent_province_id', 'permanent_city_id', 'permanent_address'],
            basic: ['life_proposed_full_name', 'cnic_number', 'mobile_number', 'date_of_birth'],
            occupation: ['avaerage_monthly_income', 'is_holding_land', 'is_emaployemnt', 'filer_status'],
            product: ['sum_assured', 'payment_mode', 'term'],
            family: ['father_age', 'mother_age'],
            women: ['is_pregnant', 'qualification'],
            nominee: ['nominee_name', 'nominee_cnic'],
            health: ['height_value', 'weight_value', 'daily_consumption']
        };
        var filled = 0;
        Object.keys(groups).forEach(function (g) {
            var ok = groups[g].some(function (k) {
                var v = payload[k];
                return v !== undefined && v !== null && String(v).trim() !== '';
            });
            if (ok) filled++;
        });
        return filled;
    }

    function saveQueueDraft(force) {
        var $form = $('#msform');
        if (!$form.length) return;
        var url = $form.data('queue-save-url');
        var productId = $form.data('product-id');
        if (!url || !productId) return;

        var payload = collectFormPayload();
        var filled = countFilledSections(payload);
        if (!force && filled < 1) return;

        var tabId = getActiveTabId();
        var body = {
            product_id: productId,
            product_name: $form.data('product-name') || '',
            last_tab: tabId,
            progress_label: QUEUE_TAB_LABELS[tabId] || 'In progress',
            filled_sections: filled,
            form_payload: payload
        };

        var hash = JSON.stringify(body);
        if (!force && hash === lastSavedHash) return;
        if (isSavingQueue) return;
        isSavingQueue = true;

        $.ajax({
            method: 'POST',
            url: url,
            data: JSON.stringify(body),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val() || '',
                'Accept': 'application/json'
            }
        }).done(function (res) {
            if (res && res.success) {
                lastSavedHash = hash;
                if (res.draft_id) {
                    $form.attr('data-draft-id', res.draft_id);
                }
            }
        }).always(function () {
            isSavingQueue = false;
        });
    }

    function scheduleQueueSave() {
        clearTimeout(saveTimer);
        saveTimer = setTimeout(function () {
            saveQueueDraft(false);
        }, 1200);
    }

    function applyDraftPayload(payload) {
        if (!payload || typeof payload !== 'object') return;
        var form = document.getElementById('msform');
        if (!form) return;

        if (typeof window.ensureMiscarriageDateRows === 'function') {
            var miscarriageValue = payload['miscarriage_dates[]'] !== undefined
                ? payload['miscarriage_dates[]']
                : payload.miscarriage_dates;
            if (miscarriageValue !== undefined && miscarriageValue !== null) {
                var miscarriageArr = Array.isArray(miscarriageValue)
                    ? miscarriageValue
                    : String(miscarriageValue).split(/\s*,\s*/);
                window.ensureMiscarriageDateRows(miscarriageArr);
            }
        }

        Object.keys(payload).forEach(function (name) {
            if (name === 'miscarriage_dates[]' || name === 'miscarriage_dates') {
                return;
            }
            if (name === '__occupation_type') {
                $('#occupation_type').val(payload[name]).trigger('change');
                return;
            }
            var value = payload[name];
            var $fields = $(form).find('[name="' + name + '"]');
            if (!$fields.length) return;

            // Skip file inputs
            if ($fields.is(':file')) return;

            if (Array.isArray(value)) {
                $fields.each(function (idx) {
                    if (value[idx] !== undefined) {
                        $(this).val(value[idx]);
                    }
                });
            } else {
                $fields.val(value);
            }
        });

        if (!payload.dual_nationality_country_id && payload.dual_nationality_country) {
            var countryName = String(payload.dual_nationality_country).trim().toLowerCase();
            var $countrySelect = $(form).find('select[name="dual_nationality_country_id"]');
            var $matchedCountry = $countrySelect.find('option').filter(function () {
                return $.trim($(this).text()).toLowerCase() === countryName;
            }).first();
            if ($matchedCountry.length) {
                $countrySelect.val($matchedCountry.val());
            }
        }

        if (!payload.primary_nationality_country_id && payload.primary_nationality) {
            var primaryName = String(payload.primary_nationality).trim().toLowerCase();
            if (primaryName === 'pakistani') {
                primaryName = 'pakistan';
            }
            var $primarySelect = $(form).find('select[name="primary_nationality_country_id"]');
            var $matchedPrimary = $primarySelect.find('option').filter(function () {
                return $.trim($(this).text()).toLowerCase() === primaryName;
            }).first();
            if ($matchedPrimary.length) {
                $primarySelect.val($matchedPrimary.val());
            }
        }

        if (typeof window.applyAgeFromDob === 'function') {
            var dob = $(form).find('[name="date_of_birth"]').val();
            if (dob) {
                window.applyAgeFromDob(dob);
            }
        }

        // Re-run dependent UI toggles
        if (typeof window.applyDualNationalityLogic === 'function') {
            window.applyDualNationalityLogic();
        }
        if (typeof window.applyFilerStatusLogic === 'function') {
            window.applyFilerStatusLogic(false);
        }
        if (typeof window.applyAppointeeLogic === 'function') {
            window.applyAppointeeLogic(false);
        }
        if (typeof window.applyFemaleDiseaseLogic === 'function') {
            window.applyFemaleDiseaseLogic(false);
        }
        if (typeof window.applyLifeProposedLogic === 'function') {
            window.applyLifeProposedLogic(false);
        }
        $('#occupation_type').trigger('change');
        $('select[name="is_holding_land"]').trigger('change');
        $('#is_same_person').trigger('change');
        $('#gender, #marital_status').trigger('change');
        if (typeof window.toggleFemaleSectionVisibility === 'function') {
            window.toggleFemaleSectionVisibility();
        }
        $('#weight_change_type').trigger('change');
        $('#height_value').trigger('input');

        // Cascade address selects after values set
        setTimeout(function () {
            if (payload.permanent_province_id) {
                $('#permanent_province_id').trigger('change');
            }
        }, 200);
        setTimeout(function () {
            if (payload.permanent_city_id) {
                $('#permanent_city_id').val(payload.permanent_city_id).trigger('change');
            }
            if (payload.corres_province_id) {
                $('#corres_province_id').val(payload.corres_province_id).trigger('change');
            }
            if (payload.temp_province_id) {
                $('#temp_province_id').val(payload.temp_province_id).trigger('change');
            }
        }, 700);
        setTimeout(function () {
            if (payload.permanent_district_id) {
                $('#permanent_district_id').val(payload.permanent_district_id);
            }
            if (payload.corres_city_id) {
                $('#corres_city_id').val(payload.corres_city_id).trigger('change');
            }
            if (payload.temp_city_id) {
                $('#temp_city_id').val(payload.temp_city_id).trigger('change');
            }
            ['corres_district_id', 'temp_district_id', 'corres_address', 'temp_address', 'permanent_address'].forEach(function (k) {
                if (payload[k] !== undefined) {
                    $('[name="' + k + '"]').val(payload[k]);
                }
            });
        }, 1400);
    }

    $(document).ready(function () {
        if (!$('#msform').length || !$('#msform').data('queue-save-url')) {
            return;
        }

        if (draftPayload && Object.keys(draftPayload).length) {
            applyDraftPayload(draftPayload);
            if (draftLastTab && $(draftLastTab).length) {
                setTimeout(function () {
                    $(draftLastTab).tab('show');
                }, 300);
            }
        }

        $(document).on('change input', '#msform input, #msform select, #msform textarea', function () {
            if ($(this).is(':file')) return;
            scheduleQueueSave();
        });

        $(document).on('shown.bs.tab', '#nav-tab a[data-toggle="tab"]', function () {
            scheduleQueueSave();
        });

        $(window).on('beforeunload pagehide', function () {
            saveQueueDraft(true);
        });

        document.addEventListener('visibilitychange', function () {
            if (document.visibilityState === 'hidden') {
                saveQueueDraft(true);
            }
        });
    });
})(jQuery);
</script>
@endpush
