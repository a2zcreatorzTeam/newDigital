<div id="product_detail" role="tabpanel" aria-labelledby="occupation-tab" class="tab-pane fade">
    <div class="w-75 mx-auto pt-5">
        <div class="row">

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('product_details') }}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6 px-0 px-sm-3">
                            <div>
                                <div>
                                    <div><label>{{ policy_label('table') }}</label>
                                        <div class="jbl-field"><input required type="text" name="table_no" value="{{$product->table_no ?? '' }}" class="jbl-dynamic-input"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <div>
                                <div>
                                    <div><label>{{ policy_label('term') }}</label>
                                        <div class="jbl-field">
                                            <input type="text" name="term" id="term" class="form-control" value="{{ $policy_data->term ?? '' }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 px-0 px-sm-3">
                            <div>
                                <div>
                                    <div><label>{{ policy_label('sum_assured') }}<span class="requi">*</span></label>
                                        <div class="jbl-field">
                                            <input required type="text" required name="sum_assured" id='sum_assured' class="jbl-dynamic-input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="policy_product_id" value="{{$product->id}}" id="policy_product_id">
                        <input type="hidden" name="plan" value="{{ $product->id }}">

                        <div class="col-md-6 px-0 px-sm-3">
                            <div>
                                <div>
                                    <div><label>{{ policy_label('payment_mode') }}<span class="requi">*</span></label>
                                        <div class="jbl-field">
                                            <select required name="payment_mode" class="form-control jbl-dynamic-input" id="payment_mode">
                                                <option value="">Select Mode</option>
                                                <option value="Yearly">Yearly (سالانہ)</option>
                                                @if($id!=2)
                                                <option value="Half Yearly">Half Yearly (ششماہی)</option>
                                                <option value="Quarterly">Quarterly (سہ ماہی)</option>
                                                <option value="Monthly">Monthly (ماہانہ)</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="policy-fieldset">
                    <div class="policy-fieldset__header">
                        <h5 class="policy-fieldset__title">{{ policy_label('riders_and_benefits') }}</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6 px-0 px-sm-3">
                            <div>
                                <div>
                                    <div><label>{{ policy_label('is_nd_applied') }}<span class="requi">*</span></label>
                                        <div class="jbl-field">
                                            <select required name="is_nd_applied" id="is_nd_applied" class="form-control jbl-dynamic-input">
                                                <option value="">Select Option</option>
                                                <option value="Yes" selected>Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 px-0 px-sm-3 js-nd-rider-field" id="adb_rider_wrap">
                            <div>
                                <div>
                                    <div><label>{{ policy_label('adb_rider') }}<span class="requi">*</span></label>
                                        <div class="jbl-field">
                                            <select required name="adb_rider" id="adb_rider" class="form-control jbl-dynamic-input">
                                                <option value="">Select Option</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 px-0 px-sm-3 js-nd-rider-field" id="tir_rider_wrap">
                            <div>
                                <div>
                                    <div><label>{{ policy_label('tir_rider') }}<span class="requi">*</span></label>
                                        <div class="jbl-field">
                                            <select required name="tir_rider" id="tir_rider" class="form-control jbl-dynamic-input">
                                                <option value="">Select Option</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 px-0 px-sm-3">
                <div>
                    <div>
                        <div>
                            <a class="btn btn-danger btn-sm my-4" id="calcultae_policy">Calculate</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="showPolicyCalculation"></div>

            <input type="hidden" value="{{$product->id}}" id="product_id">

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


        function loadPlanData() {
            let $term = $('#term');
            // Term is a readonly input prefilled from the calculator — do not treat it as a <select>
            if (!$term.length || !$term.is('select')) {
                return;
            }

            let product_id = $('#product_id').val();
            let age_birth = $('#age_birth').val();
            if (!product_id || !age_birth) {
                return;
            }
            $.ajax({
                type: 'POST',
                url: '{{ route("frontend.getPlanData") }}',
                data: {
                    product_id: product_id,
                    age: age_birth
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    $term.html('<option>Loading...</option>');
                },
                success: function(res) {
                    let options = '<option value="">Select Option</option>';

                    if (res.surrender_values && res.surrender_values.length > 0) {
                        $('#sum_assured').val('');
                        $.each(res.surrender_values, function(index, item) {
                            options += `
                            <option value="${item.duration}">
                                ${item.duration}
                            </option>
                        `;
                        });

                    } else {
                        options = '<option value="">No Data Found</option>';
                    }

                    $term.html(options);
                },
                error: function(err) {
                    $term.html('<option value="">Error loading data</option>');
                }
            });
        }

        // initial load (only applies when #term is a select)
        loadPlanData();



        function getsumassured(term_value) {

            let product_id = $('#product_id').val();
            let age_birth = $('#age_birth').val();

            if (!term_value || !product_id || !age_birth) return;

            $.ajax({
                type: 'POST',
                url: '{{ route("frontend.getSumAssured") }}',
                data: {
                    product_id: product_id,
                    age: age_birth,
                    term_value: term_value
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Loading',
                        text: 'Please wait....',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(res) {
                    Swal.close();
                    $('#sum_assured').val(res);
                },
                error: function(err) {
                    Swal.close();
                    Swal.fire('Error', 'Unable to load sum assured. Please try again.', 'error');
                }
            });
        }


        // Reload plan terms only when product changes and term is a selectable field
        $('#product_id').on('change', function() {
            loadPlanData();
        });

        $('#term').on('change', function() {
            if (!$(this).is('select')) {
                return;
            }
            let term_value = $(this).val();
            getsumassured(term_value);
        });


        $('#calcultae_policy').click(function() {
            let sum_assured = $('#sum_assured').val();
            let payment_mode = $('#payment_mode').val();
            let term = $('#term').val();
            let gender = $('#gender').val();
            let policy_product_id = $('#policy_product_id').val();
            let age_birth = $('#age_birth').val();

            let adb_rider = $('#adb_rider').val();
            let tir_rider = $('#tir_rider').val();
            let is_nd_applied = $('#is_nd_applied').val();
            let ridersRequired = is_nd_applied !== 'Yes';

            // check empty fields
            if (!sum_assured || !payment_mode || !term || !gender || !policy_product_id || !age_birth || !is_nd_applied || (ridersRequired && (!tir_rider || !adb_rider))) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Please fill all required fields',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });

                return;

            } else {


                $.ajax({
                    type: 'POST',
                    url: '{{ route("PolicyCalculator.policy_calculation") }}',
                    data: {
                        sum_assured: sum_assured,
                        payment_mode: payment_mode,
                        term: term,
                        gender: gender,
                        policy_product_id: policy_product_id,
                        age_birth: age_birth,
                        is_nd_applied: is_nd_applied,
                        adb_rider: ridersRequired ? adb_rider : 'No',
                        tir_rider: ridersRequired ? tir_rider : 'No'
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Loading',
                            text: 'Please wait....',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(res) {
                        Swal.close();
                        $('#showPolicyCalculation').html(res);

                        // $('#sum_assured').val(res);
                    },
                    error: function(err) {
                        Swal.close();
                        Swal.fire('Error', 'Unable to calculate premium. Please try again.', 'error');
                    }
                });









            }







        })

        function toggleNdRiderFields() {
            var ndApplied = $('#is_nd_applied').val() === 'Yes';
            var $adb = $('#adb_rider');
            var $tir = $('#tir_rider');

            if (ndApplied) {
                $('.js-nd-rider-field').hide();
                $adb.prop('required', false).val('');
                $tir.prop('required', false).val('');
            } else {
                $('.js-nd-rider-field').show();
                $adb.prop('required', true);
                $tir.prop('required', true);
            }
        }

        $('#is_nd_applied').on('change', toggleNdRiderFields);
        toggleNdRiderFields();

    });
</script>







@endpush
