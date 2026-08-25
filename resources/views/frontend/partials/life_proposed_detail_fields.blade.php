@php
    $lp = $lp ?? \App\Support\LifeProposedProfile::values($data ?? null);
    $show = fn ($key) => filled($lp[$key] ?? null) ? $lp[$key] : '---';
@endphp

@if(($data->is_same_person ?? '') === 'No')
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('life_proposed_full_name') }}</div>
        <div class="detail-value">{{ $show('name') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('mobile_number_personal') }}</div>
        <div class="detail-value">{{ $show('mobile') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('cnic_bform') }}</div>
        <div class="detail-value">{{ $show('cnic') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('cnic_issue_date') }}</div>
        <div class="detail-value">{{ $show('cnic_issue_date') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('cnic_expiry_date') }}</div>
        <div class="detail-value">{{ $show('cnic_expiry_date') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('date_of_birth') }}</div>
        <div class="detail-value">{{ $show('dob') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('place_of_birth') }}</div>
        <div class="detail-value">{{ $show('birth_placed') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('age') }}</div>
        <div class="detail-value">{{ $show('age') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('gender') }}</div>
        <div class="detail-value">{{ $show('gender') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('marital_status') }}</div>
        <div class="detail-value">{{ $show('marital_status') }}</div>
    </div>
</div>
@if(($lp['marital_status'] ?? '') === 'Married' && ($lp['gender'] ?? '') === 'Male')
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('wife_name') }}</div>
        <div class="detail-value">{{ $show('wife_name') }}</div>
    </div>
</div>
@endif
@if(($lp['marital_status'] ?? '') === 'Married' && ($lp['gender'] ?? '') === 'Female')
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('husband_name') }}</div>
        <div class="detail-value">{{ $show('husband_name') }}</div>
    </div>
</div>
@endif
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('mother_maiden_name') }}</div>
        <div class="detail-value">{{ $show('mother_maiden_name') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('father_name_of_life_proposed') }}</div>
        <div class="detail-value">{{ $show('father_name') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('religion') }}</div>
        <div class="detail-value">{{ $show('religion') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('email_address') }}</div>
        <div class="detail-value">{{ $show('email') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('phone_office') }}</div>
        <div class="detail-value">{{ $show('phone_office') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('phone_residential') }}</div>
        <div class="detail-value">{{ $show('phone_residential') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('country_of_residence') }}</div>
        <div class="detail-value">{{ $show('country_of_residence') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('current_address') }}</div>
        <div class="detail-value">{{ $show('current_address') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('is_dual_national') }}</div>
        <div class="detail-value">{{ $show('is_client_dual_national') }}</div>
    </div>
</div>
@if(($lp['is_client_dual_national'] ?? '') === 'Yes')
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('primary_nationality') }}</div>
        <div class="detail-value">{{ $show('primary_nationality') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('dual_nationality_country') }}</div>
        <div class="detail-value">{{ $show('dual_nationality_country') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('tax_tin_number') }}</div>
        <div class="detail-value">{{ $show('dual_tax_tin_number') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('dual_mobile_number') }}</div>
        <div class="detail-value">{{ $show('dual_mobile_number') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('dual_address') }}</div>
        <div class="detail-value">{{ $show('dual_address') }}</div>
    </div>
</div>
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('passport_number') }}</div>
        <div class="detail-value">{{ $show('dual_passport_number') }}</div>
    </div>
</div>
@endif
<div class="col-md-3 mb-3">
    <div class="detail-box">
        <div class="detail-label">{{ policy_label('relationship_with_proposer') }}</div>
        <div class="detail-value">{{ $show('relationship') }}</div>
    </div>
</div>
@endif
