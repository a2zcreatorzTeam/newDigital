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
        display: block;
    }

    /* Required field indicator */
    .detail-label .required-asterisk {
        color: #dc3545;
        font-weight: 700;
        margin-left: 2px;
    }

    .detail-box .form-control,
    .detail-box .form-select {
        border: 1px solid #dfe3e8;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #212529;
        padding: 8px 10px;
    }

    .detail-box .form-control:focus,
    .detail-box .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 .15rem rgba(13,110,253,.15);
    }

    .custom-divider {
        border-top: 1px dashed #d7dce1;
        margin: 30px 0;
    }

    .img-preview-box {
        position: relative;
        width: 100%;
        border: 1px dashed #c7ccd2;
        border-radius: 10px;
        padding: 10px;
        text-align: center;
        background: #fff;
    }

    .img-preview-box img {
        max-height: 120px;
        max-width: 100%;
        border-radius: 6px;
        margin-bottom: 8px;
        object-fit: cover;
    }

    .img-preview-box .no-img {
        height: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #adb5bd;
        font-size: 12px;
        border: 1px dashed #dee2e6;
        border-radius: 6px;
        margin-bottom: 8px;
    }

    .family-row {
        background: #fafbfc;
        border: 1px solid #edf0f2;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 15px;
        position: relative;
    }

    .remove-family-row {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        color: #dc3545;
        font-size: 16px;
    }

    .btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: .7rem 1.2rem !important;
        border-radius: 8px !important;
        font-size: 0.875rem !important;
        border: none !important;
        font-weight: 500 !important;
        cursor: pointer !important;
        transition: .2s !important;
    }

    @media(max-width:768px) {
        .profile-header h2 {
            font-size: 22px;
        }
    }
</style>

<link rel="stylesheet" href="{{ asset('frontend/css/sub-header.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/profile.css') }}">

<main class="fix">
    <section id="section-dashboard" class="profile-wrapper">

        <div class="profile-card">

            {{-- Header --}}
            <div class="profile-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2>Edit Policy</h2>
                    <p>Update policy holder and insurance profile information</p>
                </div>
                

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <a href="{{ route('frontend.self-policy', encrypt($data->id)) }}"
                        class="btn btn-sm px-3 py-2" style="background:#6c757d; color:#fff;">
                        <i class="fa-solid fa-arrow-left me-1"></i> Back to View
                    </a>
                </div>
            </div>

            <div class="p-4">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                @if($data->status == 'Rejected')
<div class="alert alert-danger mb-4">
    <h5 class="mb-2">
        <i class="fa-solid fa-circle-xmark me-2"></i>
        Policy Rejected
    </h5>

    <div class="row">
        <div class="col-md-3">
            <strong>Status</strong><br>
            <span class="badge bg-danger">
                {{ $data->status }}
            </span>
        </div>

        <div class="col-md-9">
            <strong>Admin Comment</strong>
            <div class="mt-2 p-3 bg-white border rounded">
                {{ $data->comment ?? 'No comment available.' }}
            </div>
        </div>
    </div>
</div>
@endif

                <form action="{{route('frontend.policyDetail.update',[$id])}}" method="POST" enctype="multipart/form-data" id="policyEditForm">
                    @csrf
                    @method('PUT')

                    {{-- Personal Information --}}
                    <div class="section-title">Personal Information</div>

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Life Proposed Full Name <span class="required-asterisk">*</span></label>
                                <input type="text" name="life_proposed_full_name" class="form-control" value="{{ old('life_proposed_full_name', $data->life_proposed_full_name) }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Mobile Number Personal <span class="required-asterisk">*</span></label>
                                <input type="text" name="mobile_number" id="mobile_number" class="form-control jbl-mobile-format" placeholder="0321-8976654" maxlength="12" inputmode="numeric" pattern="03[0-9]{2}-[0-9]{7}" value="{{ old('mobile_number', $data->mobile_number) }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">CNIC No <span class="required-asterisk">*</span></label>
                                <input type="text" name="cnic_number" id="cnic_number" class="form-control jbl-cnic-format" placeholder="42101-1234567-1" maxlength="15" inputmode="numeric" pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}" value="{{ old('cnic_number', $data->cnic_number) }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Cnic Issue Date</label>
                                <input type="date" name="cnic_issue_date" class="form-control" value="{{ old('cnic_issue_date', $data->cnic_issue_date) }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Cnic Expiry Date</label>
                                <input type="date" name="cnic_expiry_date" class="form-control" value="{{ old('cnic_expiry_date', $data->cnic_expiry_date) }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Date Of Birth <span class="required-asterisk">*</span></label>
                                <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $data->date_of_birth) }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Age Nearest Birth-date <span class="required-asterisk">*</span></label>
                                <input type="text" name="age_nearest_date" class="form-control" value="{{ old('age_nearest_date', $data->age_nearest_date) }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Gender/Sex <span class="required-asterisk">*</span></label>
                                <select name="gender" id="gender" class="form-select">
                                    <option value="">-- Select --</option>
                                    @foreach(['Male','Female','Other'] as $g)
                                    <option value="{{ $g }}" @selected(old('gender', $data->gender) == $g)>{{ $g }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Marital Status <span class="required-asterisk">*</span></label>
                                <select name="marital_status" id="marital_status" class="form-select">
                                    <option value="">-- Select --</option>
                                    @foreach(['Married','Unmarried'] as $ms)
                                    <option value="{{ $ms }}" @selected(old('marital_status', $data->marital_status) == $ms)>{{ $ms }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3" id="wife_name_wrap" style="display: none;">
                            <div class="detail-box">
                                <label class="detail-label">Wife Name of Life Proposed <span class="required-asterisk">*</span></label>
                                <input type="text" name="wife_name" id="wife_name" class="form-control" value="{{ old('wife_name', $data->wife_name) }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3" id="husband_name_wrap" style="display: none;">
                            <div class="detail-box">
                                <label class="detail-label">Husband Name of Life Proposed <span class="required-asterisk">*</span></label>
                                <input type="text" name="husband_name" id="husband_name" class="form-control" value="{{ old('husband_name', $data->husband_name) }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Mother Maiden Name <span class="required-asterisk">*</span></label>
                                <input type="text" name="mother_maiden_name" class="form-control" value="{{ old('mother_maiden_name', $data->mother_maiden_name) }}">
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Father's Name of Life Proposed <span class="required-asterisk">*</span></label>
                                <input type="text" name="father_name" class="form-control" value="{{ old('father_name', $data->father_name) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Religion <span class="required-asterisk">*</span></label>
                                <input type="text" name="religion" class="form-control" value="{{ old('religion', $data->religion) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Email Address <span class="required-asterisk">*</span></label>
                                <input type="email" name="user_email" class="form-control" value="{{ old('user_email', $data->user_email) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Phone Number Office</label>
                                <input type="text" name="phone_number_office" class="form-control" value="{{ old('phone_number_office', $data->phone_number_office) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Phone Number Residential</label>
                                <input type="text" name="phone_number_residente" class="form-control" value="{{ old('phone_number_residente', $data->phone_number_residente) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Is Client Dual National? <span class="required-asterisk">*</span></label>
                                <select name="is_client_dual_national" id="isClientDualNationalSelect" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="Yes" @selected(old('is_client_dual_national', $data->is_client_dual_national) == 'Yes')>Yes</option>
                                    <option value="No" @selected(old('is_client_dual_national', $data->is_client_dual_national) == 'No')>No</option>
                                </select>
                            </div>
                        </div>

                        <div id="dualNationalityWrapper" class="row m-0 w-100">

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Primary Nationality <span class="required-asterisk">*</span></label>
                                <input type="text" name="primary_nationality" id="primary_nationality" class="form-control" value="{{ old('primary_nationality', $data->primary_nationality) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Dual Nationality <span class="required-asterisk">*</span></label>
                                <input type="text" name="dual_nationality" id="dual_nationality" class="form-control" value="{{ old('dual_nationality', $data->dual_nationality) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Dual Nationality Country <span class="required-asterisk">*</span></label>
                                <input type="text" name="dual_nationality_country" id="dual_nationality_country" class="form-control" value="{{ old('dual_nationality_country', $data->dual_nationality_country) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Dual Nationality Passport Number <span class="required-asterisk">*</span></label>
                                <input type="text" name="dual_passport_number" id="dual_passport_number" class="form-control" value="{{ old('dual_passport_number', $data->dual_passport_number) }}">
                            </div>
                        </div>

                        </div><!-- /#dualNationalityWrapper -->

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                @php
                                    $selectedBirthCityId = old(
                                        'birth_place_city_id',
                                        $data->birth_place_city_id
                                            ?? optional(($cities ?? collect())->first(
                                                fn ($c) => strcasecmp($c->name, (string) ($data->birth_placed ?? '')) === 0
                                            ))->id
                                    );
                                @endphp
                                @include('frontend.partials.birth_place_select', [
                                    'cities' => $cities ?? collect(),
                                    'selectedBirthCityId' => $selectedBirthCityId,
                                    'birthPlaceRequired' => true,
                                    'birthPlaceClass' => 'form-select birth-place-city-select',
                                    'birthPlaceLabel' => 'Birth Place',
                                    'birthPlaceLabelClass' => 'detail-label',
                                ])
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Proposer & Life Proposed are same <span class="required-asterisk">*</span></label>
                                <select name="is_same_person" id="isSamePersonSelect" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="Yes" @selected(old('is_same_person', $data->is_same_person) == 'Yes')>Yes</option>
                                    <option value="No" @selected(old('is_same_person', $data->is_same_person) == 'No')>No</option>
                                </select>
                            </div>
                        </div>

                        <div id="lifeProposedWrapper" class="row m-0 w-100">

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Life Proposed Name <span class="required-asterisk">*</span></label>
                                <input type="text" name="life_proposed_name" id="life_proposed_name" class="form-control" value="{{ old('life_proposed_name', $data->life_proposed_name) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Life Proposed CNIC <span class="required-asterisk">*</span></label>
                                <input type="text" name="life_proposed_cnic" id="life_proposed_cnic" class="form-control" value="{{ old('life_proposed_cnic', $data->life_proposed_cnic) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Life Proposed DOB <span class="required-asterisk">*</span></label>
                                <input type="date" name="life_proposed_dob" id="life_proposed_dob" class="form-control" value="{{ old('life_proposed_dob', $data->life_proposed_dob) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Life Proposed RelationShip <span class="required-asterisk">*</span></label>
                                <input type="text" name="life_proposed_relationship" id="life_proposed_relationship" class="form-control" value="{{ old('life_proposed_relationship', $data->life_proposed_relationship) }}">
                            </div>
                        </div>

                        </div><!-- /#lifeProposedWrapper -->

                    </div>

                    <div class="custom-divider"></div>

                    {{-- Address Information --}}
                    <div class="section-title">Address Information</div>

                    {{-- NOTE: $provinces is passed from the controller (Provinces::get()).
                         City and District options are loaded dynamically via AJAX (see script below),
                         using routes: frontend.getcityData and frontend.getDistrictData. --}}

                    <div class="row">
                        <h6>Permanent Address</h6>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Province <span class="required-asterisk">*</span></label>
                                <select name="permanent_province_id" id="permanent_province_id" class="form-select jbl-dynamic-input">
                                    <option value="">-- Select Province --</option>
                                    @foreach($provinces as $prov)
                                    <option value="{{ $prov->id }}" @selected(old('permanent_province_id', $data->permanent_province_id) == $prov->id)>{{ $prov->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">City <span class="required-asterisk">*</span></label>
                                <select name="permanent_city_id" id="permanent_city_id" class="form-select jbl-dynamic-input">
                                    <option value="">-- Select City --</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">District <span class="required-asterisk">*</span></label>
                                <select name="permanent_district_id" id="permanent_district_id" class="form-select jbl-dynamic-input">
                                    <option value="">-- Select District --</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Address <span class="required-asterisk">*</span></label>
                                <textarea name="permanent_address" class="form-control" rows="2">{{ old('permanent_address', $data->permanent_address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <h6>Correspondence Address</h6>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Province <span class="required-asterisk">*</span></label>
                                <select name="corres_province_id" id="corres_province_id" class="form-select jbl-dynamic-input">
                                    <option value="">-- Select Province --</option>
                                    @foreach($provinces as $prov)
                                    <option value="{{ $prov->id }}" @selected(old('corres_province_id', $data->corres_province_id) == $prov->id)>{{ $prov->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">City <span class="required-asterisk">*</span></label>
                                <select name="corres_city_id" id="corres_city_id" class="form-select jbl-dynamic-input">
                                    <option value="">-- Select City --</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">District <span class="required-asterisk">*</span></label>
                                <select name="corres_district_id" id="corres_district_id" class="form-select jbl-dynamic-input">
                                    <option value="">-- Select District --</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Address <span class="required-asterisk">*</span></label>
                                <textarea name="corres_address" class="form-control" rows="2">{{ old('corres_address', $data->corres_address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <h6>Temporary Address</h6>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Province <span class="required-asterisk">*</span></label>
                                <select name="temp_province_id" id="temp_province_id" class="form-select jbl-dynamic-input">
                                    <option value="">-- Select Province --</option>
                                    @foreach($provinces as $prov)
                                    <option value="{{ $prov->id }}" @selected(old('temp_province_id', $data->temp_province_id) == $prov->id)>{{ $prov->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">City <span class="required-asterisk">*</span></label>
                                <select name="temp_city_id" id="temp_city_id" class="form-select jbl-dynamic-input">
                                    <option value="">-- Select City --</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">District <span class="required-asterisk">*</span></label>
                                <select name="temp_district_id" id="temp_district_id" class="form-select jbl-dynamic-input">
                                    <option value="">-- Select District --</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Address <span class="required-asterisk">*</span></label>
                                <textarea name="temp_address" class="form-control" rows="2">{{ old('temp_address', $data->temp_address) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="custom-divider"></div>

                    {{-- Occupation & Income --}}
                    <div class="section-title">Occupation & Income</div>

                    <div class="row">

                        @php
                            $empFlag = old('is_emaployemnt', $data->is_emaployemnt ?? '');
                            $bizFlag = old('is_business', $data->is_business ?? '');
                            if ($empFlag === 'Yes' && $bizFlag === 'Yes') {
                                $occupationType = 'Both';
                            } elseif ($empFlag === 'Yes') {
                                $occupationType = 'Employment';
                            } elseif ($bizFlag === 'Yes') {
                                $occupationType = 'Businessman';
                            } else {
                                $occupationType = old('occupation_type', '');
                            }
                        @endphp
                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Occupation Type <span class="required-asterisk">*</span></label>
                                <select id="occupation_type" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <option value="Employment" @selected($occupationType === 'Employment')>Employment</option>
                                    <option value="Businessman" @selected($occupationType === 'Businessman')>Businessman</option>
                                    <option value="Both" @selected($occupationType === 'Both')>Both</option>
                                </select>
                                <input type="hidden" name="is_emaployemnt" id="is_emaployemnt" value="{{ $empFlag }}">
                                <input type="hidden" name="is_business" id="is_business" value="{{ $bizFlag }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <div id="employment_fields" class="row"></div>
                        </div>

                        <div class="col-12">
                            <div id="business_fields" class="row"></div>
                        </div>


                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">If holding Land? <span class="required-asterisk">*</span></label>
                                <select name="is_holding_land" id="is_holding_land" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="Yes" @selected(old('is_holding_land', $data->is_holding_land) == 'Yes')>Yes</option>
                                    <option value="No" @selected(old('is_holding_land', $data->is_holding_land) == 'No')>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div id="land_fields" class="row"></div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Average monthly income (PKR) <span class="required-asterisk">*</span></label>
                                <input type="number" step="0.01" name="avaerage_monthly_income" class="form-control" value="{{ old('avaerage_monthly_income', $data->avaerage_monthly_income) }}">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">If Defence / Ex-Defence, Airline Flight Crew or Plant Protection Pilot <span class="required-asterisk">*</span></label>
                                <input type="text" name="ex_defence_personal" class="form-control" value="{{ old('ex_defence_personal', $data->ex_defence_personal) }}">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Discharged on medical grounds from service/employment <span class="required-asterisk">*</span></label>
                                <input type="text" name="discharged_on_medical" class="form-control" value="{{ old('discharged_on_medical', $data->discharged_on_medical) }}">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Engaged / intend to engage in hazardous occupation or pastime <span class="required-asterisk">*</span></label>
                                <input type="text" name="hazardous_occupation" class="form-control" value="{{ old('hazardous_occupation', $data->hazardous_occupation) }}">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Comments</label>
                                <textarea name="comment" class="form-control" rows="2">{{ old('comment', $data->comment) }}</textarea>
                            </div>
                        </div>

                    </div>

                    <div class="custom-divider"></div>

                    {{-- Family History Information --}}
                    <div class="section-title">Family History Information</div>

                    @php
                        $father = $data->family_history->firstWhere('memner_flag', 'father');
                        $mother = $data->family_history->firstWhere('memner_flag', 'mother');
                        $brothers = $data->family_history->where('memner_flag', 'brother')->values();
                        $sisters = $data->family_history->where('memner_flag', 'sister')->values();
                        $sons = $data->family_history->where('memner_flag', 'son')->values();
                        $daughters = $data->family_history->where('memner_flag', 'daughter')->values();
                    @endphp

                    <div class="row">

                        {{-- Father --}}
                        <h6 class="col-12 text-primary mt-2">Father</h6>
                        <input type="hidden" name="father_id" value="{{ $father->id ?? '' }}">
                        <input type="hidden" name="father_flag" value="father">

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Age <span class="required-asterisk">*</span></label>
                                <input type="text" name="father_age" class="form-control" value="{{ old('father_age', $father->age ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">State Of Health <span class="required-asterisk">*</span></label>
                                <input type="text" name="father_health" class="form-control" value="{{ old('father_health', $father->state_of_health ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Year Of Death</label>
                                <input type="text" name="father_year_of_death" class="form-control jbl-year-format" placeholder="YYYY" inputmode="numeric" maxlength="4" pattern="[0-9]{4}" value="{{ old('father_year_of_death', $father->year_of_death ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Age Of Death</label>
                                <input type="number" name="father_age_of_death" class="form-control" value="{{ old('father_age_of_death', $father->age_of_death ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Cause Of Death</label>
                                <textarea name="father_cause_of_death" class="form-control" rows="2" placeholder="Enter cause of death details...">{{ old('father_cause_of_death', $father->cause_of_death ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="col-12"><hr class="my-3"></div>

                        {{-- Mother --}}
                        <h6 class="col-12 text-primary">Mother</h6>
                        <input type="hidden" name="mother_id" value="{{ $mother->id ?? '' }}">
                        <input type="hidden" name="mother_flag" value="mother">

                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Age <span class="required-asterisk">*</span></label>
                                <input type="text" name="mother_age" class="form-control" value="{{ old('mother_age', $mother->age ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">State Of Health <span class="required-asterisk">*</span></label>
                                <input type="text" name="mother_health" class="form-control" value="{{ old('mother_health', $mother->state_of_health ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Year Of Death</label>
                                <input type="text" name="mother_year_of_death" class="form-control jbl-year-format" placeholder="YYYY" inputmode="numeric" maxlength="4" pattern="[0-9]{4}" value="{{ old('mother_year_of_death', $mother->year_of_death ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Age Of Death</label>
                                <input type="number" name="mother_age_of_death" class="form-control" value="{{ old('mother_age_of_death', $mother->age_of_death ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Cause Of Death</label>
                                <textarea name="mother_cause_of_death" class="form-control" rows="2" placeholder="Enter cause of death details...">{{ old('mother_cause_of_death', $mother->cause_of_death ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="col-12"><hr class="my-3"></div>

                        {{-- Brothers --}}
                        <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-primary mb-0">Brothers Details</h6>
                            <button type="button" class="btn btn-sm btn-success add-member" data-type="brother"> + Add Brother Info</button>
                        </div>
                        <div id="brothers_container" class="col-12 row px-0 mx-0">
                            @foreach($brothers as $b)
                            <input type="hidden" name="brother_id[]" value="{{ $b->id }}">
                            <input type="hidden" name="memner_flag_brother[]" value="brother">
                            <div class="col-12 row dynamic-row align-items-end border p-3 mb-3 bg-light rounded position-relative mx-0">
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Brother Age</label>
                                    <input type="text" name="brother_age[]" class="form-control" value="{{ $b->age }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">State Of Health</label>
                                    <input type="text" name="brother_health[]" class="form-control" value="{{ $b->state_of_health }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Year Of Death</label>
                                    <input type="text" name="brother_year_of_death[]" class="form-control jbl-year-format" placeholder="YYYY" inputmode="numeric" maxlength="4" pattern="[0-9]{4}" value="{{ $b->year_of_death }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Age Of Death</label>
                                    <input type="number" name="brother_age_of_death[]" class="form-control" value="{{ $b->age_of_death }}">
                                </div>
                                <div class="col-md-6 mb-2 px-1">
                                    <label class="detail-label">Cause Of Death</label>
                                    <textarea name="brother_cause_of_death[]" class="form-control" rows="2" placeholder="Enter cause of death details...">{{ $b->cause_of_death }}</textarea>
                                </div>
                                <div class="col-md-2 mb-2 text-center px-1">
                                    <button type="button" class="remove-member" title="Remove">-</button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="col-12"><hr class="my-3"></div>

                        {{-- Sisters --}}
                        <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-primary mb-0">Sisters Details</h6>
                            <button type="button" class="btn btn-sm btn-success add-member" data-type="sister"> + Add Sister Info</button>
                        </div>
                        <div id="sisters_container" class="col-12 row px-0 mx-0">
                            @foreach($sisters as $s)
                            <input type="hidden" name="sister_id[]" value="{{ $s->id }}">
                            <input type="hidden" name="memner_flag_sister[]" value="sister">
                            <div class="col-12 row dynamic-row align-items-end border p-3 mb-3 bg-light rounded position-relative mx-0">
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Sister Age</label>
                                    <input type="text" name="sister_age[]" class="form-control" value="{{ $s->age }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">State Of Health</label>
                                    <input type="text" name="sister_health[]" class="form-control" value="{{ $s->state_of_health }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Year Of Death</label>
                                    <input type="text" name="sister_year_of_death[]" class="form-control jbl-year-format" placeholder="YYYY" inputmode="numeric" maxlength="4" pattern="[0-9]{4}" value="{{ $s->year_of_death }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Age Of Death</label>
                                    <input type="number" name="sister_age_of_death[]" class="form-control" value="{{ $s->age_of_death }}">
                                </div>
                                <div class="col-md-6 mb-2 px-1">
                                    <label class="detail-label">Cause Of Death</label>
                                    <textarea name="sister_cause_of_death[]" class="form-control" rows="2" placeholder="Enter cause of death details...">{{ $s->cause_of_death }}</textarea>
                                </div>
                                <div class="col-md-2 mb-2 text-center px-1">
                                    <button type="button" class="remove-member" title="Remove">-</button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="col-12"><hr class="my-3"></div>

                        {{-- Sons --}}
                        <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-primary mb-0">Sons Details</h6>
                            <button type="button" class="btn btn-sm btn-success add-member" data-type="son"> + Add Son Info</button>
                        </div>
                        <div id="sons_container" class="col-12 row px-0 mx-0">
                            @foreach($sons as $s)
                            <input type="hidden" name="son_id[]" value="{{ $s->id }}">
                            <input type="hidden" name="memner_flag_son[]" value="son">
                            <div class="col-12 row dynamic-row align-items-end border p-3 mb-3 bg-light rounded position-relative mx-0">
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Son Age</label>
                                    <input type="text" name="son_age[]" class="form-control" value="{{ $s->age }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">State Of Health</label>
                                    <input type="text" name="son_health[]" class="form-control" value="{{ $s->state_of_health }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Year Of Death</label>
                                    <input type="text" name="son_year_of_death[]" class="form-control jbl-year-format" placeholder="YYYY" inputmode="numeric" maxlength="4" pattern="[0-9]{4}" value="{{ $s->year_of_death }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Age Of Death</label>
                                    <input type="number" name="son_age_of_death[]" class="form-control" value="{{ $s->age_of_death }}">
                                </div>
                                <div class="col-md-6 mb-2 px-1">
                                    <label class="detail-label">Cause Of Death</label>
                                    <textarea name="son_cause_of_death[]" class="form-control" rows="2" placeholder="Enter cause of death details...">{{ $s->cause_of_death }}</textarea>
                                </div>
                                <div class="col-md-2 mb-2 text-center px-1">
                                    <button type="button" class="remove-member" title="Remove">-</button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="col-12"><hr class="my-3"></div>

                        {{-- Daughters --}}
                        <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                            <h6 class="text-primary mb-0">Daughters Details</h6>
                            <button type="button" class="btn btn-sm btn-success add-member" data-type="daughter"> + Add Daughter Info</button>
                        </div>
                        <div id="daughters_container" class="col-12 row px-0 mx-0">
                            @foreach($daughters as $d)
                            <input type="hidden" name="daughter_id[]" value="{{ $d->id }}">
                            <input type="hidden" name="memner_flag_daughter[]" value="daughter">
                            <div class="col-12 row dynamic-row align-items-end border p-3 mb-3 bg-light rounded position-relative mx-0">
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Daughter Age</label>
                                    <input type="text" name="daughter_age[]" class="form-control" value="{{ $d->age }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">State Of Health</label>
                                    <input type="text" name="daughter_health[]" class="form-control" value="{{ $d->state_of_health }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Year Of Death</label>
                                    <input type="text" name="daughter_year_of_death[]" class="form-control jbl-year-format" placeholder="YYYY" inputmode="numeric" maxlength="4" pattern="[0-9]{4}" value="{{ $d->year_of_death }}">
                                </div>
                                <div class="col-md-4 mb-2 px-1">
                                    <label class="detail-label">Age Of Death</label>
                                    <input type="number" name="daughter_age_of_death[]" class="form-control" value="{{ $d->age_of_death }}">
                                </div>
                                <div class="col-md-6 mb-2 px-1">
                                    <label class="detail-label">Cause Of Death</label>
                                    <textarea name="daughter_cause_of_death[]" class="form-control" rows="2" placeholder="Enter cause of death details...">{{ $d->cause_of_death }}</textarea>
                                </div>
                                <div class="col-md-2 mb-2 text-center px-1">
                                    <button type="button" class="remove-member" title="Remove">-</button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="custom-divider"></div>

                    {{-- Female Section --}}
                    <div class="section-title">Female Section</div>

                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Date of Last Delivery</label>
                                <input type="date" name="date_of_last_delivery" class="form-control" value="{{ old('date_of_last_delivery', $data->date_of_last_delivery) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Miscarriage Dates</label>
                                <input type="text" name="miscarriage_dates" class="form-control" value="{{ old('miscarriage_dates', $data->miscarriage_dates) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Is Pregnant</label>
                                <select name="is_pregnant" class="form-select">
                                    <option value="">-- Select --</option>
                                    <option value="Yes" @selected(old('is_pregnant', $data->is_pregnant) == 'Yes')>Yes</option>
                                    <option value="No" @selected(old('is_pregnant', $data->is_pregnant) == 'No')>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Caesarean Details</label>
                                <input type="text" name="caesarean_details" class="form-control" value="{{ old('caesarean_details', $data->caesarean_details) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">LMP Date</label>
                                <input type="date" name="lmp_date" class="form-control" value="{{ old('lmp_date', $data->lmp_date) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Female Disease History</label>
                                <input type="text" name="female_disease_history" class="form-control" value="{{ old('female_disease_history', $data->female_disease_history) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Self Monthly Income</label>
                                <input type="number" step="0.01" name="self_monthly_income" class="form-control" value="{{ old('self_monthly_income', $data->self_monthly_income) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Husband Monthly Income</label>
                                <input type="number" step="0.01" name="husband_monthly_income" class="form-control" value="{{ old('husband_monthly_income', $data->husband_monthly_income) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Qualification</label>
                                <input type="text" name="qualification" class="form-control" value="{{ old('qualification', $data->qualification) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Pays Tax / Land Revenue</label>
                                <input type="text" name="pays_tax_land_revenue" class="form-control" value="{{ old('pays_tax_land_revenue', $data->pays_tax_land_revenue) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Husband Policy No.</label>
                                <input type="text" name="husband_policy_no" class="form-control" value="{{ old('husband_policy_no', $data->husband_policy_no) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Husband Zone / Company</label>
                                <input type="text" name="husband_zone_company" class="form-control" value="{{ old('husband_zone_company', $data->husband_zone_company) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Husband Sum Assured</label>
                                <input type="number" step="0.01" name="husband_sum_assured" class="form-control" value="{{ old('husband_sum_assured', $data->husband_sum_assured) }}">
                            </div>
                        </div>

                    </div>

                    <div class="custom-divider"></div>

                    {{-- Nominee Information --}}
                    <div class="section-title">Nominee Information</div>

                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Nominee Name <span class="required-asterisk">*</span></label>
                                <input type="text" name="nominee_name" class="form-control" value="{{ old('nominee_name', $data->nominee_name) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Nominee CNIC <span class="required-asterisk">*</span></label>
                                <input type="text" name="nominee_cnic" id="nominee_cnic" class="form-control jbl-cnic-format" placeholder="42101-1234567-1" maxlength="15" inputmode="numeric" pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}" value="{{ old('nominee_cnic', $data->nominee_cnic) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Nominee Age <span class="required-asterisk">*</span></label>
                                <input type="number" name="nominee_age" class="form-control" value="{{ old('nominee_age', $data->nominee_age) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Nominee Relationship <span class="required-asterisk">*</span></label>
                                <input type="text" name="nominee_relationship" class="form-control" value="{{ old('nominee_relationship', $data->nominee_relationship) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Appointee Name <span class="required-asterisk">*</span></label>
                                <input type="text" name="appointee_name" class="form-control" value="{{ old('appointee_name', $data->appointee_name) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Appointee Relationship <span class="required-asterisk">*</span></label>
                                <input type="text" name="appointee_relationship" class="form-control" value="{{ old('appointee_relationship', $data->appointee_relationship) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Appointee CNIC <span class="required-asterisk">*</span></label>
                                <input type="text" name="appointee_cnic" class="form-control" value="{{ old('appointee_cnic', $data->appointee_cnic) }}">
                            </div>
                        </div>

                    </div>

                    <div class="custom-divider"></div>

                    {{-- Documents (image upload with preview) --}}
                    <div class="section-title">Documents</div>

                    <div class="row">

                        @php
                        $documentFields = [
                            'proposer_cnic_front'  => 'Proposer CNIC Front',
                            'proposer_cnic_back'   => 'Proposer CNIC Back',
                            'nominee_document'     => 'Nominee Document',
                            'proposer_photo'       => 'Proposer Photo',
                            'income_proof'         => 'Income Proof',
                        ];
                        @endphp

                        @foreach($documentFields as $field => $label)
                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">{{ $label }}</label>
                                <div class="img-preview-box" data-preview="{{ $field }}_preview">
                                    @if($data->$field)
                                    <img id="{{ $field }}_preview" src="{{ asset('uploads/policy_documents/'.$data->$field) }}" alt="{{ $label }}">
                                    @else
                                    <div class="no-img" id="{{ $field }}_preview_placeholder">No file uploaded</div>
                                    <img id="{{ $field }}_preview" src="" alt="{{ $label }}" style="display:none;">
                                    @endif
                                    <input type="file" name="{{ $field }}" accept="image/*,application/pdf"
                                        class="form-control form-control-sm mt-1"
                                        onchange="previewImage(event, '{{ $field }}_preview')">
                                    @if($data->$field)
                                    <input type="hidden" name="{{ $field }}_old" value="{{ $data->$field }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    <div class="custom-divider"></div>

                    {{-- Health Information --}}
                    <div class="section-title">Health Information</div>

                    <div class="row">
                        @include('frontend.partials.health_measurements', [
                            'health' => $data,
                            'fieldClass' => 'form-control',
                            'selectClass' => 'form-select',
                            'labelClass' => 'detail-label',
                            'colClass' => 'col-md-6 mb-3',
                            'useDetailBox' => true,
                        ])

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">State average daily consumption of Tobacco, Pan/Niswar, Alcohol, Drugs <span class="required-asterisk">*</span></label>
                                <input type="text" name="daily_consumption" class="form-control" value="{{ old('daily_consumption', $data->daily_consumption) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">State Physical Impairments (if any) </label>
                                <input type="text" name="physical_impairments" class="form-control" value="{{ old('physical_impairments', $data->physical_impairments) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Last Illness / Injury <span class="required-asterisk">*</span></label>
                                <input type="text" name="last_illness_injury" class="form-control" value="{{ old('last_illness_injury', $data->last_illness_injury) }}">
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Medical Investigations <span class="required-asterisk">*</span></label>
                                <input type="text" name="medical_investigations" class="form-control" value="{{ old('medical_investigations', $data->medical_investigations) }}">
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="detail-box">
                                <label class="detail-label">Medical History <span class="required-asterisk">*</span></label>
                                <textarea name="medical_history" class="form-control" rows="4">{{ old('medical_history', $data->medical_history) }}</textarea>
                            </div>
                        </div>

                    </div>

                    <div class="custom-divider"></div>

                    {{-- Submit --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{route('frontend.self-policy')}}" class="btn" style="background:#6c757d;color:#fff;">
                            Cancel
                        </a>
                        <button type="submit" class="btn" style="background:#0d47a1;color:#fff;">
                            <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </section>
</main>

<script>
    // Preview newly selected image before upload
    function previewImage(event, previewId) {
        const file = event.target.files[0];
        const img = document.getElementById(previewId);
        const placeholder = document.getElementById(previewId + '_placeholder');
        if (!file) return;

        // If it's an image, show preview. If PDF, just show a generic label.
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                img.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        } else {
            img.style.display = 'none';
            if (placeholder) {
                placeholder.style.display = 'flex';
                placeholder.textContent = file.name;
            }
        }
    }

    // Toggle: Life Proposed fields (hide only, keep values intact when Proposer & Life Proposed are same = "Yes")
    (function () {
        const select = document.getElementById('isSamePersonSelect');
        const wrapper = document.getElementById('lifeProposedWrapper');

        function toggleLifeProposed() {
            if (select.value === 'Yes') {
                wrapper.style.display = 'none';
            } else {
                wrapper.style.display = '';
            }
        }

        select.addEventListener('change', toggleLifeProposed);
        toggleLifeProposed(); // run on load to respect existing value
    })();

    // Toggle: Dual Nationality fields (hide only, keep values intact when Is Client Dual National? = "No")
    (function () {
        const select = document.getElementById('isClientDualNationalSelect');
        const wrapper = document.getElementById('dualNationalityWrapper');

        function toggleDualNationality() {
            if (select.value === 'No') {
                wrapper.style.display = 'none';
            } else {
                wrapper.style.display = '';
            }
        }

        select.addEventListener('change', toggleDualNationality);
        toggleDualNationality(); // run on load to respect existing value
    })();

    // ================= Field format validations =================
    // Works for existing fields AND dynamically added family-history rows (event delegation)

    // Pakistani mobile format: 0321-8976654
    function formatMobileValue(raw) {
        let digits = raw.replace(/\D/g, '').slice(0, 11);
        if (digits.length > 4) {
            return digits.slice(0, 4) + '-' + digits.slice(4);
        }
        return digits;
    }

    // Pakistani CNIC format: 42101-1234567-1
    function formatCnicValue(raw) {
        let digits = raw.replace(/\D/g, '').slice(0, 13);
        if (digits.length > 12) {
            return digits.slice(0, 5) + '-' + digits.slice(5, 12) + '-' + digits.slice(12);
        }
        if (digits.length > 5) {
            return digits.slice(0, 5) + '-' + digits.slice(5);
        }
        return digits;
    }

    // Year Of Death: digits only, max 4
    function formatYearValue(raw) {
        return raw.replace(/\D/g, '').slice(0, 4);
    }

    document.addEventListener('input', function (e) {
        const el = e.target;

        if (el.classList && el.classList.contains('jbl-mobile-format')) {
            el.value = formatMobileValue(el.value);
        }

        if (el.classList && el.classList.contains('jbl-cnic-format')) {
            el.value = formatCnicValue(el.value);
        }

        if (el.classList && el.classList.contains('jbl-year-format')) {
            el.value = formatYearValue(el.value);
        }
    });
</script>

{{-- Occupation toggle fields + Land Holding toggle fields + Family History dynamic member rows (jQuery) --}}
@push('js')
<script>
    $(document).ready(function () {

        // ================= Occupation toggle logic =================
        function toggleOccupationFields() {
            let type = $('#occupation_type').val();
            let employment = 'No';
            let business = 'No';

            if (type === 'Employment') {
                employment = 'Yes';
            } else if (type === 'Businessman') {
                business = 'Yes';
            } else if (type === 'Both') {
                employment = 'Yes';
                business = 'Yes';
            }

            $('#is_emaployemnt').val(employment);
            $('#is_business').val(business);

            // Employment Fields
            if (employment === 'Yes') {
                $('#employment_fields').html(`
                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <label class="detail-label">Designation / Job Title <span class="required-asterisk">*</span></label>
                            <input type="text" name="employment_designation"
                                value="{{ old('employment_designation', $data->employment_designation ?? '') }}"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <label class="detail-label">Company Name <span class="required-asterisk">*</span></label>
                            <input type="text" name="employment_company_name"
                                value="{{ old('employment_company_name', $data->employment_company_name ?? '') }}"
                                class="form-control" required>
                        </div>
                    </div>
                `);
            } else {
                $('#employment_fields').html('');
            }

            // Business Fields
            if (business === 'Yes') {
                $('#business_fields').html(`
                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <label class="detail-label">Business Name <span class="required-asterisk">*</span></label>
                            <input type="text" name="business_name"
                                value="{{ old('business_name', $data->business_name ?? '') }}"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <label class="detail-label">Nature of Business <span class="required-asterisk">*</span></label>
                            <input type="text" name="nature_of_business"
                                value="{{ old('nature_of_business', $data->nature_of_business ?? '') }}"
                                class="form-control"
                                placeholder="e.g. Pharmacy, Electronics, Construction" required>
                        </div>
                    </div>
                `);
            } else {
                $('#business_fields').html('');
            }
        }

        // Page Load
        toggleOccupationFields();

        // Change Events
        $('#occupation_type').on('change', toggleOccupationFields);

        // ================= Land Holding toggle logic =================
        function toggleLandFields() {

            let holdingLand = $('select[name="is_holding_land"]').val();

            if (holdingLand === 'Yes') {
                $('#land_fields').html(`
                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <label class="detail-label">Land Unit <span class="required-asterisk">*</span></label>
                            <select name="land_unit" class="form-select" required>
                                <option value="">Select Unit</option>
                                <option value="Marla" {{ old('land_unit', $data->land_unit ?? '') == 'Marla' ? 'selected' : '' }}>Marla</option>
                                <option value="Kanal" {{ old('land_unit', $data->land_unit ?? '') == 'Kanal' ? 'selected' : '' }}>Kanal</option>
                                <option value="Acre" {{ old('land_unit', $data->land_unit ?? '') == 'Acre' ? 'selected' : '' }}>Acre</option>
                                <option value="Square Yard" {{ old('land_unit', $data->land_unit ?? '') == 'Square Yard' ? 'selected' : '' }}>Square Yard / Gaz</option>
                                <option value="Square Feet" {{ old('land_unit', $data->land_unit ?? '') == 'Square Feet' ? 'selected' : '' }}>Square Feet</option>
                                <option value="Hectare" {{ old('land_unit', $data->land_unit ?? '') == 'Hectare' ? 'selected' : '' }}>Hectare</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <label class="detail-label">Total Area <span class="required-asterisk">*</span></label>
                            <input type="number" step="0.01" min="0" name="total_acreage"
                                value="{{ old('total_acreage', $data->total_acreage ?? '') }}"
                                class="form-control" placeholder="Enter value in selected unit" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <label class="detail-label">Land Location <span class="required-asterisk">*</span></label>
                            <input type="text" name="land_location"
                                value="{{ old('land_location', $data->land_location ?? '') }}"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <label class="detail-label">Land Type <span class="required-asterisk">*</span></label>
                            <select name="land_type" class="form-select" required>
                                <option value="">Select Type</option>
                                <option value="Agricultural" {{ old('land_type', $data->land_type ?? '') == 'Agricultural' ? 'selected' : '' }}>Agricultural</option>
                                <option value="Commercial" {{ old('land_type', $data->land_type ?? '') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                <option value="Residential" {{ old('land_type', $data->land_type ?? '') == 'Residential' ? 'selected' : '' }}>Residential</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="detail-box">
                            <label class="detail-label">Estimated Land Value <span class="required-asterisk">*</span></label>
                            <input type="number" step="0.01" name="estimated_land_value"
                                value="{{ old('estimated_land_value', $data->estimated_land_value ?? '') }}"
                                class="form-control" required>
                        </div>
                    </div>
                `);
            } else {
                $('#land_fields').html('');
            }
        }

        // Page Load
        toggleLandFields();

        // Change Event
        $(document).on('change', 'select[name="is_holding_land"]', function () {
            toggleLandFields();
        });

        // ================= Family History dynamic member rows =================
        const templates = {
            brother: () => createMemberRow('brother', 'Brother'),
            sister: () => createMemberRow('sister', 'Sister'),
            son: () => createMemberRow('son', 'Son'),
            daughter: () => createMemberRow('daughter', 'Daughter')
        };

        function createMemberRow(type, labelPrefix) {
            return `
            <input type="hidden" name="${type}_id[]" value="">
            <input type="hidden" name="memner_flag_${type}[]" value="${type}">
            <div class="col-12 row dynamic-row align-items-end border p-3 mb-3 bg-light rounded position-relative mx-0">
                <div class="col-md-4 mb-2 px-1">
                    <label class="detail-label">${labelPrefix} Age</label>
                    <input type="text" name="${type}_age[]" class="form-control">
                </div>
                <div class="col-md-4 mb-2 px-1">
                    <label class="detail-label">State Of Health</label>
                    <input type="text" name="${type}_health[]" class="form-control">
                </div>
                <div class="col-md-4 mb-2 px-1">
                    <label class="detail-label">Year Of Death</label>
                    <input type="text" name="${type}_year_of_death[]" class="form-control jbl-year-format"
                        placeholder="YYYY" inputmode="numeric" maxlength="4" pattern="[0-9]{4}">
                </div>
                <div class="col-md-4 mb-2 px-1">
                    <label class="detail-label">Age Of Death</label>
                    <input type="number" name="${type}_age_of_death[]" class="form-control">
                </div>
                <div class="col-md-6 mb-2 px-1">
                    <label class="detail-label">Cause Of Death</label>
                    <textarea name="${type}_cause_of_death[]" class="form-control" rows="2" placeholder="Enter cause of death details..."></textarea>
                </div>
                <div class="col-md-2 mb-2 text-center px-1">
                    <button type="button" class="remove-member" title="Remove">-</button>
                </div>
            </div>
        `;
        }

        // Plus (+) Button Click Event
        $('.add-member').on('click', function () {
            let type = $(this).data('type');
            if (templates[type]) {
                $(`#${type}s_container`).append(templates[type]());
            }
        });

        // Minus (-) Button Click Event (Delegated Event because rows are dynamic)
        $(document).on('click', '.remove-member', function () {
            $(this).closest('.dynamic-row').remove();
        });

    });
</script>
@endpush

{{-- Dynamic Province -> City -> District dropdowns (Permanent / Correspondence / Temporary) --}}
@push('js')
<script>
    let permanentProvince = "{{ old('permanent_province_id', $data->permanent_province_id ?? '') }}";
    let permanentCity = "{{ old('permanent_city_id', $data->permanent_city_id ?? '') }}";
    let permanentDistrict = "{{ old('permanent_district_id', $data->permanent_district_id ?? '') }}";

    let corresProvince = "{{ old('corres_province_id', $data->corres_province_id ?? '') }}";
    let corresCity = "{{ old('corres_city_id', $data->corres_city_id ?? '') }}";
    let corresDistrict = "{{ old('corres_district_id', $data->corres_district_id ?? '') }}";

    let tempProvince = "{{ old('temp_province_id', $data->temp_province_id ?? '') }}";
    let tempCity = "{{ old('temp_city_id', $data->temp_city_id ?? '') }}";
    let tempDistrict = "{{ old('temp_district_id', $data->temp_district_id ?? '') }}";

    function loadCities(provinceId, citySelector, selectedCity = null, callback = null) {
        if (!provinceId) return;

        $.ajax({
            method: 'POST',
            url: '{{ route("frontend.getcityData") }}',
            data: {
                province_id: provinceId,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $(citySelector).html('<option value="">Loading .....</option>');
            },
            success: function (res) {
                let cityDropdown = $(citySelector);
                cityDropdown.html('<option value="">Select City</option>');

                $.each(res, function (i, city) {
                    let selected = (selectedCity == city.id) ? 'selected' : '';
                    cityDropdown.append(`<option value="${city.id}" ${selected}>${city.name}</option>`);
                });

                if (callback) callback();
            }
        });
    }

    function loadDistricts(cityId, districtSelector, selectedDistrict = null) {
        if (!cityId) return;

        $.ajax({
            method: 'POST',
            url: '{{ route("frontend.getDistrictData") }}',
            data: {
                city_id: cityId,
                _token: '{{ csrf_token() }}'
            },
            beforeSend: function () {
                $(districtSelector).html('<option value="">Loading .....</option>');
            },
            success: function (res) {
                let districtDropdown = $(districtSelector);
                districtDropdown.html('<option value="">Select District</option>');

                $.each(res, function (i, d) {
                    let selected = (selectedDistrict == d.id) ? 'selected' : '';
                    districtDropdown.append(`<option value="${d.id}" ${selected}>${d.name}</option>`);
                });
            }
        });
    }

    // Permanent
    $('#permanent_province_id').change(function () {
        loadCities(this.value, '#permanent_city_id');
        $('#permanent_district_id').html('<option value="">Select District</option>');
    });

    $('#permanent_city_id').change(function () {
        loadDistricts(this.value, '#permanent_district_id');
    });

    // Correspondence
    $('#corres_province_id').change(function () {
        loadCities(this.value, '#corres_city_id');
        $('#corres_district_id').html('<option value="">Select District</option>');
    });

    $('#corres_city_id').change(function () {
        loadDistricts(this.value, '#corres_district_id');
    });

    // Temporary
    $('#temp_province_id').change(function () {
        loadCities(this.value, '#temp_city_id');
        $('#temp_district_id').html('<option value="">Select District</option>');
    });

    $('#temp_city_id').change(function () {
        loadDistricts(this.value, '#temp_district_id');
    });

    $(document).ready(function () {

        // PERMANENT — preload city/district based on existing saved values
        if (permanentProvince) {
            $('#permanent_province_id').val(permanentProvince);

            loadCities(permanentProvince, '#permanent_city_id', permanentCity, function () {
                loadDistricts(permanentCity, '#permanent_district_id', permanentDistrict);
            });
        }

        // CORRESPONDENCE
        if (corresProvince) {
            $('#corres_province_id').val(corresProvince);

            loadCities(corresProvince, '#corres_city_id', corresCity, function () {
                loadDistricts(corresCity, '#corres_district_id', corresDistrict);
            });
        }

        // TEMPORARY
        if (tempProvince) {
            $('#temp_province_id').val(tempProvince);

            loadCities(tempProvince, '#temp_city_id', tempCity, function () {
                loadDistricts(tempCity, '#temp_district_id', tempDistrict);
            });
        }

    });
</script>
@endpush

@push('js')
<script>
    $(document).ready(function () {
        function toggleSpouseNameFields() {
            let gender = ($('#gender').val() || '').trim();
            let marital = ($('#marital_status').val() || '').trim();

            $('#wife_name_wrap, #husband_name_wrap').hide();
            $('#wife_name, #husband_name').prop('required', false);

            if (marital === 'Married' && gender === 'Male') {
                $('#wife_name_wrap').show();
                $('#wife_name').prop('required', true);
                $('#husband_name').val('');
            } else if (marital === 'Married' && gender === 'Female') {
                $('#husband_name_wrap').show();
                $('#husband_name').prop('required', true);
                $('#wife_name').val('');
            } else if (marital === 'Unmarried') {
                $('#wife_name, #husband_name').val('');
            }
        }

        $('#gender, #marital_status').on('change', toggleSpouseNameFields);
        toggleSpouseNameFields();
    });
</script>
@endpush


@endsection
