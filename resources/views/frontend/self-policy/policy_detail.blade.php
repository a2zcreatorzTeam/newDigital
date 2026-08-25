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

                    <a href="{{ route('frontend.policyDetail.pdf', encrypt($data->id)) }}"
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
                                <h5>{{ policy_label('policy_number') }}</h5>
                                <h4>{{ $data->policy_id ?? '---' }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="summary-item">
                                <h5>{{ policy_label('plan_name') }}</h5>
                                <h4>{{ $data->product->name ?? '---' }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mb-md-0">
                            <div class="summary-item">
                                <h5>{{ policy_label('sum_assured') }}</h5>
                                <h4>{{ number_format($data->sum_assured) ?? '---' }}</h4>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="summary-item">
                                <h5>{{ policy_label('policy_term') }}</h5>
                                <h4>{{ $data->term ?? '---' }} Years</h4>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Personal Information --}}
                <div class="section-title">
                {{ policy_label('personal_information') }}
                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('life_proposed_full_name') }}</div>
                            <div class="detail-value">{{ $data->life_proposed_full_name ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('mobile_number_personal') }}</div>
                            <div class="detail-value">{{ $data->mobile_number ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('cnic_bform') }}</div>
                            <div class="detail-value">{{ $data->cnic_number ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('cnic_issue_date') }}</div>
                            <div class="detail-value">{{ $data->cnic_issue_date ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('cnic_expiry_date') }}</div>
                            <div class="detail-value">{{ $data->cnic_expiry_date ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('date_of_birth') }}</div>
                            <div class="detail-value">{{ $data->date_of_birth ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('place_of_birth') }}</div>
                            <div class="detail-value">{{ $data->birth_placed ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('age_nearest_birthdate') }}</div>
                            <div class="detail-value">{{ $data->age_nearest_date ?? '---' }}
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('gender') }}</div>
                            <div class="detail-value">{{ $data->gender ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('marital_status') }}</div>
                            <div class="detail-value">{{ $data->marital_status ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('mother_maiden_name') }}</div>
                            <div class="detail-value">{{ $data->mother_maiden_name ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('father_name_of_life_proposed') }}</div>
                            <div class="detail-value">{{ $data->father_name ?? '---' }}</div>
                        </div>
                    </div>

                    @if(($data->marital_status ?? '') === 'Married' && ($data->gender ?? '') === 'Male')
                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('wife_name') }}</div>
                            <div class="detail-value">{{ $data->wife_name ?? '---' }}</div>
                        </div>
                    </div>
                    @elseif(($data->marital_status ?? '') === 'Married' && ($data->gender ?? '') === 'Female')
                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('husband_name') }}</div>
                            <div class="detail-value">{{ $data->husband_name ?? '---' }}</div>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('religion') }}</div>
                            <div class="detail-value">{{ $data->religion ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('email_address') }}</div>
                            <div class="detail-value">{{ $data->user_email ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('age_proof') }}</div>
                            <div class="detail-value">{{ $data->age_proof ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('phone_office') }}</div>
                            <div class="detail-value">{{ $data->phone_number_office ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('phone_residential') }}</div>
                            <div class="detail-value">{{ $data->phone_number_residente ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('country_of_residence') }}</div>
                            <div class="detail-value">{{ optional($data->countryOfResidence)->name ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('current_address') }}</div>
                            <div class="detail-value">{{ $data->current_address ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('is_dual_national') }}</div>
                            <div class="detail-value">{{ $data->is_client_dual_national ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('primary_nationality') }}</div>
                            <div class="detail-value">{{ $data->is_client_dual_national == 'No' ? 'Pakistani' : ($data->primary_nationality ?? '---') }}</div>
                        </div>
                    </div>
                    @if( $data->is_client_dual_national=='Yes')
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('dual_nationality_country') }}</div>
                            <div class="detail-value">{{ optional($data->dualNationalityCountry)->name ?? $data->dual_nationality_country ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('tax_tin_number') }}</div>
                            <div class="detail-value">{{ $data->dual_tax_tin_number ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('mobile_number') }}</div>
                            <div class="detail-value">{{ $data->dual_mobile_number ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('address') }}</div>
                            <div class="detail-value">{{ $data->dual_address ?? '---' }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('passport_number') }}</div>
                            <div class="detail-value">{{ $data->dual_passport_number ?? '---' }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('is_same_person') }}</div>
                            <div class="detail-value">{{ $data->is_same_person ?? '---' }}</div>
                        </div>
                    </div>
                    @include('frontend.partials.life_proposed_detail_fields', ['data' => $data])



                </div>

                <div class="custom-divider"></div>

                {{-- Policy Information --}}
                <div class="section-title">
                {{ policy_label('policy_information') }}
                </div>

                <div class="row">

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('policy_status') }}</div>
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
                            <div class="detail-label">{{ policy_label('table') }}</div>
                            <div class="detail-value">{{ $data->table_no ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('term') }}</div>
                            <div class="detail-value">{{ $data->term ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('sum_assured') }}</div>
                            <div class="detail-value">{{ $data->sum_assured ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('is_nd_applied') }}</div>
                            <div class="detail-value">{{ $data->is_nd_applied ?? '---' }}</div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('payment_mode') }}</div>
                            <div class="detail-value">{{ $data->payment_mode ?? '---' }}</div>
                        </div>
                    </div>


                    {{-- <div class="col-md-3 mb-3">
                        <div class="detail-box">
                            <div class="detail-label">{{ policy_label('automatic_paid_up') }}</div>
                            <div class="detail-value">{{ $data->automatic_paid_up ?? '---' }}
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="detail-box">
                <div class="detail-label">{{ policy_label('automatic_premium_loan') }}</div>
                <div class="detail-value">{{ $data->automatic_premium_loan ?? '---' }}</div>
            </div>
        </div>


        <div class="col-md-3 mb-3">
            <div class="detail-box">
                <div class="detail-label">{{ policy_label('aib_rider') }}</div>
                <div class="detail-value">{{ $data->aib_rider ?? '---' }}</div>
            </div>
        </div>
        --}}

        <div class="col-md-3 mb-3">
            <div class="detail-box">
                <div class="detail-label">{{ policy_label('adb_rider') }}</div>
                <div class="detail-value">{{ $data->adb_rider ?? '---' }}</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="detail-box">
                <div class="detail-label">{{ policy_label('tir_rider') }}</div>
                <div class="detail-value">{{ $data->tir_rider ?? '---' }}</div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="detail-box">
                <div class="detail-label">{{ policy_label('fib_rider') }}</div>
                <div class="detail-value">{{ $data->fib_rider ?? '---' }}</div>
            </div>
        </div>



        </div>

        <div class="custom-divider"></div>

        {{-- Address Details --}}
        <div class="section-title">
                {{ policy_label('address_details') }}
        </div>

        <div class="row">
            <h6 class="">{{ policy_label('permanent_address') }}</h6>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('province') }}</div>
                    <div class="detail-value">
                        {{ $data->get_permanent_province->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('city') }}</div>
                    <div class="detail-value">
                        {{ $data->get_permanent_city->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('district') }}</div>
                    <div class="detail-value">
                        {{ $data->get_permanent_district->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('address') }}</div>
                    <div class="detail-value">
                        {{ $data->permanent_address ?? '---' }}
                    </div>
                </div>
            </div>



        </div>
        <div class="row">
            <h6 class="">{{ policy_label('correspondence_address') }}</h6>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('province') }}</div>
                    <div class="detail-value">
                        {{ $data->get_corres_province->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('city') }}</div>
                    <div class="detail-value">
                        {{ $data->get_corres_city->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('district') }}</div>
                    <div class="detail-value">
                        {{ $data->get_corres_district->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('address') }}</div>
                    <div class="detail-value">
                        {{ $data->corres_address ?? '---' }}
                    </div>
                </div>
            </div>



        </div>
        <div class="row">
            <h6 class="">{{ policy_label('temporary_address') }}</h6>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('province') }}</div>
                    <div class="detail-value">
                        {{ $data->get_temp_province->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('city') }}</div>
                    <div class="detail-value">
                        {{ $data->get_temp_city->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('district') }}</div>
                    <div class="detail-value">
                        {{ $data->get_temp_district->name ?? '---' }}
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('address') }}</div>
                    <div class="detail-value">
                        {{ $data->temp_address ?? '---' }}
                    </div>
                </div>
            </div>



        </div>

        <div class="custom-divider"></div>

        {{-- Occupation & Income --}}
        <div class="section-title">
                {{ policy_label('occupation_income') }}
        </div>

        <div class="row">

            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('is_employment') }}</div>
                    <div class="detail-value">{{ $data->is_emaployemnt ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('designation') }}</div>
                    <div class="detail-value">{{ $data->employment_designation ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('company_name') }}</div>
                    <div class="detail-value">{{ $data->employment_company_name ?? '---' }}</div>
                </div>
            </div>




            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('is_businessman') }}</div>
                    <div class="detail-value">{{ $data->is_business ?? '---' }}</div>
                </div>
            </div>
            @if($data->is_business=='Yes')
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('business_name') }}</div>
                    <div class="detail-value">{{ $data->business_name ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('nature_of_business') }}</div>
                    <div class="detail-value">{{ $data->nature_of_business ?? '---' }}</div>
                </div>
            </div>
            @endif

            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('filer_status') }}</div>
                    <div class="detail-value">{{ $data->filer_status ?? '---' }}</div>
                </div>
            </div>
            @if(($data->filer_status ?? '') === 'Filer')
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('ntn_number') }}</div>
                    <div class="detail-value">{{ $data->ntn_number ?? '---' }}</div>
                </div>
            </div>
            @endif

            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('holding_land') }}</div>
                    <div class="detail-value">{{ $data->is_holding_land ?? '---' }}</div>
                </div>
            </div>
            @if($data->is_holding_land=='Yes')
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('land_unit') }}</div>
                    <div class="detail-value">{{ $data->land_unit ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('total_area') }}</div>
                    <div class="detail-value">{{ $data->total_acreage ?? '---' }}{{ !empty($data->land_unit) ? ' ' . $data->land_unit : '' }}</div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('land_location') }}</div>
                    <div class="detail-value">{{ $data->land_location ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('land_type') }}</div>
                    <div class="detail-value">{{ $data->land_type ?? '---' }}</div>
                </div>
            </div>
            @endif
            <div class="col-md-4 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('average_monthly_income') }}</div>
                    <div class="detail-value">PKR {{ $data->avaerage_monthly_income ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('ex_defence') }}</div>
                    <div class="detail-value">{{ $data->ex_defence_personal ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('discharged_medical') }}</div>
                    <div class="detail-value">{{ $data->discharged_on_medical ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('hazardous_occupation') }}</div>
                    <div class="detail-value">{{ $data->hazardous_occupation ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('comments') }}</div>
                    <div class="detail-value">{{ $data->comment ?? '---' }}</div>
                </div>
            </div>

        </div>

        <div class="custom-divider"></div>




        {{-- Voucher Information --}}
        <div class="section-title">
                {{ policy_label('payment_information') }}
        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('consumer_no') }}</div>
                    <div class="detail-value">{{ $data->voucher->consumer_number  ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('amount_within_due_date') }}</div>
                    <div class="detail-value">{{ number_format($data->voucher->amount_within_due_date)  ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('amount_after_due_date') }}</div>
                    <div class="detail-value">{{ number_format($data->voucher->amount_after_due_date)  ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('due_date') }}</div>
                    <div class="detail-value">{{ $data->voucher->due_date  ?? '---' }}</div>
                </div>
            </div>









        </div>


        {{-- Family History Information --}}
        <div class="section-title mt-4">
                {{ policy_label('family_history_information') }}
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
                                <small class="text-muted d-block">{{ policy_label('current_age') }}</small>
                                <strong>{{ $member->age ?? '---' }}</strong>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="text-muted d-block">{{ policy_label('state_of_health') }}</small>
                                <strong>{{ $member->state_of_health ?? '---' }}</strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">{{ policy_label('year_of_death') }}</small>
                                <span>{{ $member->year_of_death ?? '---' }}</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">{{ policy_label('age_of_death') }}</small>
                                <span>{{ $member->age_of_death ?? '---' }}</span>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">{{ policy_label('cause_of_death') }}</small>
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
                {{ policy_label('female_section') }}
        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('date_of_last_delivery') }}</div>
                    <div class="detail-value">{{ $data->date_of_last_delivery ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('miscarriage_dates') }}</div>
                    <div class="detail-value">{{ \App\Support\MiscarriageDates::display($data->miscarriage_dates ?? null) }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('are_you_pregnant') }}</div>
                    <div class="detail-value">{{ $data->is_pregnant ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('caesarean_details') }}</div>
                    <div class="detail-value">{{ $data->caesarean_details ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('lmp_date') }}</div>
                    <div class="detail-value">{{ $data->lmp_date ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('female_disease_history') }}</div>
                    <div class="detail-value">{{ $data->female_disease_history ?? '---' }}</div>
                </div>
            </div>

            @if(($data->female_disease_history ?? '') === 'Yes')
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('female_disease') }}</div>
                    <div class="detail-value">{{ \App\Support\FemaleDiseases::name($data->female_disease_name) ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('description') }}</div>
                    <div class="detail-value">{{ \App\Support\FemaleDiseases::details($data->female_disease_name) ?? '---' }}</div>
                </div>
            </div>
            @endif

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('self_monthly_income') }}</div>
                    <div class="detail-value">{{ $data->self_monthly_income ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('husband_monthly_income') }}</div>
                    <div class="detail-value">{{ $data->husband_monthly_income ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('qualification') }}</div>
                    <div class="detail-value">{{ $data->qualification ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('tax_paid') }}</div>
                    <div class="detail-value">{{ $data->pays_tax_land_revenue ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('husband_policy_no') }}</div>
                    <div class="detail-value">{{ $data->husband_policy_no ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('husband_zone_company') }}</div>
                    <div class="detail-value">{{ $data->husband_zone_company ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('husband_sum_assured') }}</div>
                    <div class="detail-value">{{ $data->husband_sum_assured ?? '---' }}</div>
                </div>
            </div>

        </div>



        {{-- Nominee Information --}}
        <div class="section-title">
                {{ policy_label('nominee_information') }}
        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('nominee_name') }}</div>
                    <div class="detail-value">{{ $data->nominee_name ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('nominee_cnic') }}</div>
                    <div class="detail-value">{{ $data->nominee_cnic ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('nominee_age') }}</div>
                    <div class="detail-value">{{ $data->nominee_age ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('relationship_with_you') }}</div>
                    <div class="detail-value">{{ $data->nominee_relationship ?? '---' }}</div>
                </div>
            </div>

            @php
                $isMinorNominee = filled($data->nominee_age) && (int) $data->nominee_age < 18;
            @endphp
            @if($isMinorNominee)
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('appointee_name') }}</div>
                    <div class="detail-value">{{ $data->appointee_name ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('appointee_relationship') }}</div>
                    <div class="detail-value">{{ $data->appointee_relationship ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('appointee_cnic') }}</div>
                    <div class="detail-value">{{ $data->appointee_cnic ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('appointee_mobile') }}</div>
                    <div class="detail-value">{{ $data->appointee_mobile ?? '---' }}</div>
                </div>
            </div>
            @endif

        </div>



        {{-- Documents --}}
        <div class="section-title">
                {{ policy_label('documents') }}
        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('proposer_cnic_front') }}</div>
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
                    <div class="detail-label">{{ policy_label('proposer_cnic_back') }}</div>
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

            @if(($data->is_same_person ?? '') === 'No')
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('life_proposed_document') }}</div>
                    <div class="detail-value">
                        @if($data->life_proposed_document)
                        <a href="{{ asset('uploads/policy_documents/'.$data->life_proposed_document) }}" target="_blank">
                            <img src="{{ asset('uploads/policy_documents/'.$data->life_proposed_document) }}"
                                alt="Life Proposed Document"
                                class="img-fluid rounded"
                                style="max-height:120px;">
                        </a>
                        @else
                        ---
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('nominee_document') }}</div>
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
                    <div class="detail-label">{{ policy_label('proposer_photo') }}</div>
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
                    <div class="detail-label">{{ policy_label('income_proof') }}</div>
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

        </div>










        {{-- Health Information --}}
        <div class="section-title">
                {{ policy_label('health_information') }}
        </div>

        <div class="row">

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('height_cm') }}</div>
                    <div class="detail-value">{{ $data->height_cm ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('height_ft') }}</div>
                    <div class="detail-value">{{ $data->height_ft ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('weight_kg') }}</div>
                    <div class="detail-value">{{ $data->weight_kg ?? '---' }}</div>
                </div>
            </div>



            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('chest_inspiration') }}</div>
                    <div class="detail-value">{{ $data->chest_insp_cm ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('chest_inspiration') }}</div>
                    <div class="detail-value">{{ $data->chest_insp_inches ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('chest_expansion') }}</div>
                    <div class="detail-value">{{ $data->chest_exp_cm ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('chest_expansion') }}</div>
                    <div class="detail-value">{{ $data->chest_exp_inches ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('abdomen') }}</div>
                    <div class="detail-value">{{ $data->abdomen_cm ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('abdomen') }}</div>
                    <div class="detail-value">{{ $data->abdomen_inches ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('expected_weight_loss') }}</div>
                    <div class="detail-value">{{ $data->weight_loss_kg ?? '---' }}</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('expected_weight_gain') }}</div>
                    <div class="detail-value">{{ $data->weight_gain_kg ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('daily_consumption') }}</div>
                    <div class="detail-value">{{ $data->daily_consumption ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('physical_impairments') }}</div>
                    <div class="detail-value">{{ $data->physical_impairments ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('last_illness_injury') }}</div>
                    <div class="detail-value">{{ $data->last_illness_injury ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('medical_investigations') }}</div>
                    <div class="detail-value">{{ $data->medical_investigations ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('medical_history') }}</div>
                    <div class="detail-value">{{ $data->medical_history ?? '---' }}</div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="detail-box">
                    <div class="detail-label">{{ policy_label('reason_weight_change') }}</div>
                    <div class="detail-value">{{ $data->weight_increase_reason ?? '---' }}</div>
                </div>
            </div>



        </div>




        </div>

        </div>

    </section>
</main>
@endsection
