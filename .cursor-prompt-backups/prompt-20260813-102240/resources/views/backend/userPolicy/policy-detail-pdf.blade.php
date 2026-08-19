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
                        <div class="summary-title">Policy Number</div>
                        <div class="summary-value">{{ $data->policy_id ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="summary-title">Plan Name</div>
                        <div class="summary-value">{{ $data->product->name ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="summary-title">Sum Assured</div>
                        <div class="summary-value">{{ number_format($data->sum_assured) ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="summary-title">Policy Term</div>
                        <div class="summary-value">{{ $data->term ?? '---' }} Years</div>
                    </td>
                </tr>

            </table>

            {{-- PERSONAL INFORMATION --}}
            <div class="section-title">
                Personal Information
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Life Proposed Full Name</div>
                        <div class="detail-value">{{ $data->life_proposed_full_name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Mobile Number Personal</div>
                        <div class="detail-value">{{ $data->mobile_number ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">CNIC / B-FORM NO</div>
                        <div class="detail-value">{{ $data->cnic_number ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">CNIC Issue Date</div>
                        <div class="detail-value">{{ $data->cnic_issue_date ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">CNIC Expiry Date</div>
                        <div class="detail-value">{{ $data->cnic_expiry_date ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Date Of Birth</div>
                        <div class="detail-value">{{ $data->date_of_birth ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Age Nearest Birth-date</div>
                        <div class="detail-value">{{ $data->age_nearest_date ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Gender</div>
                        <div class="detail-value">{{ $data->gender ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Marital Status</div>
                        <div class="detail-value">{{ $data->marital_status ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Mother Maiden Name</div>
                        <div class="detail-value">{{ $data->mother_maiden_name ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Father's Name of Life Proposed</div>
                        <div class="detail-value">{{ $data->father_name ?? '---' }}</div>
                    </td>
                    @if(($data->marital_status ?? '') === 'Married' && ($data->gender ?? '') === 'Male')
                    <td>
                        <div class="detail-label">Wife Name of Life Proposed</div>
                        <div class="detail-value">{{ $data->wife_name ?? '---' }}</div>
                    </td>
                    @elseif(($data->marital_status ?? '') === 'Married' && ($data->gender ?? '') === 'Female')
                    <td>
                        <div class="detail-label">Husband Name of Life Proposed</div>
                        <div class="detail-value">{{ $data->husband_name ?? '---' }}</div>
                    </td>
                    @else
                    <td>
                        <div class="detail-label">Spouse Name</div>
                        <div class="detail-value">---</div>
                    </td>
                    @endif
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Religion</div>
                        <div class="detail-value">{{ $data->religion ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Email Address</div>
                        <div class="detail-value">{{ $data->user_email ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Phone Number Office</div>
                        <div class="detail-value">{{ $data->phone_number_office ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Phone Number Residential</div>
                        <div class="detail-value">{{ $data->phone_number_residente ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div class="detail-label">Is Client Dual National?</div>
                        <div class="detail-value">{{ $data->is_client_dual_national ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Primary Nationality</div>
                        <div class="detail-value">{{ $data->primary_nationality ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Dual Nationality</div>
                        <div class="detail-value">{{ $data->dual_nationality ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Dual Nationality Country</div>
                        <div class="detail-value">{{ $data->dual_nationality_country ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Dual Nationality Passport Number</div>
                        <div class="detail-value">{{ $data->dual_passport_number ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Birth Place</div>
                        <div class="detail-value">{{ $data->birth_placed ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Proposer & Life Proposed are same</div>
                        <div class="detail-value">{{ $data->is_same_person ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Life Proposed Name</div>
                        <div class="detail-value">{{ $data->life_proposed_name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Life Proposed CNIC</div>
                        <div class="detail-value">{{ $data->life_proposed_cnic ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Life Proposed DOB</div>
                        <div class="detail-value">{{ $data->life_proposed_dob ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Life Proposed RelationShip</div>
                        <div class="detail-value">{{ $data->life_proposed_relationship ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- POLICY INFORMATION --}}
            <div class="section-title">
                Policy Information
            </div>

            <table>

                <tr>
                    <td>
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
                                            ($data->status == 'InCart' ? '#f6ca90' : '#edf19e'))) }};
                            ">
                                {{ $data->status ?? '---' }}
                            </span>
                        </div>
                    </td>

                    <td>
                        <div class="detail-label">Table</div>
                        <div class="detail-value">{{ $data->table_no ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Term</div>
                        <div class="detail-value">{{ $data->term ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Sum Assured</div>
                        <div class="detail-value">{{ $data->sum_assured ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">IS ND APPLIED</div>
                        <div class="detail-value">{{ $data->is_nd_applied ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Payment Mode</div>
                        <div class="detail-value">{{ $data->payment_mode ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Accidental Death Benefit (ADB)</div>
                        <div class="detail-value">{{ $data->adb_rider ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Term Insurance Rider (TIR)</div>
                        <div class="detail-value">{{ $data->tir_rider ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Family Income Benefit (FIB)</div>
                        <div class="detail-value">{{ $data->fib_rider ?? '---' }}</div>
                    </td>

                    <td></td>
                </tr>

            </table>

            {{-- ADDRESS INFORMATION --}}
            <div class="section-title">
                Address Information
            </div>

            <table>
                <tr>
                    <td colspan="2"> Permanent Address</td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">Province</div>
                        <div class="detail-value">{{ $data->get_permanent_province->name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">City</div>
                        <div class="detail-value">{{ $data->get_permanent_city->name ?? '---'}}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">District</div>
                        <div class="detail-value">{{ $data->get_permanent_district->name ?? '---'  }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Address</div>
                        <div class="detail-value">{{ $data->permanent_address ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> Correspondence Address</td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">Province</div>
                        <div class="detail-value">{{ $data->get_corres_province->name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">City</div>
                        <div class="detail-value">{{ $data->get_corres_city->name ?? '---'}}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">District</div>
                        <div class="detail-value">{{ $data->get_corres_district->name ?? '---'  }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Address</div>
                        <div class="detail-value">{{ $data->corres_address ?? '---' }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> Temporary Address</td>
                </tr>
                <tr>
                    <td>
                        <div class="detail-label">Province</div>
                        <div class="detail-value">{{ $data->get_temp_province->name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">City</div>
                        <div class="detail-value">{{ $data->get_temp_city->name ?? '---'}}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">District</div>
                        <div class="detail-value">{{ $data->get_temp_district->name ?? '---'  }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Address</div>
                        <div class="detail-value">{{ $data->temp_address ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- OCCUPATION --}}
            <div class="section-title">
                Occupation & Income
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Employment</div>
                        <div class="detail-value">{{ $data->is_emaployemnt ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Employment Designation</div>
                        <div class="detail-value">{{ $data->employment_designation ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Company Name</div>
                        <div class="detail-value">{{ $data->employment_company_name ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Businessman</div>
                        <div class="detail-value">{{ $data->is_business ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Business Name</div>
                        <div class="detail-value">{{ $data->business_name ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Nature Of Business</div>
                        <div class="detail-value">{{ $data->nature_of_business ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Holding Land</div>
                        <div class="detail-value">{{ $data->is_holding_land ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Land Unit</div>
                        <div class="detail-value">{{ $data->land_unit ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Total Area</div>
                        <div class="detail-value">{{ $data->total_acreage ?? '---' }}{{ !empty($data->land_unit) ? ' ' . $data->land_unit : '' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Land Location</div>
                        <div class="detail-value">{{ $data->land_location ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Land Type</div>
                        <div class="detail-value">{{ $data->land_type ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Estimated Land Value</div>
                        <div class="detail-value">{{ $data->estimated_land_value ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Average Monthly Income</div>
                        <div class="detail-value">PKR {{ $data->avaerage_monthly_income ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">
                            If Defence or Ex-Defence Personnel, Commercial Airline Flight Crew or Plant Protection Pilot
                        </div>
                        <div class="detail-value">{{ $data->ex_defence_personal ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">
                            Have you ever been discharged on medical grounds from service / employment
                        </div>
                        <div class="detail-value">{{ $data->discharged_on_medical ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">
                            Are you presently engaged or intend to engage in any hazardous occupation or pastime?
                        </div>
                        <div class="detail-value">{{ $data->hazardous_occupation ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div class="detail-label">Comments</div>
                        <div class="detail-value">{{ $data->comment ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- Voucher Information --}}
            <div class="section-title">
                Payment Information
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Consumer No</div>
                        <div class="detail-value">{{ $data->voucher->consumer_number ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Amount With In Due Date</div>
                        <div class="detail-value">{{ number_format($data->voucher->amount_within_due_date) ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Amount After Date</div>
                        <div class="detail-value">{{ number_format($data->voucher->amount_after_due_date) ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Due Date</div>
                        <div class="detail-value">{{ $data->voucher->due_date ?? '---' }}</div>
                    </td>
                </tr>

            </table>

            {{-- Family History Information --}}
            <div class="section-title">
                Family History Information
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
                        <div class="detail-label">Current Age</div>
                        <div class="detail-value">{{ $member->age ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">State of Health</div>
                        <div class="detail-value">{{ $member->state_of_health ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Year of Death</div>
                        <div class="detail-value">{{ $member->year_of_death ?? '---' }}</div>
                    </td>
                    <td>
                        <div class="detail-label">Age of Death</div>
                        <div class="detail-value">{{ $member->age_of_death ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Cause of Death</div>
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
                Female Section
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Date of Last Delivery</div>
                        <div class="detail-value">{{ $data->date_of_last_delivery ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Miscarriage Dates</div>
                        <div class="detail-value">{{ $data->miscarriage_dates ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Is Pregnant</div>
                        <div class="detail-value">{{ $data->is_pregnant ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Caesarean Details</div>
                        <div class="detail-value">{{ $data->caesarean_details ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">LMP Date</div>
                        <div class="detail-value">{{ $data->lmp_date ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Female Disease History</div>
                        <div class="detail-value">{{ $data->female_disease_history ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Self Monthly Income</div>
                        <div class="detail-value">{{ $data->self_monthly_income ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Husband Monthly Income</div>
                        <div class="detail-value">{{ $data->husband_monthly_income ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Qualification</div>
                        <div class="detail-value">{{ $data->qualification ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Pays Tax / Land Revenue</div>
                        <div class="detail-value">{{ $data->pays_tax_land_revenue ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Husband Policy No.</div>
                        <div class="detail-value">{{ $data->husband_policy_no ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Husband Zone / Company</div>
                        <div class="detail-value">{{ $data->husband_zone_company ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Husband Sum Assured</div>
                        <div class="detail-value">{{ $data->husband_sum_assured ?? '---' }}</div>
                    </td>

                    <td></td>
                </tr>

            </table>

            {{-- Nominee Information --}}
            <div class="section-title">
                Nominee Information
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Nominee Name</div>
                        <div class="detail-value">{{ $data->nominee_name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Nominee CNIC</div>
                        <div class="detail-value">{{ $data->nominee_cnic ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Nominee Age</div>
                        <div class="detail-value">{{ $data->nominee_age ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Nominee Relationship</div>
                        <div class="detail-value">{{ $data->nominee_relationship ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Appointee Name</div>
                        <div class="detail-value">{{ $data->appointee_name ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Appointee Relationship</div>
                        <div class="detail-value">{{ $data->appointee_relationship ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Appointee CNIC</div>
                        <div class="detail-value">{{ $data->appointee_cnic ?? '---' }}</div>
                    </td>

                    <td></td>
                </tr>

            </table>

            {{-- Documents --}}
            <div class="section-title">
                Documents
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Proposer CNIC Front</div>
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
                        <div class="detail-label">Proposer CNIC Back</div>
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

                <tr>
                    <td>
                        <div class="detail-label">Nominee Document</div>
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
                        <div class="detail-label">Proposer Photo</div>
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
                        <div class="detail-label">Income Proof</div>
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

            </table>

            {{-- HEALTH INFORMATION --}}
            <div class="section-title">
                Health Information
            </div>

            <table>

                <tr>
                    <td>
                        <div class="detail-label">Height CM</div>
                        <div class="detail-value">{{ $data->height_cm ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Height FT</div>
                        <div class="detail-value">{{ $data->height_ft ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Weight KG</div>
                        <div class="detail-value">{{ $data->weight_kg ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Chest Insp CM</div>
                        <div class="detail-value">{{ $data->chest_insp_cm ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Chest Insp Inches</div>
                        <div class="detail-value">{{ $data->chest_insp_inches ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Chest Exp CM</div>
                        <div class="detail-value">{{ $data->chest_exp_cm ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Chest Exp Inches</div>
                        <div class="detail-value">{{ $data->chest_exp_inches ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Abdomen CM</div>
                        <div class="detail-value">{{ $data->abdomen_cm ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Abdomen Inches</div>
                        <div class="detail-value">{{ $data->abdomen_inches ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Weight Loss KG</div>
                        <div class="detail-value">{{ $data->weight_loss_kg ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Weight Gain KG</div>
                        <div class="detail-value">{{ $data->weight_gain_kg ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Daily Consumption</div>
                        <div class="detail-value">{{ $data->daily_consumption ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Physical Impairments</div>
                        <div class="detail-value">{{ $data->physical_impairments ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Last Illness / Injury</div>
                        <div class="detail-value">{{ $data->last_illness_injury ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Medical Investigations</div>
                        <div class="detail-value">{{ $data->medical_investigations ?? '---' }}</div>
                    </td>

                    <td>
                        <div class="detail-label">Medical History</div>
                        <div class="detail-value">{{ $data->medical_history ?? '---' }}</div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div class="detail-label">Weight Increase Reason</div>
                        <div class="detail-value">{{ $data->weight_increase_reason ?? '---' }}</div>
                    </td>

                    <td></td>
                </tr>

            </table>

        </div>

    </div>

</body>

</html>