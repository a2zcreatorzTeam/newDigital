@extends('backend.layout.master')

@section('content')

<style>
    .profile-wrapper {
        background: #f4f6f9;
        padding: 20px;
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
    }

    .profile-header p {
        margin: 5px 0 0;
        opacity: .9;
        font-size: 14px;
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
</style>

<section id="section-dashboard" class="profile-wrapper">

    <div class="profile-card">

        {{-- Header --}}
        <div class="profile-header d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2>Policy Detail</h2>
                <p>Complete information of policy holder and insurance profile</p>
            </div>

            <div class="mt-2 mt-md-0">
                @if($data->status == 'Approved')
                        <span class="badge bg-success">
                            Approved
                        </span>
                @elseif($data->status == 'Rejected')
                        <span class="badge bg-danger">
                            Rejected
                        </span>
                @else
                        <span class="badge bg-warning">
                            {{ ucfirst($data->status) }}
                        </span>
                @endif
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
                            <h4>PKR 5,000,000</h4>
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
                        <div class="detail-value text-success">{{ $data->status ?? '---' }}</div>
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


                <div class="col-md-3 mb-3">
                    <div class="detail-box">
                        <div class="detail-label">Automatic Paid-Up </div>
                        <div class="detail-value">{{ $data->automatic_paid_up ?? '---' }}</div>
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
                        <div class="detail-label">Is Businessman</div>
                        <div class="detail-value">{{ $data->is_business ?? '---' }}</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="detail-box">
                        <div class="detail-label">If holding Land?</div>
                        <div class="detail-value">{{ $data->is_holding_land ?? '---' }}</div>
                    </div>
                </div>



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
                        <div class="detail-label">Reason of Increase Weight</div>
                        <div class="detail-value">{{ $data->weight_increase_reason ?? '---' }}</div>
                    </div>
                </div>



            </div>
            
            <div class="custom-divider"></div>
            @if($data->status == 'Approved' || $data->status == 'Rejected')

            <div class="section-title">
                Approval Information
            </div>

            <div class="row">

                {{-- Status --}}
                <div class="col-md-4 mb-3">
                    <div class="detail-box">

                        <div class="detail-label">
                            Status
                        </div>

                        <div class="detail-value">
                            @if($data->status == 'Approved')
                                <span class="badge bg-success">
                                    Approved
                                </span>
                            @elseif($data->status == 'Rejected')
                                <span class="badge bg-danger">
                                    Rejected
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    {{ ucfirst($data->status) }}
                                </span>
                            @endif
                        </div>

                    </div>
                </div>

            {{-- Updated By --}}
            <div class="col-md-4 mb-3">
                <div class="detail-box">

                    <div class="detail-label">
                        Updated By
                    </div>

                    <div class="detail-value">
                        {{ $data->StatusUpdatedBy->name ?? '---' }}
                    </div>

                </div>
            </div>

            {{-- Updated At --}}
            <div class="col-md-4 mb-3">
                <div class="detail-box">

                    <div class="detail-label">
                        Updated At
                    </div>

                    <div class="detail-value">
                        {{ $data->updated_at ? $data->updated_at->format('d M Y h:i A') : '---' }}
                    </div>

                </div>
            </div>

            {{-- Comment --}}
            <div class="col-md-12 mb-3">
                <div class="detail-box">

                    <div class="detail-label">
                        Admin Comment
                    </div>

                    <div class="detail-value">
                        {{ $data->admin_comment ?? '---' }}
                    </div>

                </div>
            </div>

            </div>

        @else
            {{-- Approval Section --}}
            <div class="section-title">
                Approval Action
            </div>

            <form action="{{ route('user.policy.markStatus', $data->id) }}" method="POST">
                @csrf

                <div class="row">

                    {{-- Status --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Select Status</label>

                        <select name="status" class="form-select" required>
                            <option value="" disabled selected>Select Status</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                    </div>

                    {{-- Comment --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-semibold">Comment</label>

                        <textarea
                            name="admin_comment"
                            rows="5"
                            class="form-control"
                            placeholder="Write your comment here..."
                        ></textarea>
                    </div>
                    @can('userPolicy-status-update')
                    {{-- Buttons --}}
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fa-solid fa-check"></i> Submit
                        </button>
                    </div>
                    @endcan

                </div>
            </form>
        @endif
        </div>
    </div>

</section>

@endsection