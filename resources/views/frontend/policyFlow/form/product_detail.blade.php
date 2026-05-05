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
                            <div class="jbl-field"><input required type="text" name="term" class="jbl-dynamic-input"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>Sum Assured (زرِ بیمہ)<span class="requi">*</span></label>
                            <div class="jbl-field"><input required type="text" name="sum_assured" class="jbl-dynamic-input"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 px-0 px-sm-3">
                <div>
                    <div>
                        <div><label>IS ND APPLIED? (YES/NO)<span class="requi">*</span></label>
                            <div class="jbl-field">
                                <select name="is_nd_applied" class="form-control jbl-dynamic-input">
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
                                <select name="payment_mode" class="form-control jbl-dynamic-input">
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
                                <select name="automatic_paid_up" class="form-control jbl-dynamic-input">
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
                                <select name="automatic_premium_loan" class="form-control jbl-dynamic-input">
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
                                <select name="aib_rider" class="form-control jbl-dynamic-input">
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
                                <select name="adb_rider" class="form-control jbl-dynamic-input">
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
                                <select name="tir_rider" class="form-control jbl-dynamic-input">
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
                                <select name="fib_rider" class="form-control jbl-dynamic-input">
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

        let product_id = $('#product_id').val();
        let age_birth = $('#age_birth').val();
        $.ajax({
            method: 'POST',
            url: '{{ route("frontend.getPlanData") }}',
            data: {
                product_id: product_id,
                age: age_birth,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                console.log(res);
                alert("ok");
            }
        });
    });
</script>
@endpush