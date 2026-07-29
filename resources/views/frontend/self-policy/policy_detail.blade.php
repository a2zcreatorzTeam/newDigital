@extends('frontend.layout.master')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


<style>
    .profile-wrapper {
        background: #f4f6f9;
        padding: 20px;
        margin: 73px;
    }

    .profile-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
        border: 1px solid #e9ecef;
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(90deg, #0d47a1, #1565c0);
        padding: 25px 30px;
        color: #fff;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #fff
    }

    .profile-header p {
        margin: 5px 0 0;
        opacity: .9;
        font-size: 14px;
        color: #f8ffff;
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #0d47a1;
        margin-bottom: 20px;
        border-left: 4px solid #0d47a1;
        padding-left: 12px;
    }

    .detail-box {
        background: #fafbfc;
        border: 1px solid #edf0f2;
        border-radius: 10px;
        padding: 14px 16px;
        height: 100%;
        transition: .2s;
    }

    .detail-box:hover {
        border-color: #0d6efd;
        box-shadow: 0 2px 10px rgba(13, 110, 253, 0.08);
    }

    .detail-label {
        font-size: 12px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        margin-bottom: 6px;
    }

    .detail-value {
        font-size: 15px;
        font-weight: 600;
        color: #212529;
        word-break: break-word;
    }

    .badge-status {
        background: #e8f5e9;
        color: #2e7d32;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
    }

    .policy-summary {
        background: #f8fbff;
        border: 1px solid #dbe9ff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .summary-item h5 {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 8px;
        text-transform: uppercase;
        font-weight: 600;
    }

    .summary-item h4 {
        font-size: 20px;
        font-weight: 700;
        color: #0d47a1;
        margin: 0;
    }

    .custom-divider {
        border-top: 1px dashed #d7dce1;
        margin: 30px 0;
    }

    @media(max-width:768px) {
        .profile-header h2 {
            font-size: 22px;
        }
    }

    .btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 1rem 1.2rem !important;
        border-radius: var(--radius-md) !important;
        font-size: 0.875rem !important;
        border: none !important;
        font-weight: 500 !important;
        cursor: pointer !important;
        transition: var(--transition) !important;
    }
</style>
<!-- header-area-start -->
<link rel="stylesheet" href="{{ asset('frontend/css/sub-header.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/profile.css') }}">

<!-- header-area-end -->

<main class="fix">
    <section id="section-dashboard" class="profile-wrapper">

        <div class="profile-card">

            {{-- Header --}}
            <div class="profile-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2>Policy Detail</h2>
                    <p>Complete information of policy holder and insurance profile</p>
                </div>

                <!-- Right Actions -->
                <div class="d-flex align-items-center gap-2 flex-wrap">

                    <a href="{{ route('user.policy.download.pdf', $data->id) }}"
                        class="btn  btn-sm px-3 py-2 rounded-3 shadow-sm" style="background: #e65f97;">
                        <i class="fa-solid fa-download me-1"></i>
                        Download PDF
                    </a>


                </div>
            </div>


            <div class="p-4">

                {{-- Policy Summary --}}
                <div class="policy-summary">
                    <div class="row">

                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="summary-item">
                                <h5>Policy Number</h5>
                                <h4>{{ $data->policy_id ?? '---' }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="summary-item">
                                <h5>Plan Name</h5>
                                <h4>{{ $data->product->name ?? '---' }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="summary-item">
                                <h5>Sum Assured</h5>
                                <h4>{{ number_format($data->sum_assured) ?? '---' }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="summary-item">
                                <h5>Policy Term</h5>
                                <h4>{{ $data->term ?? '---' }} Years</h4>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Personal Information --}}
                <div class="section-title">
                    Personal Information
                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Life Proposed Full Name </div>
                            <div class="detail-value">{{ $data->life_proposed_full_name ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Mobile Number Personal</div>
                            <div class="detail-value">{{ $data->mobile_number ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">CNIC / B-FORM NO </div>
                            <div class="detail-value">{{ $data->cnic_number ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Cnic Issue Date</div>
                            <div class="detail-value">{{ $data->cnic_issue_date ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Cnic Expiry Date</div>
                            <div class="detail-value">{{ $data->cnic_expiry_date ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Date Of Birth </div>
                            <div class="detail-value">{{ $data->date_of_birth ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Age Nearest Birth-date</div>
                            <div class="detail-value">{{ $data->age_nearest_date ?? '---' }}
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Gender/Sex </div>
                            <div class="detail-value">{{ $data->gender ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Mother Maiden Name</div>
                            <div class="detail-value">{{ $data->mother_maiden_name ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Father’s Name of Life Proposed</div>
                            <div class="detail-value">{{ $data->father_name ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Husband Name of Life Proposed</div>
                            <div class="detail-value">{{ $data->husband_name ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Religion</div>
                            <div class="detail-value">{{ $data->religion ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Email Address</div>
                            <div class="detail-value">{{ $data->user_email ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Age Proof</div>
                            <div class="detail-value">{{ $data->age_proof ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Phone Number Office</div>
                            <div class="detail-value">{{ $data->phone_number_office ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Phone Number Residential </div>
                            <div class="detail-value">{{ $data->phone_number_residente ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Fax No</div>
                            <div class="detail-value">{{ $data->fax_number ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Is Client Dual National? </div>
                            <div class="detail-value">{{ $data->is_client_dual_national ?? '---' }}</div>
                        </div>
                    </div>

                    @if( $data->is_client_dual_national=='Yes')
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Primary Nationality</div>
                            <div class="detail-value">{{ $data->primary_nationality ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Dual Nationality</div>
                            <div class="detail-value">{{ $data->dual_nationality ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Dual Nationality Country</div>
                            <div class="detail-value">{{ $data->dual_nationality_country ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Dual Nationality Passport Number</div>
                            <div class="detail-value">{{ $data->dual_passport_number ?? '---' }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Birth Place</div>
                            <div class="detail-value">{{ $data->birth_placed ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Proposer & Life Proposed are same</div>
                            <div class="detail-value">{{ $data->is_same_person ?? '---' }}</div>
                        </div>
                    </div>
                    @if($data->is_same_person=='No')
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Life Proposed Name</div>
                            <div class="detail-value">{{ $data->life_proposed_name ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Life Proposed CNIC</div>
                            <div class="detail-value">{{ $data->life_proposed_cnic ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Life Proposed DOB</div>
                            <div class="detail-value">{{ $data->life_proposed_dob ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Life Proposed RelationShip</div>
                            <div class="detail-value">{{ $data->life_proposed_relationship ?? '---' }}</div>
                        </div>
                    </div>
                    @endif



                </div>

                <div class="custom-divider"></div>

                {{-- Policy Information --}}
                <div class="section-title">
                    Policy Information
                </div>

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Policy Status</div>
                            <div class="detail-value ">
                                <!-- Status Badge -->
                                <span style="
                                padding:4px 11px;
                                border-radius:30px;
                                font-size:11px;
                                font-weight:600;
                                letter-spacing:0.5px;
                                background-color:
                                            {{ $data->status == 'Approved' ? '#95f0b8' : 
                                            ($data->status == 'Pending' ? '#cdeaff' : 
                                            ($data->status == 'Rejected' ? '#f1c2c7' :
                                            ($data->status == 'InCart' ? '#f6ca90' : '#edf19e'))) }};">
                                    {{ $data->status ?? '---' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Table</div>
                            <div class="detail-value">{{ $data->table_no ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Term</div>
                            <div class="detail-value">{{ $data->term ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Sum Assured</div>
                            <div class="detail-value">{{ $data->sum_assured ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">IS ND APPLIED</div>
                            <div class="detail-value">{{ $data->is_nd_applied ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Payment Mode</div>
                            <div class="detail-value">{{ $data->payment_mode ?? '---' }}</div>
                        </div>
                    </div>


                    {{-- <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">Automatic Paid-Up </div>
                            <div class="detail-value">{{ $data->automatic_paid_up ?? '---' }}
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="detail-box">
                <div class="detail-label">Automatic Premium Loan </div>
                <div class="detail-value">{{ $data->automatic_premium_loan ?? '---' }}</div>
            </div>
        </div>


        <div class="col-md-3 mb-3">
            <div class="detail-box">
                <div class="detail-label">Accidental Death & Indemnity Benefit (AIB) </div>
                <div class="detail-value">{{ $data->aib_rider ?? '---' }}</div>
            </div>
        </div>
        --}}

        <div class="col-md-3 mb-3">
            <div class="detail-box">
                <div class="detail-label">Accidental Death Benefit (ADB)</div>
                <div class="detail-value">{{ $data->adb_rider ?? '---' }}</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="detail-box">
                <div class="detail-label">Term Insurance Rider (TIR) </div>
                <div class="detail-value">{{ $data->tir_rider ?? '---' }}</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="detail-box">
                <div class="detail-label">Family Income Benefit (FIB) </div>
                <div class="detail-value">{{ $data->fib_rider ?? '---' }}</div>
            </div>
        </div>



        </div>

        <div class="custom-divider"></div>

        {{-- Address Information --}}
        <div class="section-title">
            Address Information
        </div>

        <div class="row">
            <h6 class="">Permanent Address</h6>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Province</div>
                    <div class="detail-value">
                        {{ $data->get_permanent_province->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">City</div>
                    <div class="detail-value">
                        {{ $data->get_permanent_city->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">District</div>
                    <div class="detail-value">
                        {{ $data->get_permanent_district->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Address</div>
                    <div class="detail-value">
                        {{ $data->permanent_address ?? '---' }}
                    </div>
                </div>
            </div>



        </div>
        <div class="row">
            <h6 class="">Correspondence Address</h6>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Province</div>
                    <div class="detail-value">
                        {{ $data->get_corres_province->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">City</div>
                    <div class="detail-value">
                        {{ $data->get_corres_city->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">District</div>
                    <div class="detail-value">
                        {{ $data->get_corres_district->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Address</div>
                    <div class="detail-value">
                        {{ $data->corres_address ?? '---' }}
                    </div>
                </div>
            </div>



        </div>
        <div class="row">
            <h6 class="">Temporary Address</h6>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Province</div>
                    <div class="detail-value">
                        {{ $data->get_temp_province->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">City</div>
                    <div class="detail-value">
                        {{ $data->get_temp_city->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">District</div>
                    <div class="detail-value">
                        {{ $data->get_temp_district->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Address</div>
                    <div class="detail-value">
                        {{ $data->temp_address ?? '---' }}
                    </div>
                </div>
            </div>



        </div>

        <div class="custom-divider"></div>

        {{-- Occupation & Income --}}
        <div class="section-title">
            Occupation & Income
        </div>

        <div class="row">

            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Is Employment?</div>
                    <div class="detail-value">{{ $data->is_emaployemnt ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Employment Designation</div>
                    <div class="detail-value">{{ $data->employment_designation ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Company Name</div>
                    <div class="detail-value">{{ $data->employment_company_name ?? '---' }}</div>
                </div>
            </div>




            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Is Businessman</div>
                    <div class="detail-value">{{ $data->is_business ?? '---' }}</div>
                </div>
            </div>
            @if($data->is_business=='Yes')
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Business Name</div>
                    <div class="detail-value">{{ $data->business_name ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Nature Of Business</div>
                    <div class="detail-value">{{ $data->nature_of_business ?? '---' }}</div>
                </div>
            </div>
            @endif

            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">If holding Land?</div>
                    <div class="detail-value">{{ $data->is_holding_land ?? '---' }}</div>
                </div>
            </div>
            @if($data->is_holding_land=='Yes')
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Total Acreage Owned</div>
                    <div class="detail-value">{{ $data->total_acreage ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Land Location</div>
                    <div class="detail-value">{{ $data->land_location ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Land Type</div>
                    <div class="detail-value">{{ $data->land_type ?? '---' }}</div>
                </div>
            </div>
            @endif
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Average monthly income </div>
                    <div class="detail-value">PKR {{ $data->avaerage_monthly_income ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">If Defence or Ex-Defence Personal, commercial Airline Flight Crew or plant protection pilot</div>
                    <div class="detail-value">{{ $data->ex_defence_personal ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Have you ever been discharged on medical grounds from service / employeement</div>
                    <div class="detail-value">{{ $data->discharged_on_medical ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Are you presently engaged or intent to engage in any hazardous occupation or pastime</div>
                    <div class="detail-value">{{ $data->hazardous_occupation ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Comments</div>
                    <div class="detail-value">{{ $data->comment ?? '---' }}</div>
                </div>
            </div>

        </div>

        <div class="custom-divider"></div>




        {{-- Voucher Information --}}
        <div class="section-title">
            Payment Information
        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Consumer No</div>
                    <div class="detail-value">{{ $data->voucher->consumer_number  ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Amount With In Due Date</div>
                    <div class="detail-value">{{ number_format($data->voucher->amount_within_due_date)  ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Amount After Date</div>
                    <div class="detail-value">{{ number_format($data->voucher->amount_after_due_date)  ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Due Date</div>
                    <div class="detail-value">{{ $data->voucher->due_date  ?? '---' }}</div>
                </div>
            </div>









        </div>


        {{-- Family History Information --}}
        <div class="section-title mt-4">
            Family History Information
        </div>

        <div class="row">
            @if($data->family_history && $data->family_history->count() > 0)
            @foreach($data->family_history as $member)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light py-2">
                        <h6 class="mb-0 text-capitalize text-primary"><i class="fas fa-users me-2"></i>{{ $member->memner_flag }}</h6>
                    </div>
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="col-6 mb-2">
                                <small class="text-muted d-block">Current Age</small>
                                <strong>{{ $member->age ?? '---' }}</strong>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="text-muted d-block">State of Health</small>
                                <strong>{{ $member->state_of_health ?? '---' }}</strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Year of Death</small>
                                <span>{{ $member->year_of_death ?? '---' }}</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Age of Death</small>
                                <span>{{ $member->age_of_death ?? '---' }}</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Cause of Death</small>
                                <span>{{ $member->cause_of_death ?? '---' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="col-12">
                <p class="text-muted text-center py-3">No family history recorded for this policy.</p>
            </div>
            @endif
        </div>






        {{-- Female Information --}}
        <div class="section-title">
            Female Section
        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Date of Last Delivery</div>
                    <div class="detail-value">{{ $data->date_of_last_delivery ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Miscarriage Dates</div>
                    <div class="detail-value">{{ $data->miscarriage_dates ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Is Pregnant</div>
                    <div class="detail-value">{{ $data->is_pregnant ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Caesarean Details</div>
                    <div class="detail-value">{{ $data->caesarean_details ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">LMP Date</div>
                    <div class="detail-value">{{ $data->lmp_date ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Female Disease History</div>
                    <div class="detail-value">{{ $data->female_disease_history ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Self Monthly Income</div>
                    <div class="detail-value">{{ $data->self_monthly_income ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Husband Monthly Income</div>
                    <div class="detail-value">{{ $data->husband_monthly_income ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Qualification</div>
                    <div class="detail-value">{{ $data->qualification ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Pays Tax / Land Revenue</div>
                    <div class="detail-value">{{ $data->pays_tax_land_revenue ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Husband Policy No.</div>
                    <div class="detail-value">{{ $data->husband_policy_no ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Husband Zone / Company</div>
                    <div class="detail-value">{{ $data->husband_zone_company ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Husband Sum Assured</div>
                    <div class="detail-value">{{ $data->husband_sum_assured ?? '---' }}</div>
                </div>
            </div>

        </div>



        {{-- Nominee Information --}}
        <div class="section-title">
            Nominee Information
        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Nominee Name</div>
                    <div class="detail-value">{{ $data->nominee_name ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Nominee CNIC</div>
                    <div class="detail-value">{{ $data->nominee_cnic ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Nominee Age</div>
                    <div class="detail-value">{{ $data->nominee_age ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Nominee Relationship</div>
                    <div class="detail-value">{{ $data->nominee_relationship ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Appointee Name</div>
                    <div class="detail-value">{{ $data->appointee_name ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Appointee Relationship</div>
                    <div class="detail-value">{{ $data->appointee_relationship ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Appointee CNIC</div>
                    <div class="detail-value">{{ $data->appointee_cnic ?? '---' }}</div>
                </div>
            </div>

        </div>



        {{-- Documents --}}
        <div class="section-title">
            Documents
        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Proposer CNIC Front</div>
                    <div class="detail-value">
                        @if($data->proposer_cnic_front)
                        <a href="{{ asset('uploads/policy_documents/'.$data->proposer_cnic_front) }}" target="_blank">
                            <img src="{{ asset('uploads/policy_documents/'.$data->proposer_cnic_front) }}"
                                alt="Proposer CNIC Front"
                                class="img-fluid rounded"
                                style="max-height:120px;">
                        </a>
                        @else
                        ---
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Proposer CNIC Back</div>
                    <div class="detail-value">
                        @if($data->proposer_cnic_back)
                        <a href="{{ asset('uploads/policy_documents/'.$data->proposer_cnic_back) }}" target="_blank">
                            <img src="{{ asset('uploads/policy_documents/'.$data->proposer_cnic_back) }}"
                                alt="Proposer CNIC Back"
                                class="img-fluid rounded"
                                style="max-height:120px;">
                        </a>
                        @else
                        ---
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Nominee Document</div>
                    <div class="detail-value">
                        @if($data->nominee_document)
                        <a href="{{ asset('uploads/policy_documents/'.$data->nominee_document) }}" target="_blank">
                            <img src="{{ asset('uploads/policy_documents/'.$data->nominee_document) }}"
                                alt="Nominee Document"
                                class="img-fluid rounded"
                                style="max-height:120px;">
                        </a>
                        @else
                        ---
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Proposer Photo</div>
                    <div class="detail-value">
                        @if($data->proposer_photo)
                        <a href="{{ asset('uploads/policy_documents/'.$data->proposer_photo) }}" target="_blank">
                            <img src="{{ asset('uploads/policy_documents/'.$data->proposer_photo) }}"
                                alt="Proposer Photo"
                                class="img-fluid rounded"
                                style="max-height:120px;">
                        </a>
                        @else
                        ---
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Income Proof</div>
                    <div class="detail-value">
                        @if($data->income_proof)
                        <a href="{{ asset('uploads/policy_documents/'.$data->income_proof) }}" target="_blank">
                            <img src="{{ asset('uploads/policy_documents/'.$data->income_proof) }}"
                                alt="Income Proof"
                                class="img-fluid rounded"
                                style="max-height:120px;">
                        </a>
                        @else
                        ---
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Medical Reports</div>
                    <div class="detail-value">
                        @if($data->medical_reports)
                        <a href="{{ asset('uploads/policy_documents/'.$data->medical_reports) }}" target="_blank">
                            <img src="{{ asset('uploads/policy_documents/'.$data->medical_reports) }}"
                                alt="Medical Reports"
                                class="img-fluid rounded"
                                style="max-height:120px;">
                        </a>
                        @else
                        ---
                        @endif
                    </div>
                </div>
            </div>

        </div>










        {{-- Health Information --}}
        <div class="section-title">
            Health Information
        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Height In cm</div>
                    <div class="detail-value">{{ $data->height_cm ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Height In ft</div>
                    <div class="detail-value">{{ $data->height_ft ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Weight In Kg</div>
                    <div class="detail-value">{{ $data->weight_kg ?? '---' }}</div>
                </div>
            </div>



            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Chest Insp (cm)</div>
                    <div class="detail-value">{{ $data->chest_insp_cm ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Chest Insp (Inches)</div>
                    <div class="detail-value">{{ $data->chest_insp_inches ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Chest Exp (cm)</div>
                    <div class="detail-value">{{ $data->chest_exp_cm ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Chest Exp (Inches)</div>
                    <div class="detail-value">{{ $data->chest_exp_inches ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Abdomen (cm)</div>
                    <div class="detail-value">{{ $data->abdomen_cm ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Abdomen (Inches)</div>
                    <div class="detail-value">{{ $data->abdomen_inches ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Weight Loss (Kg)</div>
                    <div class="detail-value">{{ $data->weight_loss_kg ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Weight Gain (Kg)</div>
                    <div class="detail-value">{{ $data->weight_gain_kg ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Daily Consumption</div>
                    <div class="detail-value">{{ $data->daily_consumption ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Physical Impairments</div>
                    <div class="detail-value">{{ $data->physical_impairments ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Last Illness / Injury</div>
                    <div class="detail-value">{{ $data->last_illness_injury ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Medical Investigations</div>
                    <div class="detail-value">{{ $data->medical_investigations ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Medical History</div>
                    <div class="detail-value">{{ $data->medical_history ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">Reason for Weight Gain or Weight Loss</div>
                    <div class="detail-value">{{ $data->weight_increase_reason ?? '---' }}</div>
                </div>
            </div>



        </div>




        </div>

        </div>

    </section>
</main>
@endsection
