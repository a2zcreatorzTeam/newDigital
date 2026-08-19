<style>
    button.btn.btn-danger {
        background: red;
    }

    button.btn.btn-danger:hover {
        background: red;
    }

    .remove-member {
        margin-bottom: 10px !important;
    }

    button.remove-member {
        padding: 2px 16px;
        background: red;
        color: white;
        border: none;
        margin-bottom: 31px !important;
    }
</style>

<div id="family_history" role="tabpanel" aria-labelledby="nav-family-history-tab" class="tab-pane fade">
    <div class="container">
        <div class="row">
            <h3 class="col-12 ib-form-subheading mb-4">Family History</h3>

            <h5 class="col-12 ib-form-subheading-second text-primary mt-2">Father</h5>
            <input type="hidden" name="memner_flag" value="father">
            <div class="col-md-4 mb-3 px-sm-3">
                <label>Age<span class="requi">*</span></label>
                <input type="text" name="father_age" required class="form-control">
            </div>
            <div class="col-md-4 mb-3 px-sm-3">
                <label>State Of Health<span class="requi">*</span></label>
                <input type="text" name="father_health" required class="form-control">
            </div>
            <div class="col-md-4 mb-3 px-sm-3">
                <label>Year Of Death</label>
                <input type="number"
                    name="father_year_of_death"
                    class="form-control"
                    placeholder="YYYY"
                    min="1920"
                    max="{{ date('Y') }}"
                    step="1"
                    onkeypress="if(this.value.length==4) return false;">
            </div>
            <div class="col-md-4 mb-3 px-sm-3">
                <label>Age Of Death</label>
                <input type="number" name="father_age_of_death" class="form-control">
            </div>
            <div class="col-md-4 mb-3 px-sm-3">
                <label>Cause Of Death</label>
                <textarea name="father_cause_of_death" class="form-control" rows="4" placeholder="Enter cause of death details..."></textarea>
            </div>

            <hr class="col-12 my-4">

            <h5 class="col-12 ib-form-subheading-second text-primary">Mother</h5>
            <input type="hidden" name="memner_flag" value="mother">
            <div class="col-md-4 mb-3 px-sm-3">
                <label>Age<span class="requi">*</span></label>
                <input type="text" name="mother_age" class="form-control">
            </div>
            <div class="col-md-4 mb-3 px-sm-3">
                <label>State Of Health<span class="requi">*</span></label>
                <input type="text" name="mother_health" class="form-control">
            </div>
            <div class="col-md-4 mb-3 px-sm-3">
                <label>Year Of Death</label>
                <input type="number"
                    name="mother_year_of_death"
                    class="form-control"
                    placeholder="YYYY"
                    min="1920"
                    max="{{ date('Y') }}"
                    step="1"
                    onkeypress="if(this.value.length==4) return false;">

            </div>
            <div class="col-md-4 mb-3 px-sm-3">
                <label>Age Of Death</label>
                <input type="number" name="mother_age_of_death" class="form-control">
            </div>
            <div class="col-md-4 mb-3 px-sm-3">
                <label>Cause Of Death</label>
                <textarea name="mother_cause_of_death" class="form-control" rows="4" placeholder="Enter cause of death details..."></textarea>
            </div>

            <hr class="col-12 my-4">

            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                <h5 class="ib-form-subheading-second text-primary mb-0">Brothers Details</h5>
                <button type="button" class="btn btn-sm btn-success add-member" data-type="brother"> + Add Brother Info</button>
            </div>
            <div id="brothers_container" class="col-12 row px-0 mx-0"></div>

            <hr class="col-12 my-4">

            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                <h5 class="ib-form-subheading-second text-primary mb-0">Sisters Details</h5>
                <button type="button" class="btn btn-sm btn-success add-member" data-type="sister"> + Add Sister Info</button>
            </div>
            <div id="sisters_container" class="col-12 row px-0 mx-0"></div>

            <hr class="col-12 my-4">

            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                <h5 class="ib-form-subheading-second text-primary mb-0">Sons Details</h5>
                <button type="button" class="btn btn-sm btn-success add-member" data-type="son"> + Add Son Info</button>
            </div>
            <div id="sons_container" class="col-12 row px-0 mx-0"></div>

            <hr class="col-12 my-4">

            <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                <h5 class="ib-form-subheading-second text-primary mb-0">Daughters Details</h5>
                <button type="button" class="btn btn-sm btn-success add-member" data-type="daughter"> + Add Daughter Info</button>
            </div>
            <div id="daughters_container" class="col-12 row px-0 mx-0"></div>

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

        // Dynamic Form Templates Object
        const templates = {
            brother: () => createMemberRow('brother', 'Brother'),
            sister: () => createMemberRow('sister', 'Sister'),
            son: () => createMemberRow('son', 'Son'),
            daughter: () => createMemberRow('daughter', 'Daughter')
        };

        // Helper function row generate karne ke liye
        function createMemberRow(type, labelPrefix) {
            return `
            <input type="hidden" name="memner_flag[]" value="${type}">
            <div class="col-12 row dynamic-row align-items-end border p-3 mb-3 bg-light rounded position-relative mx-0">
                <div class="col-md-4 mb-2 px-1">
                    <label>${labelPrefix} Age<span class="requi">*</span></label>
                    <input type="text" name="${type}_age[]" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2 px-1">
                    <label>State Of Health<span class="requi">*</span></label>
                    <input type="text" name="${type}_health[]" class="form-control" required>
                </div>
                <div class="col-md-4 mb-2 px-1">
                    <label>Year Of Death</label>
                    
                    <input type="number"
                    name="${type}_year_of_death[]"
                    class="form-control"
                    placeholder="YYYY"
                    min="1920"
                    max="{{ date('Y') }}"
                    step="1"
                    onkeypress="if(this.value.length==4) return false;">
                </div>
                <div class="col-md-4 mb-2 px-1">
                    <label>Age Of Death</label>
                    <input type="number" name="${type}_age_of_death[]" class="form-control">
                </div>
                <div class="col-md-4 mb-2 px-1">
                    <label>Cause Of Death</label>
                     <textarea name="${type}_cause_of_death[]" class="form-control" rows="4" placeholder="Enter cause of death details..."></textarea>    
                </div>
                <div class="col-md-1 mb-2 text-center px-1">
                    <button type="button" class="remove-member" title="Remove">-</button>
                </div>
            </div>
        `;
        }

        // Plus (+) Button Click Event
        $('.add-member').on('click', function() {
            let type = $(this).data('type');
            if (templates[type]) {
                $(`#${type}s_container`).append(templates[type]());
            }
        });

        // Minus (-) Button Click Event (Delegated Event because rows are dynamic)
        $(document).on('click', '.remove-member', function() {
            $(this).closest('.dynamic-row').remove();
        });

        // Pehle se agar koi row default show karni ho toh uncomment kar saktay hain:
        // $('.add-member').trigger('click'); 

    });
</script>
@endpush