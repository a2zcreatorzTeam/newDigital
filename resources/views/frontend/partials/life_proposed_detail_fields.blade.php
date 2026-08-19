@php
    $lp = $lp ?? \App\Support\LifeProposedProfile::values($data ?? null);
    $show = fn ($key) => filled($lp[$key] ?? null) ? $lp[$key] : '---';
@endphp

@if(($data->is_same_person ?? '') === 'No')
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Name</div>
        <div class="detail-value">{{ $show('name') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Mobile</div>
        <div class="detail-value">{{ $show('mobile') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed CNIC / B-Form</div>
        <div class="detail-value">{{ $show('cnic') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed CNIC Issue Date</div>
        <div class="detail-value">{{ $show('cnic_issue_date') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed CNIC Expiry Date</div>
        <div class="detail-value">{{ $show('cnic_expiry_date') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed DOB</div>
        <div class="detail-value">{{ $show('dob') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Age</div>
        <div class="detail-value">{{ $show('age') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Gender</div>
        <div class="detail-value">{{ $show('gender') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Marital Status</div>
        <div class="detail-value">{{ $show('marital_status') }}</div>
    </div>
</div>
@if(($lp['marital_status'] ?? '') === 'Married' && ($lp['gender'] ?? '') === 'Male')
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Wife Name</div>
        <div class="detail-value">{{ $show('wife_name') }}</div>
    </div>
</div>
@endif
@if(($lp['marital_status'] ?? '') === 'Married' && ($lp['gender'] ?? '') === 'Female')
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Husband Name</div>
        <div class="detail-value">{{ $show('husband_name') }}</div>
    </div>
</div>
@endif
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Mother Maiden Name</div>
        <div class="detail-value">{{ $show('mother_maiden_name') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Father Name</div>
        <div class="detail-value">{{ $show('father_name') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Religion</div>
        <div class="detail-value">{{ $show('religion') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Email</div>
        <div class="detail-value">{{ $show('email') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Office Phone</div>
        <div class="detail-value">{{ $show('phone_office') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Residential Phone</div>
        <div class="detail-value">{{ $show('phone_residential') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Dual National?</div>
        <div class="detail-value">{{ $show('is_client_dual_national') }}</div>
    </div>
</div>
@if(($lp['is_client_dual_national'] ?? '') === 'Yes')
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Primary Nationality</div>
        <div class="detail-value">{{ $show('primary_nationality') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Dual Nationality Country</div>
        <div class="detail-value">{{ $show('dual_nationality_country') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Tax/TIN</div>
        <div class="detail-value">{{ $show('dual_tax_tin_number') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Dual Mobile</div>
        <div class="detail-value">{{ $show('dual_mobile_number') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Dual Address</div>
        <div class="detail-value">{{ $show('dual_address') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Passport Number</div>
        <div class="detail-value">{{ $show('dual_passport_number') }}</div>
    </div>
</div>
@endif
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Life Proposed Birth Place</div>
        <div class="detail-value">{{ $show('birth_placed') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">Relationship with Proposer</div>
        <div class="detail-value">{{ $show('relationship') }}</div>
    </div>
</div>
@endif
