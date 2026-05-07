<div id="product_detail" role="tabpanel" aria-labelledby="occupation-tab" class="tab-pane fade">
    <div class="w-75 mx-auto pt-5">
        <div class="row">

            {{--
                         <div class="col-md-6 px-0 px-sm-3">
                             <div>
                                 <div>
                                     <div><label>Plan (منصوبہ)<span class="requi">*</span></label>
                                         <div class="jbl-field">
--}}
            <input required type="hidden" value="{{$id}}" name="plan" class="jbl-dynamic-input">
            {{--</div>
                                     </div>
                                 </div>
                             </div>
                         </div>
--}}

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>Table (منصوبہ نمبر)<span class="requi">*</span></label>
                            <div class="jbl-field"><input required type="text" name="table_no" class="jbl-dynamic-input"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>Term (میعاد)<span class="requi">*</span></label>
                            <div class="jbl-field">
                                <select name="term" id="term" required class="form-control">
                                    <option value="">Select Option</option>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>Sum Assured (زرِ بیمہ)<span class="requi">*</span></label>
                            <div class="jbl-field">
                                <input required type="text" required name="sum_assured" id='sum_assured' class="jbl-dynamic-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>IS ND APPLIED? (YES/NO)<span class="requi">*</span></label>
                            <div class="jbl-field">
                                <select required name="is_nd_applied" class="form-control jbl-dynamic-input">
                                    <option value="">Select Option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>Payment Mode (ادائیگی کا طریقہ)<span class="requi">*</span></label>
                            <div class="jbl-field">
                                <select required name="payment_mode" class="form-control jbl-dynamic-input">
                                    <option value="">Select Mode</option>
                                    <option value="Yearly">Yearly (سالانہ)</option>
                                    <option value="Half Yearly">Half Yearly (ششماہی)</option>
                                    <option value="Quarterly">Quarterly (سہ ماہی)</option>
                                    <option value="Monthly">Monthly (ماہانہ)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>Automatic Paid-Up (خودکار منجمد کی سہولت)<span class="requi">*</span></label>
                            <div class="jbl-field">
                                <select required name="automatic_paid_up" class="form-control jbl-dynamic-input">
                                    <option value="">Select Option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>Automatic Premium Loan (خودکار قرض برائے پریمیم کی سہولت)<span class="requi">*</span></label>
                            <div class="jbl-field">
                                <select required name="automatic_premium_loan" class="form-control jbl-dynamic-input">
                                    <option value="">Select Option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>Accidental Death & Indemnity Benefit (AIB) (حادثاتی موت اور تلافی کے معاوضہ کا ضمنی معاہدہ)<span class="requi">*</span></label>
                            <div class="jbl-field">
                                <select required name="aib_rider" class="form-control jbl-dynamic-input">
                                    <option value="">Select Option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>Accidental Death Benefit (ADB) (حادثاتی موت کے فوائد کا ضمنی معاہدہ)<span class="requi">*</span></label>
                            <div class="jbl-field">
                                <select required name="adb_rider" class="form-control jbl-dynamic-input">
                                    <option value="">Select Option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>Term Insurance Rider (TIR) (ٹرم انشورنس رائڈر)<span class="requi">*</span></label>
                            <div class="jbl-field">
                                <select required name="tir_rider" class="form-control jbl-dynamic-input">
                                    <option value="">Select Option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>Family Income Benefit (FIB) (خاندانی آمدنی کا ضمنی معاہدہ)<span class="requi">*</span></label>
                            <div class="jbl-field">
                                <select required name="fib_rider" class="form-control jbl-dynamic-input">
                                    <option value="">Select Option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" value="{{$product->id}}" id="product_id">
        </div>
    </div>
</div>
@push('js')
<script>
    $(document).ready(function() {
        function loadPlanData() {
            let product_id = $('#product_id').val();
            let age_birth = $('#age_birth').val();
            if (!product_id || !age_birth) {
                console.log("Missing product_id or age");
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
                    $('#term').html('<option>Loading...</option>');
                },
                success: function(res) {
                    console.log(res);
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

                    $('#term').html(options);
                },
                error: function(err) {
                    console.log(err);
                    $('#term').html('<option value="">Error loading data</option>');
                }
            });
        }

        // initial load
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
                    console.log(err);
                    alert('Error occurred');
                }
            });
        }


        // optional: reload if inputs change
        $('#product_id,#date_of_birth').on('change', function() {
            loadPlanData();
            alert("date change");

        });

        $('#term').on('change', function() {
            let term_value = $(this).val();
            getsumassured(term_value);
        });

    });
</script>






@endpush