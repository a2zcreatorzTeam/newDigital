<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #f4f6f9;
            font-size: 12px;
            color: #212529;
            margin: 0;
            padding: 20px;
        }

        .profile-card {
            background: #fff;
            border: 1px solid #ddd;
        }

        .profile-header {
            background: #0d47a1;
            color: #fff;
            padding: 20px;
        }

        .profile-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .profile-header p {
            margin-top: 5px;
            font-size: 12px;
        }

        .badge-status {
            margin-top: 10px;
            display: inline-block;
            background: #d4edda;
            color: #155724;
            padding: 5px 12px;
            font-size: 11px;
            border-radius: 20px;
        }

        .content {
            padding: 20px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #0d47a1;
            border-left: 4px solid #0d47a1;
            padding-left: 10px;
            margin-bottom: 15px;
            margin-top: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            width: 50%;
            border: 1px solid #ddd;
            padding: 10px;
            vertical-align: top;
        }

        .detail-label {
            font-size: 11px;
            color: #6c757d;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .detail-value {
            font-size: 13px;
            font-weight: bold;
        }

        .summary-table td {
            text-align: center;
        }

        .summary-title {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .summary-value {
            font-size: 18px;
            color: #0d47a1;
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #ccc;
            margin: 25px 0;
        }

        .doc-image {
            max-height: 120px;
            max-width: 100%;
        }
    </style>
</head>

<body>

    <div class="profile-card">

        <div class="profile-header">
            <h2>Policy Detail</h2>
            <p>Complete information of policy holder and insurance profile</p>
        </div>

        <div class="content">

            {{-- POLICY SUMMARY --}}
            <table class="summary-table">

                <tr>
                    <td>
                        <div class="summary-title">{{ policy_label('policy_number') }}</div>
                        <div class="summary-value">{{ $data->policy_id ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="summary-title">{{ policy_label('plan_name') }}</div>
                        <div class="summary-value">{{ $data->product->name ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="summary-title">{{ policy_label('sum_assured') }}</div>
                        <div class="summary-value">{{ number_format($data->sum_assured) ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="summary-title">{{ policy_label('policy_term') }}</div>
                        <div class="summary-value">{{ $data->term ?? '---' }} Years</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="summary-title">{{ policy_label('submitted_date') }}</div>
                        <div class="summary-value">
                            @if($data->created_at)
                                {{ $data->created_at->timezone('Asia/Karachi')->format('d-m-Y h:i A') }}
                            @else
                                ---
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="summary-title">{{ policy_label('premium_paid') }}</div>
                        <div class="summary-value">{{ $data->premium_paid !== null && $data->premium_paid !== '' ? number_format((float) $data->premium_paid) : '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- PERSONAL INFORMATION --}}
            <div class="section-title">
                {{ policy_label('personal_information') }}
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('life_proposed_full_name') }}</div>
                        <div class="detail-value">{{ $data->life_proposed_full_name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('mobile_number_personal') }}</div>
                        <div class="detail-value">{{ $data->mobile_number ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('cnic_bform') }}</div>
                        <div class="detail-value">{{ $data->cnic_number ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('cnic_issue_date') }}</div>
                        <div class="detail-value">{{ $data->cnic_issue_date ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('cnic_expiry_date') }}</div>
                        <div class="detail-value">{{ $data->cnic_expiry_date ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('date_of_birth') }}</div>
                        <div class="detail-value">{{ $data->date_of_birth ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('place_of_birth') }}</div>
                        <div class="detail-value">{{ $data->birth_placed ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('age_nearest_birthdate') }}</div>
                        <div class="detail-value">{{ $data->age_nearest_date ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('gender') }}</div>
                        <div class="detail-value">{{ $data->gender ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('marital_status') }}</div>
                        <div class="detail-value">{{ $data->marital_status ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('mother_maiden_name') }}</div>
                        <div class="detail-value">{{ $data->mother_maiden_name ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('father_name_of_life_proposed') }}</div>
                        <div class="detail-value">{{ $data->father_name ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    @if(($data->marital_status ?? '') === 'Married' && ($data->gender ?? '') === 'Male')
                    <td>
                        <div class="detail-label">{{ policy_label('wife_name') }}</div>
                        <div class="detail-value">{{ $data->wife_name ?? '---' }}</div>
                    </td>
                    @elseif(($data->marital_status ?? '') === 'Married' && ($data->gender ?? '') === 'Female')
                    <td>
                        <div class="detail-label">{{ policy_label('husband_name') }}</div>
                        <div class="detail-value">{{ $data->husband_name ?? '---' }}</div>
                    </td>
                    @else
                    <td>
                        <div class="detail-label">{{ policy_label('spouse') }}</div>
                        <div class="detail-value">---</div>
                    </td>
                    @endif
                    <td>
                        <div class="detail-label">{{ policy_label('religion') }}</div>
                        <div class="detail-value">{{ $data->religion ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('email_address') }}</div>
                        <div class="detail-value">{{ $data->user_email ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('phone_office') }}</div>
                        <div class="detail-value">{{ $data->phone_number_office ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('phone_residential') }}</div>
                        <div class="detail-value">{{ $data->phone_number_residente ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('country_of_residence') }}</div>
                        <div class="detail-value">{{ optional($data->countryOfResidence)->name ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('current_address') }}</div>
                        <div class="detail-value">{{ $data->current_address ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('is_dual_national') }}</div>
                        <div class="detail-value">{{ $data->is_client_dual_national ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('primary_nationality') }}</div>
                        <div class="detail-value">{{ $data->is_client_dual_national == 'No' ? 'Pakistani' : ($data->primary_nationality ?? '---') }}</div>
                    </td>
                    <td></td>
                </tr>

                @if($data->is_client_dual_national == 'Yes')
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('dual_nationality_country') }}</div>
                        <div class="detail-value">{{ optional($data->dualNationalityCountry)->name ?? $data->dual_nationality_country ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('tax_tin_number') }}</div>
                        <div class="detail-value">{{ $data->dual_tax_tin_number ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('mobile_number') }}</div>
                        <div class="detail-value">{{ $data->dual_mobile_number ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('address') }}</div>
                        <div class="detail-value">{{ $data->dual_address ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('passport_number') }}</div>
                        <div class="detail-value">{{ $data->dual_passport_number ?? '---' }}</div>
                    </td>
                    <td></td>
                </tr>
                @endif

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('is_same_person') }}</div>
                        <div class="detail-value">{{ $data->is_same_person ?? '---' }}</div>
                    </td>
                    <td></td>
                </tr>

                @php $lp = \App\Support\LifeProposedProfile::values($data); @endphp
                @if(($data->is_same_person ?? '') === 'No')
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('life_proposed_full_name') }}</div>
                        <div class="detail-value">{{ $lp['name'] ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('mobile_number_personal') }}</div>
                        <div class="detail-value">{{ $lp['mobile'] ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('life_proposed_document') }}</div>
                        <div class="detail-value">{{ $lp['cnic'] ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('date_of_birth') }}</div>
                        <div class="detail-value">{{ $lp['dob'] ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('place_of_birth') }}</div>
                        <div class="detail-value">{{ $lp['birth_placed'] ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('age') }}</div>
                        <div class="detail-value">{{ $lp['age'] ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('gender') }}</div>
                        <div class="detail-value">{{ ($lp['gender'] ?? '---') }} / {{ ($lp['marital_status'] ?? '---') }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('relationship_with_proposer') }}</div>
                        <div class="detail-value">{{ $lp['relationship'] ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('father_name') }}</div>
                        <div class="detail-value">{{ ($lp['father_name'] ?? '---') }} / {{ ($lp['mother_maiden_name'] ?? '---') }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('email_address') }}</div>
                        <div class="detail-value">{{ $lp['email'] ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('religion') }}</div>
                        <div class="detail-value">{{ $lp['religion'] ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('cnic_issue_date') }}</div>
                        <div class="detail-value">{{ $lp['cnic_issue_date'] ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('cnic_expiry_date') }}</div>
                        <div class="detail-value">{{ $lp['cnic_expiry_date'] ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('spouse') }}</div>
                        <div class="detail-value">{{ ($lp['wife_name'] ?? '---') }} / {{ ($lp['husband_name'] ?? '---') }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('phone_office') }}</div>
                        <div class="detail-value">{{ ($lp['phone_office'] ?? '---') }} / {{ ($lp['phone_residential'] ?? '---') }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('is_dual_national') }}</div>
                        <div class="detail-value">{{ $lp['is_client_dual_national'] ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('primary_nationality') }}</div>
                        <div class="detail-value">{{ $lp['primary_nationality'] ?? '---' }}</div>
                    </td>
                    <td></td>
                </tr>
                @if(($lp['is_client_dual_national'] ?? '') === 'Yes')
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('dual_nationality_country') }}</div>
                        <div class="detail-value">{{ $lp['dual_nationality_country'] ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('tax_tin_number') }}</div>
                        <div class="detail-value">{{ $lp['dual_tax_tin_number'] ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('dual_mobile_number') }}</div>
                        <div class="detail-value">{{ $lp['dual_mobile_number'] ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('dual_address') }}</div>
                        <div class="detail-value">{{ $lp['dual_address'] ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('passport_number') }}</div>
                        <div class="detail-value">{{ $lp['dual_passport_number'] ?? '---' }}</div>
                    </td>
                    <td></td>
                </tr>
                @endif
                @endif

            </table>

            {{-- POLICY INFORMATION --}}
            <div class="section-title">
                {{ policy_label('policy_information') }}
            </div>

            <table>

                <tr>
                    <td>
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
                                            ($data->status == 'InCart' ? '#f6ca90' : '#edf19e'))) }};
                            ">
                                {{ $data->status ?? '---' }}
                            </span>
                        </div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('table') }}</div>
                        <div class="detail-value">{{ $data->table_no ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('term') }}</div>
                        <div class="detail-value">{{ $data->term ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('sum_assured') }}</div>
                        <div class="detail-value">{{ $data->sum_assured ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('is_nd_applied') }}</div>
                        <div class="detail-value">{{ $data->is_nd_applied ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('payment_mode') }}</div>
                        <div class="detail-value">{{ $data->payment_mode ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('premium_paid') }}</div>
                        <div class="detail-value">{{ $data->premium_paid !== null && $data->premium_paid !== '' ? number_format((float) $data->premium_paid) : '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('age_proof') }}</div>
                        <div class="detail-value">{{ $data->age_proof ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('adb_rider') }}</div>
                        <div class="detail-value">{{ $data->adb_rider ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('tir_rider') }}</div>
                        <div class="detail-value">{{ $data->tir_rider ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('fib_rider') }}</div>
                        <div class="detail-value">{{ $data->fib_rider ?? '---' }}</div>
                    </td>

                    <td></td>
                </tr>

            </table>

            {{-- ADDRESS DETAILS --}}
            <div class="section-title">
                {{ policy_label('address_details') }}
            </div>

            <table>
                <tr>
                    <td colspan="2"> {{ policy_label('permanent_address') }}</td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('province') }}</div>
                        <div class="detail-value">{{ $data->get_permanent_province->name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('city') }}</div>
                        <div class="detail-value">{{ $data->get_permanent_city->name ?? '---'}}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('district') }}</div>
                        <div class="detail-value">{{ $data->get_permanent_district->name ?? '---'  }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('address') }}</div>
                        <div class="detail-value">{{ $data->permanent_address ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> {{ policy_label('correspondence_address') }}</td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('province') }}</div>
                        <div class="detail-value">{{ $data->get_corres_province->name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('city') }}</div>
                        <div class="detail-value">{{ $data->get_corres_city->name ?? '---'}}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('district') }}</div>
                        <div class="detail-value">{{ $data->get_corres_district->name ?? '---'  }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('address') }}</div>
                        <div class="detail-value">{{ $data->corres_address ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> {{ policy_label('temporary_address') }}</td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('province') }}</div>
                        <div class="detail-value">{{ $data->get_temp_province->name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('city') }}</div>
                        <div class="detail-value">{{ $data->get_temp_city->name ?? '---'}}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('district') }}</div>
                        <div class="detail-value">{{ $data->get_temp_district->name ?? '---'  }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('address') }}</div>
                        <div class="detail-value">{{ $data->temp_address ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- OCCUPATION --}}
            <div class="section-title">
                {{ policy_label('occupation_income') }}
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('employment') }}</div>
                        <div class="detail-value">{{ $data->is_emaployemnt ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('designation') }}</div>
                        <div class="detail-value">{{ $data->employment_designation ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('company_name') }}</div>
                        <div class="detail-value">{{ $data->employment_company_name ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('businessman') }}</div>
                        <div class="detail-value">{{ $data->is_business ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('business_name') }}</div>
                        <div class="detail-value">{{ $data->business_name ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('nature_of_business') }}</div>
                        <div class="detail-value">{{ $data->nature_of_business ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('filer_status') }}</div>
                        <div class="detail-value">{{ $data->filer_status ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('ntn_number') }}</div>
                        <div class="detail-value">{{ ($data->filer_status ?? '') === 'Filer' ? ($data->ntn_number ?? '---') : '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('holding_land') }}</div>
                        <div class="detail-value">{{ $data->is_holding_land ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('land_unit') }}</div>
                        <div class="detail-value">{{ $data->land_unit ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('total_area') }}</div>
                        <div class="detail-value">{{ $data->total_acreage ?? '---' }}{{ !empty($data->land_unit) ? ' ' . $data->land_unit : '' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('land_location') }}</div>
                        <div class="detail-value">{{ $data->land_location ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('land_type') }}</div>
                        <div class="detail-value">{{ $data->land_type ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('estimated_land_value') }}</div>
                        <div class="detail-value">{{ $data->estimated_land_value ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('average_monthly_income') }}</div>
                        <div class="detail-value">PKR {{ $data->avaerage_monthly_income ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('ex_defence') }}</div>
                        <div class="detail-value">{{ $data->ex_defence_personal ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('discharged_medical') }}</div>
                        <div class="detail-value">{{ $data->discharged_on_medical ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('hazardous_occupation') }}</div>
                        <div class="detail-value">{{ $data->hazardous_occupation ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div class="detail-label">{{ policy_label('comments') }}</div>
                        <div class="detail-value">{{ $data->comment ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- Voucher Information --}}
            <div class="section-title">
                {{ policy_label('payment_information') }}
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('consumer_no') }}</div>
                        <div class="detail-value">{{ $data->voucher->consumer_number ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('amount_within_due_date') }}</div>
                        <div class="detail-value">{{ number_format($data->voucher->amount_within_due_date) ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('amount_after_due_date') }}</div>
                        <div class="detail-value">{{ number_format($data->voucher->amount_after_due_date) ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('due_date') }}</div>
                        <div class="detail-value">{{ $data->voucher->due_date ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- Family History Information --}}
            <div class="section-title">
                {{ policy_label('family_history_information') }}
            </div>

            @if($data->family_history && $data->family_history->count() > 0)
            @foreach($data->family_history as $member)
            <table style="margin-bottom: 20px;">
                <tr>
                    <th colspan="2" style="text-transform: capitalize; color: #0d6efd; padding-bottom: 8px;">
                        {{ $member->memner_flag }}
                    </th>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('current_age') }}</div>
                        <div class="detail-value">{{ $member->age ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('state_of_health') }}</div>
                        <div class="detail-value">{{ $member->state_of_health ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('is_alive') }}</div>
                        <div class="detail-value">{{ filled($member->year_of_death) ? 'No' : 'Yes' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('year_of_death') }}</div>
                        <div class="detail-value">{{ $member->year_of_death ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('age_of_death') }}</div>
                        <div class="detail-value">{{ $member->age_of_death ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('cause_of_death') }}</div>
                        <div class="detail-value">{{ $member->cause_of_death ?? '---' }}</div>
                    </td>
                    <td></td>
                </tr>
            </table>
            @endforeach
            @else
            <table>
                <tr>
                    <td colspan="2" style="text-align: center; color: #6c757d; padding: 15px 0;">
                        No family history recorded for this policy.
                    </td>
                </tr>
            </table>
            @endif

            {{-- Female Section --}}
            <div class="section-title">
                {{ policy_label('female_section') }}
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('date_of_last_delivery') }}</div>
                        <div class="detail-value">{{ $data->date_of_last_delivery ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('miscarriage_dates') }}</div>
                        <div class="detail-value">{{ \App\Support\MiscarriageDates::display($data->miscarriage_dates ?? null) }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('are_you_pregnant') }}</div>
                        <div class="detail-value">{{ $data->is_pregnant ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('caesarean_details') }}</div>
                        <div class="detail-value">{{ $data->caesarean_details ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('lmp_date') }}</div>
                        <div class="detail-value">{{ $data->lmp_date ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('female_disease_history') }}</div>
                        <div class="detail-value">{{ $data->female_disease_history ?? '---' }}</div>
                    </td>
                </tr>

                @if(($data->female_disease_history ?? '') === 'Yes')
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('female_disease') }}</div>
                        <div class="detail-value">{{ \App\Support\FemaleDiseases::name($data->female_disease_name) ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('description') }}</div>
                        <div class="detail-value">{{ \App\Support\FemaleDiseases::details($data->female_disease_name) ?? '---' }}</div>
                    </td>
                </tr>
                @endif

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('self_monthly_income') }}</div>
                        <div class="detail-value">{{ $data->self_monthly_income ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('husband_monthly_income') }}</div>
                        <div class="detail-value">{{ $data->husband_monthly_income ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('qualification') }}</div>
                        <div class="detail-value">{{ $data->qualification ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('tax_paid') }}</div>
                        <div class="detail-value">{{ $data->pays_tax_land_revenue ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('husband_policy_no') }}</div>
                        <div class="detail-value">{{ $data->husband_policy_no ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('husband_zone_company') }}</div>
                        <div class="detail-value">{{ $data->husband_zone_company ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('husband_sum_assured') }}</div>
                        <div class="detail-value">{{ $data->husband_sum_assured ?? '---' }}</div>
                    </td>

                    <td></td>
                </tr>

            </table>

            {{-- Nominee Information --}}
            <div class="section-title">
                {{ policy_label('nominee_information') }}
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('nominee_name') }}</div>
                        <div class="detail-value">{{ $data->nominee_name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('nominee_cnic') }}</div>
                        <div class="detail-value">{{ $data->nominee_cnic ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('nominee_age') }}</div>
                        <div class="detail-value">{{ $data->nominee_age ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('relationship_with_you') }}</div>
                        <div class="detail-value">{{ $data->nominee_relationship ?? '---' }}</div>
                    </td>
                </tr>

                @php
                    $isMinorNominee = filled($data->nominee_age) && (int) $data->nominee_age < 18;
                @endphp
                @if($isMinorNominee)
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('appointee_name') }}</div>
                        <div class="detail-value">{{ $data->appointee_name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('appointee_relationship') }}</div>
                        <div class="detail-value">{{ $data->appointee_relationship ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('appointee_cnic') }}</div>
                        <div class="detail-value">{{ $data->appointee_cnic ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">{{ policy_label('appointee_mobile') }}</div>
                        <div class="detail-value">{{ $data->appointee_mobile ?? '---' }}</div>
                    </td>
                </tr>
                @endif

            </table>

            {{-- Documents --}}
            <div class="section-title">
                {{ policy_label('documents') }}
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('proposer_cnic_front') }}</div>
                        <div class="detail-value">
                            @if($data->proposer_cnic_front)
                            <img src="{{ public_path('uploads/policy_documents/'.$data->proposer_cnic_front) }}"
                                alt="Proposer CNIC Front"
                                class="doc-image">
                            @else
                            ---
                            @endif
                        </div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('proposer_cnic_back') }}</div>
                        <div class="detail-value">
                            @if($data->proposer_cnic_back)
                            <img src="{{ public_path('uploads/policy_documents/'.$data->proposer_cnic_back) }}"
                                alt="Proposer CNIC Back"
                                class="doc-image">
                            @else
                            ---
                            @endif
                        </div>
                    </td>
                </tr>

                @if(($data->is_same_person ?? '') === 'No')
                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('life_proposed_document') }}</div>
                        <div class="detail-value">
                            @if($data->life_proposed_document)
                            <img src="{{ public_path('uploads/policy_documents/'.$data->life_proposed_document) }}"
                                alt="Life Proposed Document"
                                class="doc-image">
                            @else
                            ---
                            @endif
                        </div>
                    </td>
                    <td></td>
                </tr>
                @endif

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('nominee_document') }}</div>
                        <div class="detail-value">
                            @if($data->nominee_document)
                            <img src="{{ public_path('uploads/policy_documents/'.$data->nominee_document) }}"
                                alt="Nominee Document"
                                class="doc-image">
                            @else
                            ---
                            @endif
                        </div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('proposer_photo') }}</div>
                        <div class="detail-value">
                            @if($data->proposer_photo)
                            <img src="{{ public_path('uploads/policy_documents/'.$data->proposer_photo) }}"
                                alt="Proposer Photo"
                                class="doc-image">
                            @else
                            ---
                            @endif
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('income_proof') }}</div>
                        <div class="detail-value">
                            @if($data->income_proof)
                            <img src="{{ public_path('uploads/policy_documents/'.$data->income_proof) }}"
                                alt="Income Proof"
                                class="doc-image">
                            @else
                            ---
                            @endif
                        </div>
                    </td>
                    <td></td>
                </tr>

                @include('backend.userPolicy.partials.stored-documents', [
                    'docs' => \App\Support\PolicyStoredDocuments::medical($data->medical_documents ?? null),
                    'usePublicPath' => true,
                ])
                @include('backend.userPolicy.partials.stored-documents', [
                    'docs' => \App\Support\PolicyStoredDocuments::others($data->other_documents ?? null),
                    'usePublicPath' => true,
                ])

            </table>
            <div class="section-title">
                {{ policy_label('health_information') }}
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('height_cm') }}</div>
                        <div class="detail-value">{{ $data->height_cm ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('height_ft') }}</div>
                        <div class="detail-value">{{ $data->height_ft ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('weight_kg') }}</div>
                        <div class="detail-value">{{ $data->weight_kg ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('chest_inspiration') }}</div>
                        <div class="detail-value">{{ $data->chest_insp_cm ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('chest_inspiration') }}</div>
                        <div class="detail-value">{{ $data->chest_insp_inches ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('chest_expansion') }}</div>
                        <div class="detail-value">{{ $data->chest_exp_cm ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('chest_expansion') }}</div>
                        <div class="detail-value">{{ $data->chest_exp_inches ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('abdomen') }}</div>
                        <div class="detail-value">{{ $data->abdomen_cm ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('abdomen') }}</div>
                        <div class="detail-value">{{ $data->abdomen_inches ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('expected_weight_loss') }}</div>
                        <div class="detail-value">{{ $data->weight_loss_kg ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('expected_weight_gain') }}</div>
                        <div class="detail-value">{{ $data->weight_gain_kg ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('daily_consumption') }}</div>
                        <div class="detail-value">{{ $data->daily_consumption ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('physical_impairments') }}</div>
                        <div class="detail-value">{{ $data->physical_impairments ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('last_illness_injury') }}</div>
                        <div class="detail-value">{{ $data->last_illness_injury ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('medical_investigations') }}</div>
                        <div class="detail-value">{{ $data->medical_investigations ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">{{ policy_label('medical_history') }}</div>
                        <div class="detail-value">{{ $data->medical_history ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">{{ policy_label('reason_weight_change') }}</div>
                        <div class="detail-value">{{ $data->weight_increase_reason ?? '---' }}</div>
                    </td>

                    <td></td>
                </tr>

            </table>

        </div>

    </div>

</body>

</html>
</html>
